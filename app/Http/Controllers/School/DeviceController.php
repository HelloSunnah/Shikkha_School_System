<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\TeacherAttendance;
use App\Models\Employee;
use App\Models\School;
use App\Models\StaffAttendance;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DeviceController extends Controller
{

    /**
     * new user registration to fingerprint device
     */
    public function addNewUserToDevice()
    {
        return view("panel.attendance.iframe");
    }


    /**
     * view auto settings
     */
    public function autoAttendanceSettings()
    {   
         
        return view('panel.attendance.auto-settings',compact('seo_array'));
    }


    /**
     * store auto attendance settings
     */
    public function storeAutoAttendanceSettings(Request $request)
    {
        // $request->validate([
        //     'send_absent_sms_at_morning'    =>  ['required'],
        //     'send_absent_sms_at_day'    =>  ['required'],
        //     'send_absent_sms_at_evening'    =>  ['required'],
        // ]);

        try
        {

            School::find(Auth::id())->update([
                'send_absent_sms_at_morning'  =>  date("H:i:s", strtotime($request->send_absent_sms_at_morning)),
                'send_absent_sms_at_day'  =>  date("H:i:s", strtotime($request->send_absent_sms_at_day)),
                'send_absent_sms_at_evening'  =>  date("H:i:s", strtotime($request->send_absent_sms_at_evening)),
            ]);


            toast('Record updated successfully');
        }
        catch(Exception $e)
        {
            toast($e->getMessage());
        }

        return back();
    }


    /**
     * get fetch log from stellar device
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getFetchLog(Request $request)
    {
        try
        {
            date_default_timezone_set('Asia/Dhaka');

            $result = $this->sendCurlRequest($request);

            if(!empty($result->log))
            {
                foreach($result->log as $item)
                {
                    $strLength = strlen($item->registration_id);

                    if($strLength == 9) // student
                    {
                        $this->userAttendance($item);
                    }

                    elseif($strLength == 8) // teacher
                    {
                        $this->teacherAttendance($item);
                    }

                    elseif($strLength == 7) // employee
                    {
                        $this->employeeAttendance($item);
                    }
                }

                $this->userAbsence($item);
                $this->teacherAbsence($item);
                $this->employeeAbsence($item);
            }
            else
            {
                Alert::error('Sorry!', 'Data does not exists');
                return back();
            }
            
            Alert::success('Fetch data successfully', 'Great!');
            return back();
        }
        catch(Exception $e)
        {
            Alert::error('Server Error!', $e->getMessage());
            return back();
        }
    }


    /**
     * send curl request
     * 
     * @param mixed $request
     * 
     * @return mixed
     */
    protected static function sendCurlRequest($request)
    {
        $data = array(
            "operation" => "fetch_log",
            "auth_user" => Auth::user()->device_username,
            "auth_code" => env('STELLAR_AUTH_CODE'),
            "start_date"=> date("Y-m-d", strtotime($request->from_date)),
            "end_date"  => date("Y-m-d", strtotime($request->to_date)),
            // "start_time"=> "00:00:00",
            // "end_time"  => "23:59:00"
        );

        $datapayload = json_encode($data);
        $api_request = curl_init('https://rumytechnologies.com/rams/json_api');
        curl_setopt($api_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($api_request, CURLINFO_HEADER_OUT, true);
        curl_setopt($api_request, CURLOPT_POST, true);
        curl_setopt($api_request, CURLOPT_POSTFIELDS, $datapayload);
        curl_setopt($api_request, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Content-Length: ' . strlen($datapayload)));
        $result = curl_exec($api_request);
        
        return json_decode($result);
    }



    /**
     * save User attendance
     * 
     * @param mixed $data
     * 
     * @return bool
     */
    protected function userAttendance($data)
    {
        $raw = User::where('school_id', Auth::id())->where('unique_id', $data->registration_id);

        if($raw->exists())
        {
            $user = $raw->first();

            if(!is_null($data->access_date) && !empty($data->access_date) && !is_null($data->access_time) && !empty($data->access_time)):
                Attendance::updateOrCreate(
                    [
                        'student_id'    => $user->id,
                        'class_id'      => $user->class_id,
                        'section_id'    => $user->section_id,
                        'school_id'     => $user->school_id,
                        'access_date'   => $data->access_date,
                    ],
                    [
                        'attendance'    => 1,
                        'comment'       => "Fingerprint",
                        'access_time'   => $data->access_time,
                    ]
                );
            endif;

            return true;
        }

        return false;
    }


    /**
     * save teacher attendance
     * 
     * @param mixed $data
     * 
     * @return bool
     */
    protected function teacherAttendance($data)
    {
        $raw = Teacher::where('school_id', Auth::id())->where('unique_id', $data->registration_id);

        if($raw->exists())
        {
            $user = $raw->first();

            if(!is_null($data->access_date) && !empty($data->access_date) && !is_null($data->access_time) && !empty($data->access_time)):
                TeacherAttendance::updateOrCreate(
                    [
                        'teacher_id'    => $user->id,
                        'school_id'     =>  $user->school_id,
                        'access_date'   =>  $data->access_date,
                    ],
                    [
                        'attendance'    =>  1,
                        'comment'       =>  "Fingerprint",
                        'access_time'   =>  $data->access_time
                    ]
                );
            endif;

            return true;
        }

        return false;
    }


    /**
     * save Employee attendance
     * 
     * @param mixed $data
     * 
     * @return bool
     */
    protected function employeeAttendance($data)
    {
        $raw = Employee::where('school_id', Auth::id())->where('employee_id', $data->registration_id);

        if($raw->exists())
        {
            $user = $raw->first();

            if(!is_null($data->access_date) && !empty($data->access_date) && !is_null($data->access_time) && !empty($data->access_time)):
            
                StaffAttendance::updateOrCreate(
                    [
                        'employee_id'    => $user->id,             
                        'school_id'     =>  $user->school_id,
                        'access_date'   =>  $data->access_date,
                    ],
                    [
                        'attendance'    => 1,
                        'comment'       =>  "Fingerprint",
                        'access_time'   =>  $data->access_time,
                    ]
                );

            endif;

            return true;
        }

        return false;
    }


    /**
     * make absence for user
     * 
     * @param mixed $data
     * 
     * @return void
     */
    protected function userAbsence($data)
    {
        // processing for absence
        $usersId = User::where("school_id", Auth::id())->pluck('id');

        foreach($usersId as $sid)
        {
            $attExists = Attendance::where('school_id', Auth::id())->where('student_id', $sid)->whereDate('created_at', date('Y-m-d'))->where('attendance', 1)->exists();
        
            if(!$attExists)
            {
                $student = User::find($sid);
                Attendance::updateOrCreate(
                    [
                        'student_id'    => $student->id,
                        'class_id'      => $student->class_id,
                        'section_id'    => $student->section_id,
                        'school_id'     => $student->school_id,
                        'access_date'   =>  date("Y-m-d"),
                    ],
                    [
                        'attendance'    => 0, //absence
                        'comment'       => "Fingerprint",
                    ]
                );
            }
        }
            
    }




    /**
     * make absence for teacher
     * 
     * @param mixed $data
     * 
     * @return void
     */
    protected function teacherAbsence($data)
    {
        // processing for absence
        $usersId = Teacher::where("school_id", Auth::id())->pluck('id');

        foreach($usersId as $sid)
        {
            $attExists = DB::table('teacher_attendances')->where('school_id', Auth::id())->where('teacher_id', $sid)->whereDate('created_at', date('Y-m-d'))->where('attendance', 1)->exists();
        
            if(!$attExists)
            {
                $user = Teacher::find($sid);

                TeacherAttendance::updateOrCreate(
                    [
                        'teacher_id'    => $user->id,
                        'school_id'     =>  $user->school_id,
                        'access_date'   =>  date("Y-m-d")
                    ],
                    [
                        'attendance'    =>  0, // absence
                        'comment'       =>  "Fingerprint",
                    ]
                );

            }
        }
            
    }



    /**
     * make absence for employee
     * 
     * @param mixed $data
     * 
     * @return void
     */
    protected function employeeAbsence($data)
    {
        // processing for absence
        $usersId = Employee::where("school_id", Auth::id())->pluck('id');

        foreach($usersId as $sid)
        {
            $attExists = DB::table('staff_attendances')->where('school_id', Auth::id())->where('employee_id', $sid)->whereDate('created_at', date('Y-m-d'))->where('attendance', 1)->exists();
        
            if(!$attExists)
            {
                $user = Employee::find($sid);

                StaffAttendance::updateOrCreate(
                    [
                        'employee_id'    => $user->id,             
                        'school_id'     =>  $user->school_id,
                        'access_date'   =>  date("Y-m-d"),
                    ],
                    [
                        'attendance'    => 0, //absence
                        'comment'       =>  "Fingerprint",
                    ]
                );

            }
        }
    }


    /**
     * show device settings page
     */
    public function index()
    {
        $seoTitle = 'Device  Setting';
        $seoDescription = 'Device  Setting' ;
        $seoKeyword = 'Device  Setting' ;
        $seo_array = [
            'seoTitle' => $seoTitle,
            'seoKeyword' => $seoKeyword,
            'seoDescription' => $seoDescription,
        ];
        return view('frontend.school.settings.form',compact('seo_array'));
    }


    /**
     * 
     */
    public function update(Request $request)
    {
        try{
            $school = School::find(Auth::id());
            $school->device_address = $request->device_address;
            $school->device_username    = $request->device_username;
            $school->save();

            Alert::success("Record updated Successfully", 'Server Error');
            return back();
        }
        catch(Exception $e)
        {
            Alert::error($e->getMessage(), 'Server Error');
            return back();
        }

    }
}
