<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;
use App\Models\ChatMessage;
use App\Models\UserChat;
use App\Models\Plan;

class ChatListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        $user = '';
        if (auth()->user()->id == $this->user_id ) {
            $user = MemberResource::collection(Member::where('id', $this->user_receiver)->get() );
            
        }elseif( auth()->user()->id == $this->user_receiver ){
            $user = MemberResource::collection(Member::where('id', $this->user_id)->get() );
        
        }
        
        $u_chats = UserChat::where(['id' => $this->chat_user_id])->first();
        $count =  $u_chats->totalUnRed();
        //user plan
        //$plan = PlanResource::collection(Plan::where('id', $this->plan_id)->get() );

        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'user_id_receiver' => $this->user_receiver,
            'hash_id'       => \Hashids::encode($this->id),
            'chat_user_id' => $this->chat_user_id,
            'message'    => $this->message,
            'msg_file' => $this->msg_file,
            "msg_file_path" => checkImage(asset('storage/members/chat/' . $this->msg_file),'image-svgrepo-com.svg',$this->msg_file),

            'ip_address' => $this->ip_address,
            'instant_count' => $this->instant_count,
            'un_red' => $this->un_red,
            'un_red_count' => $count,
            'is_video' => $this->is_video,
            'created_at' => $this->created_at,
            'd_time' => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y'),
            'updated_at' => $this->updated_at,   
            'member' => $user,
           
            
        ];
    }
}
