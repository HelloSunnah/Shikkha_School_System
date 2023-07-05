<?php

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\ResultSubjectCountableMark;
use App\Models\SchoolCheckout;
use App\Models\StaffAttendance;
use App\Models\AssignStudentFee;
use App\Models\Result;
use App\Models\TeacherAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function acquisition()
{
    return \App\Models\Acquisition::first();
}


function sendOtp($phone, $code)
{
    $token   = env('GREENWEB_TOKEN'); // greenweb api access
    // $code    = rand(1000, 9999);
    $to      = $phone;
    $message = $code . " is your verification code on sikkha.cc";

    $data = [
        'to'      => "$to",
        'message' => "$message",
        'token'   => "$token"
    ]; // Add parameters in key value
    $url = "http://api.greenweb.com.bd/api.php?json";

    $ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $smsresult = curl_exec($ch);

    return true;
}



function getSchoolData(){
    $data = \App\Models\School::where('id',Auth::user()->id)->first();
    return isset($data) ? $data : 0 ;
}

function getClassName($id)
{
    $data = \App\Models\InstituteClass::where('id',$id)->where('school_id',Auth::user()->id)->first();
    return isset($data) ? $data : null;
}

function getSectionName($id)
{
    $data = \App\Models\Section::where('id', $id)->where('school_id',Auth::user()->id)->first();
    return isset($data) ? $data : null ;
}

function getGroupname($id)
{
    $data = \App\Models\Group::where('id',$id)->where('school_id',Auth::user()->id)->first();
    return isset($data) ? $data : 0 ;
}

function getSubjectName($id)
{
    $data = \App\Models\Subject::where('id',$id)->where('school_id',Auth::user()->id)->first();
    // $data = \App\Models\Department::where('id',$id)->where('school_id',Auth::user()->id)->first();
    return isset($data) ? $data : 0 ;
}

function getSubjectNameTeacher($id)
{
    //$data = \App\Models\Subject::where('id',$id)->first();
    $data = \App\Models\Subject::where('id',$id)->where('school_id',Auth::user()->school_id)->first();
    return isset($data) ? $data : 0 ;
}

function getTeacherName($id)
{
    $data = \App\Models\Teacher::where('id',$id)->where('school_id',Auth::user()->id)->first();
    return isset($data) ? $data : null ;
}

function getUserName($id)
{
    $data = \App\Models\User::where('school_id',Auth::user()->id)->where('id',$id)->first();
    return isset($data) ? $data : 0 ;
}
function getUserRoll($id)
{
    $data = \App\Models\User::where('school_id',Auth::user()->id)->where('id',$id)->first();
    return isset($data) ? $data : 0 ;
}
function getStaffName($id)
{
    $data = Employee::where('school_id',Auth::user()->id)->where('id',$id)->first();
    return isset($data) ? $data : 0 ;
}

function CountUser($schoolId = null)
{
    if(is_null($schoolId)):
    $data = \App\Models\User::where('school_id',Auth::user()->id)->count();
    else:
     $data =\App\Models\User::where('school_id',$schoolId)->count();
    endif;
    return isset($data) ? $data : 0 ;
}

function CountTeacher($schoolId = null)
{
    if(is_null($schoolId)):
    $data = \App\Models\Teacher::where('school_id',Auth::user()->id)->count();
    else:
    $data = \App\Models\Teacher::where('school_id',$schoolId)->count();
    endif;
    return isset($data) ? $data : 0 ;
}
function CountStuff($schoolId=null){
    if(is_null($schoolId)):
    $data =\App\Models\Employee::where('school_id',Auth::user()->id)->count();
    else:
    $data =\App\Models\Employee::where('school_id',$schoolId)->count();
    endif;
    return isset($data) ?  $data : 0;
}

function MonthlyDue()
{
    $data = \App\Models\StudentMonthlyFee::where('school_id',Auth::user()->id)->where('month_name',date('F'))->where('amount',0)->count();
    return isset($data) ? $data : 0 ;
}

