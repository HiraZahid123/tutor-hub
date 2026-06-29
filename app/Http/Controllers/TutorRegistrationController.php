<?php

namespace App\Http\Controllers;

use App\Mail\NewTutorApplicationAlert;
use App\Models\SubjectCategory;
use App\Models\TutorRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TutorRegistrationController extends Controller
{
    /**
     * Show the multi-step registration form.
     * Restricted to authenticated tutors.
     */
    public function create()
    {
        $user = Auth::user();

        // Security Check: Only the 'tutor' role can apply
        if ($user->role !== 'tutor') {
            return redirect('/')->with('error', 'Only logged-in users with a tutor account can apply.');
        }

        // Check if application already exists
        $existing = TutorRegistration::where('user_id', $user->id)->first();
        if ($existing) {
            return redirect('/tutor/dashboard')->with('info', 'You have already submitted an application.');
        }

        $categories = SubjectCategory::with('subjects')->where('is_active', true)->orderBy('order')->get();
        return view('pages.register-tutor', compact('categories'));
    }

    /**
     * Store the comprehensive tutor application.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Role Check redundantly
        if ($user->role !== 'tutor') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            // Step 1: Basic Info
            'country' => 'required|string|max:255',
            'timezone' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'tutoring_preference' => 'required|in:online,home,both',
            'hourly_rate' => 'required|numeric|min:0',

            // Step 2: Career
            'program' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'study_year_from' => 'required|string|max:4',
            'study_year_to' => 'required|string|max:10',
            'resume' => 'required|mimes:pdf|max:5120',

            // Step 3: About Me
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'required|string|min:50',
            'teaching_experience' => 'required|string|min:30',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:subjects,id',
        ]);

        // Handle File Uploads
        $profileImagePath = $request->file('profile_image')->store('profiles', 'public');
        $resumePath = $request->file('resume')->store('resumes', 'public');

        // Update user profile image if not set
        if (!$user->profile_image) {
            $user->update(['profile_image' => $profileImagePath]);
        }

        // Prepare Data
        $tutorData = [
            'user_id' => $user->id,
            'name' => $user->name,   // Taken from logged-in user
            'email' => $user->email, // Taken from logged-in user
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'timezone' => $validated['timezone'],
            'gender' => $validated['gender'],
            'tutoring_preference' => $validated['tutoring_preference'],
            'is_online' => in_array($validated['tutoring_preference'], ['online', 'both']),
            'is_home' => in_array($validated['tutoring_preference'], ['home', 'both']),
            'hourly_rate' => $validated['hourly_rate'],
            'program' => $validated['program'],
            'major' => $validated['major'],
            'university' => $validated['university'],
            'study_year_from' => $validated['study_year_from'],
            'study_year_to' => $validated['study_year_to'],
            'resume_path' => $resumePath,
            'profile_image' => $profileImagePath,
            'bio' => $validated['bio'],
            'teaching_experience' => $validated['teaching_experience'],
            'status' => 'pending',
        ];

        // Create Registration Record
        $tutor = TutorRegistration::create($tutorData);

        // Sync Selected Subjects
        $tutor->subjects()->sync($validated['subjects']);

        // Alert admin
        try {
            Mail::to(config('mail.from.address', 'admin@tutorhub.com'))->send(new NewTutorApplicationAlert($tutor));
        } catch (\Exception $e) {
            // Log or ignore mail errors to not disrupt user experience
        }

        return redirect('/tutor/dashboard')->with('success', 'Your application as a tutor has been submitted successfully!');
    }
}
