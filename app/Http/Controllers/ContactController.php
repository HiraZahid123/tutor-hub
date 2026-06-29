<?php

namespace App\Http\Controllers;

use App\Mail\NewInquiryAlert;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $inquiry = ContactMessage::create($validated);

        // 1. Alert admin about the new inquiry
        try {
            Mail::send('emails.new-inquiry-alert', ['inquiry' => $inquiry], function ($message) use ($inquiry) {
                $message->to(config('mail.from.address'), 'TutorHub Admin')
                        ->replyTo($inquiry->email, $inquiry->name)
                        ->subject('📩 New Contact Inquiry: ' . $inquiry->name)
                        ->priority(3);
            });
        } catch (\Exception $e) {
            \Log::error('Admin contact mail failed: ' . $e->getMessage());
        }

        // 2. Send confirmation email to the person who submitted the form
        try {
            Mail::send('emails.contact-confirmation', ['inquiry' => $inquiry], function ($message) use ($inquiry) {
                $message->to($inquiry->email, $inquiry->name)
                        ->replyTo(config('mail.from.address'), 'TutorHub Support')
                        ->subject('✅ We received your message — TutorHub')
                        ->priority(3);
            });
        } catch (\Exception $e) {
            \Log::error('Contact confirmation mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent successfully!');
    }
}

