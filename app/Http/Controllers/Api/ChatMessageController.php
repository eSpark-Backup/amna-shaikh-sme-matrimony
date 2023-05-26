<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ChatMessage;
use App\Models\DeleteMessage;
use App\Models\UserChat;
use App\Models\Member;
use App\Models\EmailTemplate;
use App\Models\Notification;
use App\Models\GeneralSetting;
use App\Http\Resources\ChatListingResource;
use App\Http\Resources\ConversationResource;
use DB;


class ChatMessageController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       
      /* $db_record =  Member::select('members.id','members.first_name','members.last_name','members.profile_image','chat_messages.message')
                    ->join('user_chats', 'user_chats.user_id', '=', 'members.id')
                    ->join('chat_messages', 'user_chats.id', '=', 'chat_messages.chat_user_id')
                    ->whereIn('chat_messages.id', function($query){
                        $query->selectRaw( "MAX(chat_messages.id) AS msg_id")
                        ->from(with(new ChatMessage)->getTable())
                        ->groupBy('chat_user_id');
                    })
                     ->orWhere(['user_chats.user_id' => auth()->user()->id, 'user_chats.user_receiver' => auth()->user()->id ] )
                    ->get();*/
           $id = auth()->user()->id;
           $sql = "select chat_messages.id, chat_messages.message, chat_messages.msg_file, chat_messages.ip_address, chat_messages.instant_count, chat_messages.un_red, chat_messages.is_video, chat_messages.chat_user_id, chat_messages.created_at, chat_messages.updated_at, user_chats.user_id, user_chats.user_receiver from user_chats inner join chat_messages on user_chats.id = chat_messages.chat_user_id where chat_messages.id in (select MAX(chat_messages.id) AS msg_id from chat_messages group by chat_user_id) and (user_chats.user_id = $id or user_chats.user_receiver = $id) and chat_messages.id not in (select chat_message_id from delete_messages where (user_id = $id ) )";
        $db_record = DB::select($sql);   
        /*$db_record =  UserChat::select('chat_messages.id','chat_messages.message','chat_messages.msg_file','chat_messages.ip_address','chat_messages.instant_count','chat_messages.un_red','chat_messages.is_video','chat_messages.chat_user_id','chat_messages.created_at','chat_messages.updated_at','user_chats.user_id','user_chats.user_receiver')
                    ->join('chat_messages','user_chats.id', '=' ,'chat_messages.chat_user_id')
                    ->whereIn('chat_messages.id', function($query){
                        $query->selectRaw( "MAX(chat_messages.id) AS msg_id")
                        ->from(with(new ChatMessage)->getTable())
                        ->groupBy('chat_user_id');
                    })
                    ->where(['user_chats.user_id' => auth()->user()->id ] )
                    ->orWhere([ 'user_chats.user_receiver' => auth()->user()->id ] )
                    ->groupBy('chat_messages.chat_user_id')
                    ->get();*/




        $s_data = ChatListingResource::collection( $db_record );
        
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Members Chats']),
            'success_data' => array('data' => $s_data )
        ]);
    }
    // send message..
    public function sendMessage(Request $request){
       
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);

        $messages = [
            'user_id_receiver' => 'member id field is required',
        ];
        $validation_rules = array(
            'user_id_receiver' => 'required|integer',
            
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
        
        $member = Member::where('id', $request->input('user_id_receiver') )->first();

        if (!$member) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Member does not exist']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        //users chat
        /*$userCha = UserChat::where(['user_id' => auth()->user()->id ,'user_receiver' => $request->input('user_id_receiver')] )->orWhere(['user_id' => $request->input('user_id_receiver') ,'user_receiver' => auth()->user()->id])->first();*/

        $rid = $request->input('user_id_receiver');

        $userCha = UserChat::where(function ($quer) use ($rid){
                        $quer->where(['user_id' => auth()->user()->id,'user_receiver' => $rid])
                            ->orWhere(function ($que) use ($rid) {
                                $que->where(['user_id' => $rid ,'user_receiver' => auth()->user()->id]);
                            });
                    })->first();


        $user_chat_id = 0;
        if (!$userCha) {
                $userChat = UserChat::create([
                'user_id' => auth()->user()->id,
                'user_receiver' => $request->input('user_id_receiver'),
            ]);
            $user_chat_id = $userChat->id;
        }else{
            $user_chat_id = $userCha->id;
        }

        $image = '';
        if(!empty($request->files) && $request->hasFile('image'))
        {
            // *************** //
            // File Validation //
            // *************** //
            $messages = [
               
                'image.image' => $lang_arr['validation_messages']['file_must_be_image'],
                'image.mimes' => $lang_arr['validation_messages']['allowed_image_jpg_jpeg_png_svg']
            ];
            $validation_rules = array(
                'image' => 'file|image|mimes:jpg,jpeg,png,svg'
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
            $target_path = 'public/members/chat/';
            $file = $request->file('image');
            $image = 'image-' . uniqid() . '.' . $file->getClientOriginalExtension();
            /*$old_file = public_path() . '/storage/members/chat/' . $user->profile_image;
            if (file_exists($old_file) && !empty($user->profile_image))
            {
                Storage::delete($target_path . '/' . $user->profile_image);
            }*/
            $path = $file->storeAs($target_path, $image);
        }
        $chat = ChatMessage::create([
            'user_id' => auth()->user()->id,
            'chat_user_id' => $user_chat_id,
            'user_id_receiver' => $request->input('user_id_receiver'),
            'message' => $request->input('message'),
            'msg_file' => $image,
            'instant_count' => $request->input('instant_count'),
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ]);

        if (!$chat) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Chat Message does not send']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        // ************************* //
        // Send email To User
        // ************************* //
        $name = $member->first_name.' '.$member->last_name;
        $email = $member->email;
        
        $email_template = EmailTemplate::where('type','send_message')->first();
        //$email_template = transformEmailTemplateModel($email_template,$lang);
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $search = array("{{name}}","{{app_name}}");
        $replace = array($name,env('APP_NAME'));
        $content  = str_replace($search,$replace,$content);
        $social_links = GeneralSetting::find(1);
        sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

        // ************************* //
        // firbase notification
        // ************************* //   
        $notificationAr['user_id'] = $request->input('user_id_receiver');
        $notificationAr['chat_id'] = $user_chat_id;
        $notificationAr['event_id'] = NULL;
        $notificationAr['plan_id'] = NULL;
        $notificationAr['title'] = 'New Message';
        $notificationAr['body'] = auth()->user()->first_name.' '.auth()->user()->last_name.' send you a message.';
        $notificationAr['click_action'] = 'OPEN_CHAT';
        $notificationAr['notification_type'] = 'send_message';
        $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . auth()->user()->profile_image),NULL,auth()->user()->profile_image);
        $notificationAr['priority'] = 'hight';

        $firebaseToken['to'] = $member->firebase_token;
        firebasePushNotification($firebaseToken,$notificationAr);
        $notificationAr['image'] =  $member->profile_image;
        $notificationAr['sender_id'] =  auth()->user()->id;
        $notification = Notification::create($notificationAr);

        
        $s_data = ConversationResource::collection(ChatMessage::where('id',$chat->id)->get());
        
        return response()->json([
                'status' => 1,
                'message' => array('message' => ['Message sent successfully! ']),
                'success_data' => $s_data,
            ],200, ['Content-Type' => 'application/json']);

    }
    public function conversation(Request $request){
        //receiver ID
        $rid = $request->id;

        $db_record =  UserChat::select('chat_messages.id','chat_messages.message','chat_messages.msg_file','chat_messages.created_at','chat_messages.un_red','chat_messages.chat_user_id','chat_messages.user_id','chat_messages.instant_count')
                    ->join('chat_messages','user_chats.id', '=' ,'chat_messages.chat_user_id')
                    ->whereNotIn('chat_messages.id', function($query){
                        $query->selectRaw( "chat_message_id")
                        ->from(with(new DeleteMessage)->getTable())
                        ->where(['user_id'=> auth()->user()->id, ]);
                    })
                    ->where(function ($quer) use ($rid){
                        $quer->where(['chat_messages.user_id'=> auth()->user()->id,'chat_messages.user_id_receiver' => $rid])
                            ->orWhere(function ($que) use ($rid) {
                                $que->where(['chat_messages.user_id'=> $rid,'chat_messages.user_id_receiver' => auth()->user()->id ]);
                            });
                    })->orderBy('chat_messages.id', 'ASC')
                    ->get();

        $s_data = ConversationResource::collection( $db_record );

        return response()->json([
            'status' => 1,
            'message' => array('message' => ['conversation']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    //unred status
    public function changeUnreadStatus(Request $request){
    	
    	if ($request->has('id') && !empty( $request->input('id') )) {
    		$message = ChatMessage::where('id', $request->input('id') )->first();
	        if (!$message) {
	            return response()->json([
	                'status' => 0,
	                'message' => array('message' => ['Message does not exist']),
	                'success_data' => NULL
	            ],200, ['Content-Type' => 'application/json']);
	        }
	        $message->update([
		        'un_red' => 1
		    ]);
    	}else{

    		$db_record =  UserChat::select('chat_messages.id','chat_messages.message','chat_messages.msg_file','chat_messages.un_red','chat_messages.chat_user_id','user_chats.user_id','user_chats.user_receiver')
                    ->join('chat_messages','user_chats.id', '=' ,'chat_messages.chat_user_id')
                    ->where( ['chat_messages.chat_user_id' => $request->input('chat_user_id'), 'chat_messages.user_id' => $request->input('user_id_receiver')] )
                    ->update(['un_red' => 1]);
                   
            if (!$db_record) {
	            return response()->json([
	                'status' => 0,
	                'message' => array('message' => [' Messages do not exist']),
	                'success_data' => NULL
	            ],200, ['Content-Type' => 'application/json']);
	        }
    	}
        
	    return response()->json([
            'status' => 1,
            'message' => array('message' => ['Status Changed']),
            'success_data' => NULL
        ]);

    }
    //delete chat 
    public function destroy(Request $request){

        $user_id = auth()->user()->id;
        $chat_id = $request->input('chat_id');
        $receiver = 0;
        $messages = [
            'chat_id.required' => 'chat_id field is required',
        ];
        $validation_rules = array(
            'chat_id' => 'required|integer',
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

        $chat = UserChat::where([ 'id'=>$request->input('chat_id') ] )->first();
      

        if ($chat->user_id == $user_id) {
            $receiver = $chat->user_receiver;
        }else{
            $receiver = $chat->user_id;
        }
        

        $del_msg_both_users = DeleteMessage::where(['user_id' => $receiver,'chat_user_id' => $chat_id])->first();
        
        if ($del_msg_both_users) {
            
            DeleteMessage::where(['chat_user_id' => $chat_id])->delete();
            ChatMessage::where(['chat_user_id' => $chat_id])->delete();
            UserChat::where(['id' => $chat_id])->delete();
        }else{
            // delete message 
            DeleteMessage::where(['chat_user_id' => $chat_id, 'user_id' => $user_id])->delete();
            //get all messages for user chat
            $userMessages = ChatMessage::where(['chat_user_id'=>$request->input('chat_id') ] )->get();
            foreach ($userMessages as $K => $V) {
                $userChat = DeleteMessage::create([
                    'chat_message_id' => $V->id,
                    'chat_user_id' => $V->chat_user_id,
                    'user_id' => $user_id
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'message' => array('message' => ['Chat deleted successfully! ']),
            'success_data' => NULL
        ],200, ['Content-Type' => 'application/json']);

    }
}
