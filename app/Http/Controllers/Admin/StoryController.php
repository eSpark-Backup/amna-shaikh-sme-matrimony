<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Story;
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

class StoryController extends Controller
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
            $db_record = Story::orderBy('created_at','DESC');
            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
            $datatable = $datatable->addColumn('member', function($row)
            {
                if (isset($row->get_member->first_name)) {
                    return $row->get_member->first_name.' '.$row->get_member->last_name;
                }else{
                    return '---';
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
            // image
            $datatable = $datatable->editColumn('image', function($row)
            {
                return  '<div style="width: 50px; height: auto"><img src="'.checkImage(asset('storage/stories/' . $row->image,1),'avatar.png',$row->image).'" class="img-responsive" alt="Avatar"></div>';
            });
            //End image
            $datatable = $datatable->editColumn('created_at', function($row)
            {
                return Carbon::createFromTimeStamp(strtotime($row->created_at), "UTC")->tz(session('timezone'))->format('d M, Y') ;
            });
            $datatable = $datatable->addColumn('action', function($row)
            {
                $actions = '<div class="actions table-operate flex">';
//                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/stories/" . Hashids::encode($row->id).'/view-story').'" title="View"><img class="width-25" src="'. asset('admin-assets/assets/media/icons/files/16.svg') .'"></a>';
//                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/stories/" . Hashids::encode($row->id).'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
//                $actions .= '&nbsp;<form method="POST" action="'.url("admin/stories/" . Hashids::encode($row->id)).'" accept-charset="UTF-8" style="display:inline">';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/stories/" . $row->id.'/view-story').'" title="View"><img class="width-25" src="'. asset('admin-assets/assets/media/icons/files/16.svg') .'"></a>';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/stories/" . $row->id.'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
                $actions .= '&nbsp;<form method="POST" action="'.url("admin/stories/" . $row->id).'" accept-charset="UTF-8" style="display:inline">';
                $actions .= '<input type="hidden" name="_method" value="DELETE">';
                $actions .= '<input name="_token" type="hidden" value="'.csrf_token().'">';
               $actions .= '<button class="btn-danger del_btn" onclick="return confirm(\'Are you sure you want to delete this record?\');" title="Delete">';
                $actions .= '<img src="'. asset('admin-assets/assets/media/icons/files/bin_icon.svg') .'">';
                $actions .= '</a>';
                $actions .= '</form>';
                $actions .= '</div>';
                return $actions;
            });
            $datatable = $datatable->rawColumns(['member','image','status','action']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        return view('admin.stories.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['story'] = new Story();
        $data['member'] = Member::where('status',1)->get();
        $data['action'] = "Add";
        return view('admin.stories.form')->with($data);
    }
    public function view_story($id)
    {
        $created = $image =  '';
        $membr = array();

        $id = Hashids::decode($id)[0];
        $data['action'] = "View";
        $data['story'] = $story = Story::findOrFail($id);
        $member = Story::findOrFail($id)->get_member;
        if (isset($member) && !empty($member)) {

           $data['member'] = $membr;

            $created = Carbon::createFromTimeStamp(strtotime($member->created_at), "UTC")->tz(session('timezone'))->format('d M, Y');
            $image = checkImage(asset('storage/stories/' . $story->image),'avatar.png',$story->image);
        }

        $data['created_at'] = $created;
        $data['image'] = $image;

        Story::findOrFail($id)->get_member;
        return view('admin.stories.view')->with($data);
    }
    /*public function store(Request $request)
    {
        $input = $request->all();

        $model = Story::findOrFail($input['id']);
        $flash_message = 'State has been updated successfully.';

        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);
        return redirect('admin/stories');
    }*/
    public function store(Request $request)
    {
        $input = $request->all();
        if($input['action'] == 'Add')
        {
            $validator = Validator::make($request->all(), [

                'title'      => 'required|string|max:100',
                'partner_name'      => 'required|string|max:100',
                'member_id'      => 'required|integer',
                'description'      => 'required|string',

            ]);
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }

            $model = new Story();
            $flash_message = 'Story has been created successfully.';
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'title'      => 'required|string|max:100',
                'partner_name'      => 'required|string|max:100',
               /* 'member_id'      => 'required|integer',*/
                'description'      => 'required|string',

            ]);
            if ($validator->fails())
            {
                Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();
            }

            $model = Story::findOrFail($input['id']);
            $flash_message = 'Story has been updated successfully.';
        }

        $target_path = storage_path('app/public').'/stories';
        if (!empty($request->files) && $request->hasFile('image'))
        {
            $file = $request->file('image');

            // *********** //
            // Upload File //
            // *********** //

            if (!empty($file)) {
                //$filename = 'member-'.$file->getClientOriginalName();
                $filename = 'story-image-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('stories', $filename);
                $input['image'] = $filename;
            }
        }
        $ArGal = array();

        $target_path = storage_path('app/public').'/stories';
        if (!empty($request->files) && $request->hasFile('gallery'))
        {
            $files = $request->file('gallery');

            // *********** //
            // Upload File //
            // *********** //
            $ArGal = array();

            if (!empty($files)) {
                //$filename = 'member-'.$file->getClientOriginalName();
                foreach ($files as $K => $file) {
                   $filename = 'story-image-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('stories', $filename);
                    $ArGal[] = $filename;
                }
            }
        }
        // Gallaryp
        if( !empty($input['chk_del']) ){

            $Rs3 =  Story::where(['id' => $input['id'] ])->first();

            if(!empty($Rs3->gallery)){
                $X = explode(',', $Rs3->gallery );
                $ArGal = array_values(array_merge( $ArGal, $X ));
            }

            if(!empty($input['chk_del'])){
                foreach( $input['chk_del'] as $k => $v ){

                    if (($key = array_search($v, $ArGal)) !== false) {
                        unset( $ArGal[$key] );
                    }

                    $old_file = public_path('storage') .'/events/'.$v;
                    if (file_exists($old_file) )
                    {
                        Storage::delete($target_path . '/' . $v);
                        unlink($old_file);
                    }
                }
            }
        }
        //END
        //END video
        if (!empty($ArGal)) {
            $ArGal = array_values($ArGal);
            $input['gallery'] = implode(',', $ArGal);
        }
        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);
        return redirect('admin/stories');
    }
    //edit
    public function edit($id)
    {

        $id = Hashids::decode($id)[0];

        //if($id == 1)
        //access_denied();
        $data['action'] = "Edit";
        $data['story'] = Story::findOrFail($id);
        $data['gallary'] = explode(',', $data['story']['gallery']);
        $data['member'] = Member::where('status',1)->get();
        return view('admin.stories.form')->with($data);
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
        Story::destroy($id);
        Session::flash('flash_success', 'Story has been deleted successfully.');
        return redirect('admin/stories');
    }
}
