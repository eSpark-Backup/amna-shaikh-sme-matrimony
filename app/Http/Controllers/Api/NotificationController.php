<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Http\Resources\NotificationResource;



class NotificationController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the members.
     */

    public function index()
    {
        $s_data = NotificationResource::collection(Notification::where('user_id',auth()->user()->id)->get() );

            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Notification details']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function update(Request $request ){
    	$lang = 'en';
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);

        $notification = Notification::where('user_id' , auth()->user()->id )->get();

        if (!$notification) {

        	return response()->json([
                'status' => 0,
                'message' => array('message' => ['Request does not found']),
                'success_data' => NULL
            ],200, ['Content-Type' => 'application/json']);

        }
        foreach ($notification as $K => $V) {
        	$V->update([
            	'is_readed' => 1
        	]);
        }


        return response()->json([
            'status' => 1,
            'message' =>  array('message' => ['Request udated successfully!. ']) ,
            'success_data' => NULL
        ],200, ['Content-Type' => 'application/json']);
    }
}
