<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AssignStudentFee;
use App\Models\FeesType;
use App\Models\InstituteClass;
use App\Models\StudentFee;
use App\Models\StudentMonthlyFee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;

class AssignFeesController extends Controller
{
    /**
     * show form assign fees 
     */
    public function index()
    {
        $data['classes'] = InstituteClass::where('school_id', Auth::id())->get();
        $data['fee_types'] = FeesType::where('school_id', Auth::id())->get();
        $data['months'] = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        return view('frontend.school.assignFees', compact('data'));
    }


    /**
     * show form assign fees 
     */
    public function store(Request $request)
    {   
        // return $request;
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

        try{

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
                                    $monthlyFee = (double)($monthlyFee - (($monthlyFee * $user->discount) / 100));
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
            Alert::error("Server Error!", $e->getMessage());
            return back();
        }

        Alert::success("Great!", "Fees assign successfully");
        return back();
    }
}
