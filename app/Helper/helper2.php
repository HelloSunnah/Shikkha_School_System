<?php

use App\Models\Subject;
use App\Models\Attendance;
use App\Models\CustomAttendanceInput;
use App\Models\StudentFee;
use App\Models\InstituteClass;
use App\Models\StudentMonthlyFee;
use App\Models\User;
use App\Models\SEOModel;
use Illuminate\Support\Facades\DB;

/**
 * get student Monthly fees
 * 
 * @param int $classId
 * 
 * @param int $schoolId
 * 
 * @return mixed
 */
function studentMonthlyFee(int $classId, int $schoolId)
{
    $raw = InstituteClass::where(['id' =>  $classId, 'school_id'   =>  $schoolId])->first();

    if(!is_null($raw))
    {
        return $raw->class_fees;
    }
    else
    {
        return 0;
    }
}



/**
 * get working hours
 * 
 * @param $schoolId
 * @param $userId
 * @param $resultSettingId
 */
function getWorkingDays($schoolId, $userId = null, $resultSettingId = null)
{
    $query = CustomAttendanceInput::where('school_id', $schoolId)->whereYear("created_at", date("Y"));

    if(!is_null($resultSettingId))
    {
        $query->where('result_setting_id', $resultSettingId);
    }

    if(!is_null($userId))
    {
        $query->where('user_id', $userId);
    }


    if($query->exists())
    {
        return $query->first()->working_days;
    }
    else
    {
        return 0;
    }
}

/**
 * Get Present Day
 */
function getPresentDays($schoolId, $studentId, $resultSettingId = null)
{
    $query = CustomAttendanceInput::where('school_id', $schoolId)->where('user_id', $studentId)
            ->whereYear("created_at", date("Y"));

    if(!is_null($resultSettingId))
    {
        $query->where('result_setting_id', $resultSettingId);
    }

    if($query->exists())
    {
        return $query->first()->present;
    }
    else
    {
        return 0;
    }
}


/**
 * Get Present Day
 */
function getAbsentDays($schoolId, $studentId, $resultSettingId = null)
{
    $query = CustomAttendanceInput::where('school_id', $schoolId)->where('user_id', $studentId)
            ->whereYear("created_at", date("Y"));

    if(!is_null($resultSettingId))
    {
        $query->where('result_setting_id', $resultSettingId);
    }

    if($query->exists())
    {
        return $query->first()->absent;
    }
    else
    {
        return 0;
    }
}




/**
 * class selected
 */
function commonClassSelected($schoolId, $className)
{
    return InstituteClass::where('school_id', $schoolId)->where('class_name', $className)->exists();
}




/**
 * subject selected
 */
function commonSubjectSelected($schoolId, $className, $subjectName)
{
    return Subject::where('school_id', $schoolId)
            // ->where('class_id', $classId)
            ->whereHas('class_name', function($q) use ($className){
                $q->where('class_name', $className);
            })
            ->where('subject_name', $subjectName)
            ->exists();
}


/**
 * -------  get subject information
 * 
 * -------  @param $id -- subject id
 * ==================================================*/
function commonSubject($id)
{
    return DB::table('common_subjects')->find($id);
}


/**
 * -------  get subject information
 * 
 * -------  @param $id -- subject id
 * ==================================================*/
function instituteSubject($id)
{
    return DB::table('subjects')->find($id);
}


/**
 * -------  get classes information
 * 
 * -------  @param $id -- subject id
 * ==================================================*/
function commonClass($id)
{
    return DB::table('common_classes')->find($id);
}

/**
 * -------  get classes information
 * 
 * -------  @param $id -- subject id
 * ==================================================*/
function instituteClass($id)
{
    return DB::table('institute_classes')->find($id);
}
function instituteSection($id)
{
    return DB::table('sections')->find($id);
}


/**
 * -------  Shifts
 * 
 * -------  @param $id -- subject id
 * ==================================================*/
