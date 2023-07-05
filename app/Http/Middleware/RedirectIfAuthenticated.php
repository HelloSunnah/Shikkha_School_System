<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "admin" && Auth::guard($guard)->check()) {
            return redirect('/admin');
        }
        if ($guard == "schools" && Auth::guard($guard)->check()) {
            return redirect('/school');
        }
        if ($guard == "teachers" && Auth::guard($guard)->check()) {
            return redirect('/teachers');
        }
        if ($guard == "users" && Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
