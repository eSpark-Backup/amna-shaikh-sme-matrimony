<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberPlan extends Model
{
    public $table = 'members_plan'; 
    protected $fillable = [
        'member_id', 'plan_id', 'total_price','amoun_paid','payment_id','stripe_customer_id', 'status','start_date','end_date'
    ];
}
