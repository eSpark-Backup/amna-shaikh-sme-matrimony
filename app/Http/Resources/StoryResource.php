<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;
class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $member_name = '';
        $member = Member::where(['id' => $this->member_id])->pluck('first_name')->toArray();
        if (!empty($member)) {
            $member_name = implode(', ', $member);
        }
        return  [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "partner_name" => $this->partner_name,
            "member" => $member_name,
            "image_path" => checkImage(asset('storage/stories/' . $this->image),'image-svgrepo-com.svg',$this->image),
            "member_id" => $this->member_id,
            'hash_id' => \Hashids::encode($this->id),
            "status" => $this->status,
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y')
        ];
    }
}
