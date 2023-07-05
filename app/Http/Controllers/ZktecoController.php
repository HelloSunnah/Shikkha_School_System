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
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rats\Zkteco\Lib\ZKTeco;

class ZktecoController extends Controller
{
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


    // public function testOnly()
    // {

    // }

    public function testOnly()
    {
        $result = $this->sendCurlRequestToStellar('fetch_user_in_device_list', 'WinnerModel');

        return in_array('230280045', array_column($result->device_user, 'registraton_id'));
    }


    protected  static function sendCurlRequestToStellar($operation, $authUser)
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
