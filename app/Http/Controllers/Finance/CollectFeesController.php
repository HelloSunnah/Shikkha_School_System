<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\AccesoriesType;
use App\Models\Bank;
use App\Models\FeesType;
use App\Models\InstituteClass;
use App\Models\StudentFee;
use App\Models\StudentMonthlyFee;
use App\Models\Transection;
use App\Models\User;
use App\Traits\HttpResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CollectFeesController extends Controller
{
    use HttpResponse;

    /**
     * show students list
     */
    public function userList(Request $request)
    {   
        $seoTitle = 'Collect   Fees';
        $seoDescription = 'Collect   Fees';
        $seoKeyword = 'Collect   Fees';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        try
        {
            $users = User::with('class:id,class_name', 'section:id,section_name')->where('school_id', Auth::id());

            if($request->has('classId') && !empty($request->classId))
            {
                $users->where('class_id', $request->classId);
            }

            if($request->has('sectionId') && !empty($request->sectionId))
            {
                $users->where('section_id', $request->sectionId);
            }

            if($request->has('shift') && !empty($request->shift))
            {
                $users->where('shift', $request->shift);
            }

            if($request->has('groupId') && !empty($request->groupId))
            {
                $users->where('group_id', $request->groupId);
            }

            if($request->has('roll') && !empty($request->roll))
            {
                $users->where('roll_number', $request->roll);
            }

            if($request->has('limit') && !empty($request->limit))
            {
                $users->limit($request->limit);
            }
            else
            {
                $users->limit(100);
            }

            if($request->has('order') && !empty($request->order) && $request->order == "desc")
            {
                $users->latest();
            }
            else
            {
                $users->orderBy('roll_number');
            }

            $data['users'] = $users->get();
            $data['classes'] = InstituteClass::where('school_id', Auth::id())->pluck('class_name', 'id');

            if($request->ajax())
            {
                return $this->success(count($data['users']) . " record fetched", $data);
            }
            else
            {
                return view('frontend.school.finance.students-fee',compact('seo_array'))->with($data);
            }
        }
        catch(Exception $e)
        {
            if($request->ajax())
            {
                return $this->error($e->getMessage());
            }
            else
            {
                // Alert::error("Server Error", $e->getMessage());
                return abort(403, $e->getMessage());
            }
        }
    }


    /**
     * received fees
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @author Codecell Limited <support@codecell.com.bd>
     * @contributor Shahidul Islam <contact.shahidul@gmail.com>
     * @created August 08, 2023
     * 
     */
    public function collectFees(Request $request)
    {
        // return $request;
        $schoolId = Auth::id();
        $studentId = $request->studentId;

        try
        {
            if(isset($request->hiddenFeesId) && is_array($request->hiddenFeesId) && !empty($request->hiddenFeesId) && count($request->hiddenFeesId) > 0)
            {
                foreach($request->hiddenFeesId as $key => $id)
                {
                    $paidAmount = (double) $request->feesAmount[$key];

                    $fee = StudentMonthlyFee::find($id);

                    $requiredAmount = abs((double)$fee->amount - (double)$fee->paid_amount);
                    if($fee->status < 2)
                    {
                        $fee->paid_amount += $paidAmount;
                        if($paidAmount < $requiredAmount)
                        {
                            $fee->status = 1; // partial
                        }
                        elseif($requiredAmount == $paidAmount)
                        {
                            $fee->status = 2; // paid
                        }
                        if($paidAmount > $requiredAmount)
                        {
                            return $this->error("Please enter valid amount", $request->all());
                        }
                        $fee->save();
                    }
                    
                }
                $sid = $fee->student_id;
            }

            if(isset($request->hiddenAccessoriesId) && is_array($request->hiddenAccessoriesId) && !empty($request->hiddenAccessoriesId) && count($request->hiddenAccessoriesId) > 0)
            {
                foreach($request->hiddenAccessoriesId as $key => $id)
                {
                    $paidAmount = (double) $request->accessoriesAmount[$key];

                    $acc = AccesoriesType::find($id)->toArray();

                    Transection::create([
                        'purpose'   =>  json_encode($acc),
                        'payment_method'  => 1, // 1 for hand cash
                        'amount'    =>  $paidAmount,
                        'name'      =>  User::find($studentId)->name,
                        'type'      =>  3, // 3 for accessories txns
                        'status'    => 1,
                        'datee'     => now(),
                        'school_id' => $schoolId
                    ]);
                }
            }


            else
            {
                return $this->error("Select atleast one item", $request->all());
            }

            return $this->success("Record stored successfully", $studentId);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage(), $request->all());
        }
    }


    /**domPDF */
    public function receipt(Request $request)
    {
        // return $request;
        $data = [
            "feesTable"      =>  $request->feesTable,
            "student"      =>  User::find($request->studentId),
            "school"      =>  Auth::user(),
        ];

        return view("frontend.school.finance.pdf.pdf_collect_fees", $data);
    }



    /**
     * get user information
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        try
        {
            if(Auth::check())
            {
                $schoolId = Auth::id();
                $data['allPaid'] = false;

                $records = DB::table('student_monthly_fees as smf')
                ->select('smf.id', 'smf.month_name', 'smf.month_id', 'smf.amount', 'smf.paid_amount', 'ft.title', 'users.discount')
                ->join('student_fees as sf', 'sf.id', 'smf.student_fees_id')
                ->join('fees_types as ft', 'ft.id', 'sf.fees_type_id')
                ->join('users', 'users.id', 'smf.student_id')
                ->where('smf.student_id', $request->sid)
                ->where('smf.school_id', $schoolId)
                ->where('smf.status', "<", 2)
                ->whereNull('smf.deleted_at')
                // ->where('smf.month_id', '<', date('m'))
                ->orderBy('smf.month_id', 'ASC');

                $paidRecords = DB::table('student_monthly_fees as smf')
                ->select('smf.id', 'smf.month_name', 'smf.amount', 'smf.paid_amount', 'ft.title', 'users.discount')
                ->join('student_fees as sf', 'sf.id', 'smf.student_fees_id')
                ->join('fees_types as ft', 'ft.id', 'sf.fees_type_id')
                ->join('users', 'users.id', 'smf.student_id')
                ->where('smf.student_id', $request->sid)
                ->where('smf.school_id', $schoolId)
                ->where('smf.status', "=", 2)
                ->whereNull('smf.deleted_at')
                ->count();

                if($records->count() == 0 && $paidRecords > 0)
                {
                    $data['allPaid'] = true;
                }

                $studentMonthlyFees = $records->get()->groupBy('month_name');
                $data['student'] = User::with('class:id,class_name', 'section:id,section_name')->find($request->sid);

                $resp = [];
                foreach($studentMonthlyFees as $key => $val)
                {
                    $array = [];
                    foreach($val as $item)
                    {
                        $feesAmount = $item->amount;

                        if($item->paid_amount > 0)
                        {
                            $feesAmount = $feesAmount - $item->paid_amount;
                        }

                        $array[] = [
                            'id' => $item->id,
                            'amount'    => abs($feesAmount),
                            'month_name'    =>  $item->month_name,
                            'title'         =>  $item->title,
                            'selected'      => ($item->month_id < date('m')) ? true : false,
                        ];
                    }

                    $resp[] = [
                        'month_name'    =>  $key,
                        'fees'          =>  $array
                    ];
                }

                $fees = [];
                foreach($records->where('smf.month_id', '<', date('m'))->get() as $item)
                {
                    $feesAmount = $item->amount;

                    if($item->paid_amount > 0)
                    {
                        $feesAmount = $feesAmount - $item->paid_amount;
                    }

                    $fees[] = [
                        'id' => $item->id,
                        'amount'    => abs($feesAmount),
                        'month_name'    =>  $item->month_name,
                        'title'         =>  $item->title,
                    ];
                }

                
                $data['fees'] = $resp;
                $data['records'] = $fees;

                return $this->success("Record Fetched", $data);
            }
            else
            {
                return $this->error("Unauthenticated User");
            }
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }


    /**
     * show collected Fees
     */
    public function showCollectedFees(Request $request)
    {
        try
        {
            $sid = $request->userId;
            $schoolId = $request->schoolId;
            $data['requests'] = $request->all();

            $data['collectedFees'] = DB::table('student_monthly_fees as smf')
            ->select('smf.id', 'smf.month_name', 'smf.month_id', 'smf.amount', 'smf.paid_amount', 'smf.status', 'ft.title')
            ->join('student_fees as sf', 'sf.id', 'smf.student_fees_id')
            ->join('fees_types as ft', 'ft.id', 'sf.fees_type_id')
            ->join('users', 'users.id', 'smf.student_id')
            ->where('smf.student_id', $sid)
            ->where('smf.school_id', $schoolId)
            ->whereNull('smf.deleted_at')
            ->orderBy('smf.month_id')
            ->get();

            $data['student'] = User::with('class:id,class_name', 'section:id,section_name')->find($sid);

            return $this->success("data fetched", $data);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
    }

    /**
     * update student monthly fees
     * 
     * @param int $studentId
     * @return array
     */
    public static function updateStudentMonthlyFees(int $studentId)
    {
        try
        {
            $st = User::findOrFail($studentId);
            $classId = $st->class_id;
            $schoolId = $st->school_id;
            $classFee = InstituteClass::findOrFail($classId)?->class_fees;
            $montlyFees = StudentMonthlyFee::where('school_id', $schoolId)->where('student_id',$st->id);

            if($montlyFees->count() > 0 && $st->discount > 0)
            {
                $feesType = FeesType::where('school_id', $schoolId)->where('title','Monthly Fee')->firstOrFail();

                $studentFee = StudentFee::where('school_id', $schoolId)->where('class_id', $classId)->where('fees_type_id', $feesType->id)->firstOrFail();

                if(isset($studentFee) && !empty($studentFee) && $studentFee->fees > 0)
                {
                    $monthlyFeeAmount = (double)($studentFee->fees - (($studentFee->fees * $st->discount) / 100));
                }
                else
                {
                    $studentFee = StudentFee::create([
                                    'school_id' =>  $schoolId,
                                    'class_id'  =>  $classId,
                                    'fees_type_id' => $feesType->id,
                                    'fees'  =>  $classFee
                                ]);

                    $monthlyFeeAmount = (double)($studentFee->fees - (($studentFee->fees * $st->discount) / 100));
                }

                $montlyFees->where('student_fees_id', $studentFee->id)
                ->update([
                    'amount'    => $monthlyFeeAmount
                ]);
            }

            $status = true;
            $message = "Fees updated.";

        }
        catch(Exception $e)
        {
            $status = false;
            $message = $e->getMessage();
        }

        return [
            'status'    =>  $status,
            'message'   =>  $message
        ];
    }
}