function MonthlyIncome()
{
    $fund = \App\Models\Transection::where('school_id',Auth::user()->id)->whereMonth('updated_at',Carbon::now()->format('m'))->where('type', '=', '2')->sum('amount');
    $accessories = \App\Models\Transection::where('school_id',Auth::user()->id)->whereMonth('updated_at',Carbon::now()->format('m'))->where('type', '=', '3')->sum('amount');
    $fees = \App\Models\StudentMonthlyFee::where('school_id',Auth::user()->id)->whereMonth('updated_at',Carbon::now()->format('m'))->sum('paid_amount');

    $data = $fund+ $accessories + $fees;

    return isset($data) ? $data : 0 ;
}

function DailyAttendence()
{
    $data = \App\Models\Attendance::where('school_id',Auth::user()->id)->whereDate('created_at',date("Y-m-d"))->count();
    return isset($data) ? $data : 0 ;
}

function extraFees($class_id,$month_name){
    $data = \App\Models\StudentFee::where('class_id',$class_id)->where('school_id',Auth::user()->id)->where('month_name',$month_name)->get();
    return isset($data) ? $data : 0 ;
}

function extraFeesSum($class_id,$month_name)
{
    $data = \App\Models\StudentFee::where('class_id',$class_id)->where('school_id',Auth::user()->id)->where('month_name',$month_name)->sum('fees');
    return isset($data) ? $data : 0 ;
}

function classWiseStudentCount($class_id){
    $data = \App\Models\User::where('class_id',$class_id)->count();
    return isset($data) ? $data : 0 ;
}

function extraFeesCount($class_id){
    $data = \App\Models\StudentFee::where('class_id',$class_id)->sum('fees');
    return isset($data) ? $data : 0 ;
}

function totalDuefeature(){
    $total_data = 0;
    // $data = \App\Models\StudentMonthlyFee::where('school_id',Auth::user()->id)->where('status','<',2)->groupby('student_id')->pluck('student_id');
    $studentFees = \App\Models\StudentMonthlyFee::where('school_id',Auth::user()->id)->sum('amount');
    $total_paid = \App\Models\StudentMonthlyFee::where('school_id',Auth::user()->id)->sum('paid_amount');
    $total_data = $studentFees - $total_paid;

    return isset($total_data) ? abs($total_data) : 0 ;
}

function getSectionCount()
{
    $data = \App\Models\Section::where('school_id',Auth::user()->id)->count();
    return isset($data) ? $data : 0 ;
}

function workPlace(){
    $data = \App\Models\WorkplaceInfo::where('school_id',Auth::user()->id)->first();
    return isset($data) ? $data : 0 ;
}

function getTutorial($info){
    $data = \App\Models\Tutorial::where('page_info',$info)->first();
    return isset($data) ? $data : 0 ;
}

function getMessageCount($school_id){
    $data = \App\Models\Message::where('school_id',$school_id)->count();
    return isset($data) ? $data : 0 ;
}

function getPackagePrice($price_id){
    $data = \App\Models\Price::where('id',$price_id)->first();
    return isset($data) ? $data : 0 ;
}

function getMessageAccount(){
    $usageMessage = \App\Models\Message::where('school_id',Auth::user()->id)->where('message',1)->whereMonth('created_at',Date('m'))->sum('message');
    $provideMessage = isset(getPackagePrice(workPlace(Auth::user()->id)->price_id)->message) ? getPackagePrice(workPlace(Auth::user()->id)->price_id)->message : 0;
    $buyMessage = \App\Models\Checkout::where('school_id',Auth::user()->id)->where('status',1)->sum('package_quantity');
    $total = ( $provideMessage + (is_null($buyMessage) ? 0 : $buyMessage) );
    $dataProcessBar = $total - $usageMessage ;
    $cssProcessBar = ($total == 0) ? 0 :( ($usageMessage == 0) ? 0 :(($usageMessage/$total)) * 100);
    //dd($total);
    $messageAccount = [
        'total' => $total,
        'dataProcessBar' => $dataProcessBar,
        'cssProcessBar' => $cssProcessBar,
        'buyMessage' => $buyMessage,
    ];

    return $messageAccount;
}

