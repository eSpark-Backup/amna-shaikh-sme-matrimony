<?php
	use Illuminate\Support\Str;
	use App\Models\GeneralSetting;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Session;
	use Barryvdh\DomPDF\Facade;
	//use App\Jobs\SendEmail;
    
	function checkImage($path = '', $placeholder = '', $filename = '', $is_placeholder = 0)
	{
	    if (empty($placeholder))
	    {
	        $placeholder = 'image-svgrepo-com.svg';
	        //$placeholder = 'image-svgrepo-com.svg';
	    }
	    if (!empty($path))
	    {
	        $url = explode('storage', $path);
	        // $url = public_path() . '/storage' . $url[1]; 
	       $url = public_path('storage') . $url[1];
	        
	        if (file_exists($url) && !empty($filename)){

	            return $path;
	        }
	        else{
	        	if ($is_placeholder == 1) {
        			return  asset('images/' . $placeholder);
        		}else{
        			return NULL;
        		}	
	        }  
	    }
	    else
	    {
	        if ($is_placeholder == 1) {
    			return  asset('images/' . $placeholder);
    		}else{
    			return NULL;
    		}
	    }
	}
	function sendEmail($email, $subject, $content, $pdf = '', $filename = '', $lang = 'en', $csv = '', $social_links = '')
	{

		$lang = 'en';
	    if(!empty($pdf))
	    {

	        $lang_file = public_path('i18n/translations/'.$lang.'.json');
	        $lang_arr = json_decode(file_get_contents($lang_file),true);
	        try {
	            \Mail::send('emails.template', ['content' => $content, 'lang_arr' => $lang_arr, 'social_links' => $social_links, 'heading' => $subject], function ($message) use ($email, $subject, $pdf, $filename)
	            {
	                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
	                $message->to($email);
	                $message->subject($subject);
	                if (!empty($pdf))
	                    $message->attachData($pdf->output(), $filename);
	            });
	        }
	        catch (\Exception $e)
	        {
	        	
	            \Log::info('Send Email Exception', array(
	                'Message' => $e->getMessage()
	            ));
	        }
	    }
	    else
	    {
	        try
	        {

	        	$lang_file = public_path('i18n/translations/'.$lang.'.json');
	        	$lang_arr = json_decode(file_get_contents($lang_file),true);

				// SendEmail::dispatch(['email'=>$email,'subject' => $subject,'content' => $content,'filename' => '','lang_arr' => $lang_arr,'csv' => '', 'social_links' => $social_links]);

	            //\Mail::queue(new \App\Mail\SendMail($email, $subject, $content, $filename, $lang, $csv));
	            //Comment by Ismat
	            
	        	\Mail::send('emails.template', ['content' => $content, 'lang_arr' => $lang_arr, 'social_links' => $social_links, 'heading' => $subject], function ($message) use ($email, $subject, $pdf, $filename)
	            {
	                //$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
	                $message->from('info@smematrimony.com', 'SME Matrimony');
	                $message->to($email);
	                $message->subject($subject);
	            });
	        }
	        catch (\Exception $e)
	        {
	        	print_r( $e->getMessage() ); die();
	            \Log::info('Send Email Exception', array(
	                'Message' => $e->getMessage()
	            ));
	        }
	    }
	}

	function sendEmailNew($email, $subject, $content, $pdf = '', $filename = '', $lang = 'en', $csv = '', $social_links = '')
	{

		$lang = 'en';
	    if(!empty($pdf))
	    {

	        $lang_file = public_path('i18n/translations/'.$lang.'.json');
	        $lang_arr = json_decode(file_get_contents($lang_file),true);
	        try {
	            \Mail::send('emails.template_new', ['content' => $content, 'lang_arr' => $lang_arr, 'social_links' => $social_links, 'heading' => $subject], function ($message) use ($email, $subject, $pdf, $filename)
	            {
	                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
	                $message->to($email);
	                $message->subject($subject);
	                if (!empty($pdf))
	                    $message->attachData($pdf->output(), $filename);
	            });
	        }
	        catch (\Exception $e)
	        {
	        	
	            \Log::info('Send Email Exception', array(
	                'Message' => $e->getMessage()
	            ));
	        }
	    }
	    else
	    {
	        try
	        {

	        	$lang_file = public_path('i18n/translations/'.$lang.'.json');
	        	$lang_arr = json_decode(file_get_contents($lang_file),true);
	            //\Mail::queue(new \App\Mail\SendMail($email, $subject, $content, $filename, $lang, $csv));
	            //Comment by Ismat
	            
	        	\Mail::send('emails.template_new', ['content' => $content, 'lang_arr' => $lang_arr, 'social_links' => $social_links, 'heading' => $subject], function ($message) use ($email, $subject, $pdf, $filename)
	            {
	                //$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
	                $message->from('info@smematrimony.com', 'SME Matrimony');
	                $message->to($email);
	                $message->subject($subject);
	            });
	        }
	        catch (\Exception $e)
	        {
	        	print_r( $e->getMessage() ); die();
	            \Log::info('Send Email Exception', array(
	                'Message' => $e->getMessage()
	            ));
	        }
	    }
	}
	function sendEmailEventInvoice($email, $subject, $content, $pdf = '', $filename = '', $lang = 'en', $csv = '', $social_links = '',$member,$audience)
	{
		$lang = 'en';
        try
        {
        	$lang_file = public_path('i18n/translations/'.$lang.'.json');
        	$lang_arr = json_decode(file_get_contents($lang_file),true);
        	$pdf = \App::make('dompdf.wrapper');
        	
            $pdf = PDF::loadView('emails.pdf_invoice', ['content' => $content, 'lang_arr' => $lang_arr, 'social_links' => $social_links, 'heading' => $subject, 'member' => $member,'audience' => $audience]);

        	\Mail::send('emails.template_event_invoice', ['content' => $content, 'lang_arr' => $lang_arr, 'social_links' => $social_links, 'heading' => $subject, 'member' => $member,'audience' => $audience], function ($message) use ($email, $subject, $pdf, $filename)
            {
                $message->from('info@smematrimony.com', 'SME Matrimony');
                $message->to($email);
                $message->subject($subject);
                $message->attachData($pdf->output(),'invoice.pdf');

            });
        }
        catch (\Exception $e)
        {
        	print_r( $e->getMessage() ); die();
            \Log::info('Send Email Exception', array(
                'Message' => $e->getMessage()
            ));
        }
	}
	function transformEmailTemplateModel($model,$lang)
	{
	    $subject = $model->subject;
	    $content = $model->content;
	    $search = [];
	    $replace = [];
	    $ids = [];
	    //$search = ['{{label_1.0}}','{{label_1.1}}','{{label_1.2}}','{{label_1.3}}','{{label_1.4}}','{{label_1.5}}','{{label_1.6}}','{{label_1.7}}'];
	    //$replace = ['Verify Your Email To Start Using','Hi','Thank you for signing up. Click the button below to verify your','account','Verify Email Address','If that does not work, copy and paste the following link in your browser','If you did not create an account, no further action is required','Cheers'];
	    $content  = str_replace($search,$replace,$content);
	    return [
	        'id'      => $model->id,
	        'subject' => $subject,
	        'content' => $content,
	        'lang'    => $lang,
	        'type'    => $model->type,
	        'info'    => $model->info,
	        'status'  => $model->status
	    ];
	}

	function firebasePushNotification($to, $data){

		response()->json(['to' => $to['to'], 'notification' => $data,'data' => $data ], 200, ['Content-Type' => 'application/json']);

		$url = 'https://fcm.googleapis.com/fcm/send';

	    $fields = array (
	            'to' => $to['to'],

	            'notification' => array (
	                	"body" => $data['body'],
					    "title" => $data['title'],
					    "click_action" => $data['click_action'],
					    "notification_type" => $data['notification_type'],
					    "image" => $data['image'],
					    "user_id" => $data['user_id'],
					    "chat_id" => $data['chat_id'],
					    "event_id" => $data['event_id'],
					    "plan_id" => $data['plan_id'],
					    "priority" => $data['priority'],
					    "icon" => asset('images/login.png')
	            ),
	            'data' => array (
	                	"body" => $data['body'],
					    "title" => $data['title'],
					    "click_action" => $data['click_action'],
					    "notification_type" => $data['notification_type'],
					    "image" => $data['image'],
					    "user_id" => $data['user_id'],
					    "chat_id" => $data['chat_id'],
					    "event_id" => $data['event_id'],
					    "plan_id" => $data['plan_id'],
					    "priority" => $data['priority'],
					    "icon" => asset('images/login.png')
	            )
	    );
	    $fields = json_encode ( $fields );

	    $headers = array (
	            'Authorization: key=' . "AAAAsJOt--8:APA91bFSWoaWfS1GSpjeyPC1v6j8ZQIkFypVCIbYbaB77NWouHF7KnAjtTCV1u-ZasBGMCLyFChm7Hm11bixYX2VwfqGRiLxTwAvJ6adzEtAd5Qa8qkny_iCKBzz39D64EnxnNwbOl0F",
	            'Content-Type: application/json'
	    );

	    $ch = curl_init ();
	    curl_setopt ( $ch, CURLOPT_URL, $url );
	    curl_setopt ( $ch, CURLOPT_POST, true );
	    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

	    $result = curl_exec ( $ch );
	    $pp = json_decode($result);
	    //echo $result;
	    curl_close ( $ch );
	    if ($pp) {
	    	return $pp->success;
	    }

	}
	//frontended
	function truncatedStr($str,$opt=''){
		if ( !empty($opt) && $opt == 'stories') {
			if (strlen($str) > 70 ) {
				return Str::substr($str, 0, 500).' ...';
			}else{
				return $str;
			}
		}elseif(!empty($opt) && $opt == 'message'){
			if (strlen($str) > 40 ) {
				return Str::substr($str, 0, 40).' ...';
			}else{
				return $str;
			}
		}
		else{

			if (strlen($str) > 150 ) {
				return Str::substr($str, 0, 150).' ...';
			}else{
				return $str;
			}
		}
	}
	function getImage($gallery,$module){
		if ($module == 'events') {
			$imgAr = explode(',', $gallery);
			if (!empty($imgAr)) {
				return checkImage(asset('storage/events/' . $imgAr[0]),'',$imgAr[0],1);
			}else{
				return checkImage(asset('storage/events/' . $imgAr[0]),'',$imgAr[0],1);
			}
		}
		elseif ($module == 'members') {
			return checkImage(asset('storage/members/' . $gallery),'',$gallery,1);
		}elseif ($module == 'stories') {
			
			return checkImage(asset('storage/stories/' . $gallery),'',$gallery,1);

		}elseif ($module == 'event_detail') { 
			return checkImage(asset('storage/events/' . $gallery),'',$gallery,1);
		}elseif ($module == 'story_detail') {
			return checkImage(asset('storage/stories/' . $gallery),'',$gallery,1);
		}
		
	}

	function dateCustomFormat($c_date){
		return \Carbon\Carbon::createFromTimeStamp(strtotime($c_date), "UTC")->format('d M, Y');
	}

	function settings(){
		return GeneralSetting::where('id',1)->first();
	}
	
	function getAboutSectionImages($ind){
		$stngs = settings();
		$images = explode(',', $stngs->about_images);
		$imgAr = array();
		foreach ($images as $K => $V) {
			$imgAr[] = checkImage(asset('storage/home/' . $V),'',$V,1);
		}
		if ( isset($imgAr[$ind]) ) {
			return $imgAr[$ind];
		}
		return NULL;
	}
	function getUserName($str){
		$name = explode(' ', $str);
		return \Illuminate\Support\Str::title($name[0].' '.substr($name[1], 0, 1) );
		// return \Illuminate\Support\Str::title($name[0].' '.$name[1]);
	}
	function getAuthDetail(){
		$user = Auth::user();
		dd($user);
	}
	function getHeight(){
		return [	'4ft 0in - 122cm',
                	'4ft 1in - 124cm',
                	'4ft 2in - 127cm',
                	'4ft 3in - 129cm',
                	'4ft 4in - 132cm',
                	'4ft 5in - 135cm',
                	'4ft 6in - 137cm',
                	'4ft 7in - 140cm',
                	'4ft 8in - 142cm',
                	'4ft 9in - 145cm',
                	'4ft 10in - 147cm',
                	'4ft 11in - 150cm',
                	'5ft 0in - 152cm',
                	'5ft 1in - 153cm',
                	'5ft 2in - 157cm',
                	'5ft 3in - 160cm',
                	'5ft 4in - 162cm',
                	'5ft 5in - 165cm',
                	'5ft 6in - 168cm',
                	'5ft 7in - 170cm',
                	'5ft 8in - 172cm',
                	'5ft 9in - 175cm',
                	'5ft 10in - 177cm',
                	'5ft 11in - 180cm',
                	'6ft 0in - 183cm',
                	'6ft 1in - 185cm',
                	'6ft 2in - 188cm',
                	'6ft 3in - 190cm',
                	'6ft 4in - 193cm',
                	'6ft 5in - 195cm',
                	'6ft 6in - 198cm',
                	'6ft 7in - 200cm',
                	'6ft 8in - 203cm',
                	'6ft 9in - 205cm',
                	'6ft 10in - 208cm',
                	'6ft 11in - 211cm',
                	'7ft 0in - 213cm',
                	'7ft 1in - 216cm',
                	'7ft 2in - 218cm',
                	'7ft 3in - 221m',
                	'7ft 4in - 223cm',
                	'7ft 5in - 226cm',
                	'7ft 6in - 228cm',
                	'7ft 7in - 231cm',
                	'7ft 8in - 234cm',
                	'7ft 9in - 236cm',
                	'7ft 10in - 239cm',
                	'7ft 11in - 241cm'
	                                	];
	}	
	function getRequestCount(){
		/*Session::put('hello', 'OK');
		if (session()->has('hello')) {
			echo Session::get('hello'); die('ismat');
		}*/
		
		echo $count = \Session::get('req_counts');
		if (session()->has('hello')) {
			echo $count = Session::get('req_counts');
			echo 'ismat';
			/*if(($count+1) == 2){
				return ($count+1);
				Session::unset('req_counts');
			}*/

			Session::put('req_counts' , ($count+1) );
			return ($count+1);
		}else{
			
			\Session::put('req_counts', 'hel');
			
		}
		
	}

	if (!function_exists('image_upload')) {
	    function image_upload($file, $pathName, $multipalImageName = null)
	    {
	        $path = public_path() . '/storage/' . $pathName . '/';
	        $newFolder = strtoupper(date('M') . date('Y')) . '/';
	        $folderPath = $path . $newFolder;
	        if (!File::exists($folderPath)) {
	            File::makeDirectory($folderPath, $mode = 0777, true);
	        }
	        // $imgsize = getimagesize($file);
	        // $width = $imgsize[0];
	        // $height = $imgsize[1];
	        // // dd($imgsize);
	        // $imgre = calculateDimensions($width, $height, 450, 450);
	        $image = $file;
	        $extension = $image->getClientOriginalExtension();
	        //$orignalname = $file->getClientOriginalName();       
	        if ($multipalImageName == null) {
	            $fileName = time() . '-' . $pathName . '.' . $extension;
	        } else {
	            $fileName = time() . '-' . $pathName . '-' . $multipalImageName . '.' . $extension;
	        }
	        // dd($extension);
	        if (in_array($extension, ['jpeg', 'jpg', 'JPG', 'JPEG', 'png', 'PNG', 'gif', 'GIF', 'svg', 'webp'])) {
	            $image->move($folderPath, $fileName);
	            return array(true, $newFolder . $fileName, $extension, $fileName);
	        } else {
	            return array(false, "file should be in jpeg, jpg,png,gif,svg and webp format / double extension not allow.", '');
	        }
	    }
	}
?>