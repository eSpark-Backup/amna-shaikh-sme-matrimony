<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Onbehalf;
use App\Http\Resources\OnbehalfResource;


class OnbehalfController extends Controller
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
     * Display a listing of the onbehalf.
     */
    public function index()
    {
        $s_data = OnbehalfResource::collection(Onbehalf::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['On behalf list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
}
