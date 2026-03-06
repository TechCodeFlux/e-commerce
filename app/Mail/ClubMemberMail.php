<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClubMemberMail extends Mailable
{
    use Queueable, SerializesModels;

    public $memberData;
    public $type; // create | update

    /**
     * Create a new message instance.
     */
    public function __construct($memberData, $type = 'create')
    {
        $this->memberData = $memberData;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->type === 'create'
                ? 'Club Member Account Created'
                : 'Club Member Account Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.emails.clubmemberaccount',
            with: [
                'memberData' => $this->memberData,
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