function getSchoolStatus($i){
    if($i == 1){
        return true;
    }
    else{
        return false;
    }
}


function getschoolPayment(){
    $paymentTaka = workPlace()->price_id;
    if(workPlace()->price_id == 0){
        $payment = \App\Models\SchoolFee::where('month_id','<=',date('m'))->where('school_id',Auth::user()->id)->count();
    }else{
        $amount = getPackagePrice(workPlace()->price_id)->price;
        $date = date('m');
        $payment  = \App\Models\SchoolFee::where('month_id','<=',(int)$date)->where('amount','!=',$amount)->where('school_id',Auth::user()->id)->where('status',0)->count();
    }
    return isset($payment) ? $payment : 0 ;
}

function getSchoolCheckout(){
    $payment  = \App\Models\SchoolCheckout::where('school_id',Auth::user()->id)->where('status',1)->sum('pay_amount');
    return isset($payment) ? $payment : 0 ;
}

function getSchoolCheckoutAdmin($id){
    $workplace = \App\Models\WorkplaceInfo::where('school_id',$id)->first();
    $paymentTaka = $workplace->price_id;
    if($workplace->price_id == 0){
        $payment = \App\Models\SchoolFee::where('month_id','<=',date('m'))->count();
    }else{
        $amount = getPackagePrice($workplace->price_id)->price;
        $date = date('m');
        $payment  = \App\Models\SchoolFee::where('month_id','<=',(int)$date)->where('amount','!=',$amount)->where('school_id',$id)->where('status',1)->count();
    }
    $paymentCheckout  = \App\Models\SchoolCheckout::where('school_id',$id)->where('status',1)->sum('pay_amount');

    $amount_data = ( $payment *  getPackagePrice($workplace->price_id)->price ) - $paymentCheckout;
    return isset($amount_data) ? $amount_data : 0 ;
}

function getSchoolFeesTotalSum($id){
    $data = \App\Models\SchoolFee::where('school_id',$id)->where('status',1)->sum('amount');
    return isset($data) ? $data : 0 ;
}

function getSchoolCheckoutTotalSum($id){
    $data = \App\Models\SchoolCheckout::where('school_id',$id)->where('status',1)->sum('pay_amount');
    return isset($data) ? $data : 0 ;
}

function workPlaceAdmin($id,$month_id){
    $workplace = \App\Models\WorkplaceInfo::where('school_id',$id)->first();
    $paymentTaka = $workplace->price_id;
    if($workplace->price_id == 0){
        $amount = 0;
    }else{
        $payment  = \App\Models\SchoolFee::where('month_id',$month_id)->where('school_id',$id)->where('status',0)->count();
        $amount = getPackagePrice($workplace->price_id)->price;
    }
    return isset($amount) ? $amount*$payment : 0 ;
}

function getSchoolTeacherCount($id){
    $data = \App\Models\Teacher::where('school_id',$id)->count();
    return isset($data) ? $data : 0 ;
}

function getSchoolStudentCount($id){
    $data = \App\Models\User::where('school_id',$id)->count();
    return isset($data) ? $data : 0 ;
}

function getResultHaveorNot($Student_id,$subject_id,$term_id){
    $data = \App\Models\Result::where('school_id',Auth::user()->id)->where('student_id',$Student_id)->where('term_id',$term_id)->first();
   // dd($data);
    return isset($data) ? $data : 0 ;
}

function getResultHaveorNotById($Student_id,$subject_id,$term_id){
    $data = \App\Models\Result::where('school_id',Auth::user()->id)->where('student_id',$Student_id)->where('term_id',$term_id)->first();
   // dd($data);
    return isset($data->id) ? $data->id : 0 ;
}

/**
 * Get Result
 *
 * @param $Student_id
 * @param $subject_id
 * @param $term_id
 * @param $markType_id
 * @return String Mix Data (Sajjad)
 */
