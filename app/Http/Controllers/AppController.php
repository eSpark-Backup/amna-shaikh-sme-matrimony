<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\Member;
use App\Models\Event;
use App\Models\Story;
use App\Models\Plan;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\MemberPlan;
use App\Models\Payments;
use App\Models\Notification;

use Hashids;
use Hash;
use DataTables;
use Session;
use Auth;
use Stripe;

class AppController extends Controller
{

    public function index(Request $request){

    	$data = array();
        $membersAr = array();
    	$data['events'] = Event::where('status',1)->whereDate('event_date', '>=', date('Y-m-d'))->orderBy('id', 'desc')->take(4)->get();
        $data['past_events'] = Event::where('status',1)->whereDate('event_date', '<', date('Y-m-d'))->orderBy('id', 'desc')->take(4)->get();
        $data['stories'] = Story::where('status',1)->orderBy('id', 'desc')->take(30)->get()->toArray();

        $members = Member::where('is_approved',1)->orderBy('id', 'desc')->take(30)->get();

        if (auth('user')->check()) {
            $userId = Auth::guard('user')->user()->id;
            $members = $members->where('id', '!=', $userId);

        } else {
            $userId =  '';
        }
        $memb = $members->toArray();

        foreach ($members as $K => $V) {

            $memb[$K]['first_name'] =  Str::title($V->first_name.' '.substr($V->last_name, 0, 1) );
            // $memb[$K]['first_name'] =  Str::title($V->first_name.' '.$V->last_name);
            $memb[$K]['profile_image'] = checkImage(asset('storage/members/profile-image/' . $V->profile_image),'image-svgrepo-com.png',$V->profile_image,1);
            if (isset($V->country_id) && !empty($V->country_id)) {
                $memb[$K]['country_id'] = $V->country->name;
            }
            if (isset($V->occupation_id) && !empty($V->occupation_id)) {

                $memb[$K]['occupation_id'] = (isset($V->occupation->name))?$V->occupation->name : '' ;
            }
        }
        $data['members'] = $memb;
        return view('frontend.home')->with($data);
    }
    public function events(Request $request){
        $data = array();
        $db_record = Event::where(['status' => 1])->whereDate('event_date', '>=', date('Y-m-d'))->orderBy('id', 'desc');

        if($request->has('title')){
            $db_record->where(function($query) use($request) {
                $query->where('title', 'LIKE', "%{$request->title}%" );
            });
        }
        $data['title'] = $request->title;
        $data['is_past_event'] = '0';
        $data['events'] = $db_record->get();

        $data['past_events'] = Event::where('status',1)->whereDate('event_date', '<', date('Y-m-d'))->orderBy('id', 'desc')->get();
        return view('frontend.events')->with($data);
    }

    public function past_events(Request $request){
        $data = array();
        $db_record = Event::where(['status' => 1])->whereDate('event_date', '<', date('Y-m-d'))->orderBy('id', 'desc');

        if($request->has('title')){
            $db_record->where(function($query) use($request) {
                $query->where('title', 'LIKE', "%{$request->title}%" );
            });
        }
        $data['title'] = $request->title;
        $data['is_past_event'] = '1';
        $data['events'] = $db_record->get();
        return view('frontend.events')->with($data);
    }
    public function eventDetails( Request $request,$id ){
        $userDetail = Auth::guard('user')->user();
        $data['userDetail'] = $userDetail;
        $data['events'] = Event::findOrFail($id);
        $data['is_past_event'] = 0;
        if ($data['events'] && $data['events']->event_date < date('Y-m-d')) {
            $data['is_past_event'] = 1;
        }

        $data['past_events'] = Event::where(['status' => 1, 'type' => 0])->orderBy('id', 'desc')->take(4)->get();
        $data['stories'] = Story::where('status',1)->orderBy('id', 'desc')->take(5)->get()->toArray();
        return view('frontend.event-details')->with($data);
    }


