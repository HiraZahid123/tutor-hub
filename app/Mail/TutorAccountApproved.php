<?php

namespace App\Mail;

use App\Models\TutorRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TutorAccountApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TutorRegistration $tutor) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Tutor Account Has Been Approved! - TutorHub');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.tutor-approved');
    }
}
