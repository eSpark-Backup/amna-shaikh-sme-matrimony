<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title','location','image','event_video','status','joined_female','joined_male','seats_left','total_seats','short_description','long_description','event_date','type','adults_charges','child_charges','event_charges','country','gallary','siblings','allow_siblings','video_ratio'
    ];
}
