<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class MicrositeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $url;
    public $password;
    public $type;
    public $micrositeName;
    public $isSaleStarted;
    public $startDate;

    public function __construct($email, $url, $password, $type, $micrositeName, $isSaleStarted, $startDate)
    {
        $this->email = $email;
        $this->url = $url;
        $this->password = $password;
        $this->type = $type;
        $this->micrositeName = $micrositeName;
        $this->isSaleStarted = $isSaleStarted;
        $this->startDate = $startDate;
    }

    public function build()
    {
        return $this->subject('Microsite Access Details')
                    ->view('admin.emails.microsite');
    }
}