<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Sibling; 

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $type = ($this->type == 1)? 'Upcoming Event':'Past Event';
        $glry = explode(',', $this->gallary);
        $event_photos = array();
        foreach ($glry as $K => $V) {
        	if (!empty($V)) {
        		$event_photos[] = checkImage(asset('storage/events/' . $V),'',$V);
        	}
        }
        if (empty($event_photos)) {
        	$event_photos = NULL;
        }

        $event_video = NULL;
        if (!empty($this->event_video)) {
            $event_video = asset('storage/events/' . $this->event_video);
        }
        $siblingsAr = explode(',', $this->siblings);
        $siblings = Sibling::whereIn('id', $siblingsAr)->get();
        
        return  [
            "id" => $this->id,
            "title" => $this->title,
            'hash_id' => \Hashids::encode($this->id),
            "location" => $this->location,
            "country" => $this->country,
            "joined_female" => $this->joined_female,
            "joined_male" => $this->joined_male,
            "seats_left" => $this->seats_left,
            "total_seats" => $this->total_seats,
            "short_description" => $this->short_description,
            "long_description" => $this->long_description,
            "adults_charges" => $this->adults_charges,
            "child_charges" => $this->child_charges,
            "event_charges" => $this->event_charges,
            "photos" => $event_photos,
            "event_video" => $event_video,
            "video_ratio" => $this->video_ratio,
            "status" => $this->status,
            "siblings" => $siblings,
            "sibling_max_limit" => $this->allow_siblings,
            "type" => $type,
            "event_date" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->event_date), "UTC")->format('d M, Y'),
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y')
        ];
    }
}
