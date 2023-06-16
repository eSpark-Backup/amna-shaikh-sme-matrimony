<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Event;
use App\Models\EventAudience;
use App\Models\Country;
use App\Models\Sibling;

use Carbon\Carbon;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;

use Auth;
use Hashids;
use File;
use Storage;
use Session;
use Hash;
use DB;
use DataTables;


class EventController extends Controller
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
            $db_record = Event::orderBy('created_at','DESC');
            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
            $datatable = $datatable->editColumn('status', function($row)
            {
                $status = '<span class="badge rounded-pill bg-danger">Inactive</span>';
                if ($row->status == 1)
                {
                    $status = '<span class="badge rounded-pill bg-success">Active</span>';
                }
                return $status;
            });
            $datatable = $datatable->editColumn('type', function($row)
            {
                $type = '<span class="badge rounded-pill bg-danger">Past Event</span>';
                if ($row->type == 1)
                {
                    $type = '<span class="badge rounded-pill bg-success">Upcoming Event</span>';
                }
                return $type;
            });
            $datatable = $datatable->addColumn('action', function($row)
            {
                $actions = '<div class="actions table-operate flex">';
//                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/events-audience/" . Hashids::encode($row->id).'/get-audiences').'" title="View" _target="blank"><img class="width-25" src="'. asset('admin-assets/assets/media/icons/files/16.svg') .'"></a>';
//                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/events/" . Hashids::encode($row->id).'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
//                $actions .= '&nbsp;<form method="POST" action="'.url("admin/events/" . Hashids::encode($row->id)).'" accept-charset="UTF-8" style="display:inline">';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/events-audience/" . $row->id.'/get-audiences').'" title="View" _target="blank"><img class="width-25" src="'. asset('admin-assets/assets/media/icons/files/16.svg') .'"></a>';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/events/" . $row->id.'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
                $actions .= '&nbsp;<form method="POST" action="'.url("admin/events/" . $row->id).'" accept-charset="UTF-8" style="display:inline">';
                $actions .= '<input type="hidden" name="_method" value="DELETE">';
                $actions .= '<input name="_token" type="hidden" value="'.csrf_token().'">';
                $actions .= '<button class="btn-danger del_btn" onclick="return confirm(\'Are you sure you want to delete this record?\');" title="Delete">';
                $actions .= '<img src="'. asset('admin-assets/assets/media/icons/files/bin_icon.svg') .'">';
                $actions .= '</a>';
                $actions .= '</form>';
                $actions .= '</div>';

                return $actions;
            });
            $datatable = $datatable->rawColumns(['type','status','action']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        return view('admin.events.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['event'] = new Event();
        $data['action'] = "Add";
        $data['countries'] = Country::where(['status' => 1])->get();
        $data['siblings'] = Sibling::where(['status' => 1])->get();
        return view('admin.events.form')->with($data);
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
                'title' => ['required','max:255','string'],
                'location' => ['required','max:255','string'],
                'country' => ['required','max:100','string'],
                'event_date' => ['required','date'],
                'joined_female' => ['required','integer'],
                'joined_male' => ['required','integer'],
                'total_seats' => ['required','integer'],
                'adults_charges' => ['required'],
                'event_charges' => ['required'],
                'short_description' => ['required'],
                'long_description' => ['required'],
                'long_description' => ['required'],
                'siblings' => ['required'],
                'allow_siblings' => ['required']

            ]);
            if ($validator->fails())
            {
                //Session::flash('flash_danger', $validator->messages());
                //return redirect()->back()->withInput();

                return response()->json([
                    'status' => 0,
                    'message' => $validator->messages(),
                ],200, ['Content-Type' => 'application/json']);
            }

            $model = new Event();
            $flash_message = 'Event has been created successfully.';
        }
        else
        {

            $validator = Validator::make($request->all(), [
                'title' => ['required','max:255','string'],
                'location' => ['required','max:255','string'],
                'country' => ['required','max:100','string'],
                'event_date' => ['required','date'],
                'joined_female' => ['required','integer'],
                'joined_male' => ['required','integer'],
                'total_seats' => ['required','integer'],
                'adults_charges' => ['required'],

                'event_charges' => ['required'],
                'short_description' => ['required'],
                'long_description' => ['required'],
                'siblings' => ['required'],
                'allow_siblings' => ['required']

            ]);

            if ($validator->fails())
            {
                /*Session::flash('flash_danger', $validator->messages());
                return redirect()->back()->withInput();*/
                return response()->json([
                    'status' => 0,
                    'message' => $validator->messages(),
                ],200, ['Content-Type' => 'application/json']);
            }

            $model = Event::findOrFail($input['id']);
            $flash_message = 'Event has been updated successfully.';
        }
        //Events gallary images here
        /*$ArGal = array();
        //print_r($_FILES);
        for( $i = 0; $i < count($request->file('gallary')); $i++ ){
            //if(empty($_FILES['gallery']["tmp_name"][$i])) continue;
            $check = getimagesize($_FILES['gallery']["tmp_name"][$i]);
            if(  $check !== false ) {
                $ext = get_extension($check['mime']);
                if( !empty($ext) ){
                    $name = GetThumbnailMX( $_FILES['gallery']["tmp_name"][$i], $ext, array('W'=>800, 'H'=>800) );
                    if(!empty($name)){
                        $ArGal[] = $name;
                    }
                }
            }
        }*/
        $ArGal = array();
        //$target_path = 'public/events/';

        $target_path = storage_path('app/public').'/events';
        if (!empty($request->files) && $request->hasFile('gallary'))
        {
            $files = $request->file('gallary');

            // *********** //
            // Upload File //
            // *********** //
            $ArGal = array();

            if (!empty($files)) {
                //$filename = 'member-'.$file->getClientOriginalName();
                foreach ($files as $K => $file) {
                   $filename = 'event_image-' . uniqid() . '.' . $file->getClientOriginalExtension();
//                    $filename = $file->store('photos');
                    $file->move(public_path('storage/events'), $filename);
//                    $path = $file->storeAs('events', $filename);
                    $ArGal[] = $filename;

                }

                $Rs3 =  $model; //Event::where(['id' => $input['id'] ])->first();

                if(!empty($Rs3->gallary)){
                    $X = explode(',', $Rs3->gallary );
                    $ArGal = array_values(array_merge( $ArGal, $X ));
                }
            }
        }
        // Gallaryp
        if( !empty($input['chk_del']) ){

            $Rs3 =  Event::where(['id' => $input['id'] ])->first();

            if(!empty($Rs3->gallary)){
                $X = explode(',', $Rs3->gallary );
                $ArGal = array_values(array_merge( $ArGal, $X ));
            }

            if(!empty($input['chk_del'])){
                foreach( $input['chk_del'] as $k => $v ){

                    if (($key = array_search($v, $ArGal)) !== false) {
                        unset( $ArGal[$key] );
                    }
                    /*$old_file = public_path() . '/storage/events/'.$v;*/

                    $old_file = public_path('storage') .'/events/'.$v;
                    if (file_exists($old_file) )
                    {
                        //Storage::delete($old_file);
                        unlink($old_file);
                    }
                }
            }
        }
        //END
        //Video
        if( !empty($input['chk_del_video']) ){

            $Rs3 =  Event::where(['id' => $input['id'] ])->first();

            if(!empty($Rs3->event_video)){
                $old_filev = public_path('storage') .'/events/'.$Rs3->event_video;

                if (file_exists($old_filev) )
                {

                    unlink($old_filev);
                    $input['event_video'] = '';

                }
            }

        }
        if (!empty($request->files) && $request->hasFile('event_video'))
        {

            $file = $request->file('event_video');

            // *********** //
            // Upload File //
            // *********** //
            //$filename = 'member-'.$file->getClientOriginalName();
            $v_filename = 'event_video-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // **************** //
            // Delete Old File
            // **************** //

            if($input['action'] == 'Edit' && !empty($model->event_video))
            {
                $old_file = public_path('storage') .'/events/'.$model->event_video;
                if (file_exists($old_file) )
                {
                    unlink($old_file);
                }
            }

//            $path = $file->storeAs('events', $v_filename);
            $path = $request->event_video->move('storage/events', $v_filename);

            $input['event_video'] = $v_filename;

            /*$ov = $file->getClientOriginalName();

           $dimen =  FFMpeg::openUrl("https://crzglobal.xyz/storage/events/event_video-6277a89176fcd.mp4")
                        ->getVideoStream()
                        ->getDimensions();
            print($dimen); die();*/
            //FFMpeg::openUrl('https://videocoursebuilder.com/lesson-1.mp4');
        }
        //END video
        if (!empty($ArGal)) {
            $ArGal = array_values($ArGal);
            $input['gallary'] = implode(',', $ArGal);
        }

        $input['siblings'] = implode(',', $input['siblings']);
        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);

        return response()->json([
                'status' => 1,
                'message' => array('message' => ['File Uploaded']),
                'url' => url('admin/events')
            ],200, ['Content-Type' => 'application/json']);
        //return redirect('admin/events');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

