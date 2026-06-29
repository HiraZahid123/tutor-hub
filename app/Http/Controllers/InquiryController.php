<?php

namespace App\Http\Controllers;

use App\Models\TutorInquiry;
use App\Models\TutorRegistration;
use App\Mail\TutorHireInquiryReceived;
use App\Mail\StudentHireInquiryConfirmation;
use App\Mail\InquiryStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutor_registrations,id',
            'hiring_subjects' => 'required|array|min:1',
            'hiring_type' => 'required|string',
            'request_message' => 'nullable|string|max:2000',
        ]);
        
        if (\App\Models\Booking::hasUnpaidSessions(Auth::id())) {
            return back()->with('error', 'Please settle your pending payments for previous sessions before sending a new hire request.');
        }

        if (!Auth::check()) {
            return back()->with('error', 'You must be logged in as a student to send a hire request.');
        }

        // 2. Check for existing pending inquiry to prevent spam
        $exists = TutorInquiry::where('student_id', Auth::id())
            ->where('tutor_id', $request->tutor_id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have a pending hire request for this tutor.');
        }

        $inquiry = TutorInquiry::create([
            'student_id' => Auth::id(),
            'tutor_id' => $request->tutor_id,
            'subjects' => $request->hiring_subjects,
            'hiring_type' => $request->hiring_type,
            'message' => $request->request_message,
            'status' => 'pending',
        ]);

        // 4. Send Notifications
        try {
            $tutor = TutorRegistration::findOrFail($request->tutor_id);
            Mail::to($tutor->email)->send(new TutorHireInquiryReceived($inquiry));
            Mail::to(Auth::user()->email)->send(new StudentHireInquiryConfirmation($inquiry));
        } catch (\Exception $e) {
            // Log error but don't fail for the user
            \Log::error('Mail Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your hire request has been sent to the tutor successfully!');
    }

    public function updateStatus(Request $request, TutorInquiry $inquiry)
    {
        // 1. Ensure the tutor owns this inquiry
        $registration = TutorRegistration::where('user_id', Auth::id())->first();
        if (!$registration || $inquiry->tutor_id != $registration->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // 2. Validate input
        $request->validate(['status' => 'required|in:confirmed,rejected']);

        // 3. Update status
        // If confirmed by tutor, we move directly to 'hired' status
        $finalStatus = $request->status === 'confirmed' ? 'hired' : 'rejected';
        $inquiry->update(['status' => $finalStatus]);

        // 4. Send Notification to Student
        try {
            Mail::to($inquiry->student->email)->send(new InquiryStatusUpdated($inquiry));
        } catch (\Exception $e) {
            \Log::error('Status Notification Error: ' . $e->getMessage());
        }

        $msg = $finalStatus === 'hired' ? 'Success! You have accepted the student and are now officially hired.' : 'Request declined.';
        return back()->with('success', $msg);
    }
    public function pendingCount()
    {
        $user = Auth::user();
        if ($user->role !== 'tutor') {
            return response()->json(['count' => 0]);
        }

        $registration = TutorRegistration::where('user_id', $user->id)->first();
        if (!$registration) {
            return response()->json(['count' => 0]);
        }

        $count = TutorInquiry::where('tutor_id', $registration->id)
            ->where('status', 'pending')
            ->count();

        return response()->json(['count' => $count]);
    }
}
