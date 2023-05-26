<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'hash_id'       => \Hashids::encode($this->id),
            'is_private'    => $this->is_private,
            'is_profile'    => $this->is_profile,
            "user_image"    => checkImage(asset('storage/members/profile-image/' . $this->user_image),'placeholder.png',$this->user_image),
        ];
    }
}
