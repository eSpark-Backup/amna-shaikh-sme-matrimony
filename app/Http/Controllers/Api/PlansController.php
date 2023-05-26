<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Plan;
use App\Http\Resources\PlanResource;

class PlansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the members.
     */

    public function index()
    {
        $s_data = PlanResource::collection(Plan::where('status',1)->get());

            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Plans listing']),
                'success_data' => array('data' => $s_data)
            ]);
    }
}
