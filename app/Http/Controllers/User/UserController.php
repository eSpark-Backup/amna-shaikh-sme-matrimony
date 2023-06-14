<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Member;
use App\Models\MemberInterest;
use App\Models\EmailTemplate;
use App\Models\Notification;
use App\Models\Plan;
use App\Models\Event;
use App\Models\EventAudience;
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
use App\Models\Payments;
use App\Models\InstantCount;
use App\Models\Sibling;
use App\Models\UserImage;
use App\Models\Nationality;
use App\Models\Specialisation;
use App\Models\WorkingWith;
use App\Models\UserChat;
use App\Models\ChatMessage;
use App\Models\DeleteMessage;
use App\Models\FeedBack;
use App\Models\Story;
use App\Models\GeneralSetting;
use App\Models\MemberPlan;

use App\Http\Resources\MemberResource;
use App\Http\Resources\WebMemberResource;
use App\Http\Resources\ChatListingResource;
use App\Http\Resources\ConversationResource;
use Auth;
use Hashids;
use Session;
use Hash;
use DataTables;
use Storage;
use DB;
use Stripe;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('user.approval.status')->only('interest', 'showInterest', 'interestRequestUpdate', 'sendMessage', 'chatListing', 'memberDetails');
    }

    //members
    public function members(Request $request)
    {

        $data = array();
        if ($request->ajax()) {

            //$interstIds = MemberInterest::where('member_id', auth()->user()->id)->pluck('member_interested_id')->all();
            /*$db_record = Member::select(array('id','first_name','last_name','gender','marital_status_id','on_behalf_id','date_of_birth','country_id','occupation_id','nationality_id','caste_id','height','profile_image','education_id','picture_privacy'))->whereNotIn('id', $interstIds);*/
            $db_record = Member::select(array('id', 'first_name', 'last_name', 'gender', 'marital_status_id', 'on_behalf_id', 'date_of_birth', 'country_id', 'occupation_id', 'nationality_id', 'caste_id', 'height', 'profile_image', 'education_id', 'picture_privacy'));

            $db_record = $db_record->where('is_approved', 1)->where('id', '!=', auth()->user()->id)->whereNull('deleted_at');

            $db_record = $db_record->where('gender', '!=', auth()->user()->gender);

            $db_record = $db_record->orderBy('created_at', 'DESC');

            $datatable = Datatables::of($db_record);
            $datatable = $datatable->editColumn('last_name', function ($row) {
                return  getUserName($row->first_name . ' ' . $row->last_name);
            });

            // $datatable = $datatable->editColumn('education_id', function($row)
            // {
            //     $education = Education::where(['id' => $row->education_id])->first();
            //     return $education ? $education->name : '';
            // });

            return  $datatable->addColumn('customer_html', function ($member) {
                $member['last_name'] = getUserName($member['first_name'] . ' ' . $member['last_name']);

                switch ($member['gender']) {
                    case 0:
                        $member['gender'] = 'Male';
                        break;
                    case 1:
                        $member['gender'] = 'Female';
                        break;
                    case 2:
                        $member['gender'] = 'Transgender';
                        break;
                }
                //                $member['hash_id'] = \Hashids::encode($member['id']);
                $member['hash_id'] = $member['id'];
                $member['date_of_birth'] = \Carbon\Carbon::createFromTimeStamp(strtotime($member['date_of_birth']), "UTC")->format('d M, Y');

                return view('frontend.partials.members_list_row', compact('member'))->render();
            })
                ->rawColumns([
                    'customer_html'
                ])
                ->filter(function ($query) use ($request) {
                    $searchAr = explode(' ', $request->first_name);
                    /*if (count($searchAr) >= 2) {

                    $query->Where('first_name','LIKE', "%$searchAr[0]%")
                            ->orWhere('last_name','LIKE',"%$searchAr[1]%")
                            ->orWhere('email','LIKE',"%$request->first_name%")
                            ->orWhere('id','LIKE',"%$request->first_name%");


                }else{*/

                    if ($request->first_name) {

                        $query->where(function ($q) use ($request) {
                            $q->WhereRaw("concat(first_name, ' ', last_name) LIKE '%" . $request->first_name . "%'");
                            $q->orWhere('email', 'LIKE', "%$request->first_name%");
                            $q->orWhere('id', 'LIKE', "%$request->first_name%");
                        });

                        /*$query->WhereRaw("concat(first_name, ' ', last_name) LIKE '%".$request->first_name."%'")
                            ->orWhere('email','LIKE',"%$request->first_name%")
                            ->orWhere('id','LIKE',"%$request->first_name%");*/
                    }
                    // }
                    if ($request->partner_age) {
                        $query->selectRaw("TIMESTAMPDIFF(YEAR, DATE(date_of_birth), current_date) AS member_age");
                        $query->having('member_age', $request->partner_age);
                    }
                    if ($request->maritial_status_id) {
                        $query->Where('marital_status_id', $request->maritial_status_id);
                    }
                    if ($request->caste_id) {
                        $query->Where('caste_id', $request->caste_id);
                    }
                    if ($request->occupation_id) {
                        $query->Where('occupation_id', $request->occupation_id);
                    }
                    if ($request->height) {
                        $query->Where('height', $request->height);
                    }
                    if ($request->education_id) {
                        $query->Where('education_id', $request->education_id);
                    }
                    if ($request->nationality_id) {
                        // $query->Where('nationality_id', $request->nationality_id);
                        $query->Where('birthday_country_id', $request->nationality_id);
                    }
                    if ($request->country_id) {
                        $query->Where('country_id', $request->country_id);
                    }
                })
                ->make(true);
        }

        $data['educations'] = Education::where(['status' => 1])->get();
        $data['occupations'] = Occupation::where(['status' => 1])->get();
        $data['maritalStatus'] = MaritalStatus::where(['status' => 1])->get();
        $data['castes'] = Caste::where(['status' => 1])->get();
        $data['nationality'] = Nationality::where(['status' => 1])->get();
        $data['countries'] = Country::where(['status' => 1])->get();
        $data['plans'] = Plan::where(['status' => 1])->orderBy('id', 'desc')->get();
        return view('frontend.members')->with($data);
    }
    //member details
    public function memberDetails($id)
    {

        //$id = Hashids::decode($id)[0]; die();
        $member = Member::findOrFail($id);


        //$memb = $member->toArray();


        /*$memb['profile_image'] = checkImage(asset('storage/members/profile-image/' . $member->profile_image),'',$member->profile_image,1);
        $memb['date_of_birth'] = \Carbon\Carbon::createFromTimeStamp(strtotime($member->date_of_birth), "UTC")->format('d M, Y');*/

        $data['user_images'] = UserImage::where('member_id', $id)->get();
        $data['member'] = $member;
        return view('frontend.member_details')->with($data);
    }
    //send interest request
    public function interestRequest(Request $request)
    {


        $messages = [
            'member_interested_id' => 'interested member id field is required',
            'status' => 'status field is required',
        ];
        $validation_rules = array(
            'member_interested_id' => 'required|integer',
            'status' => 'required|integer'
        );
        if (auth()->user()->is_approved != 1 && auth()->user()->status == 4) {
            return die(json_encode([
                'status' => 0,
                'title' => "Account is under admin approval.",
                'message' => "Your account is under admin approval. You'll not be able to perform any actions until your profile is approved. Thanks for your patience.",
                'success_data' => NULL
            ]));
        } elseif (auth()->user()->is_approved != 1) {
            return die(json_encode([
                'status' => 0,
                'title' => "Account verification is required.",
                'message' => "Your account verification is required. Please complete your profile and submit it for admin approval. After your profile is approved you ll receive a verified user badge to continue your search.",
                'success_data' => NULL
            ]));
        }

        $request->validate($validation_rules, $messages);

        $member = Member::where('id', $request->input('member_interested_id'))->first();

        if (!$member) {
            return response()->json([
                'status' => 0,
                'message' => 'Member does not exist',
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }

        $interestMember = MemberInterest::where(['member_id' => auth()->user()->id, 'member_interested_id' => $request->input('member_interested_id')])->first();

        if ($interestMember) {
            if ($request->input('status') == 3) {
                return die(json_encode([
                    'status' => 0,
                    'message' => 'This member has been sent to ignore list already',
                    'title' => 'Already ignored!',
                ]));
            } else {
                return die(json_encode([
                    'status' => 0,
                    'message' => 'Request has been already sent!',
                    'title' => 'Already Sent',
                ]));
            }
        }

        if ($request->checkLikeLimitCondition == 1) {
            $interestMemberCount = MemberInterest::where('member_id', auth()->user()->id)->count();

            if ($interestMemberCount > 2) {
                return die(json_encode([
                    'status' => 5,
                    'message' => 'You can send message',
                    'title' => 'Already ignored!',
                ]));
            }
        }

        //Check Plan and Show Plan Popup
        $loginMember = Member::where('id', auth()->user()->id)->first();

        if ($loginMember->total_action_pending == 0) {
            //update Pending action
            $updateMemberData = Member::where('id', auth()->user()->id)->first();
            $updateMemberData->total_action_pending = 15;
            $updateMemberData->save();
        }

        $active_plan = MemberPlan::where('member_id', auth()->user()->id)->whereDate('end_date', '>=', date('Y-m-d'))->first();

        if (!$active_plan) {
            //checkLikeCount
            // $countLikeDislike = MemberInterest::where(['member_id' => auth()->user()->id])->count();

            if ($loginMember && $loginMember->total_action_pending <= 0) {

                return die(json_encode([
                    'status' => 3,
                    'req_message' => 'Update your plan',
                    'message' => 'Update your plan.'
                ]));
                // return response()->json([
                //     'status' => 3,
                //     'message' => array('message' => 'Update your plan'),
                //     'success_data' => NULL,
                // ],200, ['Content-Type' => 'application/json']);
            }
        }

        //End Check Plan and Show Plan Popup


        // check already other send request
        $cu_status = 2;

        if ($request->status == 3) {
            $cu_status = 3;
        }
        $s_data = NULL;
        $s_data1 = NULL;
        $otherMemberReq = MemberInterest::where(['member_id' => $request->input('member_interested_id'), 'member_interested_id' => auth()->user()->id])->first();
        if (!empty($otherMemberReq)) {
            $otherMemberReq->update([
                'status' => 1
            ]);
            $cu_status = 1;
            $id = auth()->user()->id;
            $member_interested_id = $request->input('member_interested_id');
            $db_record = Member::select(
                'members.*',
                'member_interests.status as interest'
            )
                ->join('member_interests', function ($join) use ($id, $member_interested_id) {
                    $join->on('member_interests.member_id', '=', 'members.id')
                        ->where('member_interests.member_interested_id', '=', $id)
                        ->where('member_interests.member_id', '=', $member_interested_id);
                });
            $db_record = $db_record->orderBy('member_interests.created_at', 'DESC')->get();
            $s_data =  MemberResource::collection($db_record);
        }
        // END check already other send request

        //Update Member Pending Action
        $loginMember->total_action_pending = $loginMember->total_action_pending - 1;
        $loginMember->save();
        //Update Member Pending Action end

        $memberInterest = MemberInterest::create([
            'member_id' => auth()->user()->id,
            'member_interested_id' => $request->input('member_interested_id'),
            'status' => $cu_status,
        ]);
        if ($memberInterest) {
            $notificationAr['user_id'] = Auth()->user()->id; //$request->input('member_interested_id');
            $notificationAr['chat_id'] = NULL;
            $notificationAr['event_id'] = NULL;
            $notificationAr['plan_id'] = NULL;
            $notificationAr['title'] = 'Like Request';
            $notificationAr['body'] = $member->first_name . ' ' . $member->last_name . ' liked you.';
            $notificationAr['click_action'] = 'OPEN_PROFILE';
            $notificationAr['notification_type'] = 'user_like';
            $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $member->profile_image), NULL, $member->profile_image);
            $notificationAr['priority'] = 'hight';

            $firebaseToken['to'] = $member->firebase_token;
            firebasePushNotification($firebaseToken, $notificationAr);
            $notificationAr['image'] =  $member->profile_image;
            $notificationAr['sender_id'] =  auth()->user()->id;
            $notification = Notification::create($notificationAr);
            // ************************* //
            // Send email To User
            // ************************* //
            $name = $member->first_name . ' ' . $member->last_name;
            $email = $member->email;
            $email_template = EmailTemplate::where('type', 'user_liked')->first();
            //$email_template = transformEmailTemplateModel($email_template,$lang);
            $subject = getUserName($member->first_name . ' ' . $member->last_name) . ' ' . $email_template['subject'];
            $user_profile = url('/user/members/' . $member->id);
            $content = $email_template['content'];
            $search = array("{{name}}", "{{profile_link}}", "{{app_name}}");
            $replace = array($name, $user_profile, env('APP_NAME'));
            $content  = str_replace($search, $replace, $content);

            $social_links = GeneralSetting::find(1);

            sendEmail($email, $subject, $content, '', '', 'en', '', $social_links);

            if (isset($s_data) && !empty($s_data)) {
                //login memeber
                $db_record1 = Member::select(
                    'members.*',
                    'member_interests.status as interest'
                )
                    ->join('member_interests', function ($join) use ($id, $member_interested_id) {
                        $join->on('member_interests.member_id', '=', 'members.id')
                            ->where('member_interests.member_id', '=', $id)
                            ->where('member_interests.member_interested_id', '=', $member_interested_id);
                    });
                $db_record1 = $db_record1->orderBy('member_interests.created_at', 'DESC')->get();
                $s_data1 =  MemberResource::collection($db_record1);
            }
            $req_message = '';

            $likes_count = 1;

            if (Session::has('likes')) {
                $likes_count = Session::get('likes');
                $likes_count++;
                Session::put('likes', $likes_count);
                if ($likes_count == 15) {

                    Session::forget('likes');
                }
            } else {
                $likes_count = 1;
                Session::put('likes', $likes_count);
            }
            Session::save();

            if ($likes_count == 15) {
                $req_message = "Here you can send the message directly. Click here";
            }

            $req_message = 'User has been liked';

            return die(json_encode([
                'status' => 1,
                'req_message' => $req_message,
                'message' => 'Liked request has been send successfully.'
            ]));
        } else {
            return response()->json([
                'status' => 0,
                'message' => array('message' => 'Oops something went wrong. Unable to send liked request'),
                'success_data' => NULL,
            ], 200, ['Content-Type' => 'application/json']);
        }
    }

    public function reportUser(Request $request)
    {


        $messages = [
            'memberId' => 'member id field is required',
            'reasonList' => 'reason field is required',
        ];
        $validation_rules = array(
            'memberId' => 'required',
            'reasonList' => 'required'
        );
        if (auth()->user()->is_approved != 1 && auth()->user()->status != 1) {

            return die(json_encode([
                'status' => 0,
                'message' => "Your account verification is required. Please complete your profile and submit it for admin approval. After your profile is approved you ll receive a verified user badge to continue your search.",
                'success_data' => NULL
            ]));
        }
        $request->validate($validation_rules, $messages);
        $reason = str_replace("_", " ", $request->input('reasonList'));
        $other_comment = $request->input('comment') ? 'Other Comment:- ' . $request->input('comment') : '';
        $member = Member::where('id', $request->input('memberId'))->first();

        if (!$member) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Member does not exist']),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
        $interestMember = MemberInterest::where(['member_id' => auth()->user()->id, 'member_interested_id' => $request->input('memberId'), 'status' =>  4])->first();

        if ($interestMember) {
            // return response()->json([
            //     'status' => 0,
            //     'message' => array('message' => ['Request has been already send']),
            //     'success_data' => NULL,
            // ],200, ['Content-Type' => 'application/json']);

            return die(json_encode([
                'status' => 0,
                'title' => 'Already Reported',
                'req_message' => 'Report Request has been already sent',
                'message' => 'Request has been already sent.'
            ]));
        }
        // check already other send request
        $s_data = NULL;
        $s_data1 = NULL;
        /*$otherMemberReq = MemberInterest::where(['member_id' => $request->input('memberId')  , 'member_interested_id' => auth()->user()->id ] )->first();

        if (!empty($otherMemberReq)) {
            $otherMemberReq->update([
                'status' => 1
            ]);
            $id = auth()->user()->id;
            $member_interested_id = $request->input('memberId');
            $db_record = Member::select(
                            'members.*',
                            'member_interests.status as interest')
                        ->join('member_interests', function ($join) use ($id,$member_interested_id) {
                            $join->on('member_interests.member_id', '=', 'members.id')
                            ->where('member_interests.member_interested_id','=', $id )
                            ->where('member_interests.member_id','=', $member_interested_id );
                        });
            $db_record = $db_record->orderBy('member_interests.created_at','DESC')->get();
            $s_data =  MemberResource::collection( $db_record );
        }*/
        // END check already other send request

        $memberInterest = MemberInterest::create([
            'member_id' => auth()->user()->id,
            'member_interested_id' => $request->input('memberId'),
            'status' => 4,
            'block_reason' => $request->input('reasonList') ?? '',
            'block_comment' => $request->input('comment') ?? '',
        ]);

        if ($memberInterest) {
            // ************************* //
            // Send email To Admin
            // ************************* //
            $social_links = GeneralSetting::find(1);
            $model = auth()->user();
            $name = $model->first_name . ' ' . $model->last_name;
            $blocked_user = $member->first_name . ' ' . $member->last_name;
            $email_template = EmailTemplate::where('type', 'user_blocked')->first();
            $admin_email = $social_links['email'];
            $subject = $email_template['subject'];
            $content = $email_template['content'];
            $admin = 'Admin';
            $search = array("{{name}}", "{{user}}", "{{blocked_user}}", "{{reason}}", "{{other_comment}}", "{{app_name}}");
            $replace = array(ucwords($admin), ucwords($name), ucwords($blocked_user), ucwords($reason), ucwords($other_comment), env('APP_NAME'));
            $content  = str_replace($search, $replace, $content);
            sendEmail($admin_email, $subject, $content, '', '', 'en', '', $social_links);

            if (isset($s_data) && !empty($s_data)) {
                //login memeber
                $db_record1 = Member::select(
                    'members.*',
                    'member_interests.status as interest'
                )
                    ->join('member_interests', function ($join) use ($id, $member_interested_id) {
                        $join->on('member_interests.member_id', '=', 'members.id')
                            ->where('member_interests.member_id', '=', $id)
                            ->where('member_interests.member_interested_id', '=', $member_interested_id);
                    });
                $db_record1 = $db_record1->orderBy('member_interests.created_at', 'DESC')->get();
                $s_data1 =  MemberResource::collection($db_record1);
            }
            $req_message = ucwords($reason) . ' request has been send successfully';

            $likes_count = 1;

            if (Session::has('likes')) {
                $likes_count = Session::get('likes');
                $likes_count++;
                Session::put('likes', $likes_count);
                if ($likes_count == 2) {
                    Session::forget('likes');
                }
            } else {
                $likes_count = 1;
                Session::put('likes', $likes_count);
            }
            Session::save();

            if ($likes_count == 2) {
                $req_message = ucwords($reason) . " request has been sent successfully";
            }

            return die(json_encode([
                'status' => 1,
                'req_message' => $req_message,
                'message' => ucwords($reason) . ' request has been send successfully.'
            ]));
        } else {
            return die(json_encode([
                'status' => 0,
                'message' => 'Oops something went wrong. Unable to send request',
            ]));
        }
    }
    public function interest(Request $request)
    {

        return view('frontend.user.interest');
    }
    public function showInterest(Request $request)
    {

        if ($request->ajax()) {
            $id = auth()->user()->id;
            //
            if ($request->has('request_for') &&  $request->input('request_for') == 1) {
                $db_record = Member::select(
                    'members.*',
                    'member_interests.status as interest',
                    'member_interests.member_interested_id'
                )
                    ->join('member_interests', function ($join) use ($id) {
                        $join->on('member_interests.member_id', '=', 'members.id')
                            ->where('member_interests.member_interested_id', '=', $id);
                    });
            } else {
                $db_record = Member::select(
                    'members.*',
                    'member_interests.status as interest',
                    'member_interests.member_interested_id'
                )
                    ->join('member_interests', function ($join) use ($id) {
                        $join->on('member_interests.member_interested_id', '=', 'members.id')
                            ->where('member_interests.member_id', '=', $id);
                    });
            }



            if ($request->has('status') &&  !empty($request->input('status'))) {
                $db_record = $db_record->where('member_interests.status', $request->input('status'));
            }
            $db_record = $db_record->orderBy('member_interests.created_at', 'DESC')->get();
            // dd($db_record[0]->occupation->name);
            $s_data =  MemberResource::collection($db_record);

            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Members details']),
                'success_data' => array('data' => $s_data)
            ]);
        }

        return view('frontend.user.interest');
    }
    // accept request OR reject
    public function interestRequestUpdate(Request $request)
    {

        $messages = [
            'member_id' => 'member id field is required',
            'status' => 'status field is required',
        ];
        $validation_rules = array(
            'member_id' => 'required|integer',
            'status' => 'required|integer'
        );

        $request->validate($validation_rules, $messages);

        $memberRequest = MemberInterest::where(['member_id' =>  $request->input('member_id'), 'member_interested_id' => auth()->user()->id])->first();
        if (!$memberRequest) {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Request does not found']),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
        $memberRequest->update([
            'status' => $request->input('status')
        ]);
        return response()->json([
            'status' => 1,
            'message' =>  array('message' => ['Request udated successfully!. ']),
            'success_data' => NULL
        ], 200, ['Content-Type' => 'application/json']);
    }
    public function editProfile()
    {
        $data['user'] = $user = Auth::user();
        $data['action'] = "Edit";

        $data['plans'] = Plan::where(['status' => 1, 'deleted_at' => NULL])->get();
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

        $data['created_at'] = \Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at), "UTC")->format('d M, Y');
        $data['user_images'] = UserImage::where('member_id', auth()->user()->id)->get();
        if ($data['user']->is_approved != 1 && $data['user']->status == 4) {
            Session::flash('flash_danger', 'Your account is not approved yet, please wait for approval.');
        } elseif ($data['user']->is_approved != 1) {
            Session::flash('flash_danger', 'Please fill in the basic information and upload your image to get the admin approval, otherwise you will not be able to perform any action on this website. Thank you!');
        }
        return view('frontend.user.edit_profile')->with($data);
    }

    public function picture_privacy()
    {
        $data['user'] = $user = Auth::user();
        $data['action'] = "Edit";
        $data['created_at'] = \Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at), "UTC")->format('d M, Y');
        $data['user_images'] = UserImage::where('member_id', auth()->user()->id)->get();

        if ($data['user']->is_approved != 1 && $data['user']->status == 4) {
            Session::flash('flash_danger', 'Your account is not approved yet, please wait for approval.');
        }
        return view('frontend.user.profile_privacy')->with($data);
    }
    public function profile(Request $request)
    {

        $data['member'] = Member::findOrFail(auth()->user()->id);

        $data['user_images'] = UserImage::where('member_id', auth()->user()->id)->get();

        return view('frontend.user.view_profile')->with($data);
    }
    public function profileUpdate(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:100', 'string'],
            'last_name' => ['required', 'max:100', 'string'],
            //'email' => ['required','max:100','string',Rule::unique('members')],

            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'integer'],
            'marital_status_id' => ['required', 'integer'],
            'height' => ['required'],
            'on_behalf_id' => ['required', 'integer'],
            'religion_id' => ['required', 'integer'],
            'caste_id' => ['required', 'integer'],
            'education_id' => ['required', 'integer'],
            'occupation_id' => ['required', 'integer'],
            'country_id' => ['required', 'integer'],
            'state_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'about' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }

        if (!isset(auth()->user()->social_id) || empty(auth()->user()->social_id)) {
            $input['original_password'] = $input['password'];
            $input['password'] = Hash::make($input['password']);
        }

        $model = Member::findOrFail($input['id']);

        $flash_message = 'Member has been updated successfully.';
        $model->fill($input);
        $model->save();

        $user = Member::findOrFail($input['id']);
        session(['user' => $user]);
        $request->session()->flash('flash_success', $flash_message);
        return redirect('user/profile');
    }

    public function privacyUpdate(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'picture_privacy' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }

        $model = Member::findOrFail($input['id']);

        $flash_message = 'Privacy has been updated successfully.';
        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);
        return redirect('user/profile');
    }
    //submit for approval
    public function profileApproval(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:100', 'string'],
            'last_name' => ['required', 'max:100', 'string'],
            //'email' => ['required','max:100','string',Rule::unique('members')],
            'gender' => ['required', 'integer'],
            'marital_status_id' => ['required', 'integer'],
            'height' => ['required'],
            'on_behalf_id' => ['required', 'integer'],
            'religion_id' => ['required', 'integer'],
            'caste_id' => ['required', 'integer'],
            'education_id' => ['required', 'integer'],
            'occupation_id' => ['required', 'integer'],
            'country_id' => ['required', 'integer'],
            'state_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'about' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }

        if (!isset(auth()->user()->social_id) || empty(auth()->user()->social_id)) {
            $input['original_password'] = $input['password'];
            $input['password'] = Hash::make($input['password']);
        }


        $input['status'] = 4; //send for approval

        $model = Member::findOrFail($input['id']);
        if (!isset($model->profile_image) && empty($model->profile_image)) {
            Session::flash('flash_danger', 'Profile picture is required!');
            return redirect()->back()->withInput();
        }

        $flash_message = 'Congratulations!! You have successfully submitted your account for admin approval, you will be now notified by email once its approved. For any urgent inquires please contact us at info@smematrimony.com';
        $model->fill($input);
        $model->save();

        $model = auth()->user();
        $name = $model->first_name . ' ' . $model->last_name;
        $social_links = GeneralSetting::find(1);

        // ************************* //
        //    Send email to admin
        // ************************* //
        $email_template = EmailTemplate::where('type', 'submitted_profile_approval')->first();
        $admin_email = $social_links['email'];
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $admin = 'Admin';
        $search = array("{{name}}", "{{user}}", "{{app_name}}");
        $replace = array(ucwords($admin), ucwords($name), env('APP_NAME'));
        $content  = str_replace($search, $replace, $content);
        sendEmail($admin_email, $subject, $content, '', '', 'en', '', $social_links);

        // ************************* //
        // Send email To User
        // ************************* //
        $name = $name;
        $email = $model->email;
        $email_template = EmailTemplate::where('type', 'user_send_profile_for_approval')->first();
        //$email_template = transformEmailTemplateModel($email_template,$lang);
        $subject = $email_template['subject'];

        $content = $email_template['content'];
        $search = array("{{name}}", "{{app_name}}");
        $replace = array($name, env('APP_NAME'));
        $content  = str_replace($search, $replace, $content);
        $social_links = GeneralSetting::find(1);
        sendEmail($email, $subject, $content, '', '', 'en', '', $social_links);

        // $request->session()->flash('flash_success', $flash_message);
        Session::flash('flash_success', $flash_message);
        return redirect('user/profile');
    }

    public function change_photo(Request $request)
    {
        try {

            $user = Member::findOrFail(auth()->user()->id);

            // Delete previous avatar
            if ($user->profile_image) {
                Storage::delete($user->profile_image);

                $old_file = public_path() . '/storage/members/profile-image/' . $user->profile_image;

                if (file_exists($old_file) && !empty($user->profile_image)) {
                    $target_path = '/storage/members/profile-image';
                    Storage::delete($target_path . '/' . $user->profile_image);
                }
            }

            $image = base64_decode($request->input('file'));
            $filename = 'profile_image-' . uniqid() . '.png';
            $path = 'members/profile-image/' . $filename;


            // \File::put(storage_path(). '/' . $imageName, base64_decode($image));
            if (Storage::disk('public')->put($path, $image, 'public')) {

                $user->profile_image = $filename;
                $user->save();

                //$_url = asset( Storage::url($path) );

                $_url = checkImage(asset('storage/members/profile-image/' . $filename), 'avatar.png', $filename, 1);
                $user = Member::findOrFail(auth()->user()->id);
                session(['user' => $user]);

                return [
                    'status' => 1,
                    'file_url' => $_url
                ];
            } else {
                return [
                    'status' => 2,
                    'file_url' => 'not saved here'
                ];
            }
            //$patht = $image->storeAs($path, $filename);


        } catch (\Exception $e) {
            return [
                'status' => 2,
                'msg' => "Upload was not successful. Please try again."
            ];
        }

        //return response()->json( $avatar->upload($request, $user) );
    }
    public function add_photo(Request $request)
    {
        try {
            $model = new UserImage();
            $member_id = auth()->user()->id;

            $image = base64_decode($request->input('file'));
            $filename = 'user_image-' . uniqid() . '.png';
            $path = 'members/profile-image/' . $filename;

            if (Storage::disk('public')->put($path, $image, 'public')) {

                $model->user_image = $filename;
                $model->member_id = $member_id;

                $model->save();

                //$_url = asset( Storage::url($path) );

                $_url = checkImage(asset('storage/members/profile-image/' . $filename), 'avatar.png', $filename, 1);

                return [
                    'status' => 1,
                    'file_url' => $_url
                ];
            } else {
                return [
                    'status' => 2,
                    'file_url' => 'not saved here'
                ];
            }
            //$patht = $image->storeAs($path, $filename);


        } catch (\Exception $e) {
            return [
                'status' => 2,
                'msg' => "Upload was not successful. Please try again."
            ];
        }

        //return response()->json( $avatar->upload($request, $user) );
    }
    public function imageAction(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'image_action' => ['required', 'integer'],
            'id' => ['required', 'integer']

        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }

        $member_id = auth()->user()->id;
        $model = UserImage::findOrFail($input['id']);

        switch ($input['image_action']) {
            case 1:
                $model->is_private = 1;
                $model->save();
                break;
            case 2:
                $member = Member::findOrFail(auth()->user()->id);
                $member->profile_image = $model->user_image;
                $member->save();

                $model->is_profile = 1;
                $model->save();

                break;
            case 3:
                $img = $model->user_image;

                if (UserImage::where(['id' => $input['id'], 'is_profile' => 0])->delete()) {

                    $target_path = 'members/profile-image/' . $img;
                    $deleted = Storage::disk('public')->delete($target_path);
                } else {
                    $request->session()->flash('flash_danger', 'Profile image can not be deleted');
                    return redirect('user/edit-profile');
                }
                //UserImage::destroy($input['id']);

                break;

            default:

                break;
        }
        $request->session()->flash('flash_success', 'Action perform successful');
        return redirect('user/edit-profile');
    }
    //chat listing..
    public function chatListing(Request $request)
    {
        $id = auth()->user()->id;
        $active_plan = MemberPlan::where('member_id', $id)->first();
        //$s_data = ChatListingResource::collection( $db_record );

        //$data['users'] = json_decode( json_encode($s_data) );
        //new code for datatable..
        if ($request->ajax()) {
            $member = '';
            $sql = "select chat_messages.id, chat_messages.message, chat_messages.msg_file, chat_messages.ip_address, chat_messages.instant_count, chat_messages.un_red, chat_messages.is_video, chat_messages.chat_user_id, chat_messages.created_at, chat_messages.updated_at, user_chats.user_id, user_chats.user_receiver from user_chats inner join chat_messages on user_chats.id = chat_messages.chat_user_id where chat_messages.id in (select MAX(chat_messages.id) AS msg_id from chat_messages group by chat_user_id) and (user_chats.user_id = $id or user_chats.user_receiver = $id) and chat_messages.id not in (select chat_message_id from delete_messages where (user_id = $id ) ORDER BY chat_messages.id DESC)";

            $db_record = DB::select($sql);
            $db_record = array_reverse($db_record);

            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
            $datatable = $datatable->editColumn('created_at', function ($row) {

                return \Carbon\Carbon::createFromTimeStamp(strtotime($row->created_at), "UTC")->format('Y-m-d h:i:s');
            });
            $datatable = $datatable->addColumn('display_user_name', function ($row) {
                if (auth()->user()->id == $row->user_id) {
                    $member = Member::findOrFail($row->user_receiver);
                } elseif (auth()->user()->id == $row->user_receiver) {
                    $member = Member::findOrFail($row->user_id);
                }

                return Str::title($member->first_name . ' ' . substr($member->last_name, 0, 1));
            });

            $datatable = $datatable->addColumn('oneHavePlan', function ($row) {
                $active_plan = MemberPlan::where('member_id', auth()->user()->id)->first();

                if (auth()->user()->id == $row->user_id) {
                    $otherUserId = $row->user_receiver;
                } elseif (auth()->user()->id == $row->user_receiver) {
                    $otherUserId = $row->user_id;
                }

                $current_date = date('Y-m-d');
                $oneHavePlan = 0;

                if (isset($active_plan) && !empty($active_plan) && $active_plan->end_date >= $current_date) {
                    $oneHavePlan = 1;
                }/*else {
                    $chatUserPlan =MemberPlan::where('member_id',$otherUserId)->first();

                    if (isset($chatUserPlan) && !empty($chatUserPlan) && $chatUserPlan->end_date >= $current_date){
                        $oneHavePlan = 1;
                    }
                }*/

                if (auth()->user()->id == $row->user_id) {
                    $member = Member::findOrFail($row->user_receiver);
                } elseif (auth()->user()->id == $row->user_receiver) {
                    $member = Member::findOrFail($row->user_id);
                }

                return $oneHavePlan;
            });


            $datatable = $datatable->addColumn('member_id', function ($row) {
                if (auth()->user()->id == $row->user_id) {
                    $member = Member::findOrFail($row->user_receiver);
                } elseif (auth()->user()->id == $row->user_receiver) {
                    $member = Member::findOrFail($row->user_id);
                }
                return $member->id;
            });
            $datatable = $datatable->addColumn('hash_id', function ($row) {
                if (auth()->user()->id == $row->user_id) {
                    $member = Member::findOrFail($row->user_receiver);
                } elseif (auth()->user()->id == $row->user_receiver) {
                    $member = Member::findOrFail($row->user_id);
                }
                $id = $member->id;
                //               return  \Hashids::encode($id);
                return  $id;
            });
            $datatable = $datatable->editColumn('message', function ($row) use ($active_plan) {
                $current_date = date('Y-m-d');
                if (isset($active_plan) && !empty($active_plan) && $active_plan->end_date >= $current_date) {
                    if (isset($row->message) && !empty($row->message)) {
                        return truncatedStr($row->message, 'message');
                    } elseif (isset($row->msg_file) && !empty($row->msg_file)) {
                        return $row->msg_file;
                    }
                } else {
                    return '...';
                }
            });
            $datatable = $datatable->addColumn('profile_image_path', function ($row) {
                if (auth()->user()->id == $row->user_id) {
                    $member = Member::findOrFail($row->user_receiver);
                } elseif (auth()->user()->id == $row->user_receiver) {
                    $member = Member::findOrFail($row->user_id);
                }
                $profile_image = $member->profile_image;
                return checkImage(asset('storage/members/profile-image/' . $profile_image), 'placeholder.png', $profile_image, 1);
            });

            $datatable = $datatable->addColumn('picture_privacy', function ($row) {
                if (auth()->user()->id == $row->user_id) {
                    $member = Member::findOrFail($row->user_receiver);
                } elseif (auth()->user()->id == $row->user_receiver) {
                    $member = Member::findOrFail($row->user_id);
                }
                return $member->picture_privacy;
            });
            $datatable = $datatable->addColumn('un_red_count', function ($row) {
                $u_chats = UserChat::where(['id' => $row->chat_user_id])->first();
                return $count =  $u_chats->totalUnRed();
            });
            return  $datatable->addColumn('customer_html', function ($row) {
                return view('frontend.partials.chat_list_row', compact('row'))->render();
            })
                ->rawColumns([
                    'customer_html', 'display_user_name', 'member_id', 'hash_id', 'profile_image_path', 'un_red_count'
                ])
                ->make(true);
        }

        $input = $request->all();

        $chat_user = '';
        $data['page'] = 'chat';
        $data['chat_user_id'] = 0;
        $data['chat_user'] = array();
        $data['chat'] = array();
        $rid = 0;
        $current_date = date('Y-m-d');
        $data['active_plan'] = 1;
        $data['oneHavePlan'] = 0;
        $data['requestChatId'] = $input['id'] ?? '';

        if (isset($input['id']) && !empty($input['id'])) {

            //            $rid = Hashids::decode($input['id'])[0];
            $rid = $input['id'];
            $chat_user = Member::where('id', $rid)->first();
            $chat_user->age = \Carbon\Carbon::parse($chat_user->date_of_birth)->age;
            $data['chat_user'] = $chat_user;
            $data['rid'] = $rid;

            $oneHavePlan = 0;

            if (isset($active_plan) && !empty($active_plan) && $active_plan->end_date >= $current_date) {
                $data['oneHavePlan'] = 1;
            } /*else {
                $chatUserPlan =MemberPlan::where('member_id',$rid)->first();

                if (isset($chatUserPlan) && !empty($chatUserPlan) && $chatUserPlan->end_date >= $current_date){
                    $data['oneHavePlan'] = 1;
                }
            }*/

            if (isset($active_plan) && !empty($active_plan) && $active_plan->end_date >= $current_date) {
                DB::table('chat_messages')
                    ->where(['user_id' => $rid, 'user_id_receiver' => $id])
                    ->update([
                        'un_red' => 1,
                    ]);

                $data['chat_user_id'] = $rid;
                $db_record =  UserChat::select('chat_messages.id', 'chat_messages.message', 'chat_messages.msg_file', 'chat_messages.created_at', 'chat_messages.un_red', 'chat_messages.chat_user_id', 'chat_messages.user_id', 'chat_messages.instant_count')
                    ->join('chat_messages', 'user_chats.id', '=', 'chat_messages.chat_user_id')
                    ->whereNotIn('chat_messages.id', function ($query) {
                        $query->selectRaw("chat_message_id")
                            ->from(with(new DeleteMessage)->getTable())
                            ->where(['user_id' => auth()->user()->id,]);
                    })
                    ->where(function ($quer) use ($rid) {
                        $quer->where(['chat_messages.user_id' => auth()->user()->id, 'chat_messages.user_id_receiver' => $rid])
                            ->orWhere(function ($que) use ($rid) {
                                $que->where(['chat_messages.user_id' => $rid, 'chat_messages.user_id_receiver' => auth()->user()->id]);
                            });
                    })->orderBy('chat_messages.id', 'ASC')
                    ->get();

                $ss_data = ConversationResource::collection($db_record);
                $data['chat'] = json_decode(json_encode($ss_data));
            } else {

                $data['active_plan'] = 0;
                DB::table('chat_messages')
                    ->where(['user_id' => $rid, 'user_id_receiver' => $id])
                    ->update([
                        'un_red' => 1,
                    ]);

                $data['chat_user_id'] = $rid;
                $db_record =  UserChat::select('chat_messages.id', 'chat_messages.message', 'chat_messages.msg_file', 'chat_messages.created_at', 'chat_messages.un_red', 'chat_messages.chat_user_id', 'chat_messages.user_id', 'chat_messages.instant_count')
                    ->join('chat_messages', 'user_chats.id', '=', 'chat_messages.chat_user_id')
                    ->whereNotIn('chat_messages.id', function ($query) {
                        $query->selectRaw("chat_message_id")
                            ->from(with(new DeleteMessage)->getTable())
                            ->where(['user_id' => auth()->user()->id,]);
                    })
                    ->where(function ($quer) use ($rid) {
                        $quer->where(['chat_messages.user_id' => auth()->user()->id, 'chat_messages.user_id_receiver' => $rid])
                            ->orWhere(function ($que) use ($rid) {
                                $que->where(['chat_messages.user_id' => $rid, 'chat_messages.user_id_receiver' => auth()->user()->id]);
                            });
                    })->orderBy('chat_messages.id', 'ASC')
                    ->get();

                $ss_data = ConversationResource::collection($db_record);
                $data['chat'] = json_decode(json_encode($ss_data));
            }
        } else {
            $data['active_plan'] = 0;
        }

        return view('frontend.user.chats')->with($data);
    }
    public function eventApply(Request $request)
    {

        $member = Member::findOrFail(auth()->user()->id);
        $data['name'] = '';
        $data['last4'] = '';
        $data['brand'] = '';
        $data['exp_month'] = '';
        $data['exp_year'] = '';
        $data['card_exist'] = 0;
        $data['already_apply'] = 0;
        if (isset($member->stripe_customer) && !empty($member->stripe_customer) && isset($member->stripe_payment_method) && !empty($member->stripe_payment_method)) {

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $saved = $stripe->paymentMethods->all([
                'customer' => $member->stripe_customer,
                'type' => 'card',
            ]);
            if (!empty($saved->data[0])) {
                $data['name'] = $saved->data[0]->billing_details->name;
                $data['last4'] = $saved->data[0]->card->last4;
                $data['brand'] = $saved->data[0]->card->brand;
                $data['exp_month'] = $saved->data[0]->card->exp_month;
                $data['exp_year'] = $saved->data[0]->card->exp_year;
            }
            //intent
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = Stripe\Customer::create();

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $data['intent'] = $stripe->setupIntents->create(
                [
                    'customer' => $customer->id,
                    'payment_method_types' => ['card'],
                ]
            );
            $data['card_exist'] = 1;
        } else {

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = Stripe\Customer::create();

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $data['intent'] = $stripe->setupIntents->create(
                [
                    'customer' => $customer->id,
                    'payment_method_types' => ['card'],
                ]
            );
        }

        $id = $request->id;
        $db_record = Event::where(['status' => 1, 'id' => $id, 'type' => 1])->first();
        if (empty($db_record)) {
        }
        //echo $db_record->siblings; die();
        $data['siblings'] = Sibling::whereIn('id', explode(',', $db_record->siblings))->get();

        $data['events'] = $db_record;

        $data['user'] = $member;
        /*check already apply*/
        $alreadyApply = EventAudience::where([
            'member_id' => auth()->user()->id,
            'event_id' => $id
        ])->get();

        if (!empty($alreadyApply) & count($alreadyApply) > 0) {
            $data['already_apply'] = 1;
            $data['already_guests'] = $alreadyApply;
        }

        /*if (!empty($member->stripe_customer) && !empty($member->stripe_payment_method)) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $saved = $stripe->paymentMethods->all([
              'customer' => $member->stripe_customer,
              'type' => 'card',
            ]);
            $data['name'] = $saved->data[0]->billing_details->name;
            $data['last4'] = $saved->data[0]->card->last4;
            $data['brand'] = $saved->data[0]->card->brand;
            $data['exp_month'] = $saved->data[0]->card->exp_month;
            $data['exp_year'] = $saved->data[0]->card->exp_year;
        }*/
        // dd($data);
        return view('frontend.event_apply')->with($data);
    }
    //payment for event
    public function stripePost(Request $request)
    {
        $member = Member::findOrFail(auth()->user()->id);
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'event_id' => ['required', 'integer']

        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        if (($request->has('payment_method') && !empty($request->input('payment_method'))) && ($request->has('customer') && !empty($request->input('customer')))) {

            $member->stripe_customer = $request->input('customer');
            $member->stripe_payment_method = $request->input('payment_method');
            $member->save();
        } else {

            if ((!isset($member->stripe_customer) && empty($member->stripe_customer)) || !isset($member->stripe_payment_method) && empty($member->stripe_payment_method)) {
                return die(json_encode([
                    'status' => 3,
                    'title' => 'Oops',
                    'message' => 'Something Went Wrong.',
                    'success_data' => NULL
                ]));
            }
        }
        $event_id = $request->input('event_id');
        $event = Event::find($event_id);
        if (!$event) {
            return  json_encode([
                'status' => 3,
                'title' => 'Oops',
                'message' => 'Event does not exist',
                'success_data' => NULL
            ]);
        }
        $guests = array();
        /*check already apply*/
        $alreadyApply = EventAudience::where([
            'member_id' => auth()->user()->id,
            'event_id' => $input['event_id']
        ])->first();

        if (!empty($alreadyApply)) {

            $alreadyApplyCount = EventAudience::where([
                'member_id' => auth()->user()->id,
                'event_id' => $input['event_id']
            ])->get();
            if ($alreadyApplyCount->count() >= $event->allow_siblings) {
                return  json_encode([
                    'status' => 3,
                    'title' => 'Limit Acceeded',
                    'message' => 'Your allow limit is acceeded, you can add more. Please contact admin',
                    'success_data' => NULL
                ]);
            }

            if (isset($input['guests']) && !empty($input['guests'])) {
                if (isset($input['guests']) && !empty($input['guests'])) {
                    $guests = json_decode($input['guests']);
                }
                if (count($guests) > 0) {
                    $male_guests = 0;
                    $female_guests = 0;
                    $total_guests = 0;
                    $total_cost = 0;
                    foreach ($guests as $K => $V) {
                        $total_guests++;
                        if ($V->gender == 'Male') {
                            $male_guests++;
                        } elseif ($V->gender == 'Female') {
                            $female_guests++;
                        }
                        //cost
                        $total_cost  = $total_cost + $event->adults_charges;
                    }
                } else {
                    return  json_encode([
                        'status' => 3,
                        'title' => 'Already Registered',
                        'message' => 'You have already registered for this event. if you would like to bring any family member please add here. Thanks',
                        'success_data' => NULL
                    ]);
                }
            } else {
                return  json_encode([
                    'status' => 3,
                    'title' => 'Already Registered',
                    'message' => 'You have already registered for this event. if you would like to bring any family member please add here. Thanks',
                    'success_data' => NULL
                ]);
            }
        } else {
            if (isset($input['guests']) && !empty($input['guests'])) {
                $guests = json_decode($input['guests']);
            }
            $male_guests = 0;
            $female_guests = 0;
            $total_guests = 0;
            $total_cost = $event->event_charges;
            foreach ($guests as $K => $V) {
                $total_guests++;
                if ($V->gender == 'Male') {
                    $male_guests++;
                } elseif ($V->gender == 'Female') {
                    $female_guests++;
                }
                //cost
                $total_cost  = $total_cost + $event->adults_charges;
            }
        }
        $guests = json_encode($guests);
        $apply = EventAudience::create([
            'member_id' => auth()->user()->id,
            'guests' => $guests,
            'event_id' => $input['event_id'],
            'male_guests' => $male_guests,
            'female_guests' => $female_guests,
            'total_guests' => $total_guests,
            'guest_charges' => $event->adults_charges,
            'event_charges' => $event->event_charges,
            'total_price' => $total_cost,
            'stripe_customer_id' => $member->stripe_customer
        ]);


        /*$en_coded = json_decode($input['guests'],true);

        $mainAr = array();
        foreach ($en_coded as $K => $V) {
            $mainAr[] = json_encode($V);
        }

        $guests = implode(',', $mainAr);*/

        //$guests = implode(',', $mainAr);

        /*Stripe\Stripe::setApiKey( env('STRIPE_SECRET') );
        $customer = Stripe\Customer::create(array(
            "email" => auth()->user()->email,
            "source"  => $input['stripeToken']
        ));*/


        // ************************* //
        // Send mail to user
        // ************************* //
        $model = auth()->user();
        $name = $model->first_name . ' ' . $model->last_name;

        $email = $model->email;

        $email_template = EmailTemplate::where('type', 'user_apply_event')->first();

        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $search = array("{{name}}", "{{app_name}}");
        $replace = array(ucwords($name), env('APP_NAME'));
        $content  = str_replace($search, $replace, $content);
        $social_links = GeneralSetting::find(1);

        sendEmail($email, $subject, $content, '', '', 'en', '', $social_links);

        $notificationAr['user_id'] = auth()->user()->id;
        $notificationAr['chat_id'] = NULL;
        $notificationAr['event_id'] = $input['event_id'];
        $notificationAr['plan_id'] = NULL;
        $notificationAr['title'] = 'Apply on event';
        $notificationAr['body'] = $model->first_name . ' ' . $model->last_name . ' apply on ' . $event->name . ' event';
        $notificationAr['click_action'] = 'OPEN_EVENT';
        $notificationAr['notification_type'] = 'apply_event';
        $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $model->profile_image), NULL, $model->profile_image);
        $notificationAr['priority'] = 'hight';

        $firebaseToken['to'] = $model->firebase_token;
        firebasePushNotification($firebaseToken, $notificationAr);
        $notificationAr['image'] =  $model->profile_image;

        $notification = Notification::create($notificationAr);

        // ************************* //
        //    Send email to admin
        // ************************* //
        $email_template = EmailTemplate::where('type', 'user_register_event')->first();
        $admin_email = $social_links['email'];
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $name = 'Admin';
        $search = array("{{name}}", "{{app_name}}");
        $replace = array(ucwords($name), env('APP_NAME'));
        $content  = str_replace($search, $replace, $content);

        sendEmail($admin_email, $subject, $content, '', '', 'en', '', $social_links);

        return die(json_encode([
            'status' => 1,
            'url' => url('/user/thankyou/Thank you for the event registration'),
            'message' => array('message' => ['Apply successfully! ']),
            'success_data' => NULL
        ]));
        /*$charge = Charge::create(array(
	            'customer' => $customer->id,
	            'amount'   => 1999,
	            'currency' => 'usd'
	        ));*/

        /*} catch (\Exception $e) {

            return $e->getMessage();
        }*/
    }
    public function thankYou(Request $request, $msg)
    {

        //$data['message'] = 'Thank you, You have been successfully registered for event';
        $data['message'] = '<h2>' . $msg . '</h2><p>Thank you for applying for the event. You will be notified by admin once your request has been approved for the event. Thank you!</p>';
        $data['message'] = '<h2>' . $msg . '</h2><p>Thanks for registering. You will be only charged if your requets has been approved by admin.</p>';

        return view('frontend.thankyou')->with($data);
    }

    public function thank_you(Request $request, $msg)
    {

        //$data['message'] = 'Thank you, You have been successfully registered for event';
        $data['message'] = '<h2>' . $msg . '</h2>';

        return view('frontend.thankyou')->with($data);
    }
    public function settings(Request $request)
    {

        $data['active'] = 'index';
        $member = Member::findOrFail(auth()->user()->id);
        $data['name'] = '';
        $data['last4'] = '';
        $data['brand'] = '';
        $data['exp_month'] = '';
        $data['exp_year'] = '';

        if (isset($member->stripe_customer) && !empty($member->stripe_customer) && isset($member->stripe_payment_method) && !empty($member->stripe_payment_method)) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $saved = $stripe->paymentMethods->all([
                'customer' => $member->stripe_customer,
                'type' => 'card',
            ]);
            if (!empty($saved->data[0])) {
                $data['name'] = $saved->data[0]->billing_details->name;
                $data['last4'] = $saved->data[0]->card->last4;
                $data['brand'] = $saved->data[0]->card->brand;
                $data['exp_month'] = $saved->data[0]->card->exp_month;
                $data['exp_year'] = $saved->data[0]->card->exp_year;
            }
        } else {

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $customer = Stripe\Customer::create();

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $data['intent'] = $stripe->setupIntents->create(
                [
                    'customer' => $customer->id,
                    'payment_method_types' => ['card'],
                ]
            );
        }
        if ($request->ajax()) {
            $m_id = auth()->user()->id;
            $paymentIds = Payments::select('payments.*', 'members_plan.plan_id')
                ->join('members_plan', function ($join) use ($m_id) {
                    $join->on('payments.members_plan_id', '=', 'members_plan.id')
                        ->where('members_plan.member_id', '=', $m_id);
                })->pluck('payments.id')->toArray();

            $paymentIdsWithEvent = Payments::select('payments.*', 'event_audiences.event_id')
                ->join('event_audiences', function ($join) use ($m_id) {
                    $join->on('payments.event_audiences_d', '=', 'event_audiences.id')
                        ->where('event_audiences.member_id', '=', $m_id);
                })->pluck('payments.id')->toArray();

            $allPaymentIds = array_unique(array_merge($paymentIds, $paymentIdsWithEvent));
            $db_record = Payments::select(
                'payments.*',
                'members_plan.plan_id',
                'event_audiences.event_id'
            )
                ->leftjoin('members_plan', function ($join) use ($m_id) {
                    $join->on('payments.members_plan_id', '=', 'members_plan.id')
                        ->where('members_plan.member_id', '=', $m_id);
                })
                ->leftJoin('event_audiences', function ($join) use ($m_id) {
                    $join->on('payments.event_audiences_d', '=', 'event_audiences.id')
                        ->where('event_audiences.member_id', '=', $m_id);
                })->whereIn('payments.id', $allPaymentIds)->orderBy('payments.id', 'desc');


            // $db_record = Payments::all();
            // $db_record = $db_record->whereIn('id',$allPaymentIds);
            // $db_record = $db_record->orderBy('created_at','DESC');

            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addColumn('type', function ($row) {
                if (isset($row->members_plan_id) && !empty($row->members_plan_id) && isset($row->plan_id) && !empty($row->plan_id)) {

                    return 'Plan Buy, (' . $row->getPlanName($row->plan_id) . ')';
                } elseif (isset($row->event_audiences_d) && !empty($row->event_audiences_d)) {
                    return 'Register Event, (' . $row->getEventName($row->event_id) . ')';
                }
            });
            $datatable = $datatable->editColumn('created_at', function ($row) {
                return \Carbon\Carbon::createFromTimeStamp(strtotime($row->created_at), "UTC")->format('d M, Y');
            });
            $datatable = $datatable->editColumn('status', function ($row) {
                $status = '<span class="badge rounded-pill bg-danger">' . $row->stripe_status . '</span>';
                if ($row->stripe_status == 'Payment complete.') {
                    $status = '<span class="badge rounded-pill bg-success">' . $row->stripe_status . '</span>';
                }
                return $status;
            });
            $datatable = $datatable->rawColumns(['type', 'status']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        return view('frontend.user.settings.index')->with($data);
    }
    //add stripe customer and payment method into members table
    public function addMemberStripeCustomerField(Request $request)
    {
        try {

            $user = Member::findOrFail(auth()->user()->id);

            if (($request->has('payment_method') && !empty($request->input('payment_method'))) && ($request->has('customer') && !empty($request->input('customer')))) {

                $user->stripe_customer = $request->input('customer');
                $user->stripe_payment_method = $request->input('payment_method');
                $user->save();
                $returnRedirectURL = $request->input('returnRedirectURL');

                if (!$returnRedirectURL) {
                    $returnRedirectURL = url('/user/settings');
                }

                return die(json_encode([
                    'status' => 1,
                    'url' => $returnRedirectURL,
                    'message' => array('message' => ['Apply successfully! ']),

                ]));
            } else {
                return die(json_encode([
                    'status' => 2,
                    'url' => '',
                    'message' => array('message' => ['Something Went Wrong ']),

                ]));
            }
        } catch (\Exception $e) {
            return die(json_encode([
                'status' => 2,
                'url' => '',
                'message' => array('message' => $e->message),
            ]));
        }
    }
    //Delete Payment method
    public function deletePaymentMethod()
    {

        $user = Member::findOrFail(auth()->user()->id);

        if (!empty($user->stripe_customer) && !empty($user->stripe_payment_method)) {

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $stripe->paymentMethods->detach(
                $user->stripe_payment_method,
                []
            );

            $deleted =  $stripe->customers->delete(
                $user->stripe_customer,
                []
            );
            if ($deleted->deleted) {

                $user->update([
                    'stripe_customer' => NULL,
                    'stripe_payment_method' => NULL
                ]);
            }
            return die(json_encode([
                'status' => 1,
                'url' => url('/user/settings'),
                'message' => 'Deleted successfully!'

            ]));
        } else {
            return die(json_encode([
                'status' => 0,
                'url' => '',
                'message' => 'Not found'

            ]));
        }
    }
    public function changePassword()
    {
        $data['active'] = 'change_password';
        return view('frontend.user.settings.change_password')->with($data);
    }
    public function feedback()
    {
        $data['active'] = 'feedback';
        return view('frontend.user.settings.feedback')->with($data);
    }
    public function closeAccount()
    {
        $data['active'] = 'close_account';
        return view('frontend.user.settings.close_account')->with($data);
    }
    public function updatePassword(Request $request)
    {
        $input = $request->all();
        $data['active'] = 'change_password';
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|max:30|confirmed',
            'current_original_password' => 'required|string|min:6|max:30',

        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        if (auth()->user()->original_password !== $input['current_original_password']) {
            Session::flash('flash_danger', 'You current password is not correct, Please try again');
            return redirect()->back()->withInput();
        }
        $member = Member::findOrFail(auth()->user()->id);
        $member->original_password = $input['password_confirmation'];
        $member->password = Hash::make($input['password']);
        $member->save();
        Session::flash('flash_success', 'Password updated successfully');

        return view('frontend.user.settings.change_password')->with($data);
    }
    public function postFeedback(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required',
            'image' => 'required|file|image|mimes:jpg,jpeg,png,svg'

        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        $feedback = new FeedBack();
        $feedback->title = $input['title'];
        $feedback->description = $input['description'];
        if (!empty($request->files) && $request->hasFile('image')) {
            // *********** //
            // Upload File //
            // *********** //
            $target_path = 'public/members/feedback/';
            $file = $request->file('image');
            $image = 'feedback-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($target_path, $image);
            $feedback->image = $image;
        }
        $feedback->member_id = auth()->user()->id;
        $feedback->save();
        Session::flash('flash_success', 'The Feedbad has been send successfully');
        $data['active'] = 'feedback';
        return redirect('user/settings/feedback');
    }
    public function postSuccessStory(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required',
            'partner_name' => 'required',
            'image' => 'required|file|image|mimes:jpg,jpeg,png,svg'

        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        $story = new Story();
        $story->title = $input['title'];
        $story->partner_name = $input['partner_name'];
        $story->description = $input['description'];
        if (!empty($request->files) && $request->hasFile('image')) {
            // *********** //
            // Upload File //
            // *********** //

            $target_path = storage_path('app/public') . '/stories';
            $file = $request->file('image');
            $image = 'story-image-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('stories', $image);
            $story->image = $image;
        }
        $story->member_id = auth()->user()->id;
        $story->save();
        $model = auth()->user();
        $name = $model->first_name . ' ' . $model->last_name;
        $social_links = GeneralSetting::find(1);

        // ************************* //
        //    Send email to admin
        // ************************* //
        $email_template = EmailTemplate::where('type', 'new_story_received')->first();
        $admin_email = $social_links['email'];
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $admin = 'Admin';
        $search = array("{{name}}", "{{user}}", "{{app_name}}");
        $replace = array(ucwords($admin), ucwords($name), env('APP_NAME'));
        $content  = str_replace($search, $replace, $content);
        sendEmail($admin_email, $subject, $content, '', '', 'en', '', $social_links);
        Session::flash('flash_success', 'The story has been saved successfully');
        $data['active'] = 'close_account';
        return redirect('user/settings/close-account');
    }
    public function deleteAccount(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'reason_termination' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        $user = auth()->user();
        $user->update([
            'status' => 0,
            'reason_termination' => $input['reason_termination']
        ]);
        // ************************* //
        // Send mail to user
        // ************************* //
        $model = auth()->user();
        $name = $model->first_name . ' ' . $model->last_name;

        $email = $model->email;

        $email_template = EmailTemplate::where('type', 'closed_account')->first();

        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $search = array("{{name}}", "{{user}}", "{{app_name}}", "{{reason}}");
        $replace = array(ucwords($name), 'You', env('APP_NAME'), $input['reason_termination']);
        $content  = str_replace($search, $replace, $content);
        $social_links = GeneralSetting::find(1);

        sendEmail($email, $subject, $content, '', '', 'en', '', $social_links);

        // ************************* //
        //    Send email to admin
        // ************************* //
        $email_template = EmailTemplate::where('type', 'closed_account')->first();
        $admin_email = $social_links['email'];
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $admin = 'Admin';
        $search = array("{{name}}", "{{user}}", "{{app_name}}", "{{reason}}");
        $replace = array(ucwords($admin), ucwords($name), env('APP_NAME'), $input['reason_termination']);
        $content  = str_replace($search, $replace, $content);

        sendEmail($admin_email, $subject, $content, '', '', 'en', '', $social_links);

        Auth::guard('user')->logout();

        //Member::destroy(auth()->user()->id);

        return redirect('/');
    }
    // send message..
    public function sendMessage(Request $request)
    {


        $input = $request->all();
        $id = auth()->user()->id;
        $rid = $input['user_id_receiver'];
        $member = Member::where('id', $rid)->first();

        if (!$member) {
            return die(json_encode([
                'status' => 0,
                'title' => 'Member not found!',
                'message' => 'Member does not exist',
                'success_data' => NULL
            ]));
        }
        $fee_count = ChatMessage::where(['user_id' => $id, 'user_id_receiver' => $rid])->sum('is_free_msg');

        $current_date = date('Y-m-d');
        $active_plan = MemberPlan::where('member_id', $id)->first();


        /*One have Plan*/
        $otherUserId = $rid;
        $oneHavePlan = 0;


        if (isset($active_plan) && !empty($active_plan) && $active_plan->end_date >= $current_date) {
            $oneHavePlan = 1;
        }/*else {
            $chatUserPlan =MemberPlan::where('member_id',$otherUserId)->first();

            if (isset($chatUserPlan) && !empty($chatUserPlan) && $chatUserPlan->end_date >= $current_date){
                $oneHavePlan = 1;
            }
        }*/
        /*End One Have Plan*/
        $canMsg = 0;

        if ($oneHavePlan || $fee_count < 1) {
            $canMsg = 1;
        } else {
            $canMsg = 0;
        }


        // if ( ( isset($active_plan) && !empty($active_plan) && $active_plan->end_date >= $current_date) || $fee_count < 2 ) {

        if ($canMsg == 1) {
            $is_free = 0;

            if (isset($active_plan) && !empty($active_plan) && $active_plan->end_date >= $current_date) {
                $is_free = 0;
            } elseif ($fee_count < 1) {
                $is_free = 1;
            }

            /*$validator = Validator::make($request->all(), [
                'user_id_receiver' => 'required|string',
                'message' => 'required'
            ]);
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }*/
            //$rid = Hashids::decode($input['user_id_receiver']);

            //if($request->input('instant') == 1){
            //$inst_count = InstantCount::where('member_id','=', $id)->COUNT('id');



            $pln = auth()->user()->plan;

            $inst_count = InstantCount::select('id')
                ->where('member_id', $id)
                ->groupBy(['receiver_member'])
                ->get()
                ->count();

            $inst_already = InstantCount::where(['member_id' => $id, 'receiver_member' => $rid])->first();
            if (isset($inst_already) && !empty($inst_already)) {
            } elseif (isset($pln) && !($inst_count < $pln->instant_messages_count)) {
                return die(json_encode([
                    'status' => 0,
                    'title' => 'Limit exceeded!',
                    'message' => 'You have used your all credits, please upgrade.',
                    'success_data' => NULL
                ]));
            }
            //}

            $rid = $input['user_id_receiver'];
            $member = Member::where('id', $rid)->first();

            if (!$member) {
                return die(json_encode([
                    'status' => 0,
                    'title' => 'Member not found!',
                    'message' => 'Member does not exist',
                    'success_data' => NULL
                ]));
            }
            //users chat
            $userCha = UserChat::where(function ($quer) use ($rid) {
                $quer->where(['user_id' => auth()->user()->id, 'user_receiver' => $rid])
                    ->orWhere(function ($que) use ($rid) {
                        $que->where(['user_id' => $rid, 'user_receiver' => auth()->user()->id]);
                    });
            })->first();

            $user_chat_id = 0;
            if (!$userCha) {
                $userChat = UserChat::create([
                    'user_id' => auth()->user()->id,
                    'user_receiver' => $rid,
                ]);
                $user_chat_id = $userChat->id;
            } else {
                $user_chat_id = $userCha->id;
            }

            $filename = '';
            $_url = '';
            if ($input['file'] != '') {
                // *********** //
                // Upload File //
                // *********** //

                //NEWWW

                $image = base64_decode($input['file']);

                $filename = 'image-' . uniqid() . '.PNG';
                $path = 'members/chat/' . $filename;

                if (Storage::disk('public')->put($path, $image, 'public')) {

                    $_url = checkImage(asset('storage/members/chat/' . $filename), 'avatar.png', $filename, 1);
                }
            }

            $chat = ChatMessage::create([
                'user_id' => auth()->user()->id,
                'chat_user_id' => $user_chat_id,
                'user_id_receiver' => $rid,
                'message' => $request->input('message'),
                'msg_file' => $filename,
                'instant_count' => $request->input('instant'),
                'is_free_msg' => $is_free,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            ]);

            if (!$chat) {
                return die(json_encode([
                    'status' => 0,
                    'title' => 'Oops',
                    'message' => 'Message does not send!',
                    'success_data' => NULL
                ]));
            }
            $receiver = InstantCount::where(['member_id' => auth()->user()->id, 'receiver_member' => $rid])->first();
            // if($request->input('instant') == 1){
            if ($oneHavePlan == 1 && empty($receiver)) {
                $instant = InstantCount::create([
                    'member_id' => auth()->user()->id,
                    'plan_id' => auth()->user()->plan_id,
                    'receiver_member' => $rid,
                    'is_active' => 1
                ]);
            }
            // ************************* //
            // Send email To User
            // ************************* //
            $name = $member->first_name . ' ' . $member->last_name;
            $user = getUserName(Auth()->user()->first_name . ' ' . Auth()->user()->last_name);
            //$profile_link = url('user/members/'.Auth()->user()->id);
            //            $has_id = Hashids::encode(Auth()->user()->id);
            $has_id = Auth()->user()->id;

            $profile_link = url('user/chats?id=' . $has_id);

            $email = $member->email;


            $email_template = EmailTemplate::where('type', 'send_message')->first();
            //$email_template = transformEmailTemplateModel($email_template,$lang);
            $subject = getUserName(Auth()->user()->first_name . ' ' . Auth()->user()->last_name) . ' ' . $email_template['subject'];
            $content = $email_template['content'];
            $search = array("{{name}}", "{{user}}", "{{app_name}}", "{{link}}");
            $replace = array($name, $user, env('APP_NAME'), $profile_link);
            $content  = str_replace($search, $replace, $content);
            sendEmail($email, $subject, $content, '', '', 'en');

            // ************************* //
            // firbase notification
            // ************************* //
            $notificationAr['user_id'] = $request->input('user_id_receiver');
            $notificationAr['chat_id'] = $user_chat_id;
            $notificationAr['event_id'] = NULL;
            $notificationAr['plan_id'] = NULL;
            $notificationAr['title'] = 'New Message';
            $notificationAr['body'] = $member->first_name . ' ' . $member->last_name . ' send you a message.';
            $notificationAr['click_action'] = 'OPEN_CHAT';
            $notificationAr['notification_type'] = 'send_message';
            $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $member->profile_image), NULL, $member->profile_image);
            $notificationAr['priority'] = 'hight';

            $firebaseToken['to'] = $member->firebase_token;
            firebasePushNotification($firebaseToken, $notificationAr);
            $notificationAr['image'] =  $member->profile_image;
            $notificationAr['sender_id'] =  auth()->user()->id;
            $notification = Notification::create($notificationAr);

            $c_chat = ConversationResource::collection(ChatMessage::where('id', $chat->id)->get());
            $receiver = array('id' => $member->id, 'first_name' => $member->first_name, 'last_name' => $member->last_name, 'profile_image' => $member->profile_image);
            $sender = array('id' => auth()->user()->id, 'first_name' => auth()->user()->first_name, 'last_name' => auth()->user()->last_name, 'profile_image' => auth()->user()->profile_image);
            if ($is_free == 1) {
                $c_chat[0]['message'] = 'Upgrade to read this message';
                $c_chat[0]['msg_file_path'] = '';
                $c_chat[0]['msg_file'] = '';
            }
            return die(json_encode([
                'status' => 1,
                'is_active_plan' => $oneHavePlan,
                'title' => 'Sent',
                'message' => 'Message send successfully!',
                'success_data' => array(
                    'chat' => $c_chat[0], 'sender' => $sender,
                    'receiver' => $receiver
                ),
                'user_receiver' => $rid
            ]));
        } else {
            if (isset($active_plan) && !empty($active_plan) && $active_plan->end_date < $current_date) {
                return die(json_encode([
                    'status' => 0,
                    'title' => 'Plan Expired!',
                    'message' => 'Your plan limit has been expired, please upgrade.',
                    'success_data' => NULL
                ]));
            } else {
                return die(json_encode([
                    'status' => 0,
                    'title' => 'No active plan!',
                    'message' => 'To continue sending messages please upgrade.',
                    'success_data' => NULL
                ]));
            }
        }
    }
    public function buyPlan(Request $request)
    {

        $member = Member::findOrFail(auth()->user()->id);
        $id = $request->id;

        if (empty($member->stripe_customer) || empty($member->stripe_payment_method)) {
            Session::flash('flash_danger', 'Please add payment detail first');
            $url = 'user/settings?redirect_url=' . url('/user/plans/buy/' . $id);
            return redirect($url);
        }

        if ($member->is_approved != 1) {
            $url = 'not-approved-user';
            return redirect($url);
        }

        $db_record = Plan::where(['status' => 1, 'id' => $id])->first();

        if (empty($db_record)) {
            return redirect('plans');
        }
        $data['user'] = $member;
        if (!empty($member->stripe_customer) && !empty($member->stripe_payment_method)) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $saved = $stripe->paymentMethods->all([
                'customer' => $member->stripe_customer,
                'type' => 'card',
            ]);
            $data['name'] = $saved->data[0]->billing_details->name;
            $data['last4'] = $saved->data[0]->card->last4;
            $data['brand'] = $saved->data[0]->card->brand;
            $data['exp_month'] = $saved->data[0]->card->exp_month;
            $data['exp_year'] = $saved->data[0]->card->exp_year;
        }
        $data['plan'] = $db_record;
        $data['redirect_url'] = $request->redirect_url ?? '';
        return view('frontend.buy_plan')->with($data);
    }
    public function stripePostPlan(Request $request)
    {

        $member = Member::findOrFail(auth()->user()->id);
        if (empty($member->stripe_customer) || empty($member->stripe_payment_method)) {
            Session::flash('flash_danger', 'Please add payment detail first');
            return redirect('user/settings');
        }

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'plan_id' => ['required', 'integer']

        ]);
        if ($validator->fails()) {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        $plan_id = $request->input('plan_id');
        $plan = Plan::find($plan_id);
        $mplan = Plan::find(auth()->user()->plan_id);
        if (!$plan) {
            return die(json_encode([
                'status' => 0,
                'message' => 'Plan does not exist.'

            ]));
        }
        //MemberPlan::where(['member_id' => $member->id])->delete();
        $id = auth()->user()->id;
        $mplan = MemberPlan::where('member_id', $id)->first();

        $current_date = date('Y-m-d');
        $inst_count = InstantCount::select('id')
            ->where('member_id', $id)
            ->where('is_active', 1)
            ->groupBy(['receiver_member'])
            ->get()
            ->count();

        //echo "$mplan->end_date >= $current_date"; die();
        if (isset($mplan) && !empty($mplan) && $mplan->end_date >= $current_date && $mplan->instant_messages_count >= $inst_count) {
            return die(json_encode([
                'status' => 0,
                'message' => 'You have already active plan. Please contact admin'

            ]));
        }

        /*if (isset($mplan) && !empty($mplan)) {
            if($mplan->status == 1 ){
                return die(json_encode([
                    'status' => 0,
                    'message' => 'You have already active plan. Please contact to admin'

                ]));
           }
        }*/

        $currentDateTime = \Carbon\Carbon::now();
        $newDateTime = \Carbon\Carbon::now()->addDays($plan->period);

        $end_plan_date = \Carbon\Carbon::createFromTimeStamp(strtotime($newDateTime), "UTC")->format('Y-m-d');

        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $charge = Stripe\PaymentIntent::create([
                'amount' => ($plan->price * 100),
                'currency' => 'usd',
                'customer' => $member->stripe_customer,
                'payment_method' => $member->stripe_payment_method,
                'off_session' => true,
                'confirm' => true,
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Error code will be authentication_required if authentication is needed
            echo 'Error code is:' . $e->getError()->code;
            $payment_intent_id = $e->getError()->payment_intent->id;
            $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }

        if (empty($charge->id)) {
            return die(json_encode([
                'status' => 0,
                'message' => 'Payment does not charged'
            ]));
        }

        $total_cost = $plan->price;
        if (empty($mplan)) {

            $apply = MemberPlan::create([
                'member_id' => auth()->user()->id,
                'plan_id' => $input['plan_id'],
                'total_price' => $total_cost,
                'payment_id' => $charge->id,
                'start_date' => $currentDateTime,
                'end_date' => $end_plan_date,
                'status' => 1
            ]);
            $payments = Payments::create([

                'members_plan_id' => $apply->id,

                'plan_id' => $input['plan_id'],
                'amoun_paid' => $total_cost,
                'payment_id' => $charge->id,
                'plan_end_date' => $end_plan_date,
                'stripe_status' => 'Payment complete',
                'status' => 1
            ]);
            $mmbr = auth()->user();
            $mmbr->update([
                'plan_id' => $input['plan_id']
            ]);

            InstantCount::where('member_id', $mmbr->id)->update(['is_active' => 0]);
            //InstantCount::where(['member_id' => auth()->user()->id])->delete();

            /*}elseif($mplan->status == 0 ){*/
        } else {
            //update
            $mplan->update([

                'plan_id' => $input['plan_id'],
                'total_price' => $total_cost,
                'payment_id' => $charge->id,
                'start_date' => $currentDateTime,
                'end_date' => $end_plan_date,
                'status' => 1
            ]);
            $payments = Payments::create([

                'members_plan_id' => $mplan->id,
                'plan_id' => $input['plan_id'],
                'amoun_paid' => $total_cost,
                'payment_id' => $charge->id,
                'plan_end_date' => $end_plan_date,
                'stripe_status' => 'Payment complete',
                'status' => 1
            ]);
            $mmbr = auth()->user();
            $mmbr->update([
                'plan_id' => $input['plan_id']
            ]);
            InstantCount::where('member_id', $mmbr->id)->update(['is_active' => 0]);
        }

        // ************************* //
        // Send mail to user
        // ************************* //
        $model = auth()->user();
        $name = $model->first_name . ' ' . $model->last_name;

        $email = $model->email;

        $email_template = EmailTemplate::where('type', 'user_apply_plan')->first();

        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $search = array("{{name}}", "{{days}}", "{{messages}}", "{{app_name}}");
        $replace = array(ucwords($name), $plan->period, $plan->instant_messages_count, env('APP_NAME'));
        $content  = str_replace($search, $replace, $content);
        $social_links = GeneralSetting::find(1);

        sendEmail($email, $subject, $content, '', '', 'en', '', $social_links);


        $notificationAr['user_id'] = auth()->user()->id;
        $notificationAr['chat_id'] = NULL;
        $notificationAr['event_id'] = NULL;
        $notificationAr['plan_id'] = $input['plan_id'];
        $notificationAr['title'] = 'Plan buy';
        $notificationAr['body'] = $model->first_name . ' ' . $model->last_name . ' apply on ' . $plan->name;
        $notificationAr['click_action'] = 'OPEN_NOTIFICATIONS';
        $notificationAr['notification_type'] = 'buy_plan';
        $notificationAr['image'] = checkImage(asset('storage/members/profile-image/' . $model->profile_image), NULL, $model->profile_image);
        $notificationAr['priority'] = 'hight';

        $firebaseToken['to'] = $model->firebase_token;
        firebasePushNotification($firebaseToken, $notificationAr);
        $notificationAr['image'] =  $model->profile_image;

        $notification = Notification::create($notificationAr);

        // ************************* //
        //    Send email to admin
        // ************************* //
        $email_template = EmailTemplate::where('type', 'user_registered_plan')->first();
        $admin_email = $social_links['email'];
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $name = 'Admin';
        $search = array("{{name}}", "{{app_name}}");
        $replace = array(ucwords($name), env('APP_NAME'));
        $content  = str_replace($search, $replace, $content);

        sendEmail($admin_email, $subject, $content, '', '', 'en', '', $social_links);

        // return die(json_encode([
        //     'status' => 1,
        //     'url' => url('/user/thank-you/Thank you for buying the plan now you can send messages to other members.'),
        //     'message' => array('message' => ['Apply successfully! ']),
        //     'success_data' => NULL
        // ]));

        if (isset($request->redirect_url) && $request->redirect_url) {
            return die(json_encode([
                'status' => 1,
                'url' => $request->redirect_url,
                'message' => array('message' => ['Apply successfully! ']),
                'success_data' => NULL
            ]));
        } else {
            return die(json_encode([
                'status' => 1,
                'url' => url('/user/thank-you/Thanks for updating the plan, you can now send and receive messages.'),
                'message' => array('message' => ['Apply successfully! ']),
                'success_data' => NULL
            ]));
        }


        /*} catch (\Exception $e) {

            return $e->getMessage();
        }*/
    }
    public function transactions(Request $request)
    {

        $data = array();
        $data['active'] = 'index';
        if ($request->ajax()) {
            die('here');
            $db_record = Payments::all();
            $db_record = $db_record->orderBy('created_at', 'DESC');
            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addColumn('type', function ($row) {
                if (isset($row->members_plan_id) && !empty($row->members_plan_id)) {
                    return 'Plan Buy, ' . getPlanName($row->members_plan_id);
                } elseif (isset($row->event_audiences_d) && !empty($row->event_audiences_d)) {
                    return 'Register Event, ' . getEventName($row->event_audiences_d);
                }
            });
            $datatable = $datatable->editColumn('created_at', function ($row) {
                return \Carbon\Carbon::createFromTimeStamp(strtotime($row->created_at), "UTC")->format('d M, Y');
            });
            $datatable = $datatable->editColumn('status', function ($row) {
                $status = '<span class="badge rounded-pill bg-danger">' . $row->stripe_status . '</span>';
                if ($row->stripe_status == 'Payment Complete') {
                    $status = '<span class="badge rounded-pill bg-success">' . $row->stripe_status . '</span>';
                }
                return $status;
            });
            $datatable = $datatable->rawColumns(['type', 'status']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        return view('frontend.user.settings.index', $data);
    }

    //Notification
    public function my_notifications(Request $request)
    {

        $data = array();
        if ($request->ajax()) {
            $db_record = Notification::select(array('*'));

            // $db_record = $db_record->where('is_approved',1)->where('id', '!=', auth()->user()->id)->whereNull('deleted_at');

            // $db_record = $db_record->where('gender', '!=', auth()->user()->gender);

            $db_record = $db_record->where('user_id', '=', auth()->user()->id);
            $db_record = $db_record->orderBy('created_at', 'DESC');

            $datatable = Datatables::of($db_record);
            /*$datatable = $datatable->editColumn('last_name', function($row)
            {
                return  getUserName($row->first_name.' '.$row->last_name);
            });*/

            return  $datatable->addColumn('customer_html', function ($member) {
                return view('frontend.partials.notification_list_row', compact('member'))->render();
            })
                ->rawColumns([
                    'customer_html'
                ])
                ->filter(function ($query) use ($request) {
                    $searchAr = explode(' ', $request->first_name);

                    if ($request->first_name) {

                        $query->where(function ($q) use ($request) {
                            $q->WhereRaw("concat(first_name, ' ', last_name) LIKE '%" . $request->first_name . "%'");
                            $q->orWhere('email', 'LIKE', "%$request->first_name%");
                            $q->orWhere('id', 'LIKE', "%$request->first_name%");
                        });
                    }

                    if ($request->partner_age) {
                        $query->Where('partner_age', $request->partner_age);
                    }
                    if ($request->maritial_status_id) {
                        $query->Where('marital_status_id', $request->maritial_status_id);
                    }
                    if ($request->caste_id) {
                        $query->Where('caste_id', $request->caste_id);
                    }
                    if ($request->occupation_id) {
                        $query->Where('occupation_id', $request->occupation_id);
                    }
                    if ($request->height) {
                        $query->Where('height', $request->height);
                    }
                    if ($request->education_id) {
                        $query->Where('education_id', $request->education_id);
                    }
                    if ($request->nationality_id) {
                        // $query->Where('nationality_id', $request->nationality_id);
                        $query->Where('birthday_country_id', $request->nationality_id);
                    }
                    if ($request->country_id) {
                        $query->Where('country_id', $request->country_id);
                    }
                })
                ->make(true);
        }
        return view('frontend.notification')->with($data);
    }

    public function clearAllNotification(Request $request)
    {
        $inputData = $request->all();
        $userData = auth()->user();
        $userId =  $userData->id;

        if (!isset($inputData['notification_id'])) {
            $notificationData = Notification::where(['user_id' => $userId])->delete();
            $response['status'] = true;
            $response['message'] = "All notification deleted successfully.";
            return response()->json($response, 200);
        } else {
            $notificationData = Notification::where(['id' => $inputData['notification_id'], 'user_id' => $userId])->first();

            if ($notificationData) {
                $notificationData->delete();
                $response['status'] = true;
                $response['message'] = 'Notification deleted successfully.';
            } else {
                $response['status'] = false;
                $response['message'] = 'Invalid Notification Id';
            }
            return response()->json($response, 200);
        }
    }
}
