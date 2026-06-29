<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewInquiryAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Contact Inquiry Received - TutorHub');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-inquiry-alert');
    }
}
