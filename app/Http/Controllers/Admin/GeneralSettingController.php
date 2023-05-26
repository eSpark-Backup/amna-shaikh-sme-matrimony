<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
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


class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $imgs = array();
        $sldrimgs = array();
        $settings = GeneralSetting::where('id',1)->first();
        if (!empty($settings)) {
            $imgs = explode(',', $settings->about_images);

            $sldrimgs = explode(',', $settings->slider_images);
        }
       

        $aboutImgs = array();
        foreach ($imgs as $K => $V) {
            
            $aboutImgs[$V] = checkImage(asset('storage/home/'.$V),'',$V,0);
        }
        

        $sliderImgs = array();
        foreach ($sldrimgs as $L => $M) {
            
            $sliderImgs[$M] = checkImage(asset('storage/home/'.$M),'',$M,0);
        }
        
        $data['item'] = $settings;
        $data['about_images'] = $aboutImgs;
        $data['slider_images'] = $sliderImgs;

        // dd($data);
        return view('admin.settings.index')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneralSetting  $generalSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralSetting $generalSetting)
    {
        $validator = Validator::make($request->all(), [
            'system_name' => ['required','max:191','string'],
            'system_title' => ['required','max:191','string'],
            //'email' => ['required','max:191','string',Rule::unique('admins')],
            'phone' => ['required','string'],
            'email' => ['required','string'],
            'facebook_link' => ['required','string'],
            'youtube_link' => ['required','string'],
            'instagram_link' => ['required','string'],
            'meetup_link' => ['required','string'],
            'whatsapp' => ['required','string'],
            'terms_condition' => ['required','string'],
            'privacy_policy' => ['required','string'],
            'about_title' => ['required','max:91','string'],
            'members_title' => ['required','max:91','string'],
            'events_title' => ['required','max:91','string'],
            'happy_couple_title' => ['required','max:91','string']
        ]);
        if ($validator->fails())
        {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        $input = $request->all();
        $model = GeneralSetting::findOrFail($input['id']);
        $flash_message = 'Settings has been updated successfully.';

        $ArGal = array();
        $target_path = 'public/home/';
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
                   $filename = 'about-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($target_path, $filename);
                    $ArGal[] = $filename;
                }
                $Rs3 =  $model; //Event::where(['id' => $input['id'] ])->first();    

                if(!empty($Rs3->about_images)){
                    $X = explode(',', $Rs3->about_images );
                    $ArGal = array_values(array_merge( $ArGal, $X ));
                }
            }
        }
        // Gallaryp
        if( !empty($input['chk_del']) ){

            $Rs3 =  $model; //Event::where(['id' => $input['id'] ])->first();    

            if(!empty($Rs3->about_images)){
                $X = explode(',', $Rs3->about_images );

                $ArGal = array_values(array_merge( $ArGal, $X ));
            }
           
            if(!empty($input['chk_del'])){
                foreach( $input['chk_del'] as $k => $v ){
                    
                    if (($key = array_search($v, $ArGal)) !== false) {
                        unset( $ArGal[$key] );
                        
                    }

                    $old_file = public_path() . '/storage/home/'.$v;
                    if (file_exists($old_file) )
                    {
                        Storage::delete($target_path . '/' . $v);
                    }
                }
                
                if (empty($ArGal)) {
                   $input['about_images'] = '';
                }
            }
        }
        //END
        if (!empty($ArGal)) {
            $ArGal = array_values($ArGal);
            $input['about_images'] = implode(',', $ArGal);
        }
        //Slider images...
        $ArSlider = array();
        if (!empty($request->files) && $request->hasFile('slider'))
        {
            $files = $request->file('slider');

            // *********** //
            // Upload File //
            // *********** //
            
           
            if (!empty($files)) {
                //$filename = 'member-'.$file->getClientOriginalName();
                foreach ($files as $K => $file) {
                   $filename = 'slider-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($target_path, $filename);
                    $ArSlider[] = $filename;
                }

                $Rs3 =  $model; //Event::where(['id' => $input['id'] ])->first();    

                if(!empty($Rs3->slider_images)){
                    $X = explode(',', $Rs3->slider_images );
                    $ArSlider = array_values(array_merge( $ArSlider, $X ));
                }
            }
        }
        // slider delete 
        if( !empty($input['slider_chk_del']) ){
            $Rs3 =  $model;   
            
            if(!empty($Rs3->slider_images)){
                $X = explode(',', $Rs3->slider_images );
                $ArSlider = array_values(array_merge( $ArSlider, $X ));
            }
            if(!empty($input['slider_chk_del'])){
                foreach( $input['slider_chk_del'] as $k => $v ){
                    
                    if (($key = array_search($v, $ArSlider)) !== false) {
                        unset( $ArSlider[$key] );
                    }

                    $old_file = public_path() . '/storage/home/'.$v;
                    if (file_exists($old_file) )
                    {
                        Storage::delete($target_path . '/' . $v);
                    }
                }
            }
        }
        //END
        if (!empty($ArSlider)) {
            $ArSlider = array_values($ArSlider);
            $input['slider_images'] = implode(',', $ArSlider);
        }

        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);
        $data = array();
        $data['item'] = GeneralSetting::where('id',1)->first();
        // dd($data);
        return redirect()->route('admin.general-settings');
    }

    
}
