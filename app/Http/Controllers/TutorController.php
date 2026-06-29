<?php

namespace App\Http\Controllers;

use App\Models\TutorRegistration;
use App\Models\TutorInquiry;
use App\Models\Subject;
use App\Models\SubjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TutorController extends Controller
{
    public function dashboard()
    {
        $registration = TutorRegistration::where('user_id', Auth::id())->first();
        $assignedStudents = collect();
        $upcomingBookings = collect();
        
        if ($registration) {
            $assignedStudents = \App\Models\StudentRequest::where('assigned_tutor_id', $registration->id)->latest()->get();
            $upcomingBookings = \App\Models\Booking::where('tutor_id', $registration->id)
                ->where('start_time', '>=', now())
                ->where('status', '!=', 'cancelled')
                ->orderBy('start_time', 'asc')
                ->take(5)
                ->get();

            // Calculate Inquiry Stats
            $allInquiries = TutorInquiry::where('tutor_id', $registration->id)->get();
            $totalInquiries = $allInquiries->count();
            $pendingInquiries = $allInquiries->where('status', 'pending')->count();
            $confirmedInquiries = $allInquiries->where('status', 'confirmed')->count();
            $acceptanceRate = $totalInquiries > 0 ? round(($confirmedInquiries / $totalInquiries) * 100) : 0;

            $stats = [
                'total' => $totalInquiries,
                'pending' => $pendingInquiries,
                'acceptance_rate' => $acceptanceRate
            ];
        } else {
            $stats = ['total' => 0, 'pending' => 0, 'acceptance_rate' => 0];
        }
        return view('tutor.dashboard', compact('registration', 'assignedStudents', 'upcomingBookings', 'stats'));
    }

    public function appointments()
    {
        $registration = TutorRegistration::where('user_id', Auth::id())->first();
        $bookings = $registration 
            ? \App\Models\Booking::where('tutor_id', $registration->id)->orderBy('start_time', 'desc')->paginate(15)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
        return view('tutor.appointments', compact('registration', 'bookings'));
    }

    public function payments()
    {
        $registration = TutorRegistration::where('user_id', Auth::id())->first();
        if (!$registration) {
            return redirect()->route('tutor.dashboard')->with('error', 'Please complete your profile first.');
        }

        $allBookings = \App\Models\Booking::where('tutor_id', $registration->id)
            ->where('status', '!=', 'cancelled')
            ->get();

        $totalEarned = $allBookings->where('payment_status', 'paid')->sum('price_at_booking');
        $pendingPayments = $allBookings->where('payment_status', 'unpaid')
            ->where('status', 'confirmed')
            ->sum('price_at_booking');

        $bookings = \App\Models\Booking::where('tutor_id', $registration->id)
            ->whereNotNull('payment_status')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('tutor.payments', compact('registration', 'bookings', 'totalEarned', 'pendingPayments'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $registration = TutorRegistration::with('subjects')->where('user_id', $user->id)->first();
        $categories = SubjectCategory::with('subjects')->where('is_active', true)->orderBy('order')->get();
        return view('tutor.profile', compact('user', 'registration', 'categories'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $registration = TutorRegistration::where('user_id', $user->id)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'tutoring_preference' => ['required', 'in:online,home,both'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'resume' => ['nullable', 'mimes:pdf', 'max:5120'],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*' => ['exists:subjects,id'],
        ]);

        // Update User
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Prepare Tutor Data
        $tutorData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $request->phone,
            'tutoring_preference' => $request->tutoring_preference,
            'is_online' => in_array($request->tutoring_preference, ['online', 'both']),
            'is_home' => in_array($request->tutoring_preference, ['home', 'both']),
        ];

        // Handle Image Upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $tutorData['profile_image'] = $path;
            
            // Sync user profile image too
            $user->update(['profile_image' => $path]);
        }

        // Handle Resume Upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $tutorData['resume_path'] = $path;
        }

        // Update or create tutor registration
        $tutor = TutorRegistration::updateOrCreate(
            ['user_id' => $user->id],
            $tutorData
        );

        // Sync Subjects
        $tutor->subjects()->sync($request->subjects);

        return redirect()->route('tutor.profile')->with('success', 'Profile updated successfully.');
    }

    public function inquiries()
    {
        $registration = TutorRegistration::where('user_id', Auth::id())->first();
        $inquiries = $registration 
            ? TutorInquiry::where('tutor_id', $registration->id)->latest()->paginate(10)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            
        return view('tutor.inquiries', compact('registration', 'inquiries'));
    }
}
