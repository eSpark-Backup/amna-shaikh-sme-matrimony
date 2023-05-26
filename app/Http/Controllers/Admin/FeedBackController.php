<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\FeedBack;
use App\Models\Member;
use Carbon\Carbon;
use Auth;
use Hashids;
use File;
use Storage;
use Session;
use Hash;
use DB;
use DataTables;

class FeedBackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = [];
        if($request->ajax())
        {
            $db_record = FeedBack::orderBy('created_at','DESC');
            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
            $datatable = $datatable->addColumn('name', function($row)
            {
                if (isset($row->member_id)) { 
                    //dd($row->member);
                    if (isset($row->member)) {
                        return $row->member->first_name.' '.$row->member->last_name;
                    }else{
                        return '---';
                    }
                }
            });
            $datatable = $datatable->editColumn('status', function($row)
            {
                $status = '<span class="badge rounded-pill bg-danger">Disable</span>';
                if ($row->status == 1)
                {
                    $status = '<span class="badge rounded-pill bg-success">Active</span>';
                }
                return $status;
            });

            $datatable = $datatable->addColumn('action', function($row)
            {
                $actions = '<div class="actions table-operate flex">';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/feedback/" . Hashids::encode($row->id).'/view').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/16.svg') .'" style="width:25px"></a>';
                $actions .= '</div>';
                return $actions;
            });
            $datatable = $datatable->rawColumns(['name','status','action']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        return view('admin.feedback.index',$data);
    }
    public function view($id){

    	$id = Hashids::decode($id)[0];
        $data['action'] = "View";
        $member = FeedBack::findOrFail($id)->member;

        $feedback = FeedBack::findOrFail($id);

        $data['feedback'] = $feedback;
        $data['member'] = $member;

        $data['created_at'] = Carbon::createFromTimeStamp(strtotime($feedback->created_at), "UTC")->tz(session('timezone'))->format('d M, Y');

        $data['image'] = checkImage(asset('storage/members/feedback/' . $feedback->image),'avatar.png',$feedback->image);

        return view('admin.feedback.view')->with($data);
    }
}
