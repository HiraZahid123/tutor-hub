<?php

namespace App\Http\Controllers;

use App\Models\StudentRequest;
use App\Models\TutorInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    public function dashboard()
    {
        $requests = \App\Models\StudentRequest::with('assignedTutor')->where('user_id', Auth::id())->latest()->get();
        $inquiries = \App\Models\TutorInquiry::with('tutor')->where('student_id', Auth::id())->where('status', 'hired')->get();
        $bookings = \App\Models\Booking::with('tutor')->where('student_id', Auth::id())->latest()->get();
        
        return view('student.dashboard', compact('requests', 'bookings', 'inquiries'));
    }

    public function learningRequests()
    {
        $requests = \App\Models\StudentRequest::with('assignedTutor')->where('user_id', Auth::id())->latest()->get();
        return view('student.learning-requests', compact('requests'));
    }

    public function editProfile()
    {
        return view('student.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('student.profile')->with('success', 'Your profile has been updated!');
    }

    public function showBooking($tutorId)
    {
        if (\App\Models\Booking::hasUnpaidSessions(Auth::id())) {
            return redirect()->route('student.dashboard')->with('error', 'Please settle your pending payments for previous sessions before booking a new one.');
        }

        $tutor = \App\Models\TutorRegistration::findOrFail($tutorId);
        return view('student.booking', compact('tutor'));
    }

    public function sentRequests()
    {
        $inquiries = TutorInquiry::with('tutor')->where('student_id', Auth::id())->latest()->paginate(10);
        return view('student.sent-requests', compact('inquiries'));
    }
}
