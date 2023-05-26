<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberInterest extends Model
{
    protected $fillable = [
        'member_id','member_interested_id','block_reason','block_comment','status'
    ];


}
