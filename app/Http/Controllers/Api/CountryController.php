<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Http\Resources\CountryResource;
class CountryController extends Controller
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
     * Display a listing of the countries.
     */
    public function index()
    {
        $s_data = CountryResource::collection(Country::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Countries list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
}
