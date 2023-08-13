<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultCreatePost;
use App\Models\AssignmentStudent;
use App\Models\AssignmentTeacher;
use App\Models\AssignTeacher;
use App\Models\Attendance;
use App\Models\Message;
use App\Models\Notice;
use App\Models\Result;
use App\Models\Routine;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSalary;
use App\Models\Term;
use App\Models\Todolist;
use App\Models\User;
use App\Models\ClassPeriod;
use App\Models\MarkType;
use App\Models\School;
use App\Models\VaccineTeacher;
use Exception;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use App\Notifications\AssignmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function teacherDashboard(){
        $abc = Carbon::now()->format('Y-m-d');
        $data = AssignTeacher::where('teacher_id',Auth::user()->id)->get();
        $showData = Notice::where('school_id',Auth::user()->school_id)->orderby('id','desc')->get()->toArray();
        $todo = \App\Models\Todolist::where('teacher_id',Auth::user()->id)->where('date', '>=', $abc )->orderBy('date', 'asc')->get();
        //  return $abc;
        //return $abc = \App\Models\Routine::where('teacher_id',Auth::user()->id)->get()->groupBy('subject_id');
        return view('frontend.teacher.dashboard',compact('data','showData','todo'));
    }
    
    public function myClassRoom(){
        $data = AssignTeacher::where('teacher_id',Auth::user()->id)->get();
        $classes = Routine:: where('teacher_id', Auth::user()->id)->get()->groupBy('subject_id');
        $dataTerm = Term::where('school_id', Auth::user()->school_id)->orderby('id','desc')->get();
        return view('frontend.teacher.myClassRoom',compact('data','classes', 'dataTerm'));
    }

    public function profile(){
        // $data = Auth::user()->id->first();
        return view('frontend.teacher.profile');
    }

    public function profileUpdate(Request $request,$id){
    // dd($request->all());
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'phone' => 'required|unique:teachers',
            'full_name' => 'required',
            'address' => 'required',
        ]);
          //  dd($request->all());
        $user = Teacher::where('id',$id)->first();

        if ($request->hasFile('image')) {
            // File::delete(public_path($teacher->image));
            $fileName = time() . '.' . $request->file('image')->getclientOriginalExtension();
            $request->file('image')->move(public_path('/uploads/teacher'), $fileName);
            $fileName = "/uploads/teacher/" . $fileName;
            $user->image = $fileName;
        }

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->full_name = $request->full_name;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->Nationality = $request->Nationality;
        $user->blood_group = $request->blood_group;
        $user->shift = $request->shift;
        $user->about = $request->about;
        $user->M_status = $request->M_status;
        $user->shift = $request->shift;
        $user->department_name = $request->department_name;
        $user->save();
        toast('Teacher Updated Successfully','success');
        return back();


    }

    public function changePassword(Request $request){
        dd($request->all());

        $request->validate([
            'old_password' => 'required',
            'password' => 'required',
            'change_password' => 'required|confirmed',
        ],
        [
            'old_password' =>'Not Matched With Password.',
            'change_password' =>'Not Matched With Password.',
        ]);
        
        $user = Teacher::where('id',Auth::user()->id)->first();
        
        if(Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            toast('Password Updated Successfully','success');
            return back()->with('success', 'Password changed successfully!');
        }else{
            toast('Sorry Password Not Matched','error');
        }
        return back()->with('error', 'Password not changed!');
        
    }

    public function accountVaccine(){
        $vaccine = VaccineTeacher::where('teacher_id',Auth::user()->id)->first();
        return view('frontend.teacher.vaccine',compact('vaccine'));
    }

    public function vaccineUpdate(Request $request){
        //dd($request->all());
        if(($request->id != 0)){
            $request->validate([
                'birth_certificate_no' => 'required',
                'vaccine' => 'required',
            ]);
            $vaccine = new VaccineTeacher();
            $vaccine->birth_certificate_no = $request->birth_certificate_no;
            $vaccine->vaccine = $request->vaccine;
            $vaccine->teacher_id = Auth::user()->id;
            $vaccine->save();
            toast('Vaccine Info Uploaded Successfully','success');
            return back();
        }else{
            //  dd(1);
            $request->validate([
                'birth_certificate_no' => 'required',
                'vaccine' => 'required',
            ]);

            $vaccine = VaccineTeacher::where('teacher_id',Auth::user()->id)->first();
            $vaccine->birth_certificate_no = $request->birth_certificate_no;
            $vaccine->vaccine = $request->vaccine;
            $vaccine->teacher_id = Auth::user()->id;
            $vaccine->save();
            toast('Vaccine Info Updated Successfully','success');
            return back();
        }


    }

    public function onlineClass(){
        $teacher = Teacher::where('id',Auth::user()->id)->first();
        return view('frontend.teacher.meet',compact('teacher'));
    }

    /**
     * Result Update View Page 
     * 
     * @param $subject_id
     * @param $class_id
     * @param $section_id
     * @return \Illuminate\Contracts\View\View
     */
    public function resultUpload(Request $request){
        $group_id = 0;
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;
        $section_id = $request->section_id;
        if (true) {
            $request->validate([
                'term_name' => 'required|numeric|min:1|'
            ],
            [
               'term_name.required' => "If Input Your Subject Result then First Choose Term" 
            ]);
        }

        $group_id = ($group_id == 0) ? NULL : $group_id;
        $dataStudent = User::where('class_id', $class_id)
                         ->where('section_id', $section_id)
                         ->where('group_id', $group_id)
                         ->where('school_id', Auth::user()->school_id)
                         ->get();
        $dataSubject = Subject::where('id', $subject_id)->first();
        $dataTermId = $request->term_name;
        $markTypes = MarkType::where('institute_classes_id', $class_id)->where('school_id', Auth::user()->school_id)->orderBy('id', 'asc')->get();
        if (count($markTypes) == 0) {
            toast("First create mark type for this class", "error");
            return back();
        }
        return view('frontend.teacher.result', compact('dataStudent','dataSubject','dataTermId', 'markTypes', 'class_id'));
    }

    /**
     * Update Student Result
     * 
     * @param ResultCreatePost
     * @param $request
     * @return Response
     */
    public function resultCreatePost(ResultCreatePost $request)
    {
        $request->validated();

        if(is_array($request->student_id) && count($request->student_id) > 0):
            try {        
                foreach ($request->student_id as $key => $data) {
                    $dataHave = Result::where('student_id', $data)->where('subject_id', $request->subject_id)->where('term_id', $request->term_id)->first();
                    if (isset($dataHave)) {
                        $result = Result::where('id', $dataHave->id)->first();
                    } else {
                        $result = new Result();
                    }
                    $result->school_id = Auth::user()->school_id;
                    $result->student_id = $data;
                    $result->student_roll_number = $request->student_roll_number[$key];
                    $result->institute_class_id  = $request->class_id;
                    $result->subject_id = $request->subject_id;
                    $result->term_id = $request->term_id;
                    $result->attendance =  is_null($request->Attendance) ? 0 : $request->Attendance[$key] ?? 0;
                    $result->assignment =  is_null($request->Assignment) ? 0 : $request->Assignment[$key] ?? 0;
                    $result->class_test =  is_null($request->Class_Test) ? 0 : $request->Class_Test[$key] ?? 0;
                    $result->presentation =  is_null($request->Presentation) ? 0 : $request->Presentation[$key] ?? 0;
                    $result->quiz =  is_null($request->Quiz) ? 0 : $request->Quiz[$key] ?? 0;
                    $result->practical =  is_null($request->Practical) ? 0 : $request->Practical[$key] ?? 0;
                    $result->written = is_null($request->Written) ? 0 : $request->Written[$key] ?? 0;
                    $result->mcq =  is_null($request->MCQ) ? 0 : $request->MCQ[$key] ?? 0;
                    $result->others =  is_null($request->Others) ? 0 : $request->Others[$key] ?? 0;
                    $result->total  = totalMark($result);
                    $result->grade  = grade($result->total, $request->term_id);
                    $result->gpa  = gpa($result->total, $request->term_id);
                    $result->save();
                }
    
                toast('Mark Save Sucessfully', 'success');
            }
            catch(Exception $e)
            {
                toast($e->getMessage(), 'error');
            }        
        
        else:
            toast('Please select at least one item', 'error');
        endif;        
        return back();

    }


    public function attendanceUpload($class_id,$section_id,$group_id){
        $group_id = ($group_id == 0) ? NULL : $group_id;
        $date = date('Y-m-d');
        $dataAtt = Attendance::where('class_id',$class_id)
                            ->where('section_id',$section_id)
                            ->where('group_id',$group_id)
                            ->whereDate('created_at', $date)
                            ->get();
        $dataUser = User::where('class_id',$class_id)
                         ->where('section_id',$section_id)
                         ->where('group_id',$group_id)->get();

        return view('frontend.teacher.attendance',compact('dataUser','dataAtt'));
    }

    public function attendanceCreatePost(Request $request){
       // dd($request->all());
        foreach( $request->student_id as $index => $code ) {
            $attendance = new Attendance();

            $attendance->student_id = $code;
            $attendance->attendance = $request->attendance[$code][0];
            $attendance->comment = $request->comment[$index];
            $attendance->school_id = Auth::user()->school_id;
            $attendance->class_id = getUserNameForAll($code)->class_id;
            $attendance->section_id = getUserNameForAll($code)->section_id;
            $attendance->group_id = getUserNameForAll($code)->group_id;

            $attendance->save();
            if($request->attendance[$code][0] == 0){
                $token   = env('GREENWEB_TOKEN');
                $code    = getUserNameForAll($code)->id;
                $to      = getUserNameForAll($code)->phone;
                $message = 'Student Name:'.getUserNameForAll($code)->name . ' is Absent';

                $url = "http://api.greenweb.com.bd/api.php?json";

                $data = [
                    'to'      => "$to",
                    'message' => "$message",
                    'token'   => "$token"
                ]; // Add parameters in key value

                $ch = curl_init(); // Initialize cURL
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);

                $dataMessage = new Message();
                $dataMessage->school_id = Auth::user()->school_id;
                $dataMessage->message = 1;
                $dataMessage->send_number = getUserNameForAll($code)->phone;
                $dataMessage->save();
            }
            //  $user = User::where('id',$data)->first();

        }
        return back();
    }

    public function attendanceUploadShow($class_id,$section_id,$group_id,$subject_id){
        $group_id = ($group_id == 0) ? NULL : $group_id;
        $dataAss = AssignmentTeacher::where('teacher_id',Auth::user()->id)->orderby('id','desc')->get();
        return view('frontend.teacher.assignment.show',compact('dataAss','class_id','section_id','group_id','subject_id'));
    }
    /**
     * Assignment Upload teacher (Sajjad)
     * 
     * @param Request 
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignmentUploadPost(Request $request){
      $data = New AssignmentTeacher();
      $data->title = $request->title;
      $data->description = $request->description;
      $data->deadline = $request->deadline;
      $data->teacher_id = Auth::user()->id;
      $data->class_id = $request->class_id;
      $data->section_id = $request->section_id;
      $data->group_id = $request->group_id;
      $data->subject_id = $request->subject_id;
      $data->department_id = 0;


        if ($request->file_assignment) {
            $header_file      = $request->file('file_assignment');
            $filename = time().'.'.$header_file->getClientOriginalExtension();
            $header_file_name =  $request->file_assignment->move('storage/uploads/TeacherFile/', $filename);
            $data->file = $header_file_name;
        }

        $data->save();
        $user = User::where('class_id',$request->class_id)->where('section_id',$request->section_id)->where('group_id', $request->group_id)->get();
        Notification::send($user,new AssignmentNotification($request->title));
        toast('Assigment Upload Successfully','success');
        return back();
    }

    public function attendanceDetailsShow($id){
        $data = AssignmentTeacher::where('id',$id)->first();
        $dataStudentUpload = AssignmentStudent::where('assignment_teachers_id',$id)->get();
        return view('frontend.teacher.assignment.showDetails',compact('data','dataStudentUpload'));
    }

    public function confirmAbsentPresent(Request $request,$id){
            $data = Attendance::find($id);
            $data->attendance = $request->attendance;
            $data->save();
            if($request->attendance == 1){
                $token   = "8371b733bd239059f940b857e94d4cf2";
                $code    = getUserNameForAll($data->student_id)->id;
                $to      = getUserNameForAll($data->student_id)->phone;
                $message = 'Student Name:'.getUserNameForAll($data->student_id)->name . ' is now Present';

                $url = "http://api.greenweb.com.bd/api.php?json";

                $data = [
                    'to'      => "$to",
                    'message' => "$message",
                    'token'   => "$token"
                ]; // Add parameters in key value

                $ch = curl_init(); // Initialize cURL
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
            }
            toast('Attendance Updated Successfully','success');
            return back();

    }

    public function studentShow($class_id,$section_id,$group_id){
        $group_id = ($group_id == 0) ? NULL : $group_id;
        $showStudent = User::where('class_id',$class_id)->where('section_id',$section_id)->where('group_id',$group_id)->get();
        return view('frontend.teacher.student.show',compact('showStudent'));
    }

    public function salaryShow(){
        $showStudent = TeacherSalary::where('teacher_id',Auth::user()->id)->get();
        return view('frontend.teacher.salaryShow',compact('showStudent'));
    }

    public function teacherAttendanceShow(){
        $data = AssignTeacher::where('teacher_id',Auth::user()->id)->get();
        $classes = Routine::where('teacher_id', Auth::user()->id)->get()->groupBy('subject_id');

        $showData = Notice::where('school_id',Auth::user()->school_id)->orderby('id','desc')->get()->toArray();
        return view('frontend.teacher.allAttendanceShow',compact('data','showData','classes'));
    }

    public function classAttendanceShow(Request $request,$class_id,$section_id,$group_id){
        $group_id = ($group_id == 0) ? NULL : $group_id;
        $date = is_null($request->date) ? date('m') : $request->date;
        $dataAttendance = Attendance::where('class_id',$class_id)->where('section_id',$section_id)->where('group_id',$group_id)->whereDate('created_at', $date)->get();
        $dataShow = User::where('class_id',$class_id)->where('section_id',$section_id)->where('group_id',$group_id)->get();
        return view('frontend.teacher.allAttendanceDataShow',compact('class_id','section_id','group_id','date','dataAttendance','dataShow'));

    }

    public function teacherResultShow(){
        $data = AssignTeacher::where('teacher_id',Auth::user()->id)->get();
        $classes = Routine::where('teacher_id', Auth::user()->id)->get()->groupBy('subject_id');
        $showData = Notice::where('school_id',Auth::user()->school_id)->orderby('id','desc')->get()->toArray();
        return view('frontend.teacher.allResultShow',compact('data','showData','classes'));
    }
  
    public function  teacherShow(){}

    

    public function teacherResultDataShow(Request $request,$subject_id){
        $dataTerm = Term::orderby('id','desc')->where('school_id',Auth::user()->school_id)->first();
        $dataTermAll = Term::orderby('id','desc')->where('school_id',Auth::user()->school_id)->get();
        if(!is_null($request->term)){
            $term_id = $request->term ;
            $dataResult = Result::where('subject_id',$subject_id)->where('term_id',$term_id)->where('school_id',Auth::user()->school_id)->get();
           // return $subject_id;
        }
        else{
            $term_id = $dataTerm->id;
            $dataResult = Result::where('subject_id',$subject_id)->where('term_id',$term_id)->where('school_id',Auth::user()->school_id)->get();
            
        }
        $term_id = !is_null($request->term) ? $request->term :$dataTerm->id;
        $dataResult = Result::where('subject_id',$subject_id)->where('term_id',$term_id)->where('school_id',Auth::user()->school_id)->get();
       
        return view('frontend.teacher.allResultDataShow',compact('dataResult','subject_id','dataTermAll'));
    }

    public function teacherStudentShow(){
        $data = AssignTeacher::where('teacher_id',Auth::user()->id)->get();
        $showData = Notice::where('school_id',Auth::user()->school_id)->orderby('id','desc')->get()->toArray();
        $classes = Routine::where('teacher_id', Auth::user()->id)->get()->groupBy('subject_id');
        return view('frontend.teacher.allStudentShow',compact('data','showData','classes'));
    }

    public function assignmentStudentShow(){
        $data = AssignTeacher::where('teacher_id',Auth::user()->id)->get();
        $classes = Routine::where('teacher_id', Auth::user()->id)->get()->groupBy('subject_id');
        $showData = Notice::where('school_id',Auth::user()->school_id)->orderby('id','desc')->get()->toArray();
        
        return view('frontend.teacher.allStudentShow',compact('data','showData','classes'));
    }

    public function classStudentShow(Request $request,$class_id,$section_id,$group_id){
        $group_id = ($group_id == 0) ? NULL : $group_id;
        $date = is_null($request->date) ? date('m') : $request->date;
        $dataShow = User::where('class_id',$class_id)->where('section_id',$section_id)->where('group_id',$group_id)->get();
        return view('frontend.teacher.allStudentDataShow',compact('class_id','section_id','group_id','date','dataShow'));

    }

    public function statusUpdateAssignment(Request $request,$id){
       $data = AssignmentTeacher::where('id',$id)->first();
       $data->status = $request->status;
       $data->save();
        toast('Assignment Status Updated Successfully','success');
       return back();
    }

    public function toDolistAdd(Request $request){
        $data = new Todolist();
        $data->task_name = $request->task_name;
        $data->date = $request->date;
        $data->assign_teacher_id = $request->assign_teacher_id;
        $data->priority = $request->priority;
        $data->teacher_id = Auth::user()->id;
        $data->save();

        toast('Task Updated Successfully','success');
        return back();

    }



    public function tododestroy(Request $request)
    {
    
        $key = $request->key;
        $todo = Todolist::destroy($key);
        return redirect()->route('teacher.dashboard');
        
    }

    public function teacherRoutineShow(){
        $rows = Routine::where([
            'school_id' => Auth::user()->school_id,
            'teacher_id' => Auth::user()->id,
        ])->orderBy('day','desc')->get()->groupBy('day');
        
        $data['teachers'] = DB::table('teachers')->where('school_id', Auth::user()->id)->get();
        $data['periods'] = DB::table('class_periods')->where('school_id', Auth::user()->school_id)->get();
        // return $data;
        return view('frontend.teacher.routine.table')->with(compact('rows', 'data'));
    }
    

}
