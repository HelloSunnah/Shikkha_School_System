<?php

namespace App\Helper;

use App\Models\Employee;
use App\Models\Teacher;
use App\Models\User;


class Utility
{
    
    /**
     * create unique ID
     * 
     * @param mixed $schoolId = Auth::id()
     * 
     * @param mixed $userType = student OR teacher OR employee
     * 
     * @return string
    */

    public static function createUniqueId($schoolId, $userType)
    {
        $sId = str_pad($schoolId, 3, '0', STR_PAD_LEFT); // number in three digit; Ex: 001
        $year = date("y");

        if($userType == "employee")
        {
            $rawCount = Employee::where('school_id', $schoolId)->whereYear('created_at', date("Y"))->count();
            $serial = str_pad(++$rawCount, 2, '0', STR_PAD_LEFT); // number in two digit; Ex: 01
        }

        elseif($userType == "teacher")
        {
            $rawCount = Teacher::where('school_id', $schoolId)->whereYear('created_at', date("Y"))->count();
            $serial = str_pad(++$rawCount, 3, '0', STR_PAD_LEFT); // number in three digit; Ex: 001
        }

        elseif($userType == "student")
        {
            $rawCount = User::where('school_id', $schoolId)->whereYear('created_at', date("Y"))->count();
            $serial = str_pad(++$rawCount, 4, '0', STR_PAD_LEFT); // number in four digit; Ex: 0001
        }
        
        else
        {
            return "0000000000";
        }

        $uniqueId = $year.$sId.$serial;

        return $uniqueId;
    }


    /**
     * search user in stealler device
     */
    static function fetchUserListInDevice($deviceUsername)
    {
        $result = self::sendCurlRequestToStellar('fetch_user_in_device_list', $deviceUsername);
        
        if(!is_null($result)):
            return $result->device_user;
        else:
            return null;
        endif;
    }


    protected static function sendCurlRequestToStellar($operation, $authUser)
    {
        $data = array(
            "operation" => $operation,
            "auth_user" => $authUser,
            "auth_code" => env('STELLAR_AUTH_CODE'),
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
}