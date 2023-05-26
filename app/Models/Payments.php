<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
   protected $fillable = [
        'members_plan_id','member_id','event_audiences_d', 'amoun_paid', 'payment_id','plan_end_date','stripe_status','status'
    ];

      public function nationality()
      {
        return $this->belongsTo('App\Models\Nationality', 'nationality_id');
      }

      public function getPlanName($id='')
      {
         // code...
         $plan = Plan::where(['id' => $id, 'status' => 1])->first();
         if (isset($plan) && !empty($plan)) {
            return $plan->name;
         }else{
            return '---';
         }
         
      }
      public function getEventName($id='')
      {
         // code...
         $event = Event::where(['id' => $id, 'status' => 1])->first();
         if (isset($event) && !empty($event)) {
            return $event->title;
         }else{
            return '---';
         }
         
      }
}