function getResultMarks($Student_id, $subject_id, $term_id, $markType){
    $data = \App\Models\Result::where('school_id', Auth::user()->id)->where('student_id', $Student_id)->where('term_id', $term_id)->where('subject_id', $subject_id)->first();
    // dump($data[strtolower($markType)], $markType);
    try {
        return $data[strtolower($markType)];
    } catch (\Exception $e) {
        return null;
    }
}

function getAttData($student_id,$class_id,$section_id,$group_id,$month_id,$id)
{
    $group_id = is_null($group_id) ? NULL : $group_id;
    $dateS  = date("Y").'-'.$month_id.'-'.$id;
    $dateStudent = \App\Models\Attendance::where('student_id',$student_id)
        ->where('class_id',$class_id)
        ->where('section_id',$section_id)
        ->where('group_id',$group_id)
        ->whereDate('created_at', $dateS)
        ->first();

    if(is_null($dateStudent)){
        $fData = '...';
    }
    elseif($dateStudent->attendance == 1){
        $fData = '<span class="cursor-pointer" title="'.date('g:i:s A', strtotime($dateStaff->access_time)).'">✅</span>';
    }
    elseif($dateStudent->attendance == 0){
        $fData = '❌';
    }
    elseif($dateStudent->attendance == 2){
        $fData = '⛔';
    }else{
        $fData = 'No';
    }

    return $fData;

}
function getStaffData($employee_id,$month_id,$id)
{
    
    $dateS  = date("Y").'-'.$month_id.'-'.$id;
    $dateStaff = \App\Models\StaffAttendance::where('employee_id',$employee_id)
        ->whereDate('created_at', $dateS)
        ->first();

    if(is_null($dateStaff)){
        $fData = '...';
    }
    elseif($dateStaff->attendance == 1){
        $fData = '<span class="cursor-pointer" title="'.date('g:i:s A', strtotime($dateStaff->access_time)).'">✅</span>';
    }
    elseif($dateStaff->attendance == 0){
        $fData = '❌';
    }
    elseif($dateStaff->attendance == 2){
        $fData = '⛔';
    }else{
        $fData = 'No';
    }

    return $fData;

}
function getTeacherData($teacher_id,$month_id,$id)
{
    
    $dateS  = date("Y").'-'.$month_id.'-'.$id;
    $dateStaff = \App\Models\TeacherAttendance::where('teacher_id',$teacher_id)
        ->whereDate('created_at', $dateS)
        ->first();

    if(is_null($dateStaff)){
        $fData = '...';
    }
    elseif($dateStaff->attendance == 1){
        $fData = '<span class="cursor-pointer" title="'.date('g:i:s A', strtotime($dateStaff->access_time)).'">✅</span>';
    }
    elseif($dateStaff->attendance == 0){
        $fData = '❌';
    }
    elseif($dateStaff->attendance == 2){
        $fData = '⛔';
    }else{
        $fData = 'No';
    }

    return $fData;

}


function getAssignTeacherDataAll($subject_id,$class_id,$section_id,$group_id){
   // dd($subject_id);
    $data = \App\Models\AssignTeacher::where('class_id',$class_id)->where('section_id',$section_id)->where('subject_id',(int)$subject_id)->where('school_id',Auth::user()->school_id)->first();
    return isset($data->teacher_id) ? $data->teacher_id : 0 ;
}

function getAssignTeacherDataAll2($subject_id, $class_id, $section_id){
//    dd($subject_id,$class_id,$section_id);
    $data = \App\Models\AssignTeacher::where('class_id', $class_id)->where('section_id', $section_id)->where('subject_id', (int)$subject_id)->where('school_id', Auth::user()->school_id)->first();
    return isset($data->teacher_id) ? $data->teacher_id : 0 ;
}

function getClassNameUser($id)
{
    $data = \App\Models\InstituteClass::where('id',$id)->where('school_id',Auth::user()->school_id)->first();
    return isset($data) ? $data : null ;
}

