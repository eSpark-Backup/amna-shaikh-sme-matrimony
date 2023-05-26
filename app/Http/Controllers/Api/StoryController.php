<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Story;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Http\Resources\StoryResource;
class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function stories(Request $request){
    	$s_data = StoryResource::collection(Story::where('status',1)->get());
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Stories list']),
            'success_data' => array('data' => $s_data)
        ]);
    }

    public function add_story(Request $request)
    {
        $lang =  'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        $messages = [
            'title.required' => 'This field is required.',
            'description.required' => 'This field is required.',
            'partner_name.required' => 'This field is required.',
            'image.required' => 'This field is required.',
            'image.image' => 'The image must be an image.',
            'profile_image.mimes' => 'The image must be a file of type: jpg, jpeg, png, svg.'
        ];
        $validation_rules = array(
            'title'      => 'required|string|max:100',
            'partner_name'      => 'required|string|max:100',
            'description'      => 'required|string',
            'image' => 'required|file|image|mimes:jpg,jpeg,png,svg'
        );

        $validator = Validator::make($request->all(),$validation_rules,$messages);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors(), 'success_data' => NULL ]);
        }
        $story = Story::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'partner_name' => $request->input('partner_name'),
            'member_id'  => auth()->user()->id
        ]);
        if($story)
        {
        	if(!empty($request->files) && $request->hasFile('image'))
	        {
	            
	            // *********** //
	            // Upload File //
	            // *********** //
	            $target_path = 'public/stories/';
	            $file = $request->file('image');
	            $image = 'story-image-' . uniqid() . '.' . $file->getClientOriginalExtension();
	            $old_file = public_path() . '/storage/stories/' . $story->image;
	            if (file_exists($old_file) && !empty($story->image))
	            {
	                Storage::delete($target_path . '/' . $story->image);
	            }
	            $path = $file->storeAs($target_path, $image);
	            $story->update([
	                'image' => $image
	            ]);

	        }
            
            $social_links = GeneralSetting::find(1);

            // ************************* //
            //    Send email to admin
            // ************************* //
            $email_template = EmailTemplate::where('type','new-story-received')->first();
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
                'message' =>  array('message' => ['Your request has been submitted successfully !']) ,
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'message' => array('message' => ['Oops something went wrong. Unable to create your account. Please try again.']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);
        }
    }
}
