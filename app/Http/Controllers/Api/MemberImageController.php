<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\UserImage;
use App\Member;
use Carbon\Carbon;
use Hashids;
use Storage;
use Hash;

class MemberImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //save image
    /*public function store(Request $request)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $id =  Hashids::decode($request->hash_id)[0];

        // *************** //
        // File Validation //
        // *************** //

        $messages = [
            'user_image.required' => $lang_arr['validation_messages']['field_is_required'],
            'profile_image.image' => $lang_arr['validation_messages']['file_must_be_image'],
            'profile_image.mimes' => $lang_arr['validation_messages']['allowed_image_jpg_jpeg_png_svg']
        ];
        $validation_rules = array(
            'user_image' => 'required|file|image|mimes:jpg,jpeg,png,svg'
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }
        // *********** //
        // Upload File //
        // *********** //
        $target_path = 'public/members/profile-image/';
        $file = $request->file('user_image');
        $profile_image = 'user_image-' . uniqid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($target_path, $profile_image);

        $user_image = UserImage::create([
            'user_image' => $profile_image,
            'is_private' => $request->is_private,
            'member_id'  => $id
        ]);
        if ( $user_image ) {
            if ($request->has('is_profile_image') && $request->is_profile_image == 1 ) {
                $user = Member::where('id',$id)->first();
                if ($user) {
                    $user->update([
                        'profile_image' => $profile_image,
                    ]);
                }
            }

            return response()->json([
                'status' => 1,
                'message' => array('message' => [$lang_arr['alert_messages']['extensions_upload_file_success']]),
                'success_data' => array( 'data' => '' ),
            ], 200, ['Content-Type' => 'application/json']);
        }else{
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['extensions_upload_file_error']]),
                'success_data' => array( 'data' => '' ),
            ], 200, ['Content-Type' => 'application/json']);
        }
    }
    //Delete image
    public function destroy($id)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        if(!isset(Hashids::decode($id)[0]))
        {
            return response()->json([
                'status' => 0,
                'message' => $lang_arr['alert_messages']['image_does_not_exist']
            ]);
        }

        $userimage = UserImage::findOrFail(Hashids::decode($id)[0]);
        if($userimage){
           $userimage->delete();
           return response()->json([
                'status' => 1,
                'message' => array('message' => [$lang_arr['alert_messages']['user_image_deleted']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
        else{
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['user_image_deleted_error']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
    }
    //make image private
    public function privateImage(Request $request, $id)
    {
        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        if(!isset(Hashids::decode($id)[0]))
        {
            return response()->json([
                'status' => 0,
                'message' => $lang_arr['alert_messages']['image_does_not_exist']
            ]);
        }

        $userimage = UserImage::findOrFail(Hashids::decode($id)[0]);
        $messages = [
            'is_private.required' => 'is_private field is required',
        ];
        $validation_rules = array(
            'is_private' => 'required'
        );
        if($request->has('platform') && $request->platform == 'mobile')
        {
            $validator = Validator::make($request->all(),$validation_rules,$messages);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'message' => $validator->errors()]);
            }
        }
        else
        {
            $request->validate($validation_rules,$messages);
        }
        if($userimage){
            $userimage->update([
                'is_private' => $request->input('is_private'),
            ]);
           return response()->json([
                'status' => 1,
                'message' => array('message' => [$lang_arr['alert_messages']['user_image_success']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
        else{
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['image_does_not_exist']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
    }
    //make image as profile image
    public function setProfileImage(Request $request, $id)
    {

        $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        if(!isset(Hashids::decode($id)[0]))
        {
            return response()->json([
                'status' => 0,
                'message' => $lang_arr['alert_messages']['image_does_not_exist']
            ]);
        }
        $user = auth()->user();
        if (!$user){
            return response()->json([
                'status' => 0,
                'message' => $lang_arr['login']['form_title']
            ]);
        }

        $userimage = UserImage::findOrFail(Hashids::decode($id)[0]);

        if(isset($userimage) && !empty($userimage) ){
            $user->update([
                'profile_image' => $userimage->user_image
            ]);
            return response()->json([
                'status' => 1,
                'message' => array('message' => [$lang_arr['alert_messages']['user_image_profile']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
        else{
            return response()->json([
                'status' => 0,
                'message' => array('message' => [$lang_arr['alert_messages']['image_does_not_exist']]),
                'success_data' => NULL
            ], 200, ['Content-Type' => 'application/json']);
        }
    }*/
}
