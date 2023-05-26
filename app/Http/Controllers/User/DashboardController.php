<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use App\Models\Notification;
use App\Models\OrderVoucher;
use App\Models\Product;
use App\Models\Project;
use Carbon\Carbon;
use Hashids;
use DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard()
    {
        $data = array();
        return view('frontend.user.dashboard');
    }
    
}