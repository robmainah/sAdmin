<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestingMails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $resultData;

    public function __construct($value)
    {
        $this->resultData = $value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        //used for mpesa stk callback
        return $this->view('mail.test', ['resultData' => $this->resultData])->to("johntoto67@gmail.com");
    }
}
