<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    
    public static function defaultSubject()
    {
        return [
            'Bangla 1st Paper',
            'Bangla 2nd Paper',
            'English 1st Paper',
            'English 2nd Paper',
            'Math',
            'Religion',
            'ICT',
            'Agricultural Studies',
            'Physical Studies',
            'General Science',
            'Bangladesh and Global Studies'
        ];
    }
  

    public static function GreenWebSMS($phone, $message)
    {
        $url = "http://api.greenweb.com.bd/api.php?json";
        $token   = env("GREENWEB_TOKEN");

        $data = [
            'to'      => "$phone",
            'message' => "$message",
            'token'   => "$token"
        ]; // Add parameters in key value

        if(env('APP_DEBUG') == false)
        {
            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
        }

        return true;
    }
}