    public function emailVerification($id)
    {
        $data['message'] = '';
    	$input['email_verified_at'] = now();
    	$input['status'] = 3;
//    	$id = Hashids::decode($id)[0];
    	$model = Member::findOrFail($id);
        if ($model->status != 3) {
            $model->fill($input);
            $model->save();
            $data['message'] = '<h2>Thank you for verifying your email address</h2>
                    <p>Your account has been activated and you can now login to your SME account.</p>';
            // ************************* //
            // Send mail to user
            // ************************* //

            $name = $model->first_name.' '.$model->last_name;

            $email = $model->email;

            $email_template = EmailTemplate::where('type','now_verified')->first();

            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}","{{app_name}}","{{link}}");
            $replace = array(ucwords($name),env('APP_NAME'),url('/login'));
            $content  = str_replace($search,$replace,$content);
            $social_links = GeneralSetting::find(1);

            sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

            if (Auth::guard('user')->attempt(['email' => $model->email, 'password' => $model->original_password] )) {
                // if successful, then redirect to their intended location
                $user = Member::where(['email' => $model->email ])->first();
                $is_user_active = true;
                $resend_email_flag = false;
                $message = '';
                switch ($user->status) {
                    case 0:
                        $message = 'Your account has been disabled. Please contact Admin in case of any concerns.';
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

        }elseif($model->status ==3){
            $data['message'] = '<h2>Account is already active.</h2><p>Your account has been already activated and you can now login to your SME account.</p>';
            return view('frontend.email_verified')->with($data);
        }

    }

    public function unsubscribe_payment($email)
    {
        $data['message'] = '';
        $input['auto_recurring'] = 0;
        $model = Member::where('email', $email)->first();

        if ($model) {
            $model->fill($input);
            $model->save();
            $data['message'] = '<h2>Unsubcribe</h2>
                    <p>Your auto recurring payment is now turn off successfully.</p>';

            return view('frontend.email_verified')->with($data);
            // ************************* //
            // Send mail to user
            // ************************* //

            $name = $model->first_name.' '.$model->last_name;

            $email = $model->email;

            // $email_template = EmailTemplate::where('type','now_verified')->first();

            // $subject = $email_template['subject'];
            // $content = $email_template['content'];
            // $search = array("{{name}}","{{app_name}}","{{link}}");
            // $replace = array(ucwords($name),env('APP_NAME'),url('/login'));
            // $content  = str_replace($search,$replace,$content);
            // $social_links = GeneralSetting::find(1);

            // sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

            if (Auth::guard('user')->attempt(['email' => $model->email, 'password' => $model->original_password] )) {
                // if successful, then redirect to their intended location
                $user = Member::where(['email' => $model->email ])->first();
                $is_user_active = true;
                $resend_email_flag = false;
                $message = '';
                switch ($user->status) {
                    case 0:
                        $message = 'Your account has been disabled. Please contact Admin in case of any concerns.';
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

        } else {
            $data['message'] = '<h2>Invalid Link!!!</h2><p>This link is not valid please check again.</p>';
            return view('frontend.email_verified')->with($data);
        }

    }
    //plans list
    public function plans(Request $request){
        $data = array();
        $db_record = Plan::where(['status' => 1])->orderBy('id', 'desc');
        $data['plans'] = $db_record->get();
        $data['redirect_url'] = $request->redirect_url ?? '';
        return view('frontend.plans')->with($data);
    }
    public function stories(Request $request){

        $data = array();
        $data['stories'] = Story::where(['status' => 1])->orderBy('id', 'desc')->get();
        return view('frontend.stories')->with($data);
    }
    public function storyDetails( Request $request,$id ){

        $data = array();
        $data['stories'] = Story::findOrFail($id);
        return view('frontend.story_details')->with($data);
    }
    public function privacyPolicy(Request $request){

        return view('frontend.privacy_policy');
    }
    public function termsCondition(Request $request){

        return view('frontend.terms_condition');
    }
    public function notApprovedUser(Request $request){

        return view('frontend.not_approved');
    }
    public function contactUs(){

        return view('frontend.contact_us');
    }

    public function stripeAutoRecurringPlan(Request $request){

        $getAllExpirePlanMember = MemberPlan::whereDate('end_date', '<', date('Y-m-d'))->get();


        if (count($getAllExpirePlanMember) > 0) {

            foreach ($getAllExpirePlanMember as $key => $value) {
                $member_id = $value->member_id;

                $member = Member::findOrFail($member_id);

                if ($member && $member->auto_recurring == 1 && $member->stripe_customer && $member->stripe_payment_method) {
                    $mplan = MemberPlan::where('member_id',$member->id )->first();
                    $current_date = date('Y-m-d');

                    if ($mplan) {
                        $plan = Plan::find($mplan->plan_id);

                        if ($plan) {
                            $currentDateTime = \Carbon\Carbon::now();
                            $newDateTime = \Carbon\Carbon::now()->addDays($plan->period);
                            $end_plan_date = \Carbon\Carbon::createFromTimeStamp(strtotime($newDateTime), "UTC")->format('Y-m-d');

                            try {
                              Stripe\Stripe::setApiKey( env('STRIPE_SECRET') );
                              $charge = Stripe\PaymentIntent::create([
                                'amount' => ($plan->price*100),
                                'currency' => 'usd',
                                'customer' => $member->stripe_customer,
                                'payment_method' => $member->stripe_payment_method,
                                'off_session' => true,
                                'confirm' => true,
                              ]);

                            } catch (\Stripe\Exception\CardException $e) {
                              // Error code will be authentication_required if authentication is needed
                              echo 'Error code is:' . $e->getError()->code;
                              $payment_intent_id = $e->getError()->payment_intent->id;
                              $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
                            }

                            /*if (empty($charge->id)) {
                                return die(json_encode([
                                    'status' => 0,
                                    'message' => 'Payment does not charged'
                                ]));
                            }*/

                            $total_cost = $plan->price;
                            if ( empty($mplan)  ) {

                                $apply = MemberPlan::create([
                                    'member_id' => auth()->user()->id,
                                    'plan_id' => $mplan->plan_id,
                                    'total_price' => $total_cost,
                                    'payment_id' => $charge->id,
                                    'start_date' => $currentDateTime,
                                    'end_date' => $end_plan_date,
                                    'status' => 1
                                ]);
                                $payments = Payments::create([

                                    'members_plan_id' => $apply->id,

                                    'plan_id' => $mplan->plan_id,
                                    'amoun_paid' => $total_cost,
                                    'payment_id' => $charge->id,
                                    'plan_end_date' => $end_plan_date,
                                    'stripe_status' => 'Payment complete',
                                    'status' => 1
                                ]);
                                $member->update([
                                   'plan_id' => $mplan->plan_id
                                ]);
                                InstantCount::where(['member_id' => auth()->user()->id])->delete();
                            /*}elseif($mplan->status == 0 ){*/
                            }else{
                                //update
                                $mplan->update([

                                    'plan_id' => $mplan->plan_id,
                                    'total_price' => $total_cost,
                                    'payment_id' => $charge->id,
                                    'start_date' => $currentDateTime,
                                    'end_date' => $end_plan_date,
                                    'status' => 1
                                ]);
                                $payments = Payments::create([

                                    'members_plan_id' => $mplan->id,
                                    'plan_id' => $mplan->plan_id,
                                    'amoun_paid' => $total_cost,
                                    'payment_id' => $charge->id,
                                    'plan_end_date' => $end_plan_date,
                                    'stripe_status' => 'Payment complete',
                                    'status' => 1
                                ]);
                                $member->update([
                                   'plan_id' => $mplan->plan_id
                                ]);
                            }



                            // ************************* //
                            // Send mail to user
                            // ************************* //
                            $model = $member;
                            $name = $model->first_name.' '.$model->last_name;
                            $email = $model->email;

                            $email_template = EmailTemplate::where('type','plan_auto_renewal')->first();

                            $subject = $email_template['subject'];
                            $content = $email_template['content'];
                            $unsubcribe_url = url('/user/unsubscribe-payment/'.$member->email);
                            $search = array("{{name}}","{{app_name}}","{{link}}");
                            $replace = array(ucwords($name),env('APP_NAME'),$unsubcribe_url);
                            $content  = str_replace($search,$replace,$content);
                            $social_links = GeneralSetting::find(1);

                            sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

                            $notificationAr['user_id'] = $member->id;
                            $notificationAr['chat_id'] = NULL;
                            $notificationAr['event_id'] = NULL;
                            $notificationAr['plan_id'] = $mplan->plan_id;
                            $notificationAr['title'] = 'Plan buy';
                            $notificationAr['body'] = $model->first_name.' '.$model->last_name.' apply on '. $plan->name;
                            $notificationAr['click_action'] = 'OPEN_NOTIFICATIONS';
                            $notificationAr['notification_type'] = 'buy_plan';
                            $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $model->profile_image),NULL,$model->profile_image);
                            $notificationAr['priority'] = 'hight';

                            $firebaseToken['to'] = $model->firebase_token;
                            firebasePushNotification($firebaseToken,$notificationAr);
                            $notificationAr['image'] =  $model->profile_image;

                            $notification = Notification::create($notificationAr);

                            // ************************* //
                            //    Send email to admin
                            // ************************* //
                            $email_template = EmailTemplate::where('type','user_registered_plan')->first();
                            $admin_email = $social_links['email'];
                            $subject = $email_template['subject'];
                            $content = $email_template['content'];
                            $name = 'Admin';
                            $search = array("{{name}}","{{app_name}}");
                            $replace = array(ucwords($name),env('APP_NAME'));
                            $content  = str_replace($search,$replace,$content);

                            sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);
                        }


                        /*} catch (\Exception $e) {

                            return $e->getMessage();
                        }*/
                    }

                }
            }
        }
        die('Success');

    }
    public function contactUsSend(Request $request){

        // ************************* //
        // Send mail to admin
        // ************************* //

        $input = $request->all();
        $email_template = EmailTemplate::where('type','contact_us')->first();

        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $search = array("{{first_name}}","{{last_name}}","{{email}}","{{mobile}}","{{message}}");

        $replace = array(ucwords($input['first_name']),ucwords($input['last_name']),$input['email'],$input['mobile'],$input['message']);

        $content  = str_replace($search,$replace,$content);
        $social_links = GeneralSetting::find(1);

        sendEmail($social_links->email, $subject, $content, '', '', 'en','',$social_links);
        Session::flash('flash_success', 'Thank you for your inquiry. We will contact you as soon as possible.');
        return redirect('/contact-us');
    }
}
