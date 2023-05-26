<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Member;
use App\Models\PasswordReset;
use App\Models\GeneralSetting;
use App\Models\EmailTemplate;
use Session;
use Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function forgotPasswordForm()
    {
        return view('frontend.user.auth.forget_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $member = Member::where('email', $request->email)->first();
        if (!$member)
        {
            return redirect()->back()->withInput()->withErrors(['error' => "We can't find a user with that e-mail address."]);
        }

        

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => \Str::random(60),
                'pin' => sprintf("%06d", mt_rand(1000, 999999)),
            ]
        );

        $name = $member->first_name.' '.$member->last_name;
        $email = $member->email;
        $reset_link = url('/reset-password/'.$passwordReset->token);

        $email_template = EmailTemplate::where('type','reset_password')->first();

        $subject = $email_template['subject'];
        $content = $email_template['content'];

        //$search = array("{{name}}","{{link}}","{{reset_link}}","{{app_name}}");
        $search = array("{{name}}","{{reset_link}}","{{app_name}}");
       // $replace = array($name,$passwordReset->pin,$reset_link,env('APP_NAME'));
        $replace = array($name,$reset_link,env('APP_NAME'));
        $content  = str_replace($search,$replace,$content);

        $social_links = GeneralSetting::find(1);    
        sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
       
        Session::flash('flash_success', 'We have e-mailed you reset password link! Please check your inbox or spam folder.');
        return redirect()->back();
    }

    public function resetPasswordForm($token)
    {
        $member = PasswordReset::where('token', $token)->first();
        if (!$member)
        {
            Session::flash('flash_danger', 'The password reset token is invalid.');
            return redirect('forgot-password');
        }
        $data['token'] = $token;
        /*if (\Carbon\Carbon::parse($member->password_reset_token_date)->addMinutes(60)->isPast())
        {
            $member->update([
                'password_reset_token' => null,
                //'password_reset_token_date' => null
            ]);

            Session::flash('flash_danger', 'This password reset token is expired.');
            return redirect('forgot-password');
        }*/

        return view('frontend.user.auth.reset')->with($data);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'password' => 'required|string|min:6|max:30|confirmed',
        ]);

        if ($validator->fails())
        {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        $member = PasswordReset::where('token', $request->token)->first();
        
        if (!$member)
        {
            Session::flash('flash_danger', "We can't find a user with that e-mail address.");
            return redirect()->back()->withInput();
        }
        $admin = Member::where('email', $member->email)->first();
        $admin->original_password = $request->password;
        $admin->password = Hash::make($request->password);
        $admin->save();

        $member->token = null;
        $member->save();

        Session::flash('flash_success', "Your password has been updated successfully.");
            return redirect('/login');
    }
}
