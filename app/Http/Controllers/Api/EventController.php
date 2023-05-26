<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\EventAudience;
use App\Models\EmailTemplate;
use App\Models\Notification;
use App\Models\GeneralSetting;

use App\Http\Resources\EventResource;
class EventController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $s_data = EventResource::collection(Event::where('status',1)->get());
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Events list']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    public function detail(Request $request)
    {
       // $member = Member::find($request->id);
        //return (new MemberResource($member));
        $s_data =  EventResource::collection( Event::where('id',$request->id)->get() );
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Event details']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    //Apply 
    public function apply(Request $request){
    	$messages = [
           
            'event_id' => 'member_id field is required',
            'sibling' => 'sibling field is required',
           
        ];
        $validation_rules = array(
            'sibling' => 'required',           
            'event_id' => 'required|integer',
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
        $event_id = $request->input('event_id');
        $event = Event::find($event_id);
        if (!$event) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Request does not send']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }

        $sibling = $request->input('sibling');
        $sib = json_decode($sibling);

        $male_guests = 0;
        $female_guests = 0;
        $total_guests = 0;
        $total_cost = $event->event_charges;
        foreach ($sib as $K => $V) {
            $total_guests++;
            if ($V->gender == 'Male') {
                $male_guests++;
            }elseif ($V->gender == 'Female') {
                $female_guests++;
            }
            //cost
            $total_cost  = $total_cost + $event->adults_charges;
        }
        $sib = json_encode($sib);
        
        $apply = EventAudience::create([
            'member_id' => auth()->user()->id,
            'guests' => $sib,
            'event_id' => $request->input('event_id'),
            'male_guests' => $male_guests,
            'female_guests' => $female_guests,
            'total_guests' => $total_guests,
            'guest_charges' => $event->adults_charges,
            'event_charges' => $event->event_charges,
            'total_price' => $total_cost
        ]);
        if (!$apply) {
        	 return response()->json([
                'status' => 0,
                'message' => array('message' => ['Request does not send']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        // ************************* //
        // Send mail to user
        // ************************* //
        $model = auth()->user();
        $name = $model->first_name.' '.$model->last_name;

        $email = $model->email;
        
        $email_template = EmailTemplate::where('type','user_apply_event')->first();
        
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $search = array("{{name}}","{{app_name}}");
        $replace = array(ucwords($name),env('APP_NAME'));
        $content  = str_replace($search,$replace,$content);
        $social_links = GeneralSetting::find(1);
        sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

        $notificationAr['user_id'] = auth()->user()->id;
        $notificationAr['chat_id'] = NULL;
        $notificationAr['event_id'] = $request->input('event_id');
        $notificationAr['plan_id'] = NULL;
        $notificationAr['title'] = 'Apply on event';
        $notificationAr['body'] = $model->first_name.' '.$model->last_name.' apply on '. $event->name.' event';
        $notificationAr['click_action'] = 'OPEN_EVENT';
        $notificationAr['notification_type'] = 'apply_event';
        $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $model->profile_image),NULL,$model->profile_image);
        $notificationAr['priority'] = 'hight';

        $firebaseToken['to'] = $model->firebase_token;
        firebasePushNotification($firebaseToken,$notificationAr);
        $notificationAr['image'] =  $model->profile_image;
        
        $notification = Notification::create($notificationAr);

        // ************************* //
        //    Send email to admin
        // ************************* //
        $email_template = EmailTemplate::where('type','user_register_event')->first();
        $admin_email = $social_links['email'];
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $name = 'Admin';
        $search = array("{{name}}","{{app_name}}");
        $replace = array(ucwords($name),env('APP_NAME'));
        $content  = str_replace($search,$replace,$content);
        
        sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);
        return response()->json([
                'status' => 1,
                'message' => array('message' => ['Apply successfully! ']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
    }
}
