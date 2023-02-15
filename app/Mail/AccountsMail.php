<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $laman;
    //public $head;
    public $username;
    public $email;


    public function __construct($laman, $username, $email)
    {
        $this->laman = $laman;
        //$this->head = $head;
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from(env('MAIL_USERNAME'))
        ->view('activation')->with('laman', $this->laman)->with('username', $this->username)->with('email', $this->email);
    }
}
