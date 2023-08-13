<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrialMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {   
        // dd(Auth::guard('schools')->check());
        
        if (Auth::guard('schools')->check()) {
            // dd(4);
            $school = Auth::user();
            // dd($school);
            if (($school->trial_end_date < Carbon::now())  && ($school->subscription_status == 0)) {              
                Session:: flush();
                Auth::logout();
                return redirect()->route('contact.page');
            }
            
            if (($school->trial_end_date >= Carbon::now())  && ($school->subscription_status == 0)) {              
                return $next($request);           
            }
            if($school->subscription_status == 2){
                Session:: flush();
                Auth::logout();
                return redirect()->route('contact.page');
            }
            else{
                return $next($request);
            }
        }
        
        elseif (Auth::guard('teachers')->check())
        {
            $school = \App\Models\School::find(Auth::user()->school_id)->first();
            // dd($school);
            // return Auth::user();
            if (($school->trial_end_date < Carbon::now())  && ($school->subscription_status == 0)) {  
                Session:: flush();
                Auth::logout();            
                return redirect("/error/payFirst");
            }
            
            if (($school->trial_end_date >= Carbon::now())  && ($school->subscription_status == 0)) {              
                return $next($request);
            }
            if($school->subscription_status == 2){
                Session:: flush();
                Auth::logout();
                return redirect("/error/payFirst");
            }
            else{
                return $next($request);
            }
        }

        elseif (Auth::guard('web')->check())
        
        {
            
            $school = \App\Models\School::find(Auth::user()->school_id)->first();
           
            if (($school->trial_end_date < Carbon::now())  && ($school->subscription_status == 0)) { 
                Session:: flush();
                Auth::logout();
                return redirect("/error/payFirst");
            }
            
            if (($school->trial_end_date >= Carbon::now())  && ($school->subscription_status == 0)) {              
                return $next($request);           
            }
            if($school->subscription_status == 2){
                Session:: flush();
                Auth::logout();
                return redirect("/error/payFirst");
            }
            else{
                return $next($request);
            }
        }

        
        else{
            return $next($request);
        }



    }
}
