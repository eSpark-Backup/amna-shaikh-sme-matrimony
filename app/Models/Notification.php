<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Notification extends Model
{
    protected $fillable = [
        'user_id','sender_id','chat_id','event_id','plan_id','title','body','click_action','image','priority','is_readed','notification_type'
    ];
}
