<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Admin;
use Auth;
use Hashids;
use File;
use Storage;
use Session;
use Hash;
use DB;
use DataTables;
class AdminController extends Controller
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
            $db_record = Admin::whereNotIn('id', [1, auth()->user()->id]);
            $db_record = $db_record->orderBy('created_at','DESC');
            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
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
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/admins/" . Hashids::encode($row->id).'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
                $actions .= '&nbsp;<form method="POST" action="'.url("admin/admins/" . Hashids::encode($row->id)).'" accept-charset="UTF-8" style="display:inline">';
                $actions .= '<input type="hidden" name="_method" value="DELETE">';
                $actions .= '<input name="_token" type="hidden" value="'.csrf_token().'">';
                $actions .= '<a href="javascript:void(0)" class="del_btn" onclick="return confirm(\'Are you sure you want to delete this record?\');" title="Delete">';
                $actions .= '<img src="'. asset('admin-assets/assets/media/icons/files/bin_icon.svg') .'">';
                $actions .= '</a>';
                $actions .= '</form>';
                $actions .= '</div>';



                return $actions;
            });
            $datatable = $datatable->rawColumns(['status','action']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        return view('admin.admins.index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['admin'] = new Admin();
        $data['action'] = "Add";
        return view('admin.admins.form')->with($data);
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
                'email' => ['required','max:100','string',Rule::unique('admins')],
                'name' => ['required','max:100','string'],
                'password' => 'required|string|min:8|max:30',
            ]);
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }
            $input['original_password'] = $input['password'];
            $input['password'] = Hash::make($input['password']);
            $model = new Admin();
            $flash_message = 'Admin user has been created successfully.';
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'email' => ['required','string',Rule::unique('admins')->ignore($input['id'])],
                'name' => ['required','max:100','string'],
                'password' => 'required|string|min:8|max:30',
            ]);
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }
            if(!empty($input['password']))
            {
                $input['original_password'] = $input['password'];
                $input['password'] = Hash::make($input['password']);
            }
            else
            {
                unset($input['password']);
            }
            $model = Admin::findOrFail($input['id']);
            $flash_message = 'Admin user has been updated successfully.';
        }
        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);
        return redirect('admin/admins');
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
        $data['admin'] = Admin::findOrFail($id);
        return view('admin.admins.form')->with($data);
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
        Admin::destroy($id);
        Session::flash('flash_success', 'Admin user has been deleted successfully.');
        return redirect('admin/admins');
    }

    public function manageProfile(){
        $data['action'] = "Edit";
        $data['admin'] = Auth::user();
       return view('admin.admins.form')->with($data); 
    }
}