<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Country;
use App\Models\State;
class CityResource extends JsonResource
{
    public function toArray($request)
    {
    	$country_name = '';
    	$state_name = '';
        $country = Country::where(['id' => $this->country_id])->pluck('name')->toArray();
        if (!empty($country)) {
            $country_name = implode(', ', $country);
        }
       $state = State::where(['id' => $this->state_id])->pluck('name')->toArray();

        if (!empty($state)) {
            $state_name = implode(',', $state);
        }
        return  [
            "id" => $this->id,
            "name" => $this->name,
            "country" => $country_name,
            "state" => $state_name,
            "country_id" => $this->country_id,
            "state_id" => $this->state_id,
            'hash_id' => \Hashids::encode($this->id),
            "status" => $this->status,
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y')
        ];
    }
}
