<?php

namespace App\Http\Controllers;

use App\Models\CommonSubject;
use App\Models\Department;
use App\Models\Notice;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        // $subjects = Subject::where('class_id',Auth::user()->class_id)
        //                     ->where('section_id',Auth::user()->section_id)
        //                     ->where('group_id',Auth::user()->group_id)
        //                      ->get();
        $subjects = Subject::where('school_id', Auth::user()->school_id)
                                ->where('class_id', Auth::user()->class_id)
                                ->get();
        $dataAll = Notice::where('school_id',Auth::user()->school_id)->where('class_id',0)->get()->toArray();
        $dataSpecific = Notice::where('school_id',Auth::user()->school_id)->where('class_id',Auth::user()->class_id)->get()->toArray();
        $showData = array_merge($dataAll,$dataSpecific);
        $user = User::where('id',Auth::user()->id)->first();
        return view('frontend.user.dashboard',compact('subjects','showData','user'));
    }



    public function database()
    {
        // return "Unauthorized";
        return CommonSubject::get();
    }

}
