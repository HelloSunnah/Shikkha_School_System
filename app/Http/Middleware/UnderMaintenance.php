<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class UnderMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(Auth::guard('schools')->check())
        {
            if(Auth::user()->is_down == 1)
            {
                Session:: flush();
                Auth::logout();
                return redirect("/error/503");
            }
            else{
                return $next($request);
            }        
        }

        if(Auth::guard('teachers')->check())
        {
            $user = \App\Models\School::find(Auth::user()->school_id)->first()->is_down;
            if($user == 1)
            {
                Session:: flush();
                Auth::logout();
                return redirect("/error/503");
            }
            else{
                return $next($request);
            }
        }

        if(Auth::guard('web')->check())
        {
            $user = \App\Models\School::find(Auth::user()->school_id)->first()->is_down;
            if($user == 1)
            {
                Session:: flush();
                Auth::logout();
                return redirect("/error/503");
            }
            else{
                return $next($request);
            }
        }

        return $next($request);
    }
}