function getCommonClassNameUser($id)
{
    $data = \App\Models\CommonClass::where('id',$id)->first();
    return isset($data) ? $data : 0 ;
}

function getInstituteClassNameUser($id)
{
    $data = \App\Models\instituteClass::where('id',$id)->first();
    return isset($data) ? $data : 0 ;
}

function getSectionNameUser($id)
{
    $data = \App\Models\Section::where('id',$id)->where('school_id',Auth::user()->school_id)->first();
    return isset($data) ? $data : null ;
}

function getGroupnameUser($id)
{
    // $data = \App\Models\Group::where('id',$id)->where('school_id',Auth::user()->school_id)->first();
    if ($id == 1) {
       $data = "Science";
    } elseif ($id == 2) {
        $data = "Commerce";
    } elseif ($id == 3) {
        $data = " Humanities";
    } else {
        $data = "General";
    };
    return isset($data) ? $data : 0 ;
}
function getSchoolDataUser($id){
    $data = \App\Models\School::where('id',$id)->first();
    return isset($data) ? $data : null ;
}



function getTeacherNameUser($teacher_id){
    $assign = \App\Models\Teacher::where('id', $teacher_id)->first();
    return isset($assign) ? $assign : 'NULL' ;
}

function getVaccineInfo(){
    $assign = \App\Models\Vaccine::where('student_id',Auth::user()->id)->first();
    return isset($assign) ? $assign : 0 ;
}

function getSubjectNameAll($id)
{
    $data = \App\Models\Subject::where('id',$id)->where('school_id',Auth::user()->school_id)->first();
    //$data = \App\Models\Department::where('id',$id)->where('school_id',Auth::user()->school_id)->first();
    return isset($data) ? $data : 0 ;
}


function getResultHaveorNotUser($Student_id, $subject_id, $term_id){
    $data = \App\Models\Result::where('school_id',Auth::user()->school_id)->where('subject_id',$subject_id)->where('student_id',$Student_id)->where('term_id',$term_id)->first();
    // dd($data);
    return isset($data) ? $data : 0 ;
}

function getResultHaveorNotByIdUser($Student_id, $subject_id, $term_id){
    $data = \App\Models\Result::where('school_id',Auth::user()->school_id)->where('student_id',$Student_id)->where('subject_id',$subject_id)->where('term_id',$term_id)->first();
    // dd($data);
    return isset($data->id) ? $data->id : 0 ;
}


function getUserNameForAll($id)
{
    $data = \App\Models\User::where('school_id',Auth::user()->school_id)->where('id',$id)->first();
    return isset($data) ? $data : null ;
}

function getStudentName($id)
{
    $data = \App\Models\User::where('id',$id)->first();
    return isset($data) ? $data : null ;
}

function getTermMark($id)
{
    $data = \App\Models\Term::where('id',$id)->first();
    return isset($data) ? $data : null ;
}

function getAssignmentCount($class_id,$section_id,$group_id,$subject_id,$teacher_id){
    $data = \App\Models\AssignmentTeacher::where('class_id',$class_id)->where('section_id',$section_id)->where('group_id',$group_id)->where('teacher_id',$teacher_id)->where('subject_id',$subject_id)->count();
    return isset($data) ? $data : 0 ;
}

function getAssignmentCount2(int $subject_id, int $teacherId){
    $data = \App\Models\AssignmentTeacher::where(['subject_id' => $subject_id, 'teacher_id'=> $teacherId, 'class_id' => Auth::user()->class_id, 'section_id' => Auth::user()->section_id, 'status' => 0])->count();
    return isset($data) ? $data : 0 ;
}

function getAssCountTeacher($id){
    $data = \App\Models\AssignmentStudent::where('assignment_teachers_id',$id)->count();
    return isset($data) ? $data : 0 ;
}

