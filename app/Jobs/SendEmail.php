<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200;
    public $tries = 1;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
         $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new SendMail();
        // Mail::send($email);
        // $test_email = 'lalit.kumawat0412@mailinator.com';
        // Mail::to($test_email)->send(new SendMail());

        // $email = new SendMail($this->details['email'],$this->details['subject'],$this->details['content'],$this->details['filename'],$this->details['lang'],$this->details['csv'],$this->details['social_links']);
        // Mail::to($this->details['email'])->send($email);
        // $email = $this->details['email'];
        // $subject = $this->details['subject'];
        // $filename = $this->details['filename'];
        // $pdf = $this->details['csv'];

        // \Mail::send('emails.template', ['content' => $this->details['content'], 'lang_arr' => $this->details['lang'], 'social_links' => $this->details['social_links'], 'heading' => $this->details['subject']], function ($message) use ($email, $subject, $pdf, $filename)
        //         {
        //             //$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        //             $message->from('info@smematrimony.com', 'SME Matrimony');
        //             $message->to($email);
        //             $message->subject($subject);
        //         });
    }
}
