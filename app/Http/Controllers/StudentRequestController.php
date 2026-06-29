<?php

namespace App\Http\Controllers;

use App\Mail\StudentRequestSubmitted;
use App\Models\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StudentRequestController extends Controller
{
    public function create()
    {
        $categories = \App\Models\SubjectCategory::with('subjects')->orderBy('order')->get();
        return view('pages.find-a-tutor', compact('categories'));
    }

    public function store(Request $request)
    {
        $isGuest = !Auth::check();

        $rules = [
            'city' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'subjects' => 'required|array|min:1',
            'tutoring_type' => 'required|string|in:online,home,both',
        ];

        if ($isGuest) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|string|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Security check for unpaid sessions if already logged in
        if (!$isGuest && \App\Models\Booking::hasUnpaidSessions(Auth::id())) {
            return back()->with('error', 'Please settle your pending payments for previous sessions before submitting a new tutor request.');
        }

        // 1. Handle Guest Registration
        if ($isGuest) {
            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'role' => 'student',
            ]);
            Auth::login($user);
        }

        $user = Auth::user();

        // 2. Create the Student Request
        $studentRequest = StudentRequest::create([
            'user_id' => $user->id,
            'student_name' => $user->name,
            'contact_method' => $user->email,
            'city' => $validated['city'],
            'grade' => $validated['grade'],
            'subject' => $validated['subjects'],
            'tutoring_type' => $validated['tutoring_type'],
        ]);

        // Send confirmation email
        try {
            Mail::to($user->email)->send(new StudentRequestSubmitted($studentRequest));
        } catch (\Exception $e) {
            // Log mail error
        }

        return redirect()->route('student.learning-requests')->with('success', 'Your tutor request has been submitted successfully and your account has been created!');
    }
}
