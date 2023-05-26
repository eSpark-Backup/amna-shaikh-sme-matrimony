<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
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


class SeoSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data=SeoSetting::get();
         //dd($data);
        return view('admin.seo.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SeoSetting  $seoSetting
     * @return \Illuminate\Http\Response
     */
    public function show(SeoSetting $seoSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeoSetting  $seoSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SeoSetting $seoSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeoSetting  $seoSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SeoSetting $seoSetting)
    {
        // $input = $request->all();
        // dd($input);
        $validator = Validator::make($request->all(), [
            'author' => ['required','string'],
            'seo_revisit' => ['required','integer'],
            'keywords' => ['required','string'],
            'description' => ['required','string']
        ]);
        if ($validator->fails())
        {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }
        $input = $request->all();
        $model = SeoSetting::findOrFail($input['id']);
        $flash_message = 'Seo Settings has been updated successfully.';
        $model->fill($input);
        $model->save();
        $request->session()->flash('flash_success', $flash_message);
        $data = array();
        $data=SeoSetting::get();
        // dd($data);
        //return view('admin.seo.index',compact('data'));
        return redirect('admin/seo-settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeoSetting  $seoSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SeoSetting $seoSetting)
    {
        //
    }
}