function cardColorChange($id){
    switch ($id) {
        case 0:
            $cardName = 'bg-purple';
            return   $cardName;
        case 1:
            $cardName = 'bg-orange';
            return   $cardName;
        case 2:
            $cardName = 'bg-danger';
            return   $cardName;
        case 3:
            $cardName = 'bg-pink';
            return   $cardName;
        case 4:
            $cardName = 'bg-primary';
            return   $cardName;
        case 5:
            $cardName = 'bg-success';
            return   $cardName;
        case 6:
            $cardName = 'bg-purple';
            return   $cardName;
        case 7:
            $cardName = 'bg-success';
            return   $cardName;
        case 8:
            $cardName = 'bg-danger';
            return   $cardName;
        case 9:
            $cardName = 'bg-pink';
            return   $cardName;
        case 10:
            $cardName = 'bg-primary';
            return   $cardName;
        case 11:
            $cardName = 'bg-orange';
            return   $cardName;
        default:
            $cardName = 'bg-purple';
            return   $cardName;
    }
}
function getTermName($id){
    // $data = \App\Models\Term::where('id',$id)->first();
    $data = \App\Models\ResultSetting::where('id', $id)->first();
    return $data;
}

function getSubjectTeacherName($id){
    $data = \App\Models\AssignmentTeacher::where('department_id',$id)->first();
    $dataTeacher = \App\Models\Teacher::where('id',$data->teacher_id)->first();
    return $dataTeacher;
}

function assignTeacherId($id){
    $data = \App\Models\AssignTeacher::where('id',$id)->first();
    return $data;
}

function RoutineTeacherId($id){
    $data = \App\Models\Routine::where('id',$id)->first();
    return $data;
}

/**
 * Show Student Field Wise Fee
 *
 * @param $month_id
 */
function studentFieldWiseFee($month_id)
{
    $currentYear = Carbon::now()->format('Y');
    $newYear = Carbon::parse($currentYear."-01-01");
    $currentMonth = date('Y-m-d', strtotime(Carbon::now(). "+1 months"));
    $studentFee = AssignStudentFee::where([
                  'school_id'   => Auth::user()->school_id,
                  'class_id'    => Auth::user()->class_id,
                  'month_id'    => $month_id
                ])->whereBetween('created_at', [$newYear, $currentMonth])->first();

    return isset($studentFee->fees_details) ? $studentFee : [] ;
}

/**
 * Total Mark
 */
function totalMark($data)
{
    return $data->attendance + $data->assignment + $data->class_test + $data->presentation + $data->quiz + $data->practical + $data->written + $data->mcq + $data->others;

}

/**
 * Grade
 */
// function grade($total, $term_id)
function grade($total, $result_setting_id, $class_id, $subject_id)
{
    $subjectMark = ResultSubjectCountableMark::where(['result_setting_id' => $result_setting_id, 'institute_class_id'  => $class_id, 'subject_id'   => $subject_id,  'school_id' => Auth::user()->id])->first();
    $totalMark = $total * 100 / $subjectMark->mark;

    $grading_scale = array(
        'A+' => 80, 'A' => 70, 'A-' => 60, 'B' => 50, 'C' => 40, 'D' => 33, 'F' => 0
    );

    foreach ($grading_scale as $grade => $minimum_score) {
        if ($totalMark >= $minimum_score) {
            return $grade;
        }
    }
}
/**
 * Annual Grade
 */
function annualGrade($total)
{
    $grading_scale = array(
        'A+' => 80, 'A' => 70, 'A-' => 60, 'B' => 50, 'C' => 40, 'D' => 33, 'F' => 0
    );

    foreach ($grading_scale as $grade => $minimum_score) {
        if ($total >= $minimum_score) {
            return $grade;
        }
    }
}
/**
 * Final Grade
 */
