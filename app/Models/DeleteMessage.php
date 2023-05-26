<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteMessage extends Model
{
    protected $fillable = [
        'chat_message_id','chat_user_id','user_id'
    ];
}
