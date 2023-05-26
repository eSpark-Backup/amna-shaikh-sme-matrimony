<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Event;
use App\Models\EventAudience;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\Member;
use App\Models\Notification;
use App\Models\EmailTemplate;
use App\Models\Payments;
use App\Models\Sibling;

use Carbon\Carbon;
use Auth;
use Hashids;
use File;
use Storage;
use Session;
use Hash;
use DB;
use DataTables;
use Stripe;

class EventAudienceController extends Controller
{
	public function audiences(Request $request, $id)
    {
    	
	    if($request->ajax())
	    {
	        
	        $db_record = EventAudience::where('event_id', $id);
	        //$db_record = EventAudience::orderBy('created_at','DESC');
	       
	        $datatable = Datatables::of($db_record);
	        $datatable = $datatable->addIndexColumn();
	        $datatable = $datatable->editColumn('status', function($row)
	        {
	            $status = '<span class="badge rounded-pill bg-danger">Inactive</span>';
	            if ($row->status == 1)
	            {
	                $status = '<span class="badge rounded-pill bg-success">Active</span>';
	            }
	            return $status;
	        });
	        $datatable = $datatable->editColumn('gender', function($row)
	        {
	        	$genderNew = '1';
	        	$guests = json_decode($row->guests);

	        	foreach ($guests as $K => $V) {

                    if ($V->gender == 'Male') {
                        $genderNew = '1';

                    }elseif ($V->gender == 'Female') {
                        $genderNew = '0';
                    }
                }
	            $gender = '<span class="badge rounded-pill bg-danger">Female</span>';
	            if ($genderNew == 1)
	            {
	                $gender = '<span class="badge rounded-pill bg-success">Male</span>';
	            }
	            return $gender;
	        });
	        $datatable = $datatable->addColumn('name', function($row)
	        {
	            if (isset($row->get_member) && !empty($row->get_member)) {
	                return $row->get_member->first_name.' '.$row->get_member->last_name;
	            }else{
	                return '---';
	            }
	            
	        });

	        $datatable = $datatable->addColumn('action', function($row)
	        {
	            $actions = '<div class="actions table-operate flex">';
	           
	            $actions .= '<a class="edit_btn" href="'.url("admin/events-audience/guests/" . Hashids::encode($row->id)).'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
	            $actions .= '&nbsp;<form method="POST" action="'.url("admin/events-audience/delete-guest/" . Hashids::encode($row->id)).'" accept-charset="UTF-8" style="display:inline">';
	            $actions .= '<input type="hidden" name="_method" value="DELETE">';
	            $actions .= '<input name="_token" type="hidden" value="'.csrf_token().'">';
	            $actions .= '<button class="btn-danger del_btn" onclick="return confirm(\'Are you sure you want to delete this record?\');" title="Delete">';
	            $actions .= '<img src="'. asset('admin-assets/assets/media/icons/files/bin_icon.svg') .'">';
	            $actions .= '</a>';
	            $actions .= '</form>';
	            $actions .= '</div>';

	            return $actions;
	        });
	        $datatable = $datatable->rawColumns(['gender','name','status','action']);
	        $datatable = $datatable->make(true);
	        return $datatable;
	    }
	    return view('admin.events.index',$data);
	}
	public function get_audience($id){
	    
	   $id = Hashids::decode($id)[0];
	  
	   $event = Event::findOrFail($id);
	   $data['event'] = $event;

	   $data['event_date'] = Carbon::createFromTimeStamp(strtotime($event->event_date), "UTC")->tz(session('timezone'))->format('d M, Y');

       $data['id'] = $id;
       return view('admin.events.audience',$data); 
	}
	public function get_guests($id){
	    
	   	$id = Hashids::decode($id)[0];
	  
	   	$guests = EventAudience::findOrFail($id);

	   	$db_record = Event::where(['id' => $guests->event_id])->first();

		if (empty($db_record) ) {
		    
		}
		//echo $db_record->siblings; die();

	   $members = json_decode($guests->guests,true);
	   
	   $data['action'] = 'Edit';
	   $data['members'] = $members;
	   $data['guests'] = $guests;
       $data['id'] = $id;
	   $data['siblings'] = Sibling::whereIn('id', explode(',',$db_record->siblings))->get();
       return view('admin.audiences.form',$data); 

	}
	public function delete_guest($id){
		$id = Hashids::decode($id)[0];
        EventAudience::destroy($id);
        Session::flash('flash_success', 'Event Audience user has been deleted successfully.');
        return redirect()->back();
	}
	public function update_guest(Request $request){
		$input = $request->all();
        $guest = EventAudience::findOrFail($input['id']);
        if ($input['action'] == 'Delete') {
	        $guests = array();
	        if (isset($input['guests']) && !empty($input['guests']) ) {
	            $guests = json_decode($input['guests']);
	        }
	        $male_guests = 0;
	        $female_guests = 0;
	        $total_guests = 0;
	        $total_cost = $guest->event_charges;
	        $adults = $guest->guest_charges;
	        foreach ($guests as $K => $V) {
	            $total_guests++;
	            if ($V->gender == 'Male') {
	                $male_guests++;
	            }elseif ($V->gender == 'Female') {
	                $female_guests++;
	            }
	            //cost
	            $total_cost  += $adults;
	        }

	        $guest->guests = $input['guests'];
	        $guest->male_guests = $male_guests;
	        $guest->female_guests = $female_guests;
	        $guest->total_guests = $total_guests;
	        $guest->total_price = $total_cost;
	        $deleted_guest = json_decode($input['deleted_gust']);
	        $_guest = 'Name: '.ucfirst($deleted_guest->name).'<br>Age: '.$deleted_guest->age.'<br>Relation: '.$deleted_guest->relation.'<br>Gender: '.$deleted_guest->gender;
	        // ************************* //
            // Send mail to user
            // ************************* //
            $member = $guest->get_member;
            $name = $member->first_name.' '.$member->last_name;
            $email = $member->email;
       
            $email_template = EmailTemplate::where('type','event_guest_deleted')->first();
            
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}","{{app_name}}","{{guest}}");
            $replace = array(ucwords($name),env('APP_NAME'),$_guest);

            $content  = str_replace($search,$replace,$content);

            $social_links = GeneralSetting::find(1);

            sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

	    }else{
        	$guest->guests = $input['guests'];
        }
        $guest->save();
        Session::flash('flash_success', 'Guest member has been deleted successfully.');
        $id = Hashids::encode($input['id']); 
        $url = url('/admin/events-audience/guests/'.$id);
        return die(json_encode([
            'status' => 1,
            'res_url' => $url,
            'message' => 'Deleted successfully!'
        ]));
	}

	function request_approved(Request $request){
		$input = $request->all();
		$audience = EventAudience::select('event_audiences.*')->where('event_audiences.id', $input['id'])->with('get_event')->first();
		$event_name = $audience->get_event ? '('.$audience->get_event->title.')' : '';

		

		$member = Member::findOrFail($audience->member_id);
		

		if (isset($audience) && !empty( $member->stripe_customer )) {
			
			
			try {
	            Stripe\Stripe::setApiKey( env('STRIPE_SECRET') );
	            $charge = Stripe\PaymentIntent::create([
		            'amount' => ($audience->total_price*100),
		            'currency' => 'usd',
		            'customer' => $member->stripe_customer,
		            'payment_method' => $member->stripe_payment_method,
		            'off_session' => true,
		            'confirm' => true,
	        	]);
	        
		        $audience->payment_id = $charge->id;
		        $audience->amoun_paid = ($charge->amount/100);
		        $audience->status = 1;
		        $audience->save();
		        //payments
		        $payments = Payments::create([
	                'event_audiences_d' => $audience->id,
	                'member_id' => $audience->member_id,
	                'event_id' => $audience->event_id,
	                'amoun_paid' => ($charge->amount/100),
	                'payment_id' => $charge->id,
	                'stripe_status' => $charge->charges ? $charge->charges->data[0]->outcome->seller_message : $charge->status,
	                'status' => 1
	            ]);
		        //END payments
		        // ************************* //
	            // NOTIFICATION
	            // ************************* //
		        $member = Member::findOrFail($audience->member_id);
		        $notification_msg = 'Your request for event'.$event_name.' is approved now and you have debited '.($charge->amount/100).' amount for the event.';
		        $event_data = 'Event Name: '.$event_name.' & Price: '.($charge->amount/100);

	            $notificationAr['user_id'] = $audience->member_id;
	            $notificationAr['chat_id'] = NULL;
	            $notificationAr['event_id'] = $audience->event_id;;
	            $notificationAr['plan_id'] = NULL;
	            $notificationAr['title'] = 'Event Request Approved';
	            $notificationAr['body'] = $notification_msg;
	            $notificationAr['click_action'] = 'OPEN_PROFILE';
	            $notificationAr['notification_type'] = 'profile_status';
	            $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $member->profile_image),NULL,$member->profile_image);
	            $notificationAr['priority'] = 'hight';

	            $firebaseToken['to'] = $member->firebase_token;
	            firebasePushNotification($firebaseToken,$notificationAr);

	            $notificationAr['image'] =  $member->profile_image;
	            $notificationAr['user_id'] =  $member->id;
	            $notification = Notification::create($notificationAr);

	            // ************************* //
	            // Send mail to user
	            // ************************* //
	            $name = $member->first_name.' '.$member->last_name;

	            $email = $member->email;
	            
	            $email_template = EmailTemplate::where('type','event_request_approved')->first();
	            
	            $subject = $email_template['subject'];
	            $content = $email_template['content'];
	            $search = array("{{name}}","{{app_name}}","{{event_data}}");
	            $replace = array(ucwords($name),env('APP_NAME'),ucwords($event_data));
	            $content  = str_replace($search,$replace,$content);
	            $social_links = GeneralSetting::find(1);

	            sendEmailEventInvoice($email, $subject, $content, '', '', 'en','',$social_links,$member,$audience);


		        Session::flash('flash_success', 'Approved successfully.');
	        	return redirect()->back();
	        } catch (\Stripe\Exception\CardException $e) {
	          // Error code will be authentication_required if authentication is needed
	          echo 'Error code is:' . $e->getError()->code;
	          $payment_intent_id = $e->getError()->payment_intent->id;
	          $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
	        }
		}
	}
}
