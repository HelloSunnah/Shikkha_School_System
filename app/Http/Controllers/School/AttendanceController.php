<?php

namespace App\Http\Controllers\School;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Teacher;
use App\Models\Employee;
use App\Models\Attendance;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Http\Request;
use App\Models\StaffAttendance;
use App\Imports\AttendanceImport;
use App\Models\TeacherAttendance;
use App\Models\School;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SchoolController;
use App\Models\CustomAttendanceInput;
use App\Models\InstituteClass;
use App\Models\ResultSetting;
use App\Models\Term;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Validators\ValidationException;

class AttendanceController extends Controller
{
    use HttpResponse;

    /**
     * get attendance from device
     */
    public function getAttendanceFromDevice()
    {
        if (function_exists('socket_sendto')) {
            echo "Socket extension is installed.";
        } else {
            echo "Socket extension is NOT installed.";
        }


        try{
            $zk = new ZKTeco(Auth::user()->zk_ip_address, Auth::user()->zk_ip_port);
        
            if($zk->connect())
            {
                $zk->disableDevice();
                $rows =  $zk->getAttendance();
                
                if(count($rows) > 0)
                {
                    foreach($rows as $row)
                    {
                        $user = User::where('unique_id', $row['id']);

                        if($user->exists())
                        {
                            $student = $user->first();
                            $attendance = new Attendance();
                            $attendance->student_id = $student->id;
                            $attendance->attendance = 1;
                            $attendance->comment = "Fringerprint Attendance";
                            $attendance->school_id = Auth::id(); // school Id
                            $attendance->class_id = getUserName($student->id)->class_id;
                            $attendance->section_id = getUserName($student->id)->section_id;
                            $attendance->group_id = getUserName($student->id)->group_id;
                            $attendance->created_at = $row['timestamp'];
                            $attendance->save();
                        }
                    }

                    User::where("school_id", Auth::id())->get();

                    $zk->clearAttendance();
                    $zk->enableDevice();
                }
                else
                {
                    Alert::info("Opps!", "No record Found");
                    return back();
                }                

                Alert::success("Great!", "Record added successfully");
                return back();
            }

            return "Not connect";
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }


    /** 
     * upload attendance
     * =============================================
     */
    public function uploadAttendance(Request $request)
    {
        $request->validate([
            'file'  =>  ['required', 'mimes:xls,xlsx,csv'],
        ]);

        try {

            $import = new AttendanceImport();
            $import->import($request->file);

            $usersId = User::where("school_id", Auth::id())->pluck('id');

            foreach($usersId as $sid)
            {
                $attExists = Attendance::where('school_id', Auth::id())->where('student_id', $sid)->whereDate('created_at', today())->exists();
            
                if(!$attExists)
                {
                    $student = User::find($sid);

                    Attendance::insert([
                        'student_id'    => $student->id,
                        'attendance'    => 0, // absence
                        'class_id'      => $student->class_id,
                        'section_id'     => $student->section_id,
                        'school_id'     =>  $student->school_id,
                        'comment'     =>  "Fingerprint",
                        'created_at'     =>  today(),
                        'updated_at'     =>  today(),
                    ]);


                    $token   = env('GREENWEB_TOKEN'); // greenweb api access
                    $to      = $student->phone;
                    $message = $student->name . " is absent today(" . date('d-m-Y') . ")";

                    $data = [
                        'to'      => "$to",
                        'message' => "$message",
                        'token'   => "$token"
                    ]; // Add parameters in key value
                    $url = "http://api.greenweb.com.bd/api.php?json";

                }
            }

            Alert::success('Great!', 'Record imported successfully');
            return back();
        } 
        catch (ValidationException $e) 
        {
            $failures = $e->failures();
            Alert("error", $failures);
            return back();
        }
    }


    /**
     * input attendance
     */
    public function inputAttendance(Request $request)
    {   
        $seoTitle = 'Custom Attendance Students';
        $seoDescription = 'Subject Show';
        $seoKeyword = 'Subject Show';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $query = User::where('school_id', Auth::id());

        if($request->has('class_id') && !empty($request->class_id))
        {
            $query->where('class_id', $request->class_id);
        }
        
        if($request->has('section_id') && !empty($request->section_id))
        {
            $query->where('section_id', $request->section_id);
        }

        if($request->has('shift_id') && !empty($request->shift_id))
        {
            $query->where('shift', $request->shift_id);
        }
        

        $data['users'] = $query->orderBy('roll_number')->paginate(7);
        $data['class'] = InstituteClass::where('school_id', Auth::id())->get();
        $data['terms'] = ResultSetting::where('school_id', Auth::id())->get();

        return view('panel.attendance.input', compact('seo_array'))->with($data);
    }



    /**
     * get custom attendance infor
     */
    public function inputAttendanceGet(Request $request)
    {
        try{
            $data['working_days'] = getWorkingDays(Auth::id(), $request->studentId);
            $data['present'] = getPresentDays(Auth::id(), $request->studentId);
            $data['absent'] = getAbsentDays(Auth::id(), $request->studentId);

            return $this->success("success", $data);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage(), $request->all());
        }
    }


