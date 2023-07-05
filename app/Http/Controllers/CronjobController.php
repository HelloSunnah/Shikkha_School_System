<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Traits\HttpResponse;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\StaffAttendance;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CronjobController extends Controller
{
    use HttpResponse;

    /**
     * set attendance for users
     * 
     * @return never
     */
    public function callAttendance()
    {
        $date = date("Y-m-d");
        $currentTime = date('H:i:s');
        $schools = School::where('status', 1)->get();
        $resp = [];

        if($currentTime >= "07:00:00" || $currentTime <= "18:00:00"):

            try
            {
                
                foreach($schools as $key => $school)
                {
                    // if device is connected
                    if(!is_null($school->device_username) && !is_null($school->device_address))
                    {
                        $result = $this->sendCurlRequest($school->device_username, $date, $date);

                        if(isset($result->log) && !empty($result->log)) // if data exists
                        {
                            $countStudent = 0;
                            $countTeacher = 0;
                            $countEmployee = 0;

                            foreach($result->log as $item)
                            {
                                $strLength = strlen($item->registration_id);

                                if($strLength == 9) // student
                                {
                                    $this->userAttendance($school->id, $item);
                                    ++$countStudent;
                                }

                                elseif($strLength == 8) // teacher
                                {
                                    $this->teacherAttendance($school->id, $item);
                                    ++$countTeacher;
                                }

                                elseif($strLength == 7) // employee
                                {
                                    $this->employeeAttendance($school->id, $item);
                                    ++$countEmployee;
                                }
                            }

                            $userAbsent = $this->userAbsence($school->id);
                            $teacherAbsent = $this->teacherAbsence($school->id);
                            $employeeAbsent = $this->employeeAbsence($school->id);

                            echo "Attendance inserted successfully<br/>";
                            echo "$school->id | $school->school_name <br />";
                            echo "Student Present: $countStudent ==== Teacher Present: $countTeacher ==== Employee Present: $countEmployee <br/>";
                            echo "Student Absent: $userAbsent ==== Teacher Absent: $teacherAbsent ==== Employee Absent: $employeeAbsent <br/>";
                            
                            $resp[] = [
                                "school"    =>  "$school->id | $school->school_name",
                                "present"   =>  "Student: $countStudent ==== Teacher: $countTeacher ==== Employee: $countEmployee",
                                "absent"    =>  "Student: $userAbsent ==== Teacher: $teacherAbsent ==== Employee: $employeeAbsent",
                                "message"   =>  "Attendance inserted successfully",
                            ];
                        }
                        else
                        {
                            echo "Fetch log does not exists <br/>";
                            echo "$school->id | $school->school_name <br />";

                            $resp[] = [
                                "school"    =>  "$school->id | $school->school_name",
                                "message"   =>  "Fetch log does not exists",
                            ];
                        }
                    }

                    else
                    {
                        echo "Device does not exists <br/>";
                        echo "$school->id | $school->school_name <br />";

                        $resp[] = [
                            "school"    =>  "$school->id | $school->school_name",
                            "message"   =>  "Device does not exists",
                        ];
                    }

                    echo "<hr/>";
                    
                }

                DB::table('cron_jobs')
                ->insert([
                    "title" =>  "Call Auto Attendance",
                    "route" =>  url()->current(),
                    "active"=>  1,
                    "response"  =>  json_encode($resp),
                    "created_at"    =>  now()
                ]);

                return "Cronjob running successfully at " . date("d-m-Y H:i:s");
            }
            catch(Exception $e)
            {
                DB::table('cron_jobs')
                ->insert([
                    "title" =>  "Call Auto Attendance",
                    "route" =>  url()->current(),
                    "active"=>  0,
                    "status"=>  "failed",
                    "response"  =>  $e->getMessage(),
                    "created_at"    =>  now()
                ]);

                return $e->getMessage();
            }

        endif;
    }


    /**
     * send  absent SMS to phone number
     * 
     * @return void
     */
    public function sendAbsentSmsToPhone()
    {
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $schools = School::where('status', 1)->get();
        $shift = 0;
        $resp = [];

        if($currentTime >= "07:00:00" || $currentTime <= "18:00:00"):
    
            try
            {

                if($currentTime >= "07:00:00" && $currentTime <= "10:30:00") // morning shift
                {
                    $shift = 1;
                }

                elseif($currentTime >= "10:31:00" && $currentTime <= "15:00:00") // day shift
                {
                    $shift = 2;
                }

                elseif($currentTime >= "15:01:00" && $currentTime <= "18:00:00") // evening shift
                {
                    $shift = 3;
                }


                foreach($schools as $key => $school)
                {
                    // MORNING SHIFT
                    if($shift == 1 && isset($school->send_absent_sms_at_morning) && !is_null($school->send_absent_sms_at_morning) && !empty($school->send_absent_sms_at_morning))
                    {
                        if(!DB::table('student_absent_sms')->where(['school_id'=>$school->id,'shift'=>$shift])->whereDate('created_at', date('Y-m-d'))->exists()):

                            if($school->send_absent_sms_at_morning < $currentTime):

                                $array = [];

                                $raws = Attendance::where('school_id', $school->id)
                                        ->whereHas('user', function($q) use ($shift){
                                            $q->where('shift', $shift);
                                        })
                                        ->whereDate('created_at', $currentDate)
                                        ->where('attendance', 0)
                                        ->get();
                                
                                if(isset($raws) && !empty($raws) && $raws->count() > 0)
                                {
                                    foreach($raws as $raw)
                                    {

                                        if(!is_null($school->class_for_absent_sms) && in_array($raw->class_id, explode(',', $school->class_for_absent_sms))):

                                        $user = User::find($raw->student_id);

                                        $message = "Student: $user->name is Absent at $school->school_name";
                                        $to      = $user->phone;

                                        // send SMS
                                        $this::GreenWebSMS($to, $message);

                                        $array[] = [
                                            "school"  =>  "$school->id|$school->school_name",
                                            "class"  =>  getClassName($raw->class_id)->class_name,
                                            "user"    =>  "$user->id|$user->name|$user->phone",
                                            "message"   =>  $message
                                        ];

                                        endif;
                                    }

                                    DB::table('student_absent_sms')
                                    ->insert([
                                        'school_id' =>  $school->id,
                                        'shift'     =>  $shift,
                                        'data'      =>  json_encode($array),
                                        'created_at'=> now(),
                                        'updated_at'=> now(),
                                    ]);
                                }
                                else
                                {
                                    echo "Attendance Not Found. <br/>";
                                }

                                echo "Successfully send SMS at morning shift. <br/>";
                                echo "$school->id | $school->school_name <br />";

                                $resp[] = [
                                    'school'    =>  "$school->id | $school->school_name",
                                    'message'   =>  "Successfully send SMS at morning shift",
                                ];

                            else:
                                echo "Time Not Matched <br/>";
                                echo "$school->id | $school->school_name <br />";

                                $resp[] = [
                                    'school'    =>  "$school->id | $school->school_name",
                                    'message'   =>  "Time Not Matched",
                                ];
                            endif;
                        
                        else:
                            echo "Already send sms at morning <br/>";
                            echo "$school->id | $school->school_name <br />";

                            $resp[] = [
                                'school'    =>  "$school->id | $school->school_name",
                                'message'   =>  "Already send sms at morning",
                            ];
                        endif;
                    }

                    // DAY SHIFT
                    else if($shift == 2 && isset($school->send_absent_sms_at_day) && !is_null($school->send_absent_sms_at_day) && !empty($school->send_absent_sms_at_day))
                    {
                        if(!DB::table('student_absent_sms')->where(['school_id'=>$school->id,'shift'=>$shift])->whereDate('created_at', date('Y-m-d'))->exists()):

                            if($school->send_absent_sms_at_day < $currentTime):

                                $array = [];

                                $raws = Attendance::where('school_id', $school->id)
                                        ->whereHas('user', function($q) use ($shift){
                                            $q->where('shift', $shift);
                                        })
                                        ->whereDate('created_at', $currentDate)
                                        ->where('attendance', 0)
                                        ->get();

                                
                                if($raws->count() > 0)
                                {
                                    foreach($raws as $raw)
                                    {
                                        if(!is_null($school->class_for_absent_sms) && in_array($raw->class_id, explode(',', $school->class_for_absent_sms))):

                                        $user = User::find($raw->student_id);

                                        $message = "Student: $user->name is Absent at $school->school_name";
                                        $to      = $user->phone;

                                        // send SMS
                                        $this::GreenWebSMS($to, $message);

                                    $array[] = [
                                            "school"  =>  "$school->id|$school->school_name",
                                            "user"    =>  "$user->id|$user->name|$user->phone",
                                            "message"   =>  $message
                                        ];
                                        
                                        endif;
                                    }

                                    DB::table('student_absent_sms')
                                    ->insert([
                                        'school_id' =>  $school->id,
                                        'shift'     =>  $shift,
                                        'data'      =>  json_encode($array),
                                        'created_at'=> now(),
                                        'updated_at'=> now(),
                                    ]);

                                    echo "Successfully send SMS at day shift. <br/>";
                                    echo "$school->id | $school->school_name <br />";

                                    $resp[] = [
                                        'school'    =>  "$school->id | $school->school_name",
                                        'message'   =>  "Successfully send SMS at day shift",
                                    ];
                                }
                                else
                                {
                                    echo "Attendance not found at Day shift<br/>";
                                    echo "$school->id | $school->school_name <br />"; 

                                    $resp[] = [
                                        'school'    =>  "$school->id | $school->school_name",
                                        'message'   =>  "Attendance not found at Day shift",
                                    ];
                                }

                                
                            else:
                                echo "Time Not Matched at Day shift<br/>";
                                echo "$school->id | $school->school_name <br />";    
                                
                                $resp[] = [
                                    'school'    =>  "$school->id | $school->school_name",
                                    'message'   =>  "Time Not Matched at Day shift",
                                ];
                            endif;

                        else:
                            echo "Already send sms at Day <br/>";
                            echo "$school->id | $school->school_name <br />";

                            $resp[] = [
                                'school'    =>  "$school->id | $school->school_name",
                                'message'   =>  "Already send sms at Day",
                            ];
                        endif;
                    }

                    // EVENING SHIFT
                    else if($shift == 3 && isset($school->send_absent_sms_at_evening) && !is_null($school->send_absent_sms_at_evening) && !empty($school->send_absent_sms_at_evening))
                    {
                        if(!DB::table('student_absent_sms')->where(['school_id'=>$school->id,'shift'=>$shift])->whereDate('created_at', date('Y-m-d'))->exists()):

                            if($school->send_absent_sms_at_evening < $currentTime):

                                $array = [];

                                $raws = Attendance::where('school_id', $school->id)
                                        ->whereHas('user', function($q) use ($shift){
                                            $q->where('shift', $shift);
                                        })
                                        ->whereDate('created_at', $currentDate)
                                        ->where('attendance', 0)
                                        ->get();

                                
                                if($raws->count() > 0)
                                {
                                    foreach($raws as $raw)
                                    {
                                        if(!is_null($school->class_for_absent_sms) && in_array($raw->class_id, explode(',', $school->class_for_absent_sms))):

                                        $user = User::find($raw->student_id);

                                        $message = "Student: $user->name is Absent at $school->school_name";
                                        $to      = $user->phone;

                                        // send SMS
                                        $this::GreenWebSMS($to, $message);

                                        $array[] = [
                                            "school"  =>  "$school->id|$school->school_name",
                                            "user"    =>  "$user->id|$user->name|$user->phone",
                                            "message"   =>  $message
                                        ];

                                        endif;
                                    }

                                    DB::table('student_absent_sms')
                                    ->insert([
                                        'school_id' =>  $school->id,
                                        'shift'     =>  $shift,
                                        'data'      =>  json_encode($array),
                                        'created_at'=> now(),
                                        'updated_at'=> now(),
                                    ]);

                                    echo "Successfully send SMS at evening shift. <br/>";
                                    echo "$school->id | $school->school_name <br />";

                                    $resp[] = [
                                        'school'    =>  "$school->id | $school->school_name",
                                        'message'   =>  "Successfully send SMS at evening shift.",
                                    ];
                                }
                                else
                                {
                                    echo "Attendance not found at Evening shift<br/>";
                                    echo "$school->id | $school->school_name <br />";   

                                    $resp[] = [
                                        'school'    =>  "$school->id | $school->school_name",
                                        'message'   =>  "Attendance not found at Evening shift",
                                    ];
                                }
                                
                            else:
                                echo "Time Not Matched at Evening shift<br/>";
                                echo "$school->id | $school->school_name <br />"; 
                                
                                $resp[] = [
                                    'school'    =>  "$school->id | $school->school_name",
                                    'message'   =>  "Time Not Matched at Evening shift",
                                ];
                            endif;

                        else:
                            echo "Already send sms at Evening shift <br/>";
                            echo "$school->id | $school->school_name <br />";

                            $resp[] = [
                                'school'    =>  "$school->id | $school->school_name",
                                'message'   =>  "Already send sms at Evening shift",
                            ];
                        endif;
                    }

                    else
                    {
                        echo "SMS Sending time is null. <br/>";
                        echo "$school->id | $school->school_name <br />";

                        $resp[] = [
                            'school'    =>  "$school->id | $school->school_name",
                            'message'   =>  "SMS Sending time is null",
                        ];
                    }

                    echo "<hr/>";
                }


                DB::table('cron_jobs')
                ->insert([
                    "title" =>  "Schedule SMS Send",
                    "route" =>  url()->current(),
                    "active"=>  1,
                    "response"  =>  json_encode($resp),
                    'created_at'    =>  now()
                ]);
        
            }
            catch(Exception $e)
            {
                DB::table('cron_jobs')
                ->insert([
                    "title" =>  "Schedule SMS Send",
                    "route" =>  url()->current(),
                    "active"=>  0,
                    "status"=>  "failed",
                    "response"  =>  $e->getMessage(),
                    'created_at'    =>  now()
                ]);

                return $e->getMessage();
            }
        endif;

    }


    /**
     * send curl request
     * 
     * @param mixed $request
     * 
     * @return mixed
     */
    protected function sendCurlRequest($deviceUsername, $startDate, $endDate, $startTime = null, $endTIme = null)
    {
        $data = array(
            "operation" => "fetch_log",
            "auth_user" => $deviceUsername,
            "auth_code" => env('STELLAR_AUTH_CODE'),
            "start_date"=> date("Y-m-d", strtotime($startDate)),
            "end_date"  => date("Y-m-d", strtotime($endDate)),
        );

        if(!is_null($startTime))
        {
            $data['start_time'] = $startTime;
        }
        else if(!is_null($endTIme))
        {
            $data['end_time']   = $endTIme;
        }

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
    protected function userAttendance($schoolId, $data)
    {
        $raw = User::where('school_id', $schoolId)->where('unique_id', $data->registration_id);

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
    protected function teacherAttendance($schoolId, $data)
    {
        $raw = Teacher::where('school_id', $schoolId)->where('unique_id', $data->registration_id);

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
    protected function employeeAttendance($schoolId, $data)
    {
        $raw = Employee::where('school_id', $schoolId)->where('employee_id', $data->registration_id);

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
    protected function userAbsence($schoolId)
    {
        // processing for absence
        $usersId = User::where("school_id", $schoolId)->pluck('id');
        $absentCount = 0;

        foreach($usersId as $sid)
        {
            $attExists = Attendance::where('school_id', $schoolId)->where('student_id', $sid)->whereDate('created_at', date('Y-m-d'))->where('attendance', 1)->exists();
        
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

                ++$absentCount;
            }
        }

        return $absentCount;
            
    }




    /**
     * make absence for teacher
     * 
     * @param mixed $data
     * 
     * @return void
     */
    protected function teacherAbsence($schoolId)
    {
        // processing for absence
        $usersId = Teacher::where("school_id", $schoolId)->pluck('id');
        $absentCount = 0;

        foreach($usersId as $sid)
        {
            $attExists = DB::table('teacher_attendances')->where('school_id', $schoolId)->where('teacher_id', $sid)->whereDate('created_at', date('Y-m-d'))->where('attendance', 1)->exists();
        
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

                ++$absentCount;
            }
        }
        
        return $absentCount;
    }



    /**
     * make absence for employee
     * 
     * @param mixed $data
     * 
     * @return void
     */
    protected function employeeAbsence($schoolId)
    {
        // processing for absence
        $usersId = Employee::where("school_id", $schoolId)->pluck('id');
        $absentCount = 0;

        foreach($usersId as $sid)
        {
            $attExists = DB::table('staff_attendances')->where('school_id', $schoolId)->where('employee_id', $sid)->whereDate('created_at', date('Y-m-d'))->where('attendance', 1)->exists();
        
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

                ++$absentCount;
            }
        }

        return $absentCount;
    }

}
