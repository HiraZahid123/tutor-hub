<?php

namespace App\Mail;

use App\Models\TutorInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public TutorInquiry $inquiry) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $status = $this->inquiry->status === 'confirmed' ? 'Accepted' : 'Declined';
        return new Envelope(
            subject: '🔔 Update: Your Hire Request for ' . ($this->inquiry->tutor->name ?? 'a Tutor') . ' was ' . $status . '!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.inquiry-status-alert',
        );
    }
}
