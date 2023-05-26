<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAudience extends Model
{
   protected $fillable = [
   	'gender','member_id','event_id','male_guests','female_guests','child_guests','total_price','payment_id','amoun_paid','card_number','csv','expire_date','status','guests','guest_charges','total_guests','event_charges','stripe_customer_id'
   ];
   public function get_member(){
   	return $this->belongsTo('App\Models\Member', 'member_id');
   }
   public function get_event(){
   	return $this->belongsTo('App\Models\Event', 'event_id');
   } 
}
