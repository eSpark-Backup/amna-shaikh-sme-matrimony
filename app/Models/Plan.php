<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'period', 'instant_messages_count','description','start_color','end_color','unlimited_messages_sent','boosting_profile', 'status','features'
    ];
}
