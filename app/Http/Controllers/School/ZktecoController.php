<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Rats\Zkteco\Lib\ZKTeco;


class ZktecoController extends Controller
{
    /**
     * 
     */
    public function zkTeck()
    {
        // return uniqid();
    
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        set_time_limit(300);

        $zk = new ZKTeco('192.168.0.117', '4370');
        $zk->connect();
        return $zk->version();

        // $zk->disconnect();

        // $users = Teacher::where('school_id', 2)->get();

        // foreach($users as $key => $user)
        // {
        //     $schoolId = str_pad(2, 3, '0', STR_PAD_LEFT);
        //     $year = date("y");
        //     $studentExists = ++$key;
        //     $studentSerial = str_pad($studentExists, 3, '0', STR_PAD_LEFT);
        //     $uniqueId = $year.$schoolId.$studentSerial;

        //     Teacher::find($user->id)->update(['unique_id' => $uniqueId]);

        //     $zk->setUser($user->id, $uniqueId, $user->full_name, '12345678', 0);
        // }

        // return [
        //     'status'   =>  "success",
        //     'message'   =>  "$key record inserted",
        // ];


        // try{
            
        //     $zk = new ZKTeco('192.168.0.114', '4370');

        //     if($zk->connect())
        //     {
        //         $zk->disableDevice();
        //         $zk->setUser(3, 119001, "Akbar Sir", '12345678', 0);
        //         // $zk->removeUser(3);
        //         // $zk->clearUsers();
        //         // return  $zk->getUser();
                

        //         $att =  $zk->getAttendance();
        //         // $zk->clearAttendance();
        //         $zk->enableDevice();
        //         return $att;
        //     }

        //     return "Not connect";
        // }
        // catch(Exception $e)
        // {
        //     return $e->getMessage();
        // }
    }


    public function test()
    {
        $result = $this->sendCurlRequestToStellar();

        return $result->device_user;
    }


    protected  function sendCurlRequestToStellar()
    {
        $data = array(
            "operation" => "fetch_user_in_device_list",
            "auth_user" => "lighthouseCollege",
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
