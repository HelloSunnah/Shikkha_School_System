<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Notice;
use App\Models\Result;
use App\Models\Routine;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Vaccine;
use App\Models\Attendance;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\AssignStudentFee;
use App\Models\AssignmentStudent;
use App\Models\AssignmentTeacher;
use App\Models\StudentMonthlyFee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Count;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile(){
        return view('frontend.user.profile');
    }
    public function profileUpdate(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'phone' => 'required',
            'name' => 'required',
            'address' => 'required',
            'dob' => 'required',
        ]);
        //    dd($request->all());
        $user = User::where('id',$id)->first();
        // dd($user);
        $user->email = $request->email;
        $user->roll_number = $request->roll_number;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->roll_number = $request->roll_number;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->parents_name = $request->parents_name;
        $user->save();
        toast('User Updated Successfully','success');
        return back();
    }
    public function changePassword(Request $request){
        $user = User::where('id',Auth::user()->id)->first();
        if(Hash::check($request->password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            toast('Password Updated Successfully','success');
        }else{
            toast('Sorry Worng Password','error');
        }
        return back();
    }
    public function accountVaccine(){
        $vaccine = Vaccine::where('student_id',Auth::user()->id)->first();
        return view('frontend.user.vaccine',compact('vaccine'));
    }
    public function vaccineUpdate(Request $request){
        if(($request->id != 0)){
            $request->validate([
                'birth_certificate_no' => 'required',
                'vaccine' => 'required',
            ]);
            $vaccine = new Vaccine();
            $vaccine->birth_certificate_no = $request->birth_certificate_no;
            $vaccine->vaccine = $request->vaccine;
            $vaccine->student_id = Auth::user()->id;
            $vaccine->save();
            toast('Vaccine Info Uploaded Successfully','success');
            return back();
        }else{

            $request->validate([
                'birth_certificate_no' => 'required',
                'vaccine' => 'required',
            ]);
            $vaccine = Vaccine::where('student_id',Auth::user()->id)->first();
            $vaccine->birth_certificate_no = $request->birth_certificate_no;
            $vaccine->vaccine = $request->vaccine;
            $vaccine->student_id = Auth::user()->id;
            $vaccine->save();
            toast('Vaccine Info Updated Successfully','success');
            return back();
        }
    }
    public function onlineClass($id){
        $teacher = Teacher::where('id',$id)->first();
        return view('frontend.user.meet',compact('teacher'));
    }
    public function notice(){
        $dataAll = Notice::where('school_id',Auth::user()->school_id)->where('class_id',0)->get()->toArray();
        $dataSpecific = Notice::where('school_id',Auth::user()->school_id)->where('class_id',Auth::user()->class_id)->get()->toArray();
        $showData = array_merge($dataAll,$dataSpecific);
        dd($showData);
    }
    /**
     * Show All Assignment Student Panel (Sajjad)
     * 
     * @param $subject_id
     * @param $teacher_id
     * @return \Illuminate\Contracts\View\View
     */
    public function assignmentAll($subject_id, $teacher_id){
        $data = AssignmentTeacher::where('class_id', Auth::user()->class_id)
                                    ->where('section_id', Auth::user()->section_id)
                                    ->where('subject_id', $subject_id)
                                    ->where('teacher_id', $teacher_id)
                                    ->where('status', 0)
                                    ->get();
      return view('frontend.user.assignment.showAll',compact('data'));
    }

    /**
     * Student Upload Assignment (Sajjad)
     * 
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function userUploadAssignment($id){
        $assignment = AssignmentTeacher::where('id', $id)->first();
        return view('frontend.user.assignment.showDetailsUpload',compact('assignment'));
    }

    public function userAssignmentFile($id)
    {
        $assignment = AssignmentTeacher::where('id', $id)->first();
        $path = basename($assignment->file);
        // dd($assignment->file);
        $url = Storage::url("uploads/TeacherFile".'/'.$path);
        return response()->download($assignment->file);
    }

    public function userTeacherUploadAssignment(Request $request){

         $data = new AssignmentStudent();
         $data->title = $request->title;
         $data->description = $request->description;
         $data->user_id = Auth::user()->id;
         $data->assignment_teachers_id = $request->assignment_teachers_id;
        if ($request->file_assignment) {
            $header_file      = $request->file('file_assignment');
            $filename = time().'.'.$header_file->getClientOriginalExtension();
            $header_file_name =  $request->file_assignment->move('storage/uploads/StudentFile/',$filename);
            $data->file_assignment = $header_file_name;
        }

        $data->save();
        toast('Assigment Upload Successfully','success');
        return back();
    }

    public function FeesShow(){
        $showStudent = StudentMonthlyFee::where('student_id', Auth::user()->id)->take(12)->get();
        return view('frontend.user.feeShow',compact('showStudent'));
    }

    public function classAttendanceShow(Request $request,$class_id,$section_id,$group_id){
        $group_id = ($group_id == 0) ? NULL : $group_id;
        $date = is_null($request->date) ? date('m') : $request->date;
        $dataAttendance = Attendance::where('class_id',$class_id)->where('section_id',$section_id)->where('group_id',$group_id)->where('student_id',Auth::user()->id)->whereDate('created_at', $date)->get();
        $dataShow = User::where('class_id',$class_id)->where('section_id',$section_id)->where('group_id',$group_id)->where('id',Auth::user()->id)->get();
        return view('frontend.user.allAttendanceDataShow',compact('class_id','section_id','group_id','date','dataAttendance','dataShow'));

    }

    public function allSubjectShow(){
        // $data = Department::where('class_id',Auth::user()->class_id)->where('section_id',Auth::user()->section_id)->where('group_id',Auth::user()->group_id)->get();
        // $data = Department::where('school_id', Auth::user()->school_id)->get();
        $data = Subject::where('school_id', Auth::user()->school_id)
                        ->where('class_id', Auth::user()->class_id)->get();
        return view('frontend.user.allSubjectDataShow',compact('data'));
    }

    public function allResultShow(){
        $dataResult = Result::where('student_id',Auth::user()->id)->get();
        return view('frontend.user.allResultShow',compact('dataResult'));
    }

    /**
     * Show Notice Student Panel
     * 
     * @return \Illuminate\Contracts\View
     */
    public function showNotice ()
    {
        $dataAll = Notice::where('school_id',Auth::user()->school_id)->where('class_id',0)->get()->toArray();
        $dataSpecific = Notice::where('school_id',Auth::user()->school_id)->where('class_id',Auth::user()->class_id)->get()->toArray();
        $showData = array_merge($dataAll,$dataSpecific);
        $user = User::where('id',Auth::user()->id)->first();
        return view('frontend.user.notice.show_notice',compact('showData','user'));
    }

    /**
     * Show Routine Student Panel
     * 
     * @param $id
     * @return \Illuminate\Contracts\View
     */
    public function showRoutine()
    { 
        $routines = Routine::where([
            'school_id' => Auth::user()->school_id,
            'class_id'  => Auth::user()->class_id,
            'section_id'   => Auth::user()->section_id,
            'shift'=>Auth::user()->shift,

        ])->get()->groupBy('day');

        $data['periods'] = DB::table('class_periods')->where('school_id', Auth::user()->school_id)->where('shift',Auth::user()->shift)->get();

        return view('frontend.user.routine.class_routine', compact('routines', 'data'));
    }
    
    /**
     * Show Student Payment (Sajjad)
     * 
     * @return  
     */
    public function showPayment()
    {   
        $fee = AssignStudentFee::where('month_id', 0)->first();
        // dd($fee->fees_details);
        $currentYear = Carbon::now()->format('Y');
        $newYear = Carbon::parse($currentYear."-01-01");
        $currentMonth = date('Y-m-d', strtotime(Carbon::now(). "+1 months"));
        $studentMonthlyFees = StudentMonthlyFee::where('student_id', Auth::user()->id)
                                ->where('school_id', Auth::user()->school_id)
                                ->whereBetween('created_at', [$newYear, $currentMonth])->get();
        if($fee!==null){
            return view('frontend.user.payment.index', compact('studentMonthlyFees'));
        }
        else{
            Alert::success('Not Payment Submitted','Success Message');

            return view('frontend.user.notice.index');
        }
        
    }

    /**
     * FIND STUDENT PAYMENT INFORMATION
     */
    public function findStudent(Request $request)
    {
        return $request;
        
        $student = User::where('school_id', Auth::id())->where('id', $request->studentId);
        $data['month'] = $request->month;

        if($student->exists())
        {
            $data['student'] = $student->first();
            $data['months'] = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            if($data['month'] != 'n'):
                $data['assignFees'] = AssignStudentFee::where('school_id', Auth::id())->where('class_id', $data['student']->class_id)->whereIn('month_id', $data['month'])->first();
                $data['studentFees'] = StudentMonthlyFee::where('school_id', Auth::id())->where('student_id', $data['student']->id)->whereIn('month_id', $data['month'])->first();
            endif;

            // return $data;
            return view('frontend.school.finance.student-fees', compact('data'));
        }

        Alert::info("Sorry!", 'Record does not exists');
        return back();

    }

    public function student_profile(){
        return view ('');
    }
}
