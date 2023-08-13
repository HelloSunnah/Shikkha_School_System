<?php


namespace App\Helper;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity as LogActivityModal;


class LogActivity
{


    public static function addToLog($subject)
    {   
        $url=Request::fullUrl();
        $subject = $subject;
        $school=Auth::user()->id;
        $existingActivity = LogActivityModal::wheredate('created_at', '=', Carbon::today()->toDateString())
                                   ->where('subject', $subject)
                                   ->where('school_id',$school )
                                   ->first();

    if ($existingActivity) {
        $existingActivity->increment('count');
    } else {
        $log = [];
    	$log['subject'] = $subject;
    	$log['url'] = $url;
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['school_id'] = $school ;
    	$log['count'] = 1;
    	LogActivityModal::create($log);
    }
    	// $log = [];
    	// $log['subject'] = $subject;
    	// $log['url'] = Request::fullUrl();
    	// $log['method'] = Request::method();
    	// $log['ip'] = Request::ip();
    	// $log['agent'] = Request::header('user-agent');
    	// $log['school_id'] = Auth::user()->id;
    	// LogActivityModal::create($log);
    }
    // public static function addToLog($subject)
    // {
    // 	$log = [];
    // 	$log['subject'] = $subject;
    // 	$log['url'] = Request::fullUrl();
    // 	$log['method'] = Request::method();
    // 	$log['ip'] = Request::ip();
    // 	$log['agent'] = Request::header('user-agent');
    // 	$log['school_id'] = Auth::user()->id;
    // 	LogActivityModal::create($log);
    // }


    public static function logActivityLists()
    {
    	return LogActivityModal::get();
    }
     
	// public static function countUserViewActivity($page)
    // {
    //     return LogActivityModal::where('subject', 'user_view')
    //         ->where('url', 'LIKE', "%{$page}%")
    //         ->count();
    // }

}