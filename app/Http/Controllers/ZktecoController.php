<?php

namespace App\Http\Controllers;

use App\Helper\Utility;
use App\Models\FeesType;
use App\Models\InstituteClass;
use App\Models\School;
use App\Models\StudentFee;
use App\Models\StudentMonthlyFee;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Rats\Zkteco\Lib\ZKTeco;

class ZktecoController extends Controller
{
    public function testOnly()
    {

        // $schools = School::whereIn('id', [13, 14, 15, 17, 18, 19, 21, 23, 25, 26, 27, 29, 31, 34, 35, 40, 36, 37])->pluck('school_name', 'id');
        
        // foreach ($schools as $id => $name) {
        //     DB::table('accesories_transactions')->where('school_id', $id)->delete();
        //     DB::table('accesories_types')->where('school_id', $id)->delete();
        //     DB::table('assign_student_fees')->where('school_id', $id)->delete();
        //     DB::table('assign_teachers')->where('school_id', $id)->delete();
        //     DB::table('attendances')->where('school_id', $id)->delete();
        //     DB::table('banks')->where('school_id', $id)->delete();
        //     DB::table('borrow_books')->where('school_id', $id)->delete();
        //     DB::table('checkouts')->where('school_id', $id)->delete();
        //     DB::table('class_periods')->where('school_id', $id)->delete();
        //     DB::table('custom_attendance_input')->where('school_id', $id)->delete();
        //     DB::table('departments')->where('school_id', $id)->delete();
        //     DB::table('employees')->where('school_id', $id)->delete();
        //     DB::table('employee_salaries')->where('school_id', $id)->delete();
        //     DB::table('exam_routines')->where('school_id', $id)->delete();
        //     DB::table('fees_types')->where('school_id', $id)->delete();
        //     DB::table('institute_classes')->where('school_id', $id)->delete();
        //     DB::table('groups')->where('school_id', $id)->delete();
        //     DB::table('library_book_infos')->where('school_id', $id)->delete();
        //     DB::table('lib_book_types')->where('school_id', $id)->delete();
        //     DB::table('mark_types')->where('school_id', $id)->delete();
        //     DB::table('messages')->where('school_id', $id)->delete();
        //     DB::table('notices')->where('school_id', $id)->delete();
        //     DB::table('otps')->where('school_id', $id)->delete();
        //     DB::table('payments')->where('school_id', $id)->delete();
        //     DB::table('questions')->where('school_id', $id)->delete();
        //     DB::table('results')->where('school_id', $id)->delete();
        //     DB::table('result_settings')->where('school_id', $id)->delete();
        //     DB::table('result_subject_countable_marks')->where('school_id', $id)->delete();
        //     DB::table('routines')->where('school_id', $id)->delete();
        //     DB::table('school_checkouts')->where('school_id', $id)->delete();
        //     DB::table('school_fees')->where('school_id', $id)->delete();
        //     DB::table('sections')->where('school_id', $id)->delete();
        //     DB::table('shikkhabillings')->where('school_id', $id)->delete();
        //     DB::table('staff_attendances')->where('school_id', $id)->delete();
        //     DB::table('staff_types')->where('school_id', $id)->delete();
        //     DB::table('student_absent_sms')->where('school_id', $id)->delete();

        //     DB::table('student_absent_sms')->where('school_id', $id)->delete();
        //     DB::table('student_document_uploads')->where('school_id', $id)->delete();
        //     DB::table('student_fees')->where('school_id', $id)->delete();
        //     DB::table('student_monthly_fees')->where('school_id', $id)->delete();
        //     DB::table('subjects')->where('school_id', $id)->delete();
        //     DB::table('teachers')->where('school_id', $id)->delete();
        //     DB::table('teacher_attendances')->where('school_id', $id)->delete();
        //     DB::table('teacher_salaries')->where('school_id', $id)->delete();
        //     DB::table('terms')->where('school_id', $id)->delete();
        //     // DB::table('todolists')->where('school_id', $id)->delete();
        //     DB::table('transections')->where('school_id', $id)->delete();
        //     DB::table('users')->where('school_id', $id)->delete();
        //     DB::table('workplace_infos')->where('school_id', $id)->delete();

        //     School::destroy($id);
        // }
    }


    public function zkteco()
    {

        // ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        // set_time_limit(300);

        $zk = new ZKTeco('192.168.0.115', 5005);
        $zk->connect();
        //$zk->deviceName('K12/D'); 
        //$zk->enableDevice(); 
        // $zk->setUser('15', '1567', 'Rakibul Islam', 'abcdabcd');
        // $zk->disconnect();

        // return $zk->getUser();
         //return $abc = $zk->serialNumber();
        return $zk->deviceName();

        // return $abc;
    }


}
