<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    public $table = 'feed_back';
    protected $fillable = [
        'member_id','title','description','image','status'
    ];

    public function member()
    {
        return $this->belongsTo('App\Member', 'member_id');
    }
}
