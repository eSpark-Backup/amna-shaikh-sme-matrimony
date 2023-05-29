<?php

namespace App\Http\Controllers\Auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\EmailTemplate;
use App\Member;
use App\Models\Plan;
use App\Models\GeneralSetting;
use Carbon\Carbon;

use Hash;
use Hashids;
use Session;
use Socialite;
use Str;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
   // use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    public function __construct()
    {
      $this->middleware('guest:user')->except('logout','firebasePhoneAuthentication','verifyMobileCode');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
      return view('frontend.user.auth.login');
    }
    public function register()
    {
      return view('frontend.user.auth.register');
    }

    public function registerUser(Request $request)
    {

      // Validate the form data
      $validator = Validator::make($request->all(), [
        'first_name'   => 'required|string|max:100',
        'last_name'   => 'required|string|max:100',
        'email'   => 'required|string|email|max:100|unique:members',
        'password' => 'required|string|min:6',
        'confirm_password' => 'same:password',
        'terms_conditions' => 'required|numeric'
      ]);

      if ($validator->fails())
      {
        \Illuminate\Support\Facades\Session::flash('flash_danger', $validator->messages());
          return redirect()->back()->withInput();
      }
        $member = Member::create([
            'id' => 2900,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),

            'password' => Hash::make($request->input('password')),
            'original_password' => $request->input('password'),
            'terms_conditions' => $request->input('terms_conditions'),
            'status' => 1,
            'plan_id' => 0,
        ]);
        if($member)
        {

            // ************************* //
            // Send Verify Link To User
            // ************************* //
//            $name = $member->first_name.' '.$member->last_name;
//
//            $email = $member->email;
//            $link = url('/verify-account/'.Hashids::encode($member->id));
//            $email_template = EmailTemplate::where('type','sign_up_confirmation')->first();
//            //$email_template = transformEmailTemplateModel($email_template,'en');
//            $subject = $email_template['subject'];
//            $content = $email_template['content'];
//            $search = array("{{name}}","{{link}}","{{app_name}}");
//            $replace = array(ucwords($name),$link,env('APP_NAME'));
//            $content  = str_replace($search,$replace,$content);
//            $social_links = GeneralSetting::find(1);
//
//            sendEmailNew($email, $subject, $content, '', '', '','',$social_links);

            // ************************* //
            //    Send email to admin
            // ************************* //
            /*$email_template = EmailTemplate::where('type','new_user_registered')->first();
            $admin_email = $social_links['email'];
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}","{{app_name}}");
            $replace = array(ucwords($name),env('APP_NAME'));
            $content  = str_replace($search,$replace,$content);

            sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);*/

            $request->session()->flash('flash_success', 'Your account is now successfully registered. Kindly check your email / spam or junck folder to varify.');
            return redirect('login');

        }
        else
        {
          return redirect()->back()->withErrors(['error' => 'Some thing went wrong try again.']);
        }


    }
    public function loginUser(Request $request)
    {

      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password] )) {
        // if successful, then redirect to their intended location
        $user = Member::where(['email' => $request->email ])->first();
        $is_user_active = true;
        $resend_email_flag = false;
        $message = '';
        switch ($user->status) {
            case 0:
                $message = 'Your account has been blocked due to some reason kindly contact admin for further assistance.';
                $is_user_active = false;
                break;
            case 2:
                $message = "Kindly check your email to varify your account. Please check your spam or junk folder if you did not receive the email. Thank you!";
                $is_user_active = false;
                $resend_email_flag = true;
                break;
            //
            case 5: //account deleted..
                $user->update([
                  'status' => 1
                ]);

                $is_user_active = true;
                // ************************* //
                // Send Thankyou email to User
                // ************************* //
                $name = $user->first_name.' '.$user->last_name;

                $email = $user->email;

                $email_template = EmailTemplate::where('type','user_welcome')->first();
                $subject = $email_template['subject'];
                $content = $email_template['content'];
                $search = array("{{name}}","{{app_name}}");
                $replace = array(ucwords($name),env('APP_NAME'));
                $content  = str_replace($search,$replace,$content);
                $social_links = GeneralSetting::find(1);

                sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

                break;
        }
        if($is_user_active == false)
        {
          Auth::guard('user')->logout();
          return redirect()->back()->withErrors(['error' => $message]);
        }
        session(['user' => $user]);
        return redirect()->intended(route('user.members'));
      }
      // if unsuccessful, then redirect back to the login with the form data
      //return redirect()->back()->withErrors(['error' => 'These credentials do not match our records.']);
      \Illuminate\Support\Facades\Session::flash('flash_danger', 'These credentials do not match our records.');
       return redirect()->back()->withInput();
    }

    public function logout()
    {
      Auth::guard('user')->logout();
      return redirect()->route('login');
    }
    //google callback
    public function redirectToGoogle()
    {
      return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(){
      try {
        $user = Socialite::driver('google')->user();

        $finduser = Member::where('social_id', $user->id)->first();

        $is_user_active = true;
        $resend_email_flag = false;
        $message = '';

        if (isset($finduser) && !empty($finduser) ) {
            switch ($finduser->status) {
                case 0:
                    $message = 'Your account has been blocked due to some reason kindly contact admin for further assistance.';
                    $is_user_active = false;
                    break;
                case 5: //account deleted..
                    $finduser->update([
                      'status' => 1
                    ]);

                    $is_user_active = true;
                    // ************************* //
                    // Send Thankyou email to User
                    // ************************* //
                    $name = $finduser->first_name.' '.$finduser->last_name;

                    $email = $finduser->email;

                    $email_template = EmailTemplate::where('type','user_welcome')->first();
                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{app_name}}");
                    $replace = array(ucwords($name),env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);

                    sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

                    break;
            }
            if($is_user_active == false)
            {
              Auth::guard('user')->logout();
              \Illuminate\Support\Facades\Session::flash('flash_danger', $message);
              return redirect('login');
            }
            $finduser->update([
                'last_login' => Carbon::now('UTC')->timestamp,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            ]);
        }
        else{

            if ( $user->email ) {
              $finduser = Member::where( 'email', $user->email )->first();
              if (!$finduser) {

                  $plan = Plan::where(['id' => 1, 'status' => 1])->first(); // Trial Plan
                  $finduser = Member::create([
                      'first_name' => $user->user['given_name'],
                      'last_name' => $user->user['family_name'],
                      'email' => $user->email,
                      'social_id' => $user->id,
                      'social_type' => 'google',
                      'firebase_token' => NULL,
                      'device_id' => NULL,
                      'email_verified_at' => now(),
                      'status' => 3,
                      'last_login' => Carbon::now('UTC')->timestamp,
                      'ip_address' => $_SERVER['REMOTE_ADDR'],
                  ]);
                  // ************************* //
                  // Send Thankyou email to User
                  // ************************* //
                  $name = $finduser->first_name.' '.$finduser->last_name;

                  $email = $finduser->email;

                  $email_template = EmailTemplate::where('type','user_welcome')->first();
                  //$email_template = transformEmailTemplateModel($email_template,$lang);
                  $subject = $email_template['subject'];
                  $content = $email_template['content'];
                  $search = array("{{name}}","{{app_name}}");
                  $replace = array(ucwords($name),env('APP_NAME'));
                  $content  = str_replace($search,$replace,$content);
                  $social_links = GeneralSetting::find(1);

                  sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
                  // ************************* //
                  //    Send email to admin
                  // ************************* //
                  $email_template = EmailTemplate::where('type','new_user_registered')->first();
                  $admin_email = $social_links['email'];
                  $subject = $email_template['subject'];
                  $content = $email_template['content'];
                  $search = array("{{name}}","{{app_name}}");
                  $replace = array(ucwords($name),env('APP_NAME'));
                  $content  = str_replace($search,$replace,$content);

                  sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);

              }else{
                switch ($finduser->status) {
                  case 0:
                    $message = 'Your account has been blocked due to some reason kindly contact admin for further assistance.';
                    $is_user_active = false;
                    break;
                    //
                  case 5: //account deleted..
                    $finduser->update([
                      'status' => 1
                    ]);

                    $is_user_active = true;
                    // ************************* //
                    // Send Thankyou email to User
                    // ************************* //
                    $name = $finduser->first_name.' '.$finduser->last_name;

                    $email = $finduser->email;

                    $email_template = EmailTemplate::where('type','user_welcome')->first();
                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{app_name}}");
                    $replace = array(ucwords($name),env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);

                    sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
                    break;
                }

                if($is_user_active == false)
                {
                  Auth::guard('user')->logout();
                  \Illuminate\Support\Facades\Session::flash('flash_danger', $message);
                  return redirect('login');
                }
                $finduser->update([
                    'last_login' => Carbon::now('UTC')->timestamp,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'firebase_token' => NULL,
                    'device_id' => NULL,
                    'social_id' => $user->id,
                    'email_verified_at' => now(),
                    'social_type' => 'google'
                ]);
              }
            }else{
              return response()->json(['status' => 0, 'message' => array('message' => ['Sorry for inconvenient, Something went wrong !!! ']) , 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
            }
        }
        session(['user' => $finduser]);
        //$token =  Auth::login($finduser);
        $token =  Auth::guard('user')->login($finduser);

        if ( !$token )
        {
          \Illuminate\Support\Facades\Session::flash('flash_danger', 'Something went wrong try again please !!');
          return redirect('login');
        }

        //$finduser = Member::where(['email' => $user->email ])->first();
        if (auth()->user()->is_approved != 1 && auth()->user()->status == 4) {
          return redirect()->intended(route('user.members'));
        }elseif(auth()->user()->is_approved != 1 && auth()->user()->status != 4){
          return redirect()->intended(route('user.edit-profile'));
        }

      } catch (Exception $e) {
        dd($e->getMessage());
      }
      //return redirect()->intended(route('home'));
    }
    //fb callback
    public function redirectToFb()
    {
      return Socialite::driver('facebook')->redirect();
    }
    public function handleFbCallback(){

      try {
        $user = Socialite::driver('facebook')->user();
        //print_r($user); die();
        $finduser = Member::where('social_id', $user->id)->first();

        $is_user_active = true;
        $resend_email_flag = false;
        $message = '';

        if (isset($finduser) && !empty($finduser)) {
            switch ($finduser->status) {
                case 0:
                    $message = 'Your account has been blocked due to some reason kindly contact admin for further assistance.';
                    $is_user_active = false;
                    break;
                case 5: //account deleted..
                    $finduser->update([
                      'status' => 1
                    ]);

                    $is_user_active = true;
                    // ************************* //
                    // Send Thankyou email to User
                    // ************************* //
                    $name = $finduser->first_name.' '.$finduser->last_name;

                    $email = $finduser->email;

                    $email_template = EmailTemplate::where('type','user_welcome')->first();
                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{app_name}}");
                    $replace = array(ucwords($name),env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);

                    sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

                    break;
            }
            if($is_user_active == false)
            {
              Auth::guard('user')->logout();
              \Illuminate\Support\Facades\Session::flash('flash_danger', $message);
              return redirect('login');
            }
            $finduser->update([
                'last_login' => Carbon::now('UTC')->timestamp,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'social_type' => 'facebook',
                'social_id' => $user->id,
            ]);
        }
        else{
           $finduser_exist = Member::where( 'email', $user->email )->first();
            //if ( $user->email ) {

              if (!$finduser_exist) {

                  //$plan = Plan::where(['id' => 1, 'status' => 1])->first(); // Trial Plan
                  $names = explode(' ', $user->user['name']);
                  $finduser = Member::create([
                    'first_name' => $names[0],
                    'last_name' => $names[1],
                    'email' => $user->email,
                    'plan_id' => 0,
                    'social_id' => $user->id,
                    'social_type' => 'facebook',
                    'firebase_token' => NULL,
                    'device_id' => NULL,
                    'email_verified_at' => now(),
                    'status' => 3,
                    'last_login' => Carbon::now('UTC')->timestamp,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                  ]);
                  // ************************* //
                  // Send Thankyou email to User
                  // ************************* //
                  $email = $finduser->email;
                  if(isset($email) && !empty($email)){
                    $name = $finduser->first_name.' '.$finduser->last_name;
                    $email = $finduser->email;
                    $email_template = EmailTemplate::where('type','user_welcome')->first();
                    //$email_template = transformEmailTemplateModel($email_template,$lang);
                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{app_name}}");
                    $replace = array(ucwords($name),env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);
                  }
                  //sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
                  // ************************* //
                  //    Send email to admin
                  // ************************* //
                  /*$email_template = EmailTemplate::where('type','new_user_registered')->first();
                  $admin_email = $social_links['email'];
                  $subject = $email_template['subject'];
                  $content = $email_template['content'];
                  $search = array("{{name}}","{{app_name}}");
                  $replace = array(ucwords($name),env('APP_NAME'));
                  $content  = str_replace($search,$replace,$content);

                  sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);*/

              }else{
                switch ($finduser_exist->status) {
                  case 0:
                    $message = 'Your account has been blocked due to some reason kindly contact admin for further assistance.';
                    $is_user_active = false;
                    break;
                    //
                  case 5: //account deleted..
                    $finduser_exist->update([
                      'status' => 1
                    ]);

                    $is_user_active = true;
                    // ************************* //
                    // Send Thankyou email to User
                    // ************************* //
                    $name = $finduser_exist->first_name.' '.$finduser_exist->last_name;

                    $email = $finduser_exist->email;

                    $email_template = EmailTemplate::where('type','user_welcome')->first();
                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{app_name}}");
                    $replace = array(ucwords($name),env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);

                    sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
                    break;
                }

                if($is_user_active == false)
                {
                  Auth::guard('user')->logout();
                  \Illuminate\Support\Facades\Session::flash('flash_danger', $message);
                  return redirect('login');
                }

                $finduser_exist->update([
                    'last_login' => Carbon::now('UTC')->timestamp,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'firebase_token' => NULL,
                    'device_id' => NULL,
                    'social_id' => $user->id,
                    'email_verified_at' => now(),
                    'social_type' => 'facebook'
                ]);
              }
            /*}else{
              return response()->json(['status' => 0, 'message' => array('message' => ['Sorry for inconvenient, Something went wrong !!! ']) , 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
            }*/
        }
        session(['user' => $finduser]);
        // $token =  Auth::login($finduser);
        $token =  Auth::guard('user')->login($finduser);
        if ( !$token )
        {
          \Illuminate\Support\Facades\Session::flash('flash_danger', 'Something went wrong try again please !!');
          //return redirect('login');
        }

        //$finduser = Member::where(['email' => $user->email ])->first();
        return redirect()->intended(route('user.members'));

      } catch (Exception $e) {
        dd($e->getMessage());
      }
      //return redirect()->intended(route('home'));
    }
    public function firebasePhoneAuthentication(){
        return view('frontend.user.auth.firebase_phone_authentication');
    }
    public function verifyMobileCode(Request $request){
        $input = $request->all();

        /*$this->validate($request, [
            'code'   => 'required',
            'mobile'   => 'required|unique:members'
        ]);*/
        $validator = Validator::make($request->all(), [
          'code'   => 'required',
          'mobile'   => 'required|unique:members'
        ],
        [
          'mobile.required' => 'Mobile number field is required.',
          'mobile.unique' => 'The mobile number is already used.',

        ]);

        if ($validator->fails())
        {
          \Illuminate\Support\Facades\Session::flash('flash_danger', $validator->messages());
          return redirect()->back()->withInput();
        }
        $model = Member::findOrFail(Auth::id());

        $model->update([
                'status' => 1,
                'code'   =>  $input['code'],
                'mobile'   =>  $input['mobile'],
                'mobile_verified' => 1
            ]);
        Auth::setUser($model);
        return redirect('/user/edit-profile');
    }
}
