<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Plan;

class PlanResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
//            'hash_id' => \Hashids::encode($this->id),
            'hash_id' => $this->id,
            'price' => $this->price,
            'period' => $this->period,
            'start_color' => $this->start_color,
            'end_color' => $this->end_color,
            'instant_messages_count' => $this->instant_messages_count,
            'unlimited_messages_sent' => $this->unlimited_messages_sent,
            'unlimited_messages_sent' => $this->unlimited_messages_sent,
            'boosting_profile' => $this->boosting_profile,
            'description' => $this->description,
            'status' => $this->status,
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y')
        ];

    }
}
