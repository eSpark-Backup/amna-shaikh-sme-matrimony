<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;
class TransactionResource extends JsonResource
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
        //Details
        $type = '';
        if ( isset($this->members_plan_id) && !empty($this->members_plan_id ) && isset($this->plan_id) && !empty($this->plan_id)) {

                $type =  'Plan Buy, ('.$this->getPlanName($this->plan_id).')';
            }elseif (isset($this->event_audiences_d) && !empty($this->event_audiences_d)) {
              $type =  'Register Event, ('.$this->getEventName($this->event_id).')';
            }

        return  [
            "id" => $this->id,
            "amount_paid" => $this->amoun_paid,
            "payment_id" => $this->payment_id,
            "members_plan_id" => $this->members_plan_id,
            "event_audiences_id" => $this->event_audiences_d,
            "stripe_status" => $this->stripe_status,
            "member" => $member_name,
            "image_path" => checkImage(asset('storage/stories/' . $this->image),'placeholder.png',$this->image),
            "details" =>$type,
            'hash_id' => \Hashids::encode($this->id),
            "status" => $this->status,
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y')
        ];
    }
}
