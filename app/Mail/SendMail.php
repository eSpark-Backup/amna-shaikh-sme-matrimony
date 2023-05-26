<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $viewData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $subject, $content, $filename = '', $lang = 'en', $csv = '', $social_links = '')
    {
       
        $lang_file = public_path('i18n/translations/'.$lang.'.json');
        $lang_arr = json_decode(file_get_contents($lang_file),true);
        
        $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        
        $this->to($email);
        $this->subject($subject);
        $this->viewData = compact('content','lang_arr','social_links');

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.template');  
    }
}
