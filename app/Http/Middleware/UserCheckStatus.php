<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class UserCheckStatus
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
        $flag = false;

        if($request->user()->mobile_verified == 0 ) {
            //$message = 'Your account status has been disabled.';
            $flag = true;
        }

        if($flag)
        {
            //return redirect()->route('user.firebase-phone-authentication');
            return redirect('firebase-phone-authentication');

            //Auth::guard('user')->logout();
            //return redirect()->route('login')->withErrors(['error' => $message]);
           
        }
        
        return $next($request);
        
        
    }
}