function finalGrade($total, $schoolId = null)
{
    if(is_null($schoolId)):
        $schoolId = Auth::id();
    endif;

    try {
        $totalTermMark = \App\Models\Term::where('school_id', $schoolId)->selectRaw("SUM(total_mark) as term_total_mark")->first();
        if ($totalTermMark != "0") {
            $totalMark = $total * 100 / $totalTermMark->term_total_mark;
        } else {
            return "Your total term mark should have is greater than 0";
        }
    } catch (Exception  $e) {
        return $e->getMessage();
    }

    $grading_scale = array(
        'A+' => 80, 'A' => 70, 'A-' => 60, 'B' => 50, 'C' => 40, 'D' => 33, 'F' => 0
    );

    foreach ($grading_scale as $grade => $minimum_score) {
        if ($totalMark >= $minimum_score) {
            return $grade;
        }
    }
}

/**
 * GPA
 */
// function gpa($total, $term_id)
function gpa($total, $result_setting_id, $class_id, $subject_id)
{
    // $term = \App\Models\Term::find($term_id);
    $subjectMark = ResultSubjectCountableMark::where(['result_setting_id' => $result_setting_id, 'institute_class_id'  => $class_id, 'subject_id'   => $subject_id,  'school_id' => Auth::user()->id])->first();
    $totalMark = $total * 100 / $subjectMark->mark;
    // $totalMark = $total * 100 / $term->total_mark;
    $grading_point = array(
        '5' => 80, '4' => 70, '3.5' => 60, '3' => 50, '2' => 40, '1' => 33, '0' => 0
    );

    foreach ($grading_point as $gpa => $minimum_score) {
        if ($totalMark >= $minimum_score) {
            return $gpa;
        }
    }
}
/**
 * Annula GPA
 */
function annualGpa($total)
{
    $grading_point = array(
        '5' => 80, '4' => 70, '3.5' => 60, '3' => 50, '2' => 40, '1' => 33, '0' => 0
    );

    foreach ($grading_point as $gpa => $minimum_score) {
        if ($total >= $minimum_score) {
            return $gpa;
        }
    }
}
/**
 * Final GPA
 */
function finalGpa($total, $schoolId = null)
{
    if(is_null($schoolId)):
    $schoolId = Auth::id();
    endif;

    try {
        $totalTermMark = \App\Models\Term::where('school_id', $schoolId)->selectRaw("SUM(total_mark) as term_total_mark")->first();
        if ($totalTermMark != "0") {
            $totalMark = $total * 100 / $totalTermMark->term_total_mark;
        } else {
            return "Your total term mark should have is greater than 0";
        }
    } catch (Exception  $e) {
        return $e->getMessage();
    }

    $grading_point = array(
        '5' => 80, '4' => 70, '3.5' => 60, '3' => 50, '2' => 40, '1' => 33, '0' => 0
    );

    foreach ($grading_point as $gpa => $minimum_score) {
        if ($totalMark >= $minimum_score) {
            return $gpa;

        }
    }
}
/**
 * Class Wise Result All Student GPA
 */
function classWiseGpa($total)
{
    // dd($total);
    $grading_point = array(
        'A+' => 5, 'A' => 4, 'A-' => 3.5, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0
    );

    foreach ($grading_point as $gpa => $minimum_score) {
        if ($total >= $minimum_score) {
            return $gpa;

        }
    }
}

/**
 * class wise pass fail
 */
function classWisePassFail($gpa)
{
    if ($gpa >= 1) {
        return "Pass";
    } else {
        return "Fail";
    }
}

function sendtoPaymentPage(){
  //  dd(1);
    return "Hello, Universe!";
}


/**
 * Get Result Teacher Panel
 *
 * @param $Student_id
 * @param $subject_id
 * @param $term_id
 * @param $markType
 * @return mixing $data or Null
 *
 */
function teacherGetResultMarks($Student_id, $subject_id, $term_id, $markType)
{
    $data = \App\Models\Result::where('school_id', Auth::user()->school_id)->where('student_id', $Student_id)->where('term_id', $term_id)->where('subject_id', $subject_id)->first();
    try {
        return $data[strtolower($markType)];
    } catch (\Exception $e) {
        return null;
    }
}

