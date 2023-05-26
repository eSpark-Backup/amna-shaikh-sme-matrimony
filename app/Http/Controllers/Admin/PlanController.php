<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Plan;
use Auth;
use Hashids;
use File;
use Storage;
use Session;
use Hash;
use DB;
use DataTables;


class PlanController extends Controller
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
            $db_record = Plan::orderBy('created_at','DESC');
            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();


            $datatable = $datatable->editColumn('unlimited_messages_sent', function($row)
            {
                $unlimited = '<span class="badge rounded-pill bg-danger">No</span>';
                if ($row->unlimited_messages_sent == 1)
                {
                    $unlimited = '<span class="badge rounded-pill bg-success">Yes</span>';
                }
                return $unlimited;
            });
            $datatable = $datatable->editColumn('boosting_profile', function($row)
            {
                $boosting = '<span class="badge rounded-pill bg-danger">No</span>';
                if ($row->boosting_profile == 1)
                {
                    $boosting = '<span class="badge rounded-pill bg-success">Yes</span>';
                }
                return $boosting;
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
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/plans/" . Hashids::encode($row->id).'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
                $actions .= '&nbsp;<form method="POST" action="'.url("admin/plans/" . Hashids::encode($row->id)).'" accept-charset="UTF-8" style="display:inline">';
                $actions .= '<input type="hidden" name="_method" value="DELETE">';
                $actions .= '<input name="_token" type="hidden" value="'.csrf_token().'">';
                

                 $actions .= '<button class="btn-danger del_btn" onclick="return confirm(\'Are you sure you want to delete this record?\');" title="Delete">';

                $actions .= '<img src="'. asset('admin-assets/assets/media/icons/files/bin_icon.svg') .'">';
                $actions .= '</a>';
                $actions .= '</form>';
                $actions .= '</div>';
                return $actions;
            });
            $datatable = $datatable->rawColumns(['unlimited_messages_sent','boosting_profile','status','action']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        return view('admin.plans.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['plan'] = new Plan();
        $data['action'] = "Add";
        return view('admin.plans.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
       
        if($input['action'] == 'Add')
        {
            $validator = Validator::make($request->all(), [
                'price' => ['required'],
                'name' => ['required','max:100','string'],
                'period' =>['required','max:12'],
                'instant_messages_count' =>['required'],
                'unlimited_messages_sent' =>['required'],
                'boosting_profile' =>['required'],
            ]);
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }

            $model = new Plan();
            $flash_message = 'Plan has been created successfully.';
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'price' => ['required'],
                'name' => ['required','max:100','string'],
                'period' =>['required','max:12'],
                'instant_messages_count' =>['required'],
                'unlimited_messages_sent' =>['required'],
                'boosting_profile' =>['required'],
            ]);
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }

            $model = Plan::findOrFail($input['id']);
            $flash_message = 'Plan has been updated successfully.';
        }
        if(isset($input['features']) && !empty($input['features'])){
         $input['features']  = json_encode($input['features']);
        }

        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);
        return redirect('admin/plans');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $id = Hashids::decode($id)[0];

        //if($id == 1)
        //access_denied();
        $data['action'] = "Edit";
        $plans = Plan::findOrFail($id);
        if(isset($plans->features) && !empty($plans->features)){
            $data['features'] = json_decode($plans->features);
        }
        $data['plan'] = $plans;
        return view('admin.plans.form')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Hashids::decode($id)[0];
        Plan::destroy($id);
        Session::flash('flash_success', 'Plan has been deleted successfully.');
        return redirect('admin/plans');
    }
}
