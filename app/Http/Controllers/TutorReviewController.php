<?php

namespace App\Http\Controllers;

use App\Models\TutorRegistration;
use App\Models\TutorReview;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutor_registrations,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $studentId = Auth::id();
        $tutorId = $request->tutor_id;

        // 1. Eligibility Check: Must have at least one naturally completed session (time passed) or manually completed
        $hasCompletedSession = Booking::where('student_id', $studentId)
            ->where('tutor_id', $tutorId)
            ->whereIn('status', ['confirmed', 'scheduled', 'completed'])
            ->where('end_time', '<', now())
            ->exists();

        if (!$hasCompletedSession) {
            return back()->with('error', 'You can only rate a tutor after completing at least one session with them.');
        }

        // 2. Uniqueness Check: One review per student-tutor pair
        $existingReview = TutorReview::where('student_id', $studentId)
            ->where('tutor_id', $tutorId)
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_verified_purchase' => true,
            ]);
            $msg = 'Your review has been updated!';
        } else {
            // Create new review
            TutorReview::create([
                'student_id' => $studentId,
                'tutor_id' => $tutorId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_verified_purchase' => true,
            ]);
            $msg = 'Thank you for your review!';
        }

        return back()->with('success', $msg);
    }
}
