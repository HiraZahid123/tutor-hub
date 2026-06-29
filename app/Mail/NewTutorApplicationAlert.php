<?php

namespace App\Mail;

use App\Models\TutorRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTutorApplicationAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TutorRegistration $tutor) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Tutor Application Received - TutorHub');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-tutor-alert');
    }
}
