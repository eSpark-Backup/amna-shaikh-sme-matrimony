<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_user_id','user_id','user_id_receiver','first_name','last_name','message','msg_file','ip_address','instant_count','is_video','un_red','is_free_msg'
    ];
    public function chatMessagesUnred()
    {
        return $this->belongsTo('App\Models\UserChat', 'chat_user_id');
    }

    
}
