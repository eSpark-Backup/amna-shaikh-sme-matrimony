<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use App\Models\MemberInterest;
use App\Models\EmailTemplate;
use App\Models\Notification;
use App\Models\Payments;
use App\Models\GeneralSetting;
use App\Http\Resources\MemberResource;
use App\Http\Resources\TransactionResource;
class MemberController extends Controller
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
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {

    	$interstIds = MemberInterest::where('member_id', auth()->user()->id)->pluck('member_interested_id')->all();
    	 
		$db_record = Member::whereNotIn('id', $interstIds);

    	$db_record = $db_record->where('is_approved',1)->where('id', '!=', auth()->user()->id)->whereNull('deleted_at');
    	$db_record = $db_record->where('gender', '!=', auth()->user()->gender);
    	//Country ID
    	if( $request->has('country_id') && !empty( $request->country_id ) )
        {

            $db_record = $db_record->where('country_id', $request->country_id );
        }
        //nationality ID
        if( $request->has('nationality_id') && !empty( $request->nationality_id ) )
        {
        	
            $db_record = $db_record->where('nationality_id', $request->nationality_id );
        }
        //education_id
        if( $request->has('education_id') && !empty( $request->education_id ) )
        {
        	
            $db_record = $db_record->where('education_id', $request->education_id );
        }
        //education_id
        if( $request->has('job_id') && !empty( $request->job_id ) )
        {
        	
            $db_record = $db_record->where('job_id', $request->job_id );
        }
        //caste_id
        if( $request->has('caste_id') && !empty( $request->caste_id ) )
        {
        	
            $db_record = $db_record->where('caste_id', $request->caste_id );
        }
        //marital_status_id
        if( $request->has('marital_status_id') && !empty( $request->marital_status_id ) )
        {
            $db_record = $db_record->where('marital_status_id', $request->marital_status_id );
        }
        //height
        if( $request->has('height') && !empty( $request->height ) )
        {
            $db_record = $db_record->where('height', $request->height );
        }
        //age
        if( $request->has('partner_age') && !empty( $request->partner_age ) )
        {
            $db_record = $db_record->where('partner_age', $request->partner_age );
        }
        //annual_income
        if( $request->has('annual_income') && !empty( $request->annual_income ) )
        {
            $db_record = $db_record->where('annual_income', $request->annual_income );
        }

        $s_data = MemberResource::collection( $db_record->get() );
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Members details']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request)
    {
       // $member = Member::find($request->id);
        //return (new MemberResource($member));
        $s_data =  MemberResource::collection( Member::where('id',$request->id)->get() );
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Members details']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    //send interest request
    public function interestRequest(Request $request ){
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'member_interested_id' => 'interested member id field is required',
            'status' => 'status field is required',
        ];
        $validation_rules = array(
            'member_interested_id' => 'required|integer',
            'status' => 'required|integer'
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
        $member = Member::where('id', $request->input('member_interested_id') )->first();
        if (!$member) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Member does not exist']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        $interestMember = MemberInterest::where(['member_id' => auth()->user()->id , 'member_interested_id' => $request->input('member_interested_id') ] )->first();
        if ($interestMember) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Request has been already send']),
                'success_data' => NULL,
            ],200, ['Content-Type' => 'application/json']);
        }
        // check already other send request
        $cu_status = 2;
        $s_data = NULL;
        $s_data1 = NULL;
        $otherMemberReq = MemberInterest::where(['member_id' => $request->input('member_interested_id')  , 'member_interested_id' => auth()->user()->id ] )->first();
        if (!empty($otherMemberReq)) {
            $otherMemberReq->update([
                'status' => 1
            ]);
            $cu_status = 1;
            $id = auth()->user()->id;
            $member_interested_id = $request->input('member_interested_id');
            $db_record = Member::select(
                            'members.*',
                            'member_interests.status as interest')
                        ->join('member_interests', function ($join) use ($id,$member_interested_id) {
                            $join->on('member_interests.member_id', '=', 'members.id')
                            ->where('member_interests.member_interested_id','=', $id )
                            ->where('member_interests.member_id','=', $member_interested_id );
                        });
            $db_record = $db_record->orderBy('member_interests.created_at','DESC')->get();
            $s_data =  MemberResource::collection( $db_record );
        }
        // END check already other send request

        $memberInterest = MemberInterest::create([
            'member_id' => auth()->user()->id,
            'member_interested_id' => $request->input('member_interested_id'),
            'status' => $cu_status,
        ]);
        if($memberInterest)
        {
            $notificationAr['user_id'] = $request->input('member_interested_id');
            $notificationAr['chat_id'] = NULL;
            $notificationAr['event_id'] = NULL;
            $notificationAr['plan_id'] = NULL;
            $notificationAr['title'] = 'Like Request';
            $notificationAr['body'] = auth()->user()->first_name.' '.auth()->user()->last_name.' liked you.';
            $notificationAr['click_action'] = 'OPEN_PROFILE';
            $notificationAr['notification_type'] = 'user_like';
            $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . auth()->user()->profile_image),NULL,$member->profile_image);
            $notificationAr['priority'] = 'hight';

            $firebaseToken['to'] = $member->firebase_token;
            firebasePushNotification($firebaseToken,$notificationAr);
            $notificationAr['image'] =  $member->profile_image;
            $notificationAr['sender_id'] =  auth()->user()->id;
            $notification = Notification::create($notificationAr);
            // ************************* //
            // Send email To User
            // ************************* //
            $name = $member->first_name.' '.$member->last_name;
            $email = $member->email;
            $email_template = EmailTemplate::where('type','user_liked')->first();
            //$email_template = transformEmailTemplateModel($email_template,$lang);
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}","{{app_name}}");
            $replace = array($name,env('APP_NAME'));
            $content  = str_replace($search,$replace,$content);
            
            $social_links = GeneralSetting::find(1);
            sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
            if (isset($s_data) && !empty($s_data)) {
	            //login memeber
	            $db_record1 = Member::select(
	                            'members.*',
	                            'member_interests.status as interest')
	                        ->join('member_interests', function ($join) use ($id,$member_interested_id) {
	                            $join->on('member_interests.member_id', '=', 'members.id')
	                            ->where('member_interests.member_id','=', $id )
	                            ->where('member_interests.member_interested_id','=', $member_interested_id );
	                        });
	            $db_record1 = $db_record1->orderBy('member_interests.created_at','DESC')->get();
	            $s_data1 =  MemberResource::collection( $db_record1 );
	        }

            return response()->json([
                'status' => 1,
                'message' => array('message' => [$lang_arr['alert_messages']['liked_request']]) ,
                'success_data' => array('data' => ['interested_member' => $s_data, 'sender_member' => $s_data1])
            ]);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['liked_request_error']]),
                'success_data' => NULL,
            ],200, ['Content-Type' => 'application/json']);
        }
    }
    // accept request
    public function interestRequestUpdate(Request $request ){
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'member_id' => 'member id field is required',
            'status' => 'status field is required',
        ];
        $validation_rules = array(
            'member_id' => 'required|integer',
            'status' => 'required|integer'
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
        $memberRequest = MemberInterest::where(['member_id' =>  $request->input('member_id'), 'member_interested_id' => auth()->user()->id ] )->first();
        if (!$memberRequest) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Request does not found']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        $memberRequest->update([
            'status' => $request->input('status')
        ]);
            $notificationAr['user_id'] = $request->input('member_id');
            $notificationAr['chat_id'] = NULL;
            $notificationAr['event_id'] = NULL;
            $notificationAr['plan_id'] = NULL;
            $notificationAr['title'] = 'Like Request';
            $notificationAr['body'] = auth()->user()->first_name.' '.auth()->user()->last_name. ' '.$request->input('status'). ' you.';
            $notificationAr['click_action'] = 'OPEN_PROFILE';
            $notificationAr['notification_type'] = 'user_like';
            $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . auth()->user()->profile_image),NULL,$member->profile_image);
            $notificationAr['priority'] = 'hight';

            $firebaseToken['to'] = $member->firebase_token;
            firebasePushNotification($firebaseToken,$notificationAr);
            $notificationAr['image'] =  $member->profile_image;
            $notificationAr['sender_id'] =  auth()->user()->id;
            $notification = Notification::create($notificationAr);
            // ************************* //
            // Send email To User
            // ************************* //
            $name = $member->first_name.' '.$member->last_name;
            $email = $member->email;
            $email_template = EmailTemplate::where('type','user_liked')->first();
            //$email_template = transformEmailTemplateModel($email_template,$lang);
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}","{{app_name}}");
            $replace = array($name,env('APP_NAME'));
            $content  = str_replace($search,$replace,$content);
            
            $social_links = GeneralSetting::find(1);
            sendEmail($email, $subject, $content, '', '', 'en','',$social_links);


        return response()->json([
            'status' => 1,
            'message' =>  array('message' => ['Request udated successfully!. ']) ,
            'success_data' => NULL
        ],200, ['Content-Type' => 'application/json']);
    }
    public function membersListWithInterest(Request $request){ //request send members
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $id = auth()->user()->id;
        //
        $db_record = Member::select(
                            'members.*',
                            'member_interests.status as interest','member_interests.member_interested_id')
                        ->join('member_interests', function ($join) use ($id) {
                            $join->on('member_interests.member_interested_id', '=', 'members.id')
                            ->where('member_interests.member_id','=', $id );

                        });
        if ( $request->has('status') &&  !empty( $request->input('status') ) ) {
            $db_record = $db_record->where('member_interests.status',$request->input('status') );
        }
        $db_record = $db_record->orderBy('member_interests.created_at','DESC')->get();
        $s_data =  MemberResource::collection( $db_record );
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Members details']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    public function membersListReceivedRequest(Request $request){ //request send members
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $id = auth()->user()->id;
        //
        $db_record = Member::select(
                            'members.*',
                            'member_interests.status as interest','member_interests.member_interested_id')
                        ->join('member_interests', function ($join) use ($id) {
                            $join->on('member_interests.member_id', '=', 'members.id')
                            ->where('member_interests.member_interested_id','=', $id );
                        });
        if ( $request->has('status') &&  !empty( $request->input('status') ) ) {
            $db_record = $db_record->where('member_interests.status',$request->input('status') );
        }else{
        	$db_record = $db_record->where('member_interests.status','<>', 1 );
        }
        $db_record = $db_record->orderBy('member_interests.created_at','DESC')->get();
        $s_data =  MemberResource::collection( $db_record );
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Members details']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    //Request cancel OR delete
    public function interestRequestCancel(Request $request ){
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'member_interested_id' => 'member id field is required',
        ];
        $validation_rules = array(
            'member_interested_id' => 'required|integer',
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
        $memberRequest = MemberInterest::where(['member_id' => auth()->user()->id , 'member_interested_id' => $request->input('member_interested_id')  ] )->first();
        if (!$memberRequest) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Request does not found']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }

        $memberRequest->delete();
        $member = Member::where('id',$request->input('member_interested_id'));

        $notificationAr['user_id'] = $request->input('member_interested_id');
        $notificationAr['chat_id'] = NULL;
        $notificationAr['event_id'] = NULL;
        $notificationAr['plan_id'] = NULL;
        $notificationAr['title'] = 'Like Request';
        $notificationAr['body'] = auth()->user()->first_name.' '.auth()->user()->last_name. ' '.$request->input('status'). ' you.';
        $notificationAr['click_action'] = 'OPEN_PROFILE';
        $notificationAr['notification_type'] = 'user_like';
        $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . auth()->user()->profile_image),NULL,auth()->user()->profile_image);
        $notificationAr['priority'] = 'hight';

        $firebaseToken['to'] = $member->firebase_token;
        firebasePushNotification($firebaseToken,$notificationAr);
        
        $notificationAr['sender_id'] =  auth()->user()->id;
        $notification = Notification::create($notificationAr);
        // ************************* //
        // Send email To User
        // ************************* //
        $name = $member->first_name.' '.$member->last_name;
        $email = $member->email;
        $email_template = EmailTemplate::where('type','user_liked')->first();
        //$email_template = transformEmailTemplateModel($email_template,$lang);
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $search = array("{{name}}","{{app_name}}");
        $replace = array($name,env('APP_NAME'));
        $content  = str_replace($search,$replace,$content);
        
        $social_links = GeneralSetting::find(1);
        sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

        return response()->json([
            'status' => 1,
            'message' =>  array('message' => ['Request udated successfully!. ']) ,
            'success_data' => NULL
        ],200, ['Content-Type' => 'application/json']);
    }
    //memeber search,
    public function membersSearch(Request $request){

		//$s_data = MemberResource::collection();

    	$db_record = Member::where('is_approved',1)->whereNull('deleted_at')->where( 'id', '!=', auth()->user()->id );

    	$db_record = $db_record->where('gender', '!=', auth()->user()->gender);
    	
    	
        if( $request->has('search') && !empty($request->search))
        {
            $db_record = $db_record->where( function($q) use ($request)
            {
                $q->where(function ($query) use ($request) {
                    $query->where('first_name','like', '%'.$request->search.'%')->orWhere('last_name','like', '%'.$request->search.'%')
                    	->orWhere('email','like', '%'.$request->search.'%');
                });
            });
        }

        $s_data = MemberResource::collection( $db_record->get() );

        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Members Searched']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    //transactions
    public function transactions(Request $request)
    {
        //Transactins
        $m_id = auth()->user()->id;
        $db_record = Payments::select(
                        'payments.*','members_plan.plan_id','event_audiences.event_id'
                        )
                    ->leftJoin('members_plan', function ($join) use ($m_id) {
                        $join->on('payments.members_plan_id', '=', 'members_plan.id')
                        ->where('members_plan.member_id','=', $m_id );
                    })
                    ->leftJoin('event_audiences', function ($join) use ($m_id) {
                        $join->on('payments.event_audiences_d', '=', 'event_audiences.id')
                        ->where('event_audiences.member_id','=', $m_id );
                    });

        $s_data = TransactionResource::collection( $db_record->get() );
        
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Transaction details']),
            'success_data' => array('data' => $s_data)
        ]);
    }
}