function shifting($key)
{
    if($key == 1)
    {
        return "Morning";
    }
    elseif($key == 2)
    {
        return "Day";
    }
    elseif($key == 3)
    {
        return "Evening";
    }
    else
    {
        return "none";
    }
}



/** --------    Positioning Number
 * ====================================================*/
function ordinalNumber($number)
{
    if($number == 1)
    {
        return "1st";
    }
    elseif($number == 2)
    {
        return "2nd";
    }
    elseif($number == 3)
    {
        return "3rd";
    }
    else
    {
        return $number . "th";
    }
}

/**
 * Array of Subjects
 * @author CodeCell <support@codecell.com.bd>
 * @contributor Shahidul
 * @modifier Sajjad <sajjad.develpr@gmail.com>
 * @modified 05-07-23
 * 
 * @return Array
 */
function defaultSubjects()
{
    $data =  array (
        0 => 
        array (
            'id' => 1,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 3,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        1 => 
        array (
            'id' => 2,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 3,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        2 => 
        array (
            'id' => 3,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 3,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        3 => 
        array (
            'id' => 4,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 4,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        4 => 
        array (
            'id' => 5,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 4,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        5 => 
        array (
            'id' => 6,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 4,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        6 => 
        array (
            'id' => 7,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 5,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        7 => 
        array (
            'id' => 8,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 5,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        8 => 
        array (
            'id' => 9,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 5,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        9 => 
        array (
            'id' => 10,
            'code' => '127',
            'name' => 'Science',
            'group' => 0,
            'class' => 5,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        10 => 
        array (
            'id' => 11,
            'code' => '150',
            'name' => 'Bangladesh and Global',
            'group' => 0,
            'class' => 5,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        11 => 
        array (
            'id' => 12,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 5,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        12 => 
        array (
            'id' => 13,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 6,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        13 => 
        array (
            'id' => 14,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 6,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        14 => 
        array (
            'id' => 15,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 6,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        15 => 
        array (
            'id' => 16,
            'code' => '127',
            'name' => 'Science',
            'group' => 0,
            'class' => 6,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        16 => 
        array (
            'id' => 17,
            'code' => '150',
            'name' => 'Bangladesh and Global',
            'group' => 0,
            'class' => 6,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        17 => 
        array (
            'id' => 18,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 6,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        18 => 
        array (
            'id' => 19,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 7,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        19 => 
        array (
            'id' => 20,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 7,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        20 => 
        array (
            'id' => 21,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 7,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        21 => 
        array (
            'id' => 22,
            'code' => '127',
            'name' => 'Science',
            'group' => 0,
            'class' => 7,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        22 => 
        array (
            'id' => 23,
            'code' => '150',
            'name' => 'Bangladesh and Global',
            'group' => 0,
            'class' => 7,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        23 => 
        array (
            'id' => 24,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 7,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        24 => 
        array (
            'id' => 25,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        25 => 
        array (
            'id' => 26,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        26 => 
        array (
            'id' => 27,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        27 => 
        array (
            'id' => 28,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        28 => 
        array (
            'id' => 29,
            'code' => '127',
            'name' => 'Science Inquiry Lessons',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        29 => 
        array (
            'id' => 30,
            'code' => '127',
            'name' => 'Science practice book',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        30 => 
        array (
            'id' => 31,
            'code' => '151',
            'name' => 'History and Social Science Inquiry Lessons',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        31 => 
        array (
            'id' => 32,
            'code' => '151',
            'name' => 'History and Social Science Practice Books',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        32 => 
        array (
            'id' => 33,
            'code' => '154',
            'name' => 'Information Technology',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        33 => 
        array (
            'id' => 34,
            'code' => 'Null',
            'name' => 'Health protection',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        34 => 
        array (
            'id' => 35,
            'code' => '155',
            'name' => 'Work and Education',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        35 => 
        array (
            'id' => 36,
            'code' => '148',
            'name' => 'Art and Culture',
            'group' => 0,
            'class' => 8,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        36 => 
        array (
            'id' => 37,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        37 => 
        array (
            'id' => 38,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        38 => 
        array (
            'id' => 39,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        39 => 
        array (
            'id' => 40,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        40 => 
        array (
            'id' => 41,
            'code' => '127',
            'name' => 'Science Inquiry Lessons',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        41 => 
        array (
            'id' => 42,
            'code' => '127',
            'name' => 'Science practice book',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        42 => 
        array (
            'id' => 43,
            'code' => '151',
            'name' => 'History and Social Science Inquiry Lessons',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        43 => 
        array (
            'id' => 44,
            'code' => '151',
            'name' => 'History and Social Science Practice Books',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        44 => 
        array (
            'id' => 45,
            'code' => '154',
            'name' => 'Information Technology',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        45 => 
        array (
            'id' => 46,
            'code' => 'Null',
            'name' => 'Health protection',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        46 => 
        array (
            'id' => 47,
            'code' => '155',
            'name' => 'Work and Education',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        47 => 
        array (
            'id' => 48,
            'code' => '148',
            'name' => 'Art and Culture',
            'group' => 0,
            'class' => 9,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        48 => 
        array (
            'id' => 49,
            'code' => '101',
            'name' => 'Bangla First Paper',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        49 => 
        array (
            'id' => 50,
            'code' => '102',
            'name' => 'Bangla Second paper',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        50 => 
        array (
            'id' => 51,
            'code' => '107',
            'name' => 'English First Paper',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        51 => 
        array (
            'id' => 52,
            'code' => '108',
            'name' => 'English Second Paper',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        52 => 
        array (
            'id' => 53,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        53 => 
        array (
            'id' => 54,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        54 => 
        array (
            'id' => 55,
            'code' => '134',
            'name' => 'Agriculture Studies',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        55 => 
        array (
            'id' => 56,
            'code' => '151',
            'name' => 'Home science',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        56 => 
        array (
            'id' => 57,
            'code' => '154',
            'name' => 'Information and Communication Technology',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        57 => 
        array (
            'id' => 58,
            'code' => 'Null',
            'name' => 'Health protection',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        58 => 
        array (
            'id' => 59,
            'code' => '155',
            'name' => 'Work and Education',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        59 => 
        array (
            'id' => 60,
            'code' => '148',
            'name' => 'Art and Culture',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        60 => 
        array (
            'id' => 61,
            'code' => 'Null',
            'name' => 'Bangla literature',
            'group' => 0,
            'class' => 10,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        61 => 
        array (
            'id' => 62,
            'code' => '101',
            'name' => 'Bangla First Paper',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        62 => 
        array (
            'id' => 63,
            'code' => '102',
            'name' => 'Bangla Second paper',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        63 => 
        array (
            'id' => 64,
            'code' => '107',
            'name' => 'English First Paper',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        64 => 
        array (
            'id' => 65,
            'code' => '108',
            'name' => 'English Second Paper',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        65 => 
        array (
            'id' => 66,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        66 => 
        array (
            'id' => 67,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        67 => 
        array (
            'id' => 68,
            'code' => '134',
            'name' => 'Agriculture Studies',
            'group' => 4,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        68 => 
        array (
            'id' => 69,
            'code' => '151',
            'name' => 'Home science',
            'group' => 4,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        69 => 
        array (
            'id' => 70,
            'code' => '154',
            'name' => 'Information & Communication Technology',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        70 => 
        array (
            'id' => 71,
            'code' => '133',
            'name' => 'Health and Sports',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        71 => 
        array (
            'id' => 72,
            'code' => '156',
            'name' => 'Career Education',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        72 => 
        array (
            'id' => 73,
            'code' => '148',
            'name' => 'Art and Culture',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        73 => 
        array (
            'id' => 74,
            'code' => '048',
            'name' => 'Bangla literature',
            'group' => 0,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        74 => 
        array (
            'id' => 75,
            'code' => '136',
            'name' => 'Physics',
            'group' => 1,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        75 => 
        array (
            'id' => 76,
            'code' => '137',
            'name' => 'Chemistry',
            'group' => 1,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        76 => 
        array (
            'id' => 77,
            'code' => '138',
            'name' => 'Biology',
            'group' => 4,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        77 => 
        array (
            'id' => 78,
            'code' => '126',
            'name' => 'Higher Math',
            'group' => 4,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        78 => 
        array (
            'id' => 79,
            'code' => '150',
            'name' => 'Bangladesh and Global Studies',
            'group' => 1,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        79 => 
        array (
            'id' => 80,
            'code' => '152',
            'name' => 'Finance & Banking',
            'group' => 2,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        80 => 
        array (
            'id' => 81,
            'code' => '146',
            'name' => 'Accounting',
            'group' => 2,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        81 => 
        array (
            'id' => 82,
            'code' => '143',
            'name' => 'Business Entrepreneurship',
            'group' => 2,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        82 => 
        array (
            'id' => 83,
            'code' => '127',
            'name' => 'General Science',
            'group' => 2,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        83 => 
        array (
            'id' => 84,
            'code' => '149',
            'name' => 'Music',
            'group' => 2,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        // 84 => 
        // array (
        //     'id' => 85,
        //     'code' => '3127',
        //     'name' => 'General Science (Arts)',
        //     'group' => 3,
        //     'class' => 11,
        //     'status' => 1,
        //     'created_at' => '2023-02-09T09:55:00.000000Z',
        //     'updated_at' => '2023-02-09T09:55:00.000000Z',
        // ),
        // 85 => 
        // array (
        //     'id' => 86,
        //     'code' => '3149',
        //     'name' => 'Music (Arts)',
        //     'group' => 3,
        //     'class' => 11,
        //     'status' => 1,
        //     'created_at' => '2023-02-09T09:55:00.000000Z',
        //     'updated_at' => '2023-02-09T09:55:00.000000Z',
        // ),
        86 => 
        array (
            'id' => 87,
            'code' => '110',
            'name' => 'Geography',
            'group' => 3,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        87 => 
        array (
            'id' => 88,
            'code' => '140',
            'name' => 'Civic and Citizenship',
            'group' => 3,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        88 => 
        array (
            'id' => 89,
            'code' => '141',
            'name' => 'Economics',
            'group' => 3,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        89 => 
        array (
            'id' => 90,
            'code' => '153',
            'name' => 'History of Bangladesh',
            'group' => 3,
            'class' => 11,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        90 => 
        array (
            'id' => 91,
            'code' => '101',
            'name' => 'Bangla First Paper',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        91 => 
        array (
            'id' => 92,
            'code' => '102',
            'name' => 'Bangla Second paper',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        92 => 
        array (
            'id' => 93,
            'code' => '107',
            'name' => 'English First Paper',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        93 => 
        array (
            'id' => 94,
            'code' => '108',
            'name' => 'English Second Paper',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        94 => 
        array (
            'id' => 95,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        95 => 
        array (
            'id' => 96,
            'code' => '111',
            'name' => 'Islam/ Other Religions',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        96 => 
        array (
            'id' => 97,
            'code' => '134',
            'name' => 'Agriculture Studies',
            'group' => 4,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        97 => 
        array (
            'id' => 98,
            'code' => '151',
            'name' => 'Home science',
            'group' => 4,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        98 => 
        array (
            'id' => 99,
            'code' => '154',
            'name' => 'Information & Communication Technology',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        99 => 
        array (
            'id' => 100,
            'code' => '133',
            'name' => 'Health and Sports',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        100 => 
        array (
            'id' => 101,
            'code' => '156',
            'name' => 'Career Education',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        101 => 
        array (
            'id' => 102,
            'code' => '148',
            'name' => 'Art and Culture',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        102 => 
        array (
            'id' => 103,
            'code' => '048',
            'name' => 'Bangla literature',
            'group' => 0,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        103 => 
        array (
            'id' => 104,
            'code' => '136',
            'name' => 'Physics',
            'group' => 1,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        104 => 
        array (
            'id' => 105,
            'code' => '137',
            'name' => 'Chemistry',
            'group' => 1,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        105 => 
        array (
            'id' => 106,
            'code' => '138',
            'name' => 'Biology',
            'group' => 4,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        106 => 
        array (
            'id' => 107,
            'code' => '126',
            'name' => 'Higher Math',
            'group' => 4,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        107 => 
        array (
            'id' => 108,
            'code' => '150',
            'name' => 'Bangladesh and Global Studies',
            'group' => 1,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        108 => 
        array (
            'id' => 109,
            'code' => '152',
            'name' => 'Finance & Banking',
            'group' => 2,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        109 => 
        array (
            'id' => 110,
            'code' => '146',
            'name' => 'Accounting',
            'group' => 2,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        110 => 
        array (
            'id' => 111,
            'code' => '143',
            'name' => 'Business Entrepreneurship',
            'group' => 2,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        111 => 
        array (
            'id' => 112,
            'code' => '127',
            'name' => 'General Science',
            'group' => 2,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        112 => 
        array (
            'id' => 113,
            'code' => '149',
            'name' => 'Music',
            'group' => 2,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        // 113 => 
        // array (
        //     'id' => 114,
        //     'code' => '3127',
        //     'name' => 'General Science (Arts)',
        //     'group' => 3,
        //     'class' => 12,
        //     'status' => 1,
        //     'created_at' => '2023-02-09T09:55:01.000000Z',
        //     'updated_at' => '2023-02-09T09:55:01.000000Z',
        // ),
        // 114 => 
        // array (
        //     'id' => 115,
        //     'code' => '3149',
        //     'name' => 'Music (Arts)',
        //     'group' => 3,
        //     'class' => 12,
        //     'status' => 1,
        //     'created_at' => '2023-02-09T09:55:01.000000Z',
        //     'updated_at' => '2023-02-09T09:55:01.000000Z',
        // ),
        115 => 
        array (
            'id' => 116,
            'code' => '110',
            'name' => 'Geography',
            'group' => 3,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        116 => 
        array (
            'id' => 117,
            'code' => '140',
            'name' => 'Civic and Citizenship',
            'group' => 3,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        117 => 
        array (
            'id' => 118,
            'code' => '141',
            'name' => 'Economics',
            'group' => 3,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        118 => 
        array (
            'id' => 119,
            'code' => '153',
            'name' => 'History of Bangladesh',
            'group' => 3,
            'class' => 12,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        119 => 
        array (
            'id' => 120,
            'code' => '101',
            'name' => 'Bangla First Paper',
            'group' => 0,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        120 => 
        array (
            'id' => 121,
            'code' => '102',
            'name' => 'Bangla Second paper',
            'group' => 0,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        121 => 
        array (
            'id' => 122,
            'code' => '107',
            'name' => 'English First Paper',
            'group' => 0,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        122 => 
        array (
            'id' => 123,
            'code' => '108',
            'name' => 'English Second Paper',
            'group' => 0,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        123 => 
        array (
            'id' => 124,
            'code' => '275',
            'name' => 'Information & Communication Technology',
            'group' => 0,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        124 => 
        array (
            'id' => 125,
            'code' => '174',
            'name' => 'Physics First Paper',
            'group' => 1,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        125 => 
        array (
            'id' => 126,
            'code' => '175',
            'name' => 'Physics Second Paper',
            'group' => 1,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        126 => 
        array (
            'id' => 127,
            'code' => '176',
            'name' => 'Chemistry First Paper',
            'group' => 1,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        127 => 
        array (
            'id' => 128,
            'code' => '177',
            'name' => 'Chemistry Second Paper',
            'group' => 1,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        128 => 
        array (
            'id' => 129,
            'code' => '178',
            'name' => 'Biology First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        129 => 
        array (
            'id' => 130,
            'code' => '179',
            'name' => 'Biology Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        130 => 
        array (
            'id' => 131,
            'code' => '266',
            'name' => 'Higher Math Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        131 => 
        array (
            'id' => 132,
            'code' => '265',
            'name' => 'Higher Math First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        132 => 
        array (
            'id' => 133,
            'code' => '292',
            'name' => 'Finance & Banking First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        133 => 
        array (
            'id' => 134,
            'code' => '293',
            'name' => 'Finance & Banking Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        134 => 
        array (
            'id' => 135,
            'code' => '253',
            'name' => 'Accounting First Paper',
            'group' => 2,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        135 => 
        array (
            'id' => 136,
            'code' => '254',
            'name' => 'Accounting Second Paper',
            'group' => 2,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        136 => 
        array (
            'id' => 137,
            'code' => '277',
            'name' => 'Business Organization & Management First Paper',
            'group' => 2,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        137 => 
        array (
            'id' => 138,
            'code' => '278',
            'name' => 'Business Organization & Management Second Paper',
            'group' => 2,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        138 => 
        array (
            'id' => 139,
            'code' => '286',
            'name' => 'Production Management & Marketing First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        139 => 
        array (
            'id' => 140,
            'code' => '287',
            'name' => 'Production Management & Marketing Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        140 => 
        array (
            'id' => 141,
            'code' => '109',
            'name' => 'Economics First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        141 => 
        array (
            'id' => 142,
            'code' => '110',
            'name' => 'Economics Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        142 => 
        array (
            'id' => 143,
            'code' => '269',
            'name' => 'Civic and Good Govern First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        143 => 
        array (
            'id' => 144,
            'code' => '270',
            'name' => 'Civic and Good Govern Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        144 => 
        array (
            'id' => 145,
            'code' => '121',
            'name' => 'Logic First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        145 => 
        array (
            'id' => 146,
            'code' => '121',
            'name' => 'Logic Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        146 => 
        array (
            'id' => 147,
            'code' => '101',
            'name' => 'Bangla First Paper',
            'group' => 0,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        147 => 
        array (
            'id' => 148,
            'code' => '102',
            'name' => 'Bangla Second Paper',
            'group' => 0,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        148 => 
        array (
            'id' => 149,
            'code' => '107',
            'name' => 'English First Paper',
            'group' => 0,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        149 => 
        array (
            'id' => 150,
            'code' => '108',
            'name' => 'English Second Paper',
            'group' => 0,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        150 => 
        array (
            'id' => 151,
            'code' => '275',
            'name' => 'Information & Communication Technology',
            'group' => 0,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        151 => 
        array (
            'id' => 152,
            'code' => '174',
            'name' => 'Physics First Paper',
            'group' => 1,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        152 => 
        array (
            'id' => 153,
            'code' => '175',
            'name' => 'Physics Second Paper',
            'group' => 1,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        153 => 
        array (
            'id' => 154,
            'code' => '176',
            'name' => 'Chemistry First Paper',
            'group' => 1,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        154 => 
        array (
            'id' => 155,
            'code' => '177',
            'name' => 'Chemistry Second Paper',
            'group' => 1,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        155 => 
        array (
            'id' => 156,
            'code' => '178',
            'name' => 'Biology First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        156 => 
        array (
            'id' => 157,
            'code' => '179',
            'name' => 'Biology Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        157 => 
        array (
            'id' => 158,
            'code' => '266',
            'name' => 'Higher Math Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        158 => 
        array (
            'id' => 159,
            'code' => '265',
            'name' => 'Higher Math First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        159 => 
        array (
            'id' => 160,
            'code' => '292',
            'name' => 'Finance & Banking First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        160 => 
        array (
            'id' => 161,
            'code' => '293',
            'name' => 'Finance & Banking Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        161 => 
        array (
            'id' => 162,
            'code' => '253',
            'name' => 'Accounting First Paper',
            'group' => 2,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        162 => 
        array (
            'id' => 163,
            'code' => '254',
            'name' => 'Accounting Second Papre',
            'group' => 2,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        163 => 
        array (
            'id' => 164,
            'code' => '277',
            'name' => 'Business Organization & Management First Paper',
            'group' => 2,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        164 => 
        array (
            'id' => 165,
            'code' => '278',
            'name' => 'Business Organization & Management Second Paper',
            'group' => 2,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        165 => 
        array (
            'id' => 166,
            'code' => '286',
            'name' => 'Production Management & Marketing First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        166 => 
        array (
            'id' => 167,
            'code' => '287',
            'name' => 'Production Management & Marketing Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        167 => 
        array (
            'id' => 168,
            'code' => '109',
            'name' => 'Economics First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        168 => 
        array (
            'id' => 169,
            'code' => '110',
            'name' => 'Economics Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        169 => 
        array (
            'id' => 170,
            'code' => '269',
            'name' => 'Civic and Good Govern First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        170 => 
        array (
            'id' => 171,
            'code' => '121',
            'name' => 'Logic First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        171 => 
        array (
            'id' => 172,
            'code' => '122',
            'name' => 'Logic Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        172 => 
        array (
            'id' => 173,
            'code' => '270',
            'name' => 'Civic and Good Govern Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        173 => 
        array (
            'id' => 174,
            'code' => '117',
            'name' => 'Sociology First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        174 => 
        array (
            'id' => 175,
            'code' => '118',
            'name' => 'Sociology Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        175 => 
        array (
            'id' => 176,
            'code' => '304',
            'name' => 'History First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        176 => 
        array (
            'id' => 177,
            'code' => '305',
            'name' => 'History Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        177 => 
        array (
            'id' => 178,
            'code' => '267',
            'name' => 'Islamic History & Culture Fist Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        178 => 
        array (
            'id' => 179,
            'code' => '268',
            'name' => 'Islamic History & Culture Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        179 => 
        array (
            'id' => 180,
            'code' => '125',
            'name' => 'Geography First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        180 => 
        array (
            'id' => 181,
            'code' => '126',
            'name' => 'Geography Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        181 => 
        array (
            'id' => 182,
            'code' => '123',
            'name' => 'Psychology First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        182 => 
        array (
            'id' => 183,
            'code' => '124',
            'name' => 'Psychology Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        183 => 
        array (
            'id' => 184,
            'code' => '239',
            'name' => 'Agriculture First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        184 => 
        array (
            'id' => 185,
            'code' => '240',
            'name' => 'Agriculture Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        185 => 
        array (
            'id' => 186,
            'code' => '271',
            'name' => 'Social Work First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        186 => 
        array (
            'id' => 187,
            'code' => '272',
            'name' => 'Social Work Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        187 => 
        array (
            'id' => 188,
            'code' => '249',
            'name' => 'Studies of Islam First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        188 => 
        array (
            'id' => 189,
            'code' => '250',
            'name' => 'Studies of Islam Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        189 => 
        array (
            'id' => 190,
            'code' => '129',
            'name' => 'Statistics First Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        190 => 
        array (
            'id' => 191,
            'code' => '130',
            'name' => 'Statistics Second Paper',
            'group' => 4,
            'class' => 14,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        191 => 
        array (
            'id' => 192,
            'code' => '117',
            'name' => 'Sociology First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        192 => 
        array (
            'id' => 193,
            'code' => '118',
            'name' => 'Sociology Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        193 => 
        array (
            'id' => 194,
            'code' => '304',
            'name' => 'History First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        194 => 
        array (
            'id' => 195,
            'code' => '305',
            'name' => 'History Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        195 => 
        array (
            'id' => 196,
            'code' => '267',
            'name' => 'Islamic History & Culture First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        196 => 
        array (
            'id' => 197,
            'code' => '268',
            'name' => 'Islamic History & Culture Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        197 => 
        array (
            'id' => 198,
            'code' => '125',
            'name' => 'Geography First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        198 => 
        array (
            'id' => 199,
            'code' => '126',
            'name' => 'Geography Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        199 => 
        array (
            'id' => 200,
            'code' => '123',
            'name' => 'Psychology First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        200 => 
        array (
            'id' => 201,
            'code' => '124',
            'name' => 'Psychology Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        201 => 
        array (
            'id' => 202,
            'code' => '239',
            'name' => 'Agriculture First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        202 => 
        array (
            'id' => 203,
            'code' => '240',
            'name' => 'Agriculture Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        203 => 
        array (
            'id' => 204,
            'code' => '271',
            'name' => 'Social Work First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        204 => 
        array (
            'id' => 205,
            'code' => '272',
            'name' => 'Social Work Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        205 => 
        array (
            'id' => 206,
            'code' => '249',
            'name' => 'Studies of Islam First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        206 => 
        array (
            'id' => 207,
            'code' => '250',
            'name' => 'Studies of Islam Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        207 => 
        array (
            'id' => 208,
            'code' => '129',
            'name' => 'Statistics First Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        208 => 
        array (
            'id' => 209,
            'code' => '130',
            'name' => 'Statistics Second Paper',
            'group' => 4,
            'class' => 13,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:01.000000Z',
            'updated_at' => '2023-02-09T09:55:01.000000Z',
        ),
        209 => 
        array (
            'id' => 210,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 1,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        210 => 
        array (
            'id' => 211,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 1,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        211 => 
        array (
            'id' => 212,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 1,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        212 => 
        array (
            'id' => 213,
            'code' => '101',
            'name' => 'Bangla',
            'group' => 0,
            'class' => 2,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        213 => 
        array (
            'id' => 214,
            'code' => '107',
            'name' => 'English',
            'group' => 0,
            'class' => 2,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        214 => 
        array (
            'id' => 215,
            'code' => '109',
            'name' => 'Math',
            'group' => 0,
            'class' => 2,
            'status' => 1,
            'created_at' => '2023-02-09T09:55:00.000000Z',
            'updated_at' => '2023-02-09T09:55:00.000000Z',
        ),
        
        
    );


    return $data;
}

function extraFeesabsent($class_id,$month_name,$student_id, $absent){

    $absenceCount = Attendance::whereMonth('date', $month_name)->where('student_id',$student_id)->where('attendance', 0)->count();
    $fees = ($absenceCount * $absent);
}

function extraFeesAbsentAfterBreak($class_id,$month_name,$student_id, $absentafterbreak){

    $absenceBreakCount = Attendance::whereMonth('date', $month_name)->where('student_id',$student_id)->where('attendance', 2)->count();
    $fees = ($absenceBreakCount * $absentafterbreak);
}


function getStudentFees($schoolId, $classId, $feesType)
{
    return StudentFee::where(['school_id' => $schoolId, 'class_id' => $classId, 'fees_type_id' => $feesType])->first();
}
function getFees($schoolId,$studentId,$monthId)
{ 
return StudentMonthlyFee::where(['school_id' => $schoolId,'student_id'=>$studentId,'month_id'=>$monthId])->sum('amount');
}
function getPaid($schoolId,$studentId,$monthId)
{ 
return StudentMonthlyFee::where(['school_id' => $schoolId,'student_id'=>$studentId,'month_id'=>$monthId])->sum('paid_amount');
}
function getDue($schoolId,$studentId,$monthId)
{ 
    $data1= StudentMonthlyFee::where(['school_id' => $schoolId,'student_id'=>$studentId,'month_id'=>$monthId])->sum('amount');

  $data2=StudentMonthlyFee::where(['school_id' => $schoolId,'student_id'=>$studentId,'month_id'=>$monthId])->sum('paid_amount');
$due=$data1-$data2;
return $due;
}

function getStatus($schoolId,$studentId,$monthId){
    $fee1='Due';
    $fee2='Partial';
    $fee3='Paid';
    $StudentFees=StudentMonthlyFee::where(['school_id' => $schoolId,'student_id'=>$studentId,'month_id'=>$monthId])->get();
    foreach($StudentFees as $fees ){
        if($fees->status==0){
            return '<span class="badge bg-danger">'. $fee1.'</span>' ;
        }
        elseif ($fees->status==1){
            return '<span class="badge bg-primary">'. $fee2.'</span>' ;
        }
        else{
            return '<span class="badge bg-success">'. $fee3.'</span>' ;
        }

    }
}
