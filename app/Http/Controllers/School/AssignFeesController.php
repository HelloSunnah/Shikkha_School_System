<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AssignStudentFee;
use App\Models\FeesType;
use App\Models\InstituteClass;
use App\Models\StudentFee;
use App\Models\StudentMonthlyFee;
use App\Models\User;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;

class AssignFeesController extends Controller
{
    use HttpResponse;

    /**
     * show form assign fees 
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * 
     * @author codecell limited
     * @contributor Shahidul Islam <contact.shahidul@gmail.com>
     * @createdAt July 18, 2023
     */
    public function index()
    {    
        $seoTitle = 'Assign  Fees';
        $seoDescription = 'Assign  Fees';
        $seoKeyword = 'Assign  Fees';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $data['classes'] = InstituteClass::where('school_id', Auth::id())->get();
        $data['fee_types'] = FeesType::where('school_id', Auth::id())->get();
        $data['months'] = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        return view('frontend.school.assignFees', compact('data','seo_array'));
    }


    /**
     * assignedFees
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse
     * 
     * @author codecell limited
     * @contributor Shahidul Islam <contact.shahidul@gmail.com>
     * @createdAt July 19, 2023
     */
    public function assignedFees(Request $request)
    {
        $resp['requests'] = $request->all();

        try
        {
            if(Auth::check() && $request->ajax())
            {

                $student = User::where('school_id', Auth::id())->where('class_id', $request->classId)->firstOrFail();

                $resp['assigned_fees'] = DB::table('student_fees as fees')
                ->select(
                    'type.id',
                    'class.class_name',
                    'type.title',
                    'fees.fees',
                    'assignedFee.month_name',
                    'assignedFee.month_id',
                    'assignedFee.student_fees_id',
                )
                ->join('institute_classes as class', 'class.id', 'fees.class_id')
                ->join('fees_types as type', 'type.id', 'fees.fees_type_id')
                ->join('student_monthly_fees as assignedFee', 'assignedFee.student_fees_id', 'fees.id')
                ->where('fees.school_id', Auth::id())
                ->where('fees.class_id', $request->classId)
                ->where('assignedFee.student_id', $student->id)
                ->whereNull('assignedFee.deleted_at')
                ->orderBy('assignedFee.month_id')
                ->get();

                return view('frontend.school.assignFee.assigned_table')->with($resp);

                // return $this->success('data fetched successfully', $resp);
            }
            else
            {
                return $this->error("Unathenticate request.", $resp);
            }
            
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }


    /**
     * assignedFees delete
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @author codecell limited
     * @contributor Shahidul Islam <contact.shahidul@gmail.com>
     * @createdAt July 25, 2023
     */
    public function assignedFeesDelete(Request $request)
    {
        $resp = $request->all();

        try
        {
            if(Auth::check() && $request->ajax())
            {
                $row = StudentMonthlyFee::where('school_id', Auth::id())->where('month_id', $request->monthId)->where('student_fees_id', $request->studentFeeId);
                $row->forcedelete();

                return $this->success($row->count() . ' Record deleted successfully', $resp);
            }
            else
            {
                return $this->error("Unathenticate request.", $resp);
            }
            
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }


    /**
     * show form assign fees 
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @author codecell limited
     * @contributor Shahidul Islam <contact.shahidul@gmail.com>
     * @created July 19, 2023
     * @modify July 22, 2023
     */
    public function store(Request $request)
    {   

        try{

            $request->validate(
                [
                    'class' =>  ['required', 'array'],
                    'month' =>  ['required', 'array'],
                    'feesTypeId'    => 'required|array',
                ],
                [
                    'feesTypeId.required' => "Please select atleast one fees"
                ]
            );

            foreach($request['class'] as $classId)
            {

                $users = User::where(['school_id' => Auth::id(), 'class_id' => $classId])->get();

                foreach($users as $user)
                {
                    foreach($request['month'] as $month)
                    {
                        $monthNum = $month + 1;
                        $loop = 0;
                        foreach($request['feesTypeId'] as $feesType)
                        {
                            $feesType = FeesType::find($feesType);
                            $studentFee = StudentFee::where('school_id', Auth::id())->where('class_id', $classId)->where('fees_type_id', $feesType->id)->first();

                            if(empty($studentFee) || is_null($studentFee))
                            {
                                Alert("Data Missing", "Please enter valid amount for ".$feesType->title);
                                return back();
                            }

                            $monthlyFee = (double)$studentFee->fees;

                            if($loop == 0 && ($feesType->title == "Monthly Fees" || $feesType->title == "Monthly Fee"))
                            {
                                if($user->discount > 0)
                                {
                                    $monthlyFee = (double)($monthlyFee - $user->discount);
                                    // $monthlyFee = (double)($monthlyFee - (($monthlyFee * $user->discount) / 100));
                                }
                            }

                            StudentMonthlyFee::updateOrCreate(
                                [
                                    'student_id'  =>  $user->id,
                                    'month_id'  =>  $month,
                                    'month_name'    => date('F', mktime(0, 0, 0, $monthNum, 10)),
                                    'student_fees_id'  =>  $studentFee->id,
                                    'school_id' =>  Auth::id(),
                                ],
                                [
                                    'amount'    =>  $monthlyFee ?? 0
                                ]
                            );

                            ++$loop;
                        }
                    }
                }
            }
                
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }

        return $this->success('Request saved successfully');
    }
}
