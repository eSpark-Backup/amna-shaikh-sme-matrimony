<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'member_id','title','description','partner_name','image','gallery','status'
    ];

    public function get_member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
