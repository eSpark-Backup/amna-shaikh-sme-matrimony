<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\FeedBack;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;

class FeedBackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function addFeedBack(Request $request ){
    	 $lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
    	$messages = [
            'title' => 'Title field is required',
            'description' => 'description field is required',
            'image.required' => 'Image is requierd',
            'profile_image.image' => $lang_arr['validation_messages']['file_must_be_image'],
            'profile_image.mimes' => $lang_arr['validation_messages']['allowed_image_jpg_jpeg_png_svg']
        ];
        $validation_rules = array(
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|file|image|mimes:jpg,jpeg,png,svg'
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

        $feedback = FeedBack::create([
        	'member_id' => auth()->user()->id,
            'title' => $request->input('title'),
            
            'description' => $request->input('description')
        ]);
        if (!$feedback) {
        	return response()->json([
                'status' => 0,
                'message' => array('message' => ['Something went wrong']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        if(!empty($request->files) && $request->hasFile('image'))
        {
            // *********** //
            // Upload File //
            // *********** //
            $target_path = 'public/members/feedback/';
            $file = $request->file('image');
            $image = 'feedback-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $old_file = public_path() . '/storage/members/feedback/' . $feedback->image;
            if (file_exists($old_file) && !empty($feedback->image))
            {
                Storage::delete($target_path . '/' . $feedback->image);
            }
            $path = $file->storeAs($target_path, $image);
            $feedback->update([
                'image' => $image
            ]);
        }
        // ************************* //
        //    Send email to admin
        // ************************* //
        $social_links = GeneralSetting::find(1);
        $email_template = EmailTemplate::where('type','new_feedback_received')->first();
        $admin_email = $social_links['email'];
        
        $subject = $email_template['subject'];
        $content = $email_template['content'];
        $name = 'Admin';
        $search = array("{{name}}","{{app_name}}");
        $replace = array(ucwords($name),env('APP_NAME'));
        $content  = str_replace($search,$replace,$content);
        
        sendEmail($admin_email, $subject, $content, '', '', 'en','',$social_links);

        return response()->json([
            'status' => 1,
            'message' => array('message' => ['FeedBack has beed added successfully ']) ,
            'success_data' => NULL
        ]);
    }
}
