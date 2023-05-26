<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'system_name','system_title', 'email','phone','address','timezone','facebook_link','youtube_link','instagram_link','meetup_link','whatsapp','terms_condition','privacy_policy','happy_couple_title','happy_couple_description','events_title','events_description','members_title','members_description','about_title','about_description','about_images','slider_title_first','slider_sub_title_first','slider_title_sec','slider_sub_title_sec','slider_title_third','slider_sub_title_third','slider_images'
    ];
}
