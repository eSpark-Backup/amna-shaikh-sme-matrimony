<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    protected $fillable = [
        'first_name','last_name','user_id','user_receiver','message','msg_file','ip_address','instant_count','is_video'
    ];
    public function totalUnRed()
    {
    	$chat_user_id = $this->id;
        $user_id = auth()->user()->id;
        $records = ChatMessage::select('*')
                ->join('user_chats', function ($join) use ($chat_user_id,$user_id) {
                    $join->on('user_chats.id', '=', 'chat_messages.chat_user_id')
                    ->where(['chat_messages.chat_user_id' =>  $chat_user_id,'chat_messages.un_red' =>  0])
                    ->where('chat_messages.user_id','<>',$user_id);
                    
                })
                ->get();
        return count($records);
    }
    public function get_member()
    {
        if ( auth()->user()->id == $this->user_id ) {
            return Member::findOrFail($this->user_receiver);
            
        }elseif( auth()->user()->id == $this->user_receiver ){
            return Member::findOrFail($this->user_id);
        }
    }
}
