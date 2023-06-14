<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Notification;
use App\Models\Member;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $member = Member::where(['id' => $this->user_id])->get();
        return  [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "chat_id" => $this->chat_id,
            "event_id" => $this->event_id,
            "title" => $this->title,
            "body" => $this->body,
            "click_action" => $this->click_action,
            "notifcation_type" => $this->notification_type,
            "image" => $this->image,
            "priority" => $this->priority,
            "is_readed" => $this->is_readed,
            "image" => checkImage(asset('storage/members/profile-image/' . $this->image),'image-svgrepo-com.svg',$this->image),
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y'),
            'user' => $member

        ];

    }
}
