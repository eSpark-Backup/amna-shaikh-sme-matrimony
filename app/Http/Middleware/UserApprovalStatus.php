<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class UserApprovalStatus
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

        if($request->user()->is_approved != 1 ) {

            
            $message = 'You cannot perform any action unless you fill out your basic information and upload your photo. Once done, please submit it for admin approval, thank you!';
            $flag = true;
        }
        if (($request->user()->status == 0) || ($request->user()->status == 5) ) {
            $message = 'You cannot perform any action. Please contact admin, thank you!';
            $flag = true;
        }
        if($flag)
        {
            
            //return redirect()->route('user.firebase-phone-authentication');
            if ($request->user()->status == 4) {
                return redirect('not-approved-user');    
            }elseif(($request->user()->status == 0) || ($request->user()->status == 5)  ){
                Auth::guard('user')->logout();
                return redirect()->route('login')->withErrors(['error' => $message]);
            }
            else{

                return redirect()->route('user.edit-profile')->withErrors(['error' => $message]);    
            }
            //Auth::guard('user')->logout();
            //return redirect()->route('login')->withErrors(['error' => $message]);
           
        }
        
        return $next($request);
        
        
    }
}
