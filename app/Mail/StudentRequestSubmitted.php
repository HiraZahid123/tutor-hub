<?php

namespace App\Mail;

use App\Models\StudentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentRequestSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public StudentRequest $studentRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Tutor Request Has Been Submitted - TutorHub');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.student-request-submitted');
    }
}
