<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClubMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    public $type;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $password = null, $type = 'create')
    {
        $this->email = $email;
        $this->password = $password;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->type === 'create'
                ? 'Club Account Created'
                : 'Club Account Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.club.account',
            with: [
                'email' => $this->email,
                'password' => $this->password,
                'type' => $this->type,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}