    /**
     * save input attendance
     */
    public function saveInputAttendance(Request $request)
    {
        try
        {
            $request->validate([
                'term_id'   =>  ['required'],
                'working_days'  =>  ['required'],
                'present'   =>  ['required'],
                'absent'    =>  ['required']
            ]);
            $class_id = User::findOrFail($request->studentId)->class_id;
            CustomAttendanceInput::updateOrCreate(
                [
                    "school_id" =>  Auth::id(),
                    "user_id"   =>  $request->studentId,
                    "result_setting_id"   =>  $request->term_id
                ],
                [
                    "class_id"      => $class_id,
                    "working_days"  =>  $request->working_days,
                    "present"  =>  $request->present,
                    "absent"  =>  $request->absent,
                ]
            );

            return $this->success("success", $request->all());
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage(), $request->all());
        }
    }


    /**
     * save selected class
     */
    public function classSelectForAbsentSMS(Request $request)
    {
        $raw = School::find(Auth::id());
        
        if(is_array($request->classIds) && count($request->classIds) > 0)
        {
            foreach($request->classIds as $id)
            {
                if(is_null($raw->class_for_absent_sms))
                {
                    $raw->update([
                        'class_for_absent_sms'  => $id
                    ]);
                }
                else
                {
                    if(!in_array($id, explode(",", $raw->class_for_absent_sms)))
                    {
                        $raw->update([
                            'class_for_absent_sms'  => $raw->class_for_absent_sms . ',' . $id
                        ]);
                    }
                    else
                    {
                        return back()->with('error', 'Record already exists');
                    }
                    
                }
            }
        }

        return back()->with('success', 'Record updated successfully');
    }


    // Staff Attendance

    public function staffAttendancePage(){
        $seoTitle = 'Staff Take/View Attendance';
        $seoDescription = 'Staff Attendance';
        $seoKeyword = 'Staff Attendance';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $defaultDate = Carbon::today()->format('Y-m-d');
        return view('frontend.school.staff.StaffAttendance.ViewPage',compact('defaultDate','seo_array'));
    }



    public function StaffAttendance($date)
    {   
        $seoTitle = 'Staff Attendance';
        $seoDescription = 'Staff Attendance';
        $seoKeyword = 'Staff Attendance';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('d M, Y');
        $school = School::find(Auth::user()->id);
        $dataAttendance = StaffAttendance::where('school_id', Auth::id())->whereDate('created_at', $date)->get()->unique('employee_id');
        $dataShow=Employee::where("school_id", Auth::user()->id)->get();
         
        return view('frontend.school.staff.StaffAttendance.StaffAttendance',compact('dataShow','dataAttendance','date', 'formattedDate', 'school','seo_array'));
    }


    public function StaffAttendance_DatePost(Request $request){
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        //dd($request->all());
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([
                'date' => 'required',
            ]);

            $date = $request->date;
            return redirect()->route('StaffAttendance', [ 'date' => $date]);
           }
    }

    
    public function StaffAttendance_post(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            foreach ($request->employee_id as $index => $code) {
                $attend = StaffAttendance::where("school_id", Auth::user()->id)
                             ->where('employee_id', $code)
                             ->whereDate('created_at', $request->segment_date)->delete();
                           
                 $attendance = StaffAttendance::create(
                     [                
                         "employee_id"    => $code,
                         "school_id"     => Auth::user()->id,
                         "created_at"    => $request->segment_date." "."15:41:51",
                         "attendance"    => $request->attendance[$code][0],
                         "comment"       => $request->comment[$index],
                     ]
                 );
             }
             toast("Attendance Save Successfully", "success");
             return back();
         }
    }


    public function Staff_confirmabsentpresent(Request $request ,$id){
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $data = StaffAttendance::find($id);
            $data->attendance = $request->attendance;
            $data->save();
            toast("Attendance Update Successfully", "success");
            return back();
        }
    }


   public function StaffAttendance_AllView()
   {    
        $seoTitle = 'Staff Attendance Monthly';
        $seoDescription = 'Staff Attendance Monthly';
        $seoKeyword = 'Staff Attendance Monthly';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.school.staff.StaffAttendance.AllStaffAttendance',compact('seo_array'));
   }


   public function StaffAttendance_AllView_Post(Request $request)
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        //dd($request->all());
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([
                'month_id' => 'required',
            ]);
            $date = $request->month_id;

            return redirect()->route('StaffAttendance.Month', [ 'date' => $date]);
        }
    }

    public function StaffAttendance_Month($date){
        $seoTitle = 'Staff Attendance Monthly';
        $seoDescription = 'Staff Attendance Monthly';
        $seoKeyword = 'Staff Attendance Monthly';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $school = School::find(Auth::user()->id);
        $dataAttendance = StaffAttendance::where("school_id", Auth::user()->id)->whereDate('created_at', $date)->get();
        $dataShow = Employee::where("school_id", Auth::user()->id)->get();
        return view('frontend.school.staff.StaffAttendance.AttendanceMonthView',compact('school','dataAttendance','dataShow','date','seo_array'));
    }
    
    //teacher Attendance
    public function Teacher_datepage(){
        $seoTitle = 'Teacher Take/View Attendance';
        $seoDescription = 'Teacher Take/View Attendance';
        $seoKeyword = 'Teacher Take/View Attendance';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $defaultDate = Carbon::today()->format('Y-m-d');
        return view('frontend.school.teacher.TeacherAttendance.dateView',compact('defaultDate','seo_array'));
    }

    public function datepage_post(Request $request){
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        //dd($request->all());
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([
                'date' => 'required',
            ]);

            $date = $request->date;
            
            return redirect()->route('TeacherAttendance.page', [ 'date' => $date]);
           }
    }


    public function TeacherAttendance_page($date)
    {   
        $seoTitle = 'Teacher Attendance';
        $seoDescription = 'Teacher Attendance';
        $seoKeyword = 'Teacher Attendance';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('d M, Y');
        $dataAttendance = TeacherAttendance::where('school_id', Auth::id())->whereDate('created_at',$date)->get()->unique('teacher_id');
        $dataShow=Teacher::where("school_id", Auth::user()->id)->get();
        $school = School::find(Auth::user()->id);
        return view('frontend.school.teacher.TeacherAttendance.TeacherAttendancePage' ,compact('dataAttendance','dataShow','formattedDate','school','date','seo_array'));
    }
    

    public function TeacherAttendance_post(Request $request){
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            foreach ($request->teacher_id as $index => $code) {
                $attend = TeacherAttendance::where("school_id", Auth::user()->id)
                             ->where('teacher_id', $code)
                             ->whereDate('created_at', $request->segment_date)->delete();
                           
                 $attendance = TeacherAttendance::create(
                     [                
                         "teacher_id"    => $code,
                         "school_id"     => Auth::user()->id,
                         "created_at"    => $request->segment_date." ".date("H:i:s"),
                         "attendance"    => $request->attendance[$code][0],
                         "comment"       => $request->comment[$index],
                     ]
                 );
             }
             toast("Attendance Save Successfully", "success");
             return back();
         }
   }

    public function TeacherAttendance_AllView(){
        $seoTitle = 'Teacher Attendance Monthly';
        $seoDescription = 'Teacher Attendance Monthly';
        $seoKeyword = 'Teacher Attendance Monthly';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.school.teacher.TeacherAttendance.AllTeacherView',compact('seo_array'));
    }

    public function TeacherAttendance_Viewpost(Request $request){
        if (Auth::user()->status == 0) {
            return redirect()->route('school.payment.info');
        } elseif (Auth::user()->status == 2) {
            toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
            return back();
        }
        if (Auth::user()->is_editor != 3) {
            return back();
        } else {
            $request->validate([
                'month_id' => 'required',
            ]);
            $date = $request->month_id;
             
            return redirect()->route('TeacherAttendance.Month', [ 'date' => $date]);
        }
    }

    public function TeacherAttendance_Month($date){
        $seoTitle = 'Teacher Attendance Monthly';
        $seoDescription = 'Teacher Attendance Monthly';
        $seoKeyword = 'Teacher Attendance Monthly';
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        $school = School::find(Auth::user()->id);
        $dataAttendance = TeacherAttendance::where("school_id", Auth::user()->id)->whereDate('created_at', $date)->get();
        $dataShow = Teacher::where("school_id", Auth::user()->id)->get();
        return view('frontend.school.teacher.TeacherAttendance.TeacherMonthView',compact('school','dataAttendance','dataShow','date','seo_array'));
   }

   public function Teacher_confirmabsentpresent(Request $request, $id){
    if (Auth::user()->status == 0) {
        return redirect()->route('school.payment.info');
    } elseif (Auth::user()->status == 2) {
        toast('Sorry Admin can Inactive Your Account Please Contact', 'error');
        return back();
    }
    if (Auth::user()->is_editor != 3) {
        return back();
    } else {
        $data = TeacherAttendance::find($id);
        $data->attendance = $request->attendance;
        $data->save();
        toast("Attendance Update Successfully", "success");
        return back();
    }
   }


   public function Attendance_dashboard(){
    $seoTitle = 'Student Attendance Dashboard';
    $seoDescription = 'Student Attendance Dashboard';
    $seoKeyword = 'Student Attendance Dashboard';
    $seo_array = [
        'seoTitle' => $seoTitle,
        'seoKeyword' => $seoKeyword,
        'seoDescription' => $seoDescription,
    ];
    return view ('frontend.school.student.Attendancedashboard.Sdashboard', compact('seo_array'));
   }
   public function Attendance_profile(){
    return view ('frontend.school.student.Attendancedashboard.SAttendanceProfile');
   }


   /**
    * show student list in dashboard
    */
   public function Studentdetailsdashboard(Request $request)
   {  
        try
        {
            $seoTitle = 'Student Attendance Dashboard';
            $seoDescription = 'Student Attendance Dashboard';
            $seoKeyword = 'Student Attendance Dashboard';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
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
                return view('frontend.school.student.Attendancedashboard.Studentdetailsdashboard',compact('seo_array'))->with($data);
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
                return abort(403, $e->getMessage());
            }
        }
   }


   /**
    * show Teacher list in dashboard
    */
   public function teacherAttendanceDashboard(Request $request)
   {
        try
        {    
            $seoTitle = 'Teacher Attendance Dashboard';
            $seoDescription = 'Teacher Attendance Dashboard';
            $seoKeyword = 'Teacher Attendance Dashboard';
            $seo_array = [
                'seoTitle' => $seoTitle,
                'seoKeyword' => $seoKeyword,
                'seoDescription' => $seoDescription,
            ];
            $users = Teacher::where('school_id', Auth::id());

            if($request->has('shift') && !empty($request->shift))
            {
                $users->where('shift', $request->shift);
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
                $users->orderBy('id');
            }

            $data['users'] = $users->get();

            if($request->ajax())
            {
                return $this->success(count($data['users']) . " record fetched", $data);
            }
            else
            {
                return view('frontend.school.student.Attendancedashboard.teacher_dashboard',compact('seo_array'))->with($data);
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
                return abort(403, $e->getMessage());
            }
        }
   }

   /**
    * update user list from stellar api
    */
   protected function updateDeviceConnectedUserList()
   {
        try
        {
            if(Auth::check())
            {
                $schoolId = Auth::id();
                $username = Auth::user()->device_username;
                $updateCount = 0;

                if(!is_null($username) && !empty($username)):
                    
                    $data = \App\Helper\Utility::fetchUserListInDevice($username);
                    
                    if(!is_null($data) && !empty($data))
                    {
                        $connectedUsers = array_column($data, 'registraton_id');

                        $students = User::where('school_id', $schoolId)->pluck('unique_id', 'id');
                    
                        foreach($students as $userId => $uniqueId)
                        {
                            $user = User::find($userId);
                            if(in_array($uniqueId, $connectedUsers))
                            {
                                $user->update(['device_connected'=>1]);
                                ++$updateCount;
                            }
                            else
                            {
                                $user->update(['device_connected'=>0]);
                            }
                        } 
                    
                        $teachers = Teacher::where('school_id', $schoolId)->pluck('unique_id', 'id');

                        foreach($teachers as $userId => $uniqueId)
                        {
                            if(in_array($uniqueId, $connectedUsers))
                            {
                                Teacher::find($userId)->update(['device_connected'=>1]);
                                ++$updateCount;
                            }
                        }

                        return $this->success($updateCount . " record updated successfully");
                    }
                    else
                    {
                        return $this->error("Stellar API data does not exists");
                    }

                else:
                    return $this->error("Device is not connected");
                endif;

            }
            else
            {
                return $this->error("Your session is over. Please login.");
            }
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }
   }
}
