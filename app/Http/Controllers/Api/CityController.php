<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\City;
use App\Models\State;
use App\Http\Resources\CityResource;

class CityController extends Controller
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
     * Display a listing of the cities.
     */
    public function index()
    {
        $s_data = CityResource::collection(City::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Cities list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
}
