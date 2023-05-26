<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Country;
class StateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $country_name = '';
        $country = Country::where(['id' => $this->country_id])->pluck('name')->toArray();
        if (!empty($country)) {
            $country_name = implode(', ', $country);
        }
        return  [
            "id" => $this->id,
            "name" => $this->name,
            "country" => $country_name,
            "country_id" => $this->country_id,
            'hash_id' => \Hashids::encode($this->id),
            "status" => $this->status,
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y')
        ];
    }
}
