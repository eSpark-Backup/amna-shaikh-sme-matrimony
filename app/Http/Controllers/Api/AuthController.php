<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Member;
use App\Models\Plan;
use App\Models\UserImage;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Http\Resources\UserImageResource;
/*use App\Http\Resources\EmailTemplateResource;*/
use Carbon\Carbon;
use Hashids;
use Storage;
use Hash;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register','login','verifyAccount','resendVerificationEmail','socialLogin']]);
    }
    public function register(Request $request)
    {
        $lang =  'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'first_name.required' => $lang_arr['validation_messages']['field_is_required'],
            'last_name.required' => $lang_arr['validation_messages']['field_is_required'],
            'first_name. max' => $lang_arr['validation_messages']['field_not_greater_than_100_characters'],
            'last_name.max' => $lang_arr['validation_messages']['field_not_greater_than_100_characters'],
            'email.required' => $lang_arr['validation_messages']['field_is_required'],
            'email.max' => $lang_arr['validation_messages']['field_not_greater_than_100_characters'],
            'email.email' => $lang_arr['validation_messages']['field_must_valid_email'],
            'email.unique' => $lang_arr['validation_messages']['email_already_exists'],
            'password.required' => $lang_arr['validation_messages']['field_is_required'],
            'password.min' => $lang_arr['validation_messages']['field_not_less_than_6_characters'],
            'password_confirmation.same' => $lang_arr['validation_messages']['password_confirmation_must_match'],
        ];
        $validation_rules = array(
            'first_name'      => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'     => 'required|string|email|max:100|unique:members',
            'password'  => 'required|string|min:6',
            'password_confirmation' => 'same:password',
        );

        $validator = Validator::make($request->all(),$validation_rules,$messages);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors(), 'success_data' => NULL ]);
        }
        $member = Member::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'password' => Hash::make($request->input('password')),
            'original_password' => $request->input('password'),
            'date_of_birth' => $request->input('date_of_birth'),
            'last_login' =>  Carbon::now('UTC')->timestamp,
            'status' => 2,
            'plan_id' => 0,
            'firebase_token' => $request->input('firebase_token'),
            'device_id' => $request->input('device_id'),
        ]);
        if($member)
        {
            
            // ************************* //
            // Send Verify Link To User
            // ************************* //
            $name = $member->first_name.' '.$member->last_name;

            $email = $member->email;
            $link = url('/verify-account/'.Hashids::encode($member->id));
            $email_template = EmailTemplate::where('type','sign_up_confirmation')->first();
            //$email_template = transformEmailTemplateModel($email_template,$lang);
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}","{{link}}","{{app_name}}");
            $replace = array(ucwords($name),$link,env('APP_NAME'));
            $content  = str_replace($search,$replace,$content);
            $social_links = GeneralSetting::find(1);

            sendEmail($email, $subject, $content, '', '', $lang,'',$social_links);

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
            
            sendEmail($admin_email, $subject, $content, '', '', $lang,'',$social_links);
            return response()->json([
                'status' => 1,
                'message' =>  array('message' => [$lang_arr['alert_messages']['verification_email_success']]) ,
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['sign_up_error']]),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'email.required' => $lang_arr['validation_messages']['field_is_required'],
            'email.email' => $lang_arr['validation_messages']['field_must_valid_email'],
            'password.required' => $lang_arr['validation_messages']['field_is_required'],
        ];
        $validation_rules = array(
            'email' => 'required|string|email',
            'password' => 'required|string'
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors(), 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
            }
        }
        else
        {
            $validatedData = $request->validate($validation_rules,$messages);
        }
        $credentials = ['email' => $request->email, 'password' => $request->password];
        
        if (!$token = auth()->attempt($credentials) )
        {
            return response()->json(['status' => 0, 'message' => array('message' => [$lang_arr['alert_messages']['invalid_email_password']]) , 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
        }
        $user = Member::where(['email' => $request->input('email')])->first();

        $is_user_active = true;
        $resend_email_flag = false;
        $message = '';
        switch ($user->status) {
            case 0:
                $message = $lang_arr['alert_messages']['account_disabled_contact_admin'];
                $is_user_active = false;
                break;
            case 2:
                $message = $lang_arr['alert_messages']['verify_email_or_recend_email'];
                $is_user_active = false;
                $resend_email_flag = true;
                break;
            //
            case 4: //account deleted..
                $message = $lang_arr['alert_messages']['account_deleted_contact_admin'];
                $is_user_active = false;
                break;
        }
        if($is_user_active == false)
        {
            auth()->logout();
            $success_data = array('user_status' => $user->status,'resend_email_flag' => $resend_email_flag, 'email' => $request->email, );
            return response()->json(['status' => 0,'message' => array('message' => [$message]),'success_data' => $success_data], 200, ['Content-Type' => 'application/json']);
        }
        $is_approved = true;
        $message = '';
        switch ($user->is_approved) {
            case 0:
                $message = $lang_arr['alert_messages']['account_under_review_contact_admin'];
                $is_approved = false;
                break;
            case 2:
                $message = $lang_arr['alert_messages']['account_rejected_contact_admin'];
                $is_approved = false;
                break;
            case 3:
                $message = $lang_arr['alert_messages']['account_rejected_contact_admin'];
                $is_approved = false;
                break;
        }
        /*if($is_approved == false)
        {
            auth()->logout();
            return response()->json(['status' => 0,'message' => array('message' =>$message),'success_data' => ['user_approved' => $is_approved]]);
        }*/
        $user->update([
            'last_login' => Carbon::now('UTC')->timestamp,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'firebase_token' => $request->input('firebase_token'),
            'device_id' => $request->input('device_id'),
        ]);
        // get user images
        $userimages = UserImageResource::collection(UserImage::where('member_id',$user->id)->get() );

        $user['user_images'] = $userimages;
        $success_data = array('access_token' => $token,'token_type' => 'bearer', 'expires_in' => auth()->factory()->getTTL(),'data' => $user->makeHidden(['original_password']));

        return response()->json([
            'status' => 1,
            'message' => array('message' => [$lang_arr['alert_messages']['user_logged_success']]),
            'user_approved' => $is_approved,
            'success_data' =>  $success_data
        ], 200, ['Content-Type' => 'application/json']);
    }
    public function socialLogin(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'social_id.required' => $lang_arr['validation_messages']['field_is_required'],
            'social_type.required' => $lang_arr['validation_messages']['field_is_required'],
        ];
        $validation_rules = array(
            'social_id' => 'required|string',
            'social_type' => 'required|string'
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors(), 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
            }
        }
        else
        {
            $validatedData = $request->validate($validation_rules,$messages);
        }
       
                   
        $user = Member::where('social_id', $request->social_id)->first();
        if ($user) {

            $user->update([
                'last_login' => Carbon::now('UTC')->timestamp,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'firebase_token' => $request->firebase_token,
                'device_id' => $request->device_id
            ]);
        }
        else{
            if ( $request->has('email') ) {

                $user = Member::where( 'email', $request->email )->first();

                if (!$user) {

                    //$plan = Plan::where(['id' => 1, 'status' => 1])->first(); // Trial Plan
                    $user = Member::create([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        //'plan_id' => $plan->id,
                        'social_id' => $request->social_id,
                        'social_type' => $request->social_type,
                        'firebase_token' => $request->firebase_token,
                        'device_id' => $request->device_id,
                        'email_verified_at' => now(),
                        'status' => 3,
                        'last_login' => Carbon::now('UTC')->timestamp,
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                    ]);
                    // ************************* //
                    // Send Thankyou email to User
                    // ************************* //
                    $name = $user->first_name.' '.$user->last_name;

                    $email = $user->email;
                    
                    $email_template = EmailTemplate::where('type','user_welcome')->first();
                    //$email_template = transformEmailTemplateModel($email_template,$lang);
                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{app_name}}");
                    $replace = array(ucwords($name),env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);
                    
                    sendEmail($email, $subject, $content, '', '', $lang,'',$social_links);
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
                    
                    sendEmail($admin_email, $subject, $content, '', '', $lang,'',$social_links);

                }else{

                    $user->update([
                        'last_login' => Carbon::now('UTC')->timestamp,
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'firebase_token' => $request->firebase_token,
                        'device_id' => $request->device_id,
                        'social_id' => $request->social_id,
                        'email_verified_at' => now(),
                        'social_type' => $request->social_type
                    ]);
                }
            }else{
                return response()->json(['status' => 0, 'message' => array('message' => ['Sorry for inconvenient, Something went wrong !!! ']) , 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
            }
        }

        $token =  Auth::login($user);

        if ( !$token )
        {
            return response()->json(['status' => 0, 'message' => array('message' => [$lang_arr['alert_messages']['invalid_email_password']]) , 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
        }

        $user = Member::where(['email' => $request->input('email')])->first();

        $is_user_active = true;
        $resend_email_flag = false;
        $message = '';
        /*switch ($user->status) {
            case 0:
                $message = $lang_arr['alert_messages']['account_disabled_contact_admin'];
                $is_user_active = false;
                break;
            case 2:
                $message = $lang_arr['alert_messages']['verify_email_or_recend_email'];
                $is_user_active = false;
                $resend_email_flag = true;
                break;
            case 3:
                $message = $lang_arr['alert_messages']['account_deleted_contact_admin'];
                $is_user_active = false;
                break;
        }*/
        if($is_user_active == false)
        {
            auth()->logout();
            $success_data = array('user_status' => $user->status,'resend_email_flag' => $resend_email_flag, 'email' => $request->email, );
            return response()->json(['status' => 0,'message' => array('message' => [$message]),'success_data' => $success_data], 200, ['Content-Type' => 'application/json']);
        }

        // get user images
        $userimages = UserImageResource::collection(UserImage::where('member_id',$user->id)->get() );

        $user['user_images'] = $userimages;
        $success_data = array('access_token' => $token,'token_type' => 'bearer', 'expires_in' => auth()->factory()->getTTL(),'data' => $user->makeHidden(['original_password']),);
        return response()->json([
            'status' => 1,
            'message' => array('message' => [$lang_arr['alert_messages']['user_logged_success']]),
            'success_data' => $success_data
        ], 200, ['Content-Type' => 'application/json']);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        return response()->json([
            'success_data' => ['data' => auth('api')->user()->makeHidden(['original_password'])],
            'status' => 1,
            'message' =>  array('message' => ['Your Profile'] ),
        ], 200, ['Content-Type' => 'application/json']);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json(['status' => 1, 'message' =>   array('message' =>  ['Successfully logged out'] ), 'success_data' => NULL], 200, ['Content-Type' => 'application/json']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'status' => 1,
            'message' => 'User Token'
        ]);
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'      => 'required|string',
            'new_password'      => 'required|string|min:6|same:confirm_password',
            'confirm_password'  => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()], 400, ['Content-Type' => 'application/json']);
        }
        $user = auth()->user();
        if(Hash::check($request->input('old_password'), $user->password))
        {
            $user->update([
                'password' => Hash::make($request->input('new_password')),
                'original_password' => $request->input('new_password')
            ]);
            return response()->json(['status' => 1, 'message' =>  array('message' => ['Password has been updated successfully']), 'success_data' => NULL ], 200, ['Content-Type' => 'application/json']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' =>  array('message' => ['Old password is not correct.'] ), 'success_data' => NULL], 400, ['Content-Type' => 'application/json']);
        }
    }
    public function updateProfile(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $user = auth()->user();

        $user = Member::where('id', auth()->user()->id)->first();

        $reqdata = $request->all();
        
        $messages = [
            
            'password.required' => $lang_arr['validation_messages']['field_is_required'],
            'password.max' => $lang_arr['validation_messages']['field_not_greater_than_30_characters'],
            'password.min' => $lang_arr['validation_messages']['field_not_less_than_6_characters'],
            'password.regex' => $lang_arr['password_field_title'],
            'password_confirmation.same' => $lang_arr['validation_messages']['password_confirmation_must_match'],
        ];
        $validation_rules = array();
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }
        
        //print_r($reqdata); die();
        //$user->update($reqdata);
        $user->fill($reqdata);
        $user->save();

        if($request->has('timezone')) {
            $user->update([
                'timezone' => $request->input('timezone')
            ]);
        }
        if(!empty($request->password))
        {
            // ******************* //
            // Password Validation //
            // ******************* //
            $messages = [
                'old_password.required' => $lang_arr['validation_messages']['field_is_required'],
                'password.required' => $lang_arr['validation_messages']['field_is_required'],
                'password.max' => $lang_arr['validation_messages']['field_not_greater_than_30_characters'],
                'password.min' => $lang_arr['validation_messages']['field_not_less_than_6_characters'],
                'password.regex' => $lang_arr['password_field_title'],
                'password_confirmation.same' => $lang_arr['validation_messages']['password_confirmation_must_match'],
            ];
            $validation_rules = array(
                'old_password'  => 'required|string',
                'password'      => 'required|string|min:6|max:30|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/',
                'password_confirmation' => 'same:password',
            );
            if($request->has('platform') && $request->platform == 'mobile')
            {
                $validator = Validator::make($request->all(),$validation_rules,$messages);
                if ($validator->fails()) {
                    return response()->json(['status' => 0, 'message' => $validator->errors()]);
                }
            }
            else
            {
                $request->validate($validation_rules,$messages);
            }
            if(Hash::check($request->input('old_password'), $user->password))
            {
                $user->update([
                    'password' => Hash::make($request->input('password')),
                    'original_password' => $request->input('password')
                ]);
            }
            else
            {
                return response()->json(['status' => 0, 'message' =>  array('message' => [$lang_arr['alert_messages']['old_password_incorrect']] ), 'success_data' => NULL ], 400, ['Content-Type' => 'application/json']);
            }
        }
        if(!empty($request->files) && $request->hasFile('profile_image'))
        {
            // *************** //
            // File Validation //
            // *************** //
            $messages = [
                'profile_image.required' => $lang_arr['validation_messages']['field_is_required'],
                'profile_image.image' => $lang_arr['validation_messages']['file_must_be_image'],
                'profile_image.mimes' => $lang_arr['validation_messages']['allowed_image_jpg_jpeg_png_svg']
            ];
            $validation_rules = array(
                'profile_image' => 'required|file|image|mimes:jpg,jpeg,png,svg'
            );
            if($request->has('platform') && $request->platform == 'mobile')
            {
                $validator = Validator::make($request->all(),$validation_rules,$messages);
                if ($validator->fails()) {
                    return response()->json(['status' => 0, 'message' => $validator->errors()]);
                }
            }
            else
            {
                $request->validate($validation_rules,$messages);
            }
            // *********** //
            // Upload File //
            // *********** //
            $target_path = 'public/members/profile-image/';
            $file = $request->file('profile_image');
            $profile_image = 'profile_image-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $old_file = public_path() . '/storage/members/profile-image/' . $user->profile_image;
            if (file_exists($old_file) && !empty($user->profile_image))
            {
                Storage::delete($target_path . '/' . $user->profile_image);
            }
            $path = $file->storeAs($target_path, $profile_image);
            $user->update([
                'profile_image' => $profile_image
            ]);


        }
        return response()->json([
            'status' => 1,
            'message' => array('message' => [$lang_arr['alert_messages']['update_profile_success']]),
            'success_data' => array( 'data' => $user ),
        ], 200, ['Content-Type' => 'application/json']);
    }
    public function deleteAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason_termination'  => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()[0]], 400, ['Content-Type' => 'application/json']);
        }
        /*if(Hash::check($request->input('password'), auth()->user()->password))
        {*/
            $user = auth()->user();
            $user->update([
                    'status' => 4,
                    'reason_termination' => $request->input('reason_termination')
                ]);

            Member::destroy(auth()->user()->id);
            return response()->json(['status' => 1, 'message' => 'Your account has been deleted successfully'], 200, ['Content-Type' => 'application/json']);
        /*}
        else
        {
            return response()->json(['status' => 0, 'message' => 'Password is not correct.'], 400, ['Content-Type' => 'application/json']);
        }*/
    }
    public function verifyAccount($id, Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        if(!isset(Hashids::decode($id)[0]))
        {
            return response()->json([
                'status' => 0,
                'message' => $lang_arr['alert_messages']['verify_account_error']
            ]);
        }
        $member = Member::find(Hashids::decode($id)[0]);
        $message = '';
        if($member)
        {
            $is_approved = true;
            switch ($user->is_approved) {
                case 0:
                    $message = $lang_arr['alert_messages']['account_under_review_contact_admin'];
                    $is_approved = false;
                    break;
                case 2:
                    $message = $lang_arr['alert_messages']['account_rejected_contact_admin'];
                    $is_approved = false;
                    break;
            }
            $member->update([
                'status' => 3,
            ]);
            if($is_approved == false)
            {
                return response()->json(['status' => 0, 'user_approved' => $is_approved, 'message' => $message]);
            }
            $credentials = ['email' => $member->email, 'password' => $member->original_password];
            $token = auth()->attempt($credentials);
            $user->update([
                'last_login' => Carbon::now('UTC')->timestamp,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL(),
                'data' => $member->makeHidden(['subscription','original_password']),
                'status' => 1,
                'message' => $lang_arr['alert_messages']['account_verified_successfully']
            ]);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'message' => $lang_arr['alert_messages']['verify_account_error']
            ]);
        }
    }
    public function verifyMobile( Request $request )
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);


        $messages = [
            'mobile.required' => 'phone field is required',
            'mobile.unique' => 'This phone number already exists',
        ];
        $validation_rules = array(
            'mobile' => 'required|unique:members'
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }
        $member = Member::find( auth()->user()->id );
        if($member)
        {
            $is_approved = true;
            switch ($member->is_approved) {
                case 0:
                    $message = $lang_arr['alert_messages']['account_under_review_contact_admin'];
                    $is_approved = false;
                    break;
                case 2:
                    $message = $lang_arr['alert_messages']['account_rejected_contact_admin'];
                    $is_approved = false;
                    break;
            }
            $member->update([
                'mobile_verified' => 1,
                'status' => 1,
                'mobile' => $request->mobile,
                'code' => $request->code,
            ]);
            $credentials = ['email' => $member->email, 'password' => $member->original_password];
            $token = auth()->attempt($credentials);
            $member->update([
                'last_login' => Carbon::now('UTC')->timestamp,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            $success_data = array('access_token' => $token,'token_type' => 'bearer', 'expires_in' => auth()->factory()->getTTL(),'data' => $member->makeHidden(['original_password']));
            return response()->json([
                'status' => 1,
                'message' => array('message' => [$lang_arr['alert_messages']['account_verified_successfully']]),
                'user_approved' => $is_approved,
                'success_data' => $success_data
            ], 200, ['Content-Type' => 'application/json']);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'message' => $lang_arr['alert_messages']['verify_account_error']
            ]);
        }
    }
    public function checkMobileAvailability(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);

        $messages = [
            'mobile.required' => 'phone field is required',
            'mobile.unique' => 'This phone number already exists',
        ];
        $validation_rules = array(
            'mobile' => 'required|unique:members'
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }

        $member = Member::where('mobile', $request->mobile)->first();

        if($member)
        {
            return response()->json([
                'status' => 0,
                'message' => array('message' => [ $lang_arr['alert_messages']['phone_already_exists'] ]),

                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
        else
        {
            return response()->json([
                'status' => 1,
                'success_data' => NULL,
                'message' => array('message' => [ $lang_arr['available'] ])
            ]);
        }
    }
    public function accountSettings(Request $request)
    {
        return response()->json([
            'data' => auth()->user()->accountSettings,
            'status' => 1,
            'message' => 'Your Account Settings'
        ]);
    }
    public function updateAccountSettings(Request $request)
    {
        $request->validate([
            'address'               => 'required',
            'card_holder_name'      => 'required|max:250',
            'card_brand'            => 'required|max:100',
            'card_number'           => 'required|max:16',
            'expire_month'          => 'required',
            'expire_year'           => 'required',
            'cvc'                   => 'required|max:4',
        ]);
        $lang = $request->has('lang') && $request->lang != 'en' ? $request->lang : 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        AccountSetting::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'user_id'               => auth()->user()->id,
                'address'               => $request->address,
                'card_holder_name'      => $request->card_holder_name,
                'card_brand'            => $request->card_brand,
                'card_number'           => encrypt($request->card_number),
                'card_last_four_digits' => substr($request->card_number, -4),
                'expire_month'          => $request->expire_month,
                'expire_year'           => $request->expire_year,
                'cvc'                   => encrypt($request->cvc)
            ]
        );
        return response()->json([
            'status' => 1,
            'message' => $lang_arr['alert_messages']['auth_update_account_settings_success']
        ]);
    }
    public function resendVerificationEmail(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $user = Member::where('email', $request->email)->first();
        if($user)
        {
            // ************************* //
            // Send Verify Link To User
            // ************************* //
            $name = $user->first_name.' '.$user->last_name;
            $email = $user->email;
            $link = url('/verify-account/'.Hashids::encode($user->id));
            $email_template = EmailTemplate::where('type','sign_up_confirmation')->first();
            //$email_template = transformEmailTemplateModel($email_template,$lang);
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}","{{link}}","{{app_name}}");
            $replace = array(ucwords($name),$link,env('APP_NAME'));
            $content  = str_replace($search,$replace,$content);
           
            $social_links = GeneralSetting::find(1);
            
            sendEmail($email, $subject, $content, '', '', $lang,'',$social_links);
            return response()->json([
                'status' => 1,
                'message' =>  array('message' => [$lang_arr['alert_messages']['verification_email_success']]) ,
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['sign_up_error']]),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
    }

    //save image
    public function store(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        //$id =  Hashids::decode($request->hash_id)[0];

        // *************** //
        // File Validation //
        // *************** //

        $messages = [
            'user_image.required' => $lang_arr['validation_messages']['field_is_required'],
            'profile_image.image' => $lang_arr['validation_messages']['file_must_be_image'],
            'profile_image.mimes' => $lang_arr['validation_messages']['allowed_image_jpg_jpeg_png_svg']
        ];
        $validation_rules = array(
            'user_image' => 'required|file|image|mimes:jpg,jpeg,png,svg'
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }
        // *********** //
        // Upload File //
        // *********** //
        $target_path = 'public/members/profile-image/';
        $file = $request->file('user_image');
        $profile_image = 'user_image-' . uniqid() . '.' . $file->getClientOriginalExtension();

        $alreadyUserImages = UserImage::where('member_id',auth()->user()->id )->first();
       //print_r($alreadyUserImages); die();
        $path = $file->storeAs($target_path, $profile_image);

        $user_image = UserImage::create([
            'user_image' => $profile_image,
            'is_private' => $request->is_private,
            'member_id'  => auth()->user()->id
        ]);

        if ( $user_image ) {

            $user = Member::where('id',auth()->user()->id)->first();

            if ($request->has('is_profile_image') && $request->is_profile_image == 1 ) {
                
                if ($user) {
                    $user->update([
                        'profile_image' => $profile_image,
                    ]);
                }
            }elseif(empty($alreadyUserImages)){ // first image should be profile image 
                    $user->update([
                        'profile_image' => $profile_image,
                    ]);
                    $user_image->update([
                        'is_profile' => 1
                    ]);
            }

            return response()->json([
                'status' => 1,
                'message' => array('message' => [$lang_arr['alert_messages']['extensions_upload_file_success']]),
                'success_data' => array( 'data' => NULL ),
            ], 200, ['Content-Type' => 'application/json']);
        }else{
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['extensions_upload_file_error']]),
                'success_data' => array( 'data' => '' ),
            ], 200, ['Content-Type' => 'application/json']);
        }
    }
    //Delete image
    public function destroy(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);

        $messages = [
            'image_id.required' => 'image_id field is required',
        ];
        $validation_rules = array(

            'image_id' => 'required|integer',

        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }

        $userimage = UserImage::where(['id'=>$request->input('image_id'),'member_id' => auth()->user()->id] )->first();

        if (!$userimage) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['user_image_deleted_error']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }

        $userimage->delete();

        return response()->json([
            'status' => 1,
            'message' => array('message' => [$lang_arr['alert_messages']['user_image_deleted']]),
            'success_data' => NULL
        ], 200, ['Content-Type' => 'application/json']);

    }
    //make image private
    public function privateImage(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);

        $messages = [
            'is_private.required' => 'is_private field is required',
            'image_id.required' => 'image_id field is required',
        ];
        $validation_rules = array(
            'is_private' => 'required',
            'image_id' => 'required|integer',

        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }

        $userimage = UserImage::where('id',$request->input('image_id'))->first();
        if (!$userimage) {

            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['image_does_not_exist']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);

        }

        $userimage->update([
            'is_private' => $request->input('is_private'),
        ]);
        return response()->json([
            'status' => 1,
            'message' => array('message' => [$lang_arr['alert_messages']['user_image_success']]),
            'success_data' => NULL
        ], 200, ['Content-Type' => 'application/json']);


    }
    //make image as profile image
    public function setProfileImage(Request $request)
    {

        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'image_id.required' => 'image_id field is required',
        ];
        $validation_rules = array(
            'image_id' => 'required|integer',
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }

        $user = auth()->user();

        $userimage = UserImage::where('id',$request->input('image_id'))->first();
        if (!$userimage) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['image_does_not_exist']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }

        $user->update([
            'profile_image' => $userimage->user_image
        ]);
        $userimage->update([
            'is_profile' => 1

        ]);

        return response()->json([
            'status' => 1,
            'message' => array('message' => [$lang_arr['alert_messages']['user_image_profile']]),
            'success_data' => NULL
        ], 200, ['Content-Type' => 'application/json']);
    }
    // approval request to change is_approved set 4 Pending by user..
    public function setProfilePending(Request $request)
    {
        $user = auth()->user();
        $user->update([
            'is_approved' => 4
        ]);
         // ************************* //
            // Send mail to user
            // ************************* //
            $model = auth()->user();
            $name = $model->first_name.' '.$model->last_name;
            
            // ************************* //
            //    Send email to admin
            // ************************* //
            $social_links = GeneralSetting::find(1);
            
            $email_template = EmailTemplate::where('type','submitted_profile_approval')->first();
            $admin_email = $social_links['email'];
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $admin = 'Admin';
            $search = array("{{name}}","{{user}}","{{app_name}}");
            $replace = array(ucwords($admin),ucwords($name),env('APP_NAME'));
            $content  = str_replace($search,$replace,$content);
            
            sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);



        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Approval request has been send successfully']),
            'success_data' => NULL
        ], 200, ['Content-Type' => 'application/json']);
    }
}




/*$user->update([
    'first_name'     => $request->input('first_name'),
    'last_name'     => $request->input('last_name'),
    'about' => $request->input('about'),
    'martial_status_id' => $request->input('martial_status_id'),
    'height' => $request->input('height'),
    'caste' => $request->input('cast_id'),
    'mobile' => $request->input('mobile'),
    'date_of_birth' => $request->input('date_of_birth'),
    'gender' => $request->input('gender'),
    'country_id' => $request->input('country_id'),
    'state_id' => $request->input('state_id'),
    'city_id' => $request->input('city_id'),
    'nationality_id' => $request->input('nationality_id'),
    'education_id' => $request->input('education_id'),
    'specialization_id' => $request->input('specialization_id'),
    'working_with_id' => $request->input('working_with_id'),
    'looking_for_id' => $request->input('looking_for_id'),
    'drinking' => $request->input('drinking'),
    'smoking' => $request->input('smoking'),
    'star_sign' => $request->input('star_sign'),
    'language_id' => $request->input('language_id'),
    'occupation_' => $request->input('occupation_id'),
    'annual_income' => $request->input('annual_income')
]);*/