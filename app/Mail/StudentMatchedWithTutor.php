<?php

namespace App\Mail;

use App\Models\StudentRequest;
use App\Models\TutorRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentMatchedWithTutor extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public StudentRequest $studentRequest,
        public TutorRegistration $tutor
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'You Have Been Matched! - TutorHub');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.student-matched');
    }
}
