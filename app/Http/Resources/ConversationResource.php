<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            "message_id" => $this->id,
            'sender_id' => $this->user_id,
//            'hash_id'       => \Hashids::encode($this->id),
            'hash_id'       => $this->id,
            'chat_id' => $this->chat_user_id,
            'message' => $this->message,
            'msg_file' => $this->msg_file,
            'msg_file_path' => checkImage(asset('storage/members/chat/'. $this->msg_file),'placeholder.png',$this->msg_file),
            'ip_address' => $this->ip_address,
            'instant_count' => $this->instant_count,
            'un_red' => $this->un_red,
            'is_video' => $this->is_video,
            'created_at' => $this->created_at,
            'd_time' =>  \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, h:i A'),
        ];
    }
}
