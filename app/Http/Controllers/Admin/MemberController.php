<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\Religion;
use App\Models\FamilyValue;
use App\Models\FamilyStatus;
use App\Models\MaritalStatus;
use App\Models\Language;
use App\Models\Caste;
use App\Models\Onbehalf;
use App\Exports\MembersExport;


use App\Models\UserImage;
use App\Models\Nationality;
use App\Models\Specialisation;
use App\Models\WorkingWith;
use App\Models\Notification;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\UserChat;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Http\Resources\UserImageResource;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Auth;
use Hashids;
use File;
use Storage;
use Session;
use Hash;
use DB;
use DataTables;

use Str;




class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        if($request->ajax())
        {
            $db_record = Member::orderBy('created_at','DESC');
            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
            $datatable = $datatable->addColumn('plan', function($row)
            {
                if (isset($row->plan) && !empty($row->plan)) {
                    return $row->plan->name;
                }else{
                    return '---';
                }

            });

            $datatable = $datatable->editColumn('name', function($row)
            {
                return $row->first_name.' '.$row->last_name;

            });
            //profile image
            $datatable = $datatable->editColumn('profile_image', function($row)
            {
                return  '<div style="width: 50px; height: auto"><img src="'.checkImage(asset('storage/members/profile-image/' . $row->profile_image),'avatar.png',$row->profile_image,1).'" class="img-responsive" alt="Avatar"></div>';
            });
            //End profile image/storage/members/profile-image/

            $datatable = $datatable->editColumn('status', function($row)
            {
                $status = '';
                if ($row->status == 1)
                {
                    $status = '<span class="badge rounded-pill bg-success">Active</span>';
                }
                if ($row->status == 2)
                {
                    $status = '<span class="badge rounded-pill bg-info">Email is not Verified</span>';
                }
                if ($row->status == 3)
                {
                    $status = '<span class="badge rounded-pill bg-warning">Mobile is not Verified</span>';
                }
                if ($row->status == 0){
                    $status = '<span class="badge rounded-pill bg-danger">Blocked</span>';
                }
                if ($row->status == 5){
                    $status = '<span class="badge rounded-pill bg-danger">Closed</span>';
                }if ($row->status == 4){
                    $status = '<span class="badge rounded-pill bg-info">Submitted for Approval</span>';
                }

                return $status;
            });
            $datatable = $datatable->editColumn('created_at', function($row)
            {
                return Carbon::createFromTimeStamp(strtotime($row->created_at), "UTC")->tz(session('timezone'))->format('d M, Y') ;
            });
            $datatable = $datatable->addColumn('action', function($row)
            {
                $actions = '<div class="actions table-operate flex">';
//                $actions .= '<a class="download_btn" style="border: 1px solid #145be9;" target="_blank" href="'.url("admin/members/" . Hashids::encode($row->id).'/download').'" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a>';
//                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/members/" . Hashids::encode($row->id).'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
//
//                $actions .= '&nbsp;<form method="POST" action="'.url("admin/members/" . Hashids::encode($row->id)).'" accept-charset="UTF-8" style="display:inline">';

                $actions .= '<a class="download_btn" style="border: 1px solid #145be9;" target="_blank" href="'.url("admin/members/" . $row->id.'/download').'" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a>';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/members/" . $row->id.'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';

                $actions .= '&nbsp;<form method="POST" action="'.url("admin/members/" . $row->id).'" accept-charset="UTF-8" style="display:inline">';

                $actions .= '<input type="hidden" name="_method" value="DELETE">';
                $actions .= '<input name="_token" type="hidden" value="'.csrf_token().'">';
                $actions .= '<button class="btn-danger del_btn" onclick="return confirm(\'Are you sure you want to delete this record?\');" title="Delete">';
                $actions .= '<img src="'. asset('admin-assets/assets/media/icons/files/bin_icon.svg') .'">';
                $actions .= '</a>';
                $actions .= '</form>';
                $actions .= '</div>';
                return $actions;
            });
            $datatable = $datatable->addColumn('custom_checkbox', function($row)
            {
                return '<input type="checkbox" name="member_id[]" value="" id="checkItem" class="checkboxes"><span class="text-danger"> </span>';
            });
            $datatable = $datatable->rawColumns(['profile_image','unlimited_messages_sent','is_approved','boosting_profile','status','action','custom_checkbox']);
            $datatable = $datatable->make(true);
            return $datatable;
        }

        $data['country'] =  Country::orderBy('created_at','DESC')->get();

        return view('admin.members.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['member'] = new Member();
       /* $data['plans'] = Plan::where(['status' => 1, 'deleted_at' => NULL])->get();*/
        $data['countries'] = Country::where(['status' => 1])->get();


        $statesAr = array();
        $cityAr = array();
        $states = State::where(['status' => 1])->get();
        foreach ($states as $K => $V) {
            $statesAr[$V->country_id][] =  ['id' => $V->id, 'name' => $V->name];
        }

        $data['states'] = $states;
        $data['states_ar'] =  json_encode($statesAr);


        $cities = City::where(['status' => 1])->get();
        foreach ($cities as $K => $V) {
            $citiesAr[$V->state_id][] =  ['id' => $V->id, 'name' => $V->name];
        }

        $data['cities_ar']  = json_encode($citiesAr);
        $data['cities']  = $cities;

        $data['educations'] = Education::where(['status' => 1])->get();
        $data['occupations'] = Occupation::where(['status' => 1])->get();
        $data['religions'] = Religion::where(['status' => 1])->get();
        $data['familyValues'] = FamilyValue::where(['status' => 1])->get();
        $data['familyStatus'] = FamilyStatus::where(['status' => 1])->get();
        $data['maritalStatus'] = MaritalStatus::where(['status' => 1])->get();
        $data['languages'] = Language::where(['status' => 1])->get();
        $data['castes'] = Caste::where(['status' => 1])->get();
        $data['onbehalf'] = Onbehalf::where(['status' => 1])->get();

        $data['action'] = "Add";
        return view('admin.members.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $befor_status = '';
            $befor_active_status = '';
            $input = $request->all();
            if($input['action'] == 'Add')
            {
                /*$validator = Validator::make($request->all(), [
                    'first_name' => ['required','max:100','string'],
                    'last_name' => ['required','max:100','string'],
                    'email' => ['required','max:100','string',Rule::unique('admins')],
                    'password' => ['required','string','min:6', 'max:30'],
                    'date_of_birth' => ['required','date'],
                    'gender' => ['required','integer'],
                    'on_behalf_id' => ['required','integer'],

                    'profile_image' => 'file|mimes:jpeg,jpg,png,svg|max:'.config('constants.file_size'),

                ]);
                if ($validator->fails())
                {
                    Session::flash('flash_danger', $validator->messages());
                    return redirect()->back()->withInput();
                }*/
                $input['original_password'] = $input['password'];
                $input['password'] = Hash::make($input['password']);

                $model = new Member();
                $flash_message = 'Member has been created successfully.';
            }
            else
            {
                $model = Member::findOrFail($input['id']);
                $pw = '';
                if(empty($model->social_id)){
                    $pw =  " 'password' => ['required','string','min:6', 'max:30'],";
                    $input['original_password'] = $input['password'];
                    $input['password'] = Hash::make($input['password']);
                }
                /*$validator = Validator::make($request->all(), [
                    'first_name' => ['required','max:100','string'],
                    'last_name' => ['required','max:100','string'],
                    'email' => ['required','max:100','string',Rule::unique('admins')],$pw,

                    'date_of_birth' => ['required','date'],
                    'gender' => ['required','integer'],
                    'on_behalf_id' => ['required','integer'],
                    'profile_image' => 'file|mimes:jpeg,jpg,png,svg|max:'.config('constants.file_size'),
                ]);
                if ($validator->fails())
                {
                    Session::flash('flash_danger', $validator->messages());
                    return redirect()->back()->withInput();
                }*/

                $befor_status = $model->is_approved;
                $befor_active_status = $model->status;
                $flash_message = 'Member has been updated successfully.';
            }
            //Member profile image here
            if (!empty($request->files) && $request->hasFile('profile_image'))
            {
                $file = $request->file('profile_image');

                // *********** //
                // Upload File //
                // *********** //

                $target_path = 'public/members/profile-image/';
                //$filename = 'member-'.$file->getClientOriginalName();
                $filename = 'profile_image-' . uniqid() . '.' . $file->getClientOriginalExtension();

                // **************** //
                // Delete Old File
                // **************** //

                if($input['action'] == 'Edit')
                {
                    $old_file = public_path() . '/storage/members/profile-image/' . $model->profile_image;
                    if (file_exists($old_file) && !empty($model->profile_image))
                    {
                        Storage::delete($target_path . '/' . $model->profile_image);
                    }
                }

                $path = $file->storeAs($target_path, $filename);
                $input['profile_image'] = $filename;
            }

            $model->fill($input);
            $model->save();
            //send email and push notification.
            if ( $input['is_approved'] != $befor_status && $input['action'] == 'Edit') {
                $status = 'pending';
                switch ((int)$request->is_approved) {
                    case 1:
                        $status = 'approved';
                        break;
                    case 2:
                        $status = 'blocked';
                        break;
                    case 3:
                        $status = 'rejected';
                        break;

                    default:
                        $status = 'pending';
                        break;
                }

                $notificationAr['user_id'] = $input['id'];
                $notificationAr['chat_id'] = NULL;
                $notificationAr['event_id'] = NULL;
                $notificationAr['plan_id'] = NULL;
                $notificationAr['title'] = 'Profile status changed to '.$status;
                $notificationAr['body'] = 'Your profile status changed to '.$status;
                $notificationAr['click_action'] = 'OPEN_PROFILE';
                $notificationAr['notification_type'] = 'profile_status';
                $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $model->profile_image),NULL,$model->profile_image);
                $notificationAr['priority'] = 'hight';

                $firebaseToken['to'] = $model->firebase_token;
                firebasePushNotification($firebaseToken,$notificationAr);

                $notificationAr['image'] =  $model->profile_image;
                $notificationAr['user_id'] =  $input['id'];
                $notification = Notification::create($notificationAr);

                // ************************* //
                // Send mail to user
                // ************************* //
                $name = $model->first_name.' '.$model->last_name;

                $email = $model->email;
                $link = url('/');

                if ($request->is_approved == 2) {

                    $email_template = EmailTemplate::where('type','profile_blocked')->first();

                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{status}}","{{link}}","{{app_name}}");
                    $replace = array(ucwords($name),$status,$link,env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);

                    sendEmail($email, $subject, $content, '', '', 'en','',$social_links);

                }elseif($request->is_approved == 1) {
                    $email_template = EmailTemplate::where('type','now_verified')->first();

                    $subject = $email_template['subject'];
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{status}}","{{link}}","{{app_name}}");
                    $replace = array(ucwords($name),$status,$link,env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);

                    sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
                }else {
                    $email_template = EmailTemplate::where('type','profile_approval_status')->first();

                    $subject = str_replace("{{status}}",$status,$email_template['subject']);
                    $content = $email_template['content'];
                    $search = array("{{name}}","{{status}}","{{link}}","{{app_name}}");
                    $replace = array(ucwords($name),$status,$link,env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    $social_links = GeneralSetting::find(1);

                    sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
                }
            }

            if ($request->status != $befor_active_status && $input['action'] == 'Edit') {
                $bstatus = 'active';
                switch ((int)$request->status) {
                    case 1:
                        $bstatus = 'active';
                        break;
                    case 0:
                        $bstatus = 'blocked';
                        break;
                    case 5:
                        $bstatus = 'closed';
                        break;
                    default:
                        $bstatus = 'submitted for approval';
                        break;
                }
                $name = $model->first_name.' '.$model->last_name;

                $email = $model->email;
                $link = url('/');
                $email_template = EmailTemplate::where('type','profile_approval_status')->first();

                $subject = str_replace("{{status}}",$bstatus,$email_template['subject']);
                $content = $email_template['content'];
                $search = array("{{name}}","{{status}}","{{link}}","{{app_name}}");
                $replace = array(ucwords($name),$bstatus,$link,env('APP_NAME'));
                $content  = str_replace($search,$replace,$content);
                $social_links = GeneralSetting::find(1);

                sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
            }
            //create new account send welcome mail to user
            if ($input['action'] == 'Add') {

                // ************************* //
                // Send Thankyou email to User
                // ************************* //
                $name = $model->first_name.' '.$model->last_name;

                $email = $model->email;

                $email_template = EmailTemplate::where('type','user_welcome')->first();
                //$email_template = transformEmailTemplateModel($email_template,$lang);
                $subject = $email_template['subject'];
                $content = $email_template['content'];
                $search = array("{{name}}","{{app_name}}");
                $replace = array(ucwords($name),env('APP_NAME'));
                $content  = str_replace($search,$replace,$content);
                $social_links = GeneralSetting::find(1);

                sendEmail($email, $subject, $content, '', '', 'en','',$social_links);
                // ************************* //
                //    Send email to admin
                // ************************* //
                $email_template = EmailTemplate::where('type','new_user_registered')->first();
                $admin_email = $social_links['email'];
                $subject = $email_template['subject'];
                $content = $email_template['content'];
                $name = 'Admin';
                $search = array("{{name}}","{{app_name}}");
                $replace = array(ucwords($name),env('APP_NAME'));
                $content  = str_replace($search,$replace,$content);

                sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);
            }
            $request->session()->flash('flash_success', $flash_message);
            return redirect('admin/members');
        }catch(\Exception $e){
            Session::flash('flash_danger', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

//        $id = Hashids::decode($id)[0];

        //if($id == 1)
        //access_denied();
        $data['action'] = "Edit";
        $data['member'] = Member::findOrFail($id);
        /*$data['plans'] = Plan::where(['status' => 1, 'deleted_at' => NULL])->get();*/
        $data['countries'] = Country::where(['status' => 1])->get();


        $statesAr = array();
        $cityAr = array();
        $states = State::where(['status' => 1])->get();
        foreach ($states as $K => $V) {
            $statesAr[$V->country_id][] =  ['id' => $V->id, 'name' => $V->name];
        }

        $data['states'] = $states;
        $data['states_ar'] =  json_encode($statesAr);


        $cities = City::where(['status' => 1])->get();
        foreach ($cities as $K => $V) {
            $citiesAr[$V->state_id][] =  ['id' => $V->id, 'name' => $V->name];
        }

        $data['cities_ar']  = json_encode($citiesAr);
        $data['cities']  = $cities;

        $data['educations'] = Education::where(['status' => 1])->get();
        $data['occupations'] = Occupation::where(['status' => 1])->get();
        $data['religions'] = Religion::where(['status' => 1])->get();
        $data['familyValues'] = FamilyValue::where(['status' => 1])->get();
        $data['familyStatus'] = FamilyStatus::where(['status' => 1])->get();
        $data['maritalStatus'] = MaritalStatus::where(['status' => 1])->get();
        $data['languages'] = Language::where(['status' => 1])->get();
        $data['castes'] = Caste::where(['status' => 1])->get();
        $data['onbehalf'] = Onbehalf::where(['status' => 1])->get();

        return view('admin.members.form')->with($data);
    }


    public function download($id)
    {

        $id = Hashids::decode($id)[0];

        $member = Member::findOrFail($id);
        $data['userimages'] = $member->user_images;
        $data['member'] = $member;
        $data['occupation'] = (isset($member->occupation) && !empty($member->occupation)) ? $member->occupation->name : '---';
        $data['profile_image'] = checkImage(asset('storage/members/profile-image/'.$member->profile_image),'avatar.png',$member->profile_image,1);
        //$data['profile_image'] = $member->profile_image;
        $data['city'] = (isset($member->city) && !empty($member->city)) ? $member->city->name : '---';
        $data['country'] = (isset($member->country) && !empty($member->country)) ? $member->country->name : '---';
        $data['partner_prefered_country'] = (isset($member->partner_prefered_country_id) && !empty($member->partner_prefered_country_id)) ? $member->partner_prefered_country->name : '---';

        $data['caste'] = (isset($member->caste) && !empty($member->caste)) ? $member->caste->name : '---';
        $data['partner_caste'] = (isset($member->partner_caste_id) && !empty($member->partner_caste_id)) ? $member->partner_caste->name : '---';
        $gender = '---';
        switch ($member->gender) {
            case 0:
                $gender = 'Male';
                break;
            case 1:
                $gender = 'Female';
                break;
            case 2:
                $gender = 'Transgender';
                break;
        }
        $data['gender'] = $gender;
        $data['age'] = (isset($member->date_of_birth) && !empty($member->date_of_birth)) ? Carbon::parse($member->date_of_birth)->diff(Carbon::now())->y : '---';
        $data['partner_age'] =(isset($member->partner_age) && !empty($member->partner_age)) ? $member->partner_age : '---';
        $data['marital_status'] =(isset($member->martial_status) && !empty($member->martial_status)) ? $member->marital_status->name : '---';
        $data['partner_marital_status'] = (isset($member->partner_marital_status) && !empty($member->partner_marital_status)) ? $member->partner_marital_status->name : '---'; ;
        $data['mobile'] =(isset($member->mobile) && !empty($member->mobile)) ? $member->mobile : '---';
        $data['email'] =(isset($member->email) && !empty($member->email)) ? $member->email : '---';
        $data['education'] =(isset($member->education_id) && !empty($member->education_id)) ? $member->education->name : '---';
        $data['partner_education'] =(isset($member->partner_education_id) && !empty($member->partner_education_id)) ? $member->partner_education->name : '---';
        $data['height'] =(isset($member->height) && !empty($member->height)) ? $member->height : '---';
        $data['partner_height'] =(isset($member->partner_height) && !empty($member->partner_height)) ? $member->partner_height : '---';
        $data['family_status'] =(isset($member->family_status_id) && !empty($member->family_status_id)) ? $member->family_status->name : '---';
        $data['partner_family_status'] = '';//(isset($member->partner_prefered_status) && !empty($member->partner_prefered_status)) ? $member->partner_family_status->name : '---';
        $data['kids'] =(isset($member->kids) && !empty($member->kids)) ? $member->kids : '---';
        $data['partner_with_children_acceptable'] =(isset($member->partner_with_children_acceptable) && !empty($member->partner_with_children_acceptable)) ? $member->partner_with_children_acceptable : '---';
        $data['on_behalf'] =(isset($member->on_behalf_id) && !empty($member->on_behalf_id)) ? $member->on_behalf->name : '---';
        $data['specialisation'] =(isset($member->working_with_id) && !empty($member->working_with_id)) ? $member->specialisation->name : '---';
        $data['working'] =(isset($member->working_with_id) && !empty($member->working_with_id)) ? $member->working->name : '---';
        $data['religion'] =(isset($member->religion_id) && !empty($member->religion_id)) ? $member->religion->name : '---';
        $data['partner_religion'] =(isset($member->partner_religion_id) && !empty($member->partner_religion_id)) ? $member->partner_religion->name : '---';

        $data['mother_language'] =(isset($member->mother_language_id) && !empty($member->mother_language_id)) ? $member->mother_language->name : '---';
        $data['partner_mother_language'] =(isset($member->partner_mother_language_id) && !empty($member->partner_mother_language_id)) ? $member->partner_mother_language->name : '---';
        $data['state'] =(isset($member->state_id) && !empty($member->state_id)) ? $member->state->name : '---';
        $data['partner_prefered_state'] =(isset($member->partner_prefered_state_id) && !empty($member->partner_prefered_state_id)) ? $member->partner_prefered_state->name : '---';

        $data['nationality'] =(isset($member->nationality_id) && !empty($member->nationality_id)) ? $member->nationality->name : '---';
        //return view('admin.members.pdf',$data);
        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.members.pdf', $data);
        return $pdf->stream();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Hashids::decode($id)[0];
        Member::destroy($id);
        Session::flash('flash_success', 'Member has been deleted successfully.');
        return redirect('admin/members');
    }
    public function export(Request $request){
        $input = $request->all();


        $db_record = Member::orderBy('created_at','DESC');

        if( $request->country_id != null )
        {
            $db_record = $db_record->where('country_id', $request->country_id );
        }

        if(  $request->is_approved != null )
        {
            $db_record = $db_record->where('is_approved', $request->is_approved  );
        }

        $users = $db_record->get();
        return Excel::download(new MembersExport($users,$request->mobile,$request->email), 'members.xlsx');
    }
    public function viewChatMembers(Request $request,$id=''){
        $data = [];
        if($request->ajax())
        {
            $member = '';
            $sql = "select chat_messages.id, chat_messages.message, chat_messages.msg_file, chat_messages.ip_address, chat_messages.instant_count, chat_messages.un_red, chat_messages.is_video, chat_messages.chat_user_id, chat_messages.created_at, chat_messages.updated_at, user_chats.user_id, user_chats.user_receiver from user_chats inner join chat_messages on user_chats.id = chat_messages.chat_user_id where chat_messages.id in (select MAX(chat_messages.id) AS msg_id from chat_messages group by chat_user_id) and (user_chats.user_id = $id or user_chats.user_receiver = $id) and chat_messages.id not in (select chat_message_id from delete_messages where (user_id = $id ) ORDER BY chat_messages.id DESC)";

            $db_record = DB::select($sql);
            $db_record = array_reverse($db_record);

            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
            $datatable = $datatable->editColumn('created_at', function($row)
            {

                return \Carbon\Carbon::createFromTimeStamp(strtotime($row->created_at), "UTC")->format('Y-m-d h:i:s');

            });
            $datatable = $datatable->addColumn('display_user_name', function($row) use($id)
            {

                if ( $id == $row->user_id ) {

                    $member = Member::findOrFail($row->user_receiver);

                }elseif( $id == $row->user_receiver ){
                    $member = Member::findOrFail($row->user_id);
                }

                return $member->first_name.' '.$member->last_name;
            });

            $datatable = $datatable->addColumn('member_id', function($row) use($id)
            {
                if ( $id == $row->user_id ) {
                    $member = Member::findOrFail($row->user_receiver);

                }elseif( $id == $row->user_receiver ){
                    $member = Member::findOrFail($row->user_id);

                }
                return $member->id;
            });
            $datatable = $datatable->addColumn('hash_id', function($row) use($id)
            {
                if ( $id == $row->user_id ) {
                    $member = Member::findOrFail($row->user_receiver);

                }elseif( $id == $row->user_receiver ){
                    $member = Member::findOrFail($row->user_id);

                }
               $rid = $member->id;
               return  \Hashids::encode($rid);
            });
            $datatable = $datatable->editColumn('message', function($row) use($id)
            {

                if ( isset($row->message) && !empty($row->message) ) {
                   return truncatedStr($row->message,'message');

                }elseif(isset($row->msg_file) && !empty($row->msg_file)){
                   return $row->msg_file;
                }
            });
            $datatable = $datatable->addColumn('profile_image_path', function($row) use($id)
            {
                if ( $id == $row->user_id ) {
                    $member = Member::findOrFail($row->user_receiver);

                }elseif( $id == $row->user_receiver ){
                    $member = Member::findOrFail($row->user_id);

                }
                $profile_image = $member->profile_image;
                $pi =  checkImage(asset('storage/members/profile-image/' . $profile_image),'image-svgrepo-com.svg',$profile_image,1);

                return  '<div style="width: 50px; height: auto"><img src="'.$pi.'" class="img-responsive" alt="Avatar"></div>';
            });
            $datatable = $datatable->addColumn('email', function($row) use($id)
            {
                if ( $id == $row->user_id ) {
                    $member = Member::findOrFail($row->user_receiver);

                }elseif( $id == $row->user_receiver ){
                    $member = Member::findOrFail($row->user_id);

                }
                return $member->email;
            });
            $datatable = $datatable->addColumn('action', function($row)
            {
                $actions = '<div class="actions table-operate flex">';

                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/members/15/view").'" title="View"><img src="'. asset('admin-assets/assets/media/icons/files/16.svg') .'"></a>';


                $actions .= '</div>';
                return $actions;
            });
            return  $datatable->rawColumns([
                'display_user_name','member_id','profile_image_path','email','action'
            ])
            ->make(true);
        }
        $data['user_id'] = $id;
        return view('admin.members.chat_members',$data);
    }
}
