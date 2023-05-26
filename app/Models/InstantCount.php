<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstantCount extends Model
{
    public $table = 'instant_count';
    protected $fillable = [
        'member_id','plan_id','instant_messages_count','is_active','receiver_member'
    ];
}