/**
 * Get Attendance on Admin Pannel (Sajjad Devel)
 *
 * @param $Student_id
 * @param $class_id
 * @param $subject_id
 * @param $section_id
 * @param $date
 * @return mixing $Int or Null
 *
 */
function getAttendance($student_id, $class_id, $section_id, $date)
{
    $attend = Attendance::where("school_id", Auth::user()->id)
                            ->where('class_id', $class_id)
                            ->where('section_id', $section_id)
                            ->where('student_id', $student_id)
                            ->whereDate('created_at', $date)->first();
    if($attend != null) {
        return $attend->attendance;
    }else {
        return 0;
    }
}
function getStaffAttendance($employee_id,$date)
{   
    $attend = StaffAttendance::where("school_id", Auth::user()->id)
                            ->where('employee_id', $employee_id)
                            ->whereDate('created_at', $date)->first();
    if($attend != null) {
        return $attend->attendance;
    }else {
        return 0;
    }
}
function getTeacherAttendance($teacher_id,$date)
{   
    $attend = TeacherAttendance::where("school_id", Auth::user()->id)
                            ->where('teacher_id', $teacher_id)
                            ->whereDate('created_at', $date)->first();
    if($attend != null) {
        return $attend->attendance;
    }else {
        return 0;
    }
}

/**
 * Subject Mark
 */
function subjectMark($result_setting_id, $class_id, $subject_id)
{
    $subjectMark = ResultSubjectCountableMark::where(['result_setting_id' => $result_setting_id, 'institute_class_id'  => $class_id, 'subject_id'   => $subject_id,  'school_id' => Auth::user()->id])->first();
    // dd($subjectMark);
    if($subjectMark == null){
        return "1";
    }
    return ($subjectMark->mark);
}

/**
 * Find Rank student in class
 * 
 * @param $class_id
 * @param $term_id
 * @param $student_id
 * @return $studentRank;
 */
function classWiseStudnetRank($class_id, $term_id, $student_id)
{   
    $rank = DB::table('results')->join('custom_attendance_input as attendance', 'results.student_id', '=', 'attendance.user_id')
                ->select('student_id','student_roll_number', 'attendance.present as present' )->selectRaw("SUM(results.total) as finalTotal")
                ->where('results.institute_class_id', $class_id)
                ->where('results.term_id', $term_id)
                ->where('attendance.result_setting_id', $term_id)
                ->where('results.school_id', Auth::user()->id)
                ->where('attendance.school_id', Auth::user()->id)
                ->groupBy('results.student_id','results.student_roll_number', 'present')
                ->orderBy('finalTotal', 'DESC')
                ->orderBy('present', 'DESC')
                ->orderBy('student_roll_number', 'ASC')
                ->get();
                            
    $findRank       = $rank->where('student_id', $student_id);
    $studentRank    = $findRank->keys()->first() + 1;

    return $studentRank;
}

/**
 * Find Rank student in class
 * 
 * @param $class_id
 * @param $section_id
 * @param $term_id
 * @param $student_id
 * @return $studentRank;
 */
function sectionWiseStudnetRank($class_id, $section_id, $term_id, $student_id)
{   
    $rank = DB::table('results')->join('custom_attendance_input as attendance', 'results.student_id', '=', 'attendance.user_id')
                ->select('student_id','student_roll_number', 'attendance.present as present' )->selectRaw("SUM(results.total) as finalTotal")
                ->where('results.institute_class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('results.term_id', $term_id)
                ->where('attendance.result_setting_id', $term_id)
                ->where('results.school_id', Auth::user()->id)
                ->where('attendance.school_id', Auth::user()->id)
                ->groupBy('results.student_id','results.student_roll_number', 'present')
                ->orderBy('finalTotal', 'DESC')
                ->orderBy('present', 'DESC')
                ->orderBy('student_roll_number', 'ASC')
                ->get();
                
    $findRank       = $rank->where('student_id', $student_id);
    $studentRank    = $findRank->keys()->first() + 1;

    return $studentRank;
}


?>
