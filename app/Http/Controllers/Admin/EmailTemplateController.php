<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;
use Hashids;
use Auth;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['email_templates'] = EmailTemplate::orderBy('created_at','DESC')->get();
        return view('admin.email-templates.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //access_denied();

        $data['email_template'] = new EmailTemplate();
        $data['action'] = "Add";
        return view('admin.email-templates.form')->with($data);
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
        $input['status'] = 1;

        if($input['action'] == 'Add')
        {
            $validator = Validator::make($request->all(), [
                'subject' => ['required','string','max:250'],
                /*'type' => ['required','string','max:250',Rule::unique('email_templates')],*/
                'content' => ['required','string'],
            ]);

            $model = new EmailTemplate();
            $input['type'] = str_replace(' ', '_', strtolower($input['type']) );
            $flash_message = 'Email Template has been created successfully.';
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'subject' => ['required','string','max:250'],
                /*'type' => ['max:250',Rule::unique('email_templates')->ignore($input['id'])],*/
                'content' => ['required','string'],
            ]);

            $model = EmailTemplate::findOrFail($input['id']);
            $flash_message = 'Email Template has been updated successfully.';
        }

        if ($validator->fails())
        {
            Session::flash('flash_danger', $validator->messages());
            return redirect()->back()->withInput();
        }

        

        $model->fill($input);
        $model->save();

        if ($input['action'] == 'Add') {
            $getAllUser = Member::where('status', '1')->orderBy('id', 'desc')->limit('17')->get();

            if (count($getAllUser)) {
                $email_template = EmailTemplate::findOrFail($model->id);

                foreach ($getAllUser as $key => $value) {
                    // ************************* //
                    // Send email To User
                    // ************************* //
                    $name = $value->first_name.' '.$value->last_name;
                    // $user = getUserName(Auth()->user()->first_name.' '.Auth()->user()->last_name);
                    // $profile_link = url('user/members/'.Auth()->user()->id);
                    $email = $value->email;
                    
                    
                    //$email_template = transformEmailTemplateModel($email_template,$lang);
                    $subject = $email_template->subject; 
                    $content = $email_template->content;
                    $search = array("{{name}}","{{app_name}}");
                    $replace = array($name,env('APP_NAME'));
                    $content  = str_replace($search,$replace,$content);
                    sendEmail($email, $subject, $content, '', '', 'en');
                }
            }
        }

        $request->session()->flash('flash_success', $flash_message);
        return redirect('admin/email-templates');
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
        $data['action'] = "Edit";
        $data['email_template'] = EmailTemplate::findOrFail($id);
        return view('admin.email-templates.form')->with($data);
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
        EmailTemplate::destroy($id);
        Session::flash('flash_success', 'Email Template has been deleted successfully.');
        return redirect('admin/email-templates');
    }
}