//        $id = Hashids::decode($id)[0];

        //if($id == 1)
        //access_denied();
        $data['action'] = "Edit";
        $data['event'] = Event::findOrFail($id);
        $data['gallary'] = explode(',', $data['event']['gallary']);
        $data['countries'] = Country::where(['status' => 1])->get();
        $data['siblings'] = Sibling::where(['status' => 1])->get();
        return view('admin.events.form')->with($data);
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
        Event::destroy($id);
        Session::flash('flash_success', 'Event has been deleted successfully.');
        return redirect('admin/events');
    }
    public function audiences($id)
    {
        $id = Hashids::decode($id)[0];
        $data['id'] = $id;
        return view('admin.events.audience',$data);

    }
    public function audiences_ajax(Request $request)
    {
        $data = [];
        if($request->ajax())
        {
            //echo $id = $request->id; die();
            //$db_record = EventAudience::where('event_id', $id);
            $db_record = EventAudience::orderBy('created_at','DESC');

            $datatable = Datatables::of($db_record);
            $datatable = $datatable->addIndexColumn();
            $datatable = $datatable->editColumn('status', function($row)
            {
                $status = '<span class="badge rounded-pill bg-danger">Inactive</span>';
                if ($row->status == 1)
                {
                    $status = '<span class="badge rounded-pill bg-success">Active</span>';
                }
                return $status;
            });
            $datatable = $datatable->editColumn('gender', function($row)
            {
                $gender = '<span class="badge rounded-pill bg-danger">Female Event</span>';
                if ($row->gender == 1)
                {
                    $gender = '<span class="badge rounded-pill bg-success">Male</span>';
                }
                return $gender;
            });
            $datatable = $datatable->addColumn('name', function($row)
            {
                if (isset($row->member) && !empty($row->member)) {
                    return $row->member->first_name.' '.$row->member->last_name;
                }else{
                    return '---';
                }

            });

            $datatable = $datatable->addColumn('action', function($row)
            {
                $actions = '<div class="actions table-operate flex">';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/events/" . Hashids::encode($row->id).'/audiences').'" title="View"><img class="width-25" src="'. asset('admin-assets/assets/media/icons/files/16.svg') .'"></a>';
                $actions .= '&nbsp;<a class="edit_btn" href="'.url("admin/events/" . Hashids::encode($row->id).'/edit').'" title="Edit"><img src="'. asset('admin-assets/assets/media/icons/files/edit_pencil.svg') .'"></a>';
                $actions .= '&nbsp;<form method="POST" action="'.url("admin/events/" . Hashids::encode($row->id)).'" accept-charset="UTF-8" style="display:inline">';
                $actions .= '<input type="hidden" name="_method" value="DELETE">';
                $actions .= '<input name="_token" type="hidden" value="'.csrf_token().'">';
                $actions .= '<button class="btn-danger del_btn" onclick="return confirm(\'Are you sure you want to delete this record?\');" title="Delete">';
                $actions .= '<img src="'. asset('admin-assets/assets/media/icons/files/bin_icon.svg') .'">';
                $actions .= '</a>';
                $actions .= '</form>';
                $actions .= '</div>';

                return $actions;
            });
            $datatable = $datatable->rawColumns(['gender','name','status','action']);
            $datatable = $datatable->make(true);
            return $datatable;
        }
        //return view('admin.events.audience',$data);
    }
}
