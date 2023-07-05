<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\StudentMonthlyFee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Utility extends Controller
{
    static function assignFeesToNewStudent($userObj)
    {
        $scFees = DB::table('fees_types as type')
            ->join('student_fees as  fees', 'fees.fees_type_id', 'type.id')
            ->select('type.title', 'fees.fees', 'fees.id')
            ->where('type.school_id', Auth::id())
            ->where('fees.class_id', $userObj->class_id)
            ->get();

        if(count($scFees) > 0):

            $demoSt = User::where('school_id', Auth::id())
            ->where('class_id', $userObj->class_id)
            ->where('section_id', $userObj->section_id)
            ->where('shift', $userObj->shift)
            ->where('group_id', $userObj->group_id)
            ->first();

            if(isset($demoSt) && !empty($demoSt)):
                $rows = StudentMonthlyFee::where('student_id', $demoSt->id)->whereYear('created_at', date("Y"))->get();

                if($rows->count() > 0):
                    foreach($rows as $row)
                    {
                        $monthlyFeeAmount = $row->studentFees->fees;

                        if($userObj->discount > 0)
                        {
                            if(isset($row->studentFees->feesType) && $row->studentFees->feesType == 'Monthly Fee')
                            {
                                $monthlyFeeAmount = ($monthlyFeeAmount - (($monthlyFeeAmount*$userObj->discount)/100));
                            }
                        }
                        

                        StudentMonthlyFee::create([
                            'month_name'    => $row->month_name,
                            'month_id'    => $row->month_id,
                            'amount'    => $monthlyFeeAmount,
                            'paid_amount'    => 0,
                            'status'    => 0,
                            'student_id'    => $userObj->id,
                            'school_id'    => Auth::id(),
                            'student_fees_id'   => $row->student_fees_id
                        ]);
                    }
                endif;
            endif;
        endif;
    }
}