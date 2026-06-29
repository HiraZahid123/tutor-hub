<?php

namespace App\Http\Controllers;

use App\Mail\TutorMatchedWithStudent;
use App\Mail\StudentMatchedWithTutor;
use App\Mail\TutorAccountApproved;
use App\Models\TutorInquiry;
use App\Models\StudentRequest;
use App\Models\TutorRegistration;
use App\Models\ContactMessage;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        $totalTutors = TutorRegistration::count();
        $totalStudents = StudentRequest::count(); // Total unique student leads
        
        // Active Matches: TutorInquiry (hired) + StudentRequest (matched)
        $activeMatches = TutorInquiry::where('status', 'hired')->count() + 
                         StudentRequest::where('status', 'matched')->count();
        
        // Pending Leads: TutorInquiry (pending) + StudentRequest (pending/reviewing)
        $pendingLeads = TutorInquiry::where('status', 'pending')->count() + 
                        StudentRequest::whereIn('status', ['pending', 'reviewing'])->count();

        return view('admin.dashboard', compact(
            'totalTutors', 
            'totalStudents', 
            'activeMatches', 
            'pendingLeads'
        ));
    }

    public function students()
    {
        $students = StudentRequest::with('assignedTutor')->orderBy('created_at', 'desc')->get();
        $approvedTutors = TutorRegistration::where('is_approved', true)->with('subjects')->get();
        return view('admin.students', compact('students', 'approvedTutors'));
    }

    public function assignTutor(Request $request, $id)
    {
        $request->validate(['tutor_id' => 'required|exists:tutor_registrations,id']);
        
        $studentRequest = StudentRequest::findOrFail($id);
        $studentRequest->update([
            'assigned_tutor_id' => $request->tutor_id,
            'status' => 'matched'
        ]);

        // Send match emails
        $tutor = TutorRegistration::findOrFail($request->tutor_id);
        Mail::to($studentRequest->contact_method)->send(new StudentMatchedWithTutor($studentRequest, $tutor));
        Mail::to($tutor->email)->send(new TutorMatchedWithStudent($studentRequest, $tutor));

        return back()->with('success', 'Tutor assigned successfully!');
    }

    public function updateStudentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewing,matched,closed'
        ]);

        $studentRequest = StudentRequest::findOrFail($id);
        $studentRequest->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function tutors(Request $request)
    {
        $query = TutorRegistration::orderBy('created_at', 'desc');
        
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        $tutors = $query->get();
        $subjects = Subject::orderBy('name')->get();
        return view('admin.tutors', compact('tutors', 'subjects'));
    }

    public function interviews()
    {
        $interviews = \App\Models\TutorRegistration::where('status', 'interviewing')
            ->whereNotNull('interview_at')
            ->orderBy('interview_at', 'asc')
            ->get();
            
        return view('admin.interviews', compact('interviews'));
    }

    public function editTutor($id)
    {
        $tutor = TutorRegistration::with('subjects')->findOrFail($id);
        $subjects = Subject::orderBy('name')->get();
        return view('admin.tutors-edit', compact('tutor', 'subjects'));
    }

    public function approveTutor(Request $request, $id)
    {
        $tutor = TutorRegistration::findOrFail($id);

        // 1. Ensure the tutor has an associated User account
        if (!$tutor->user_id) {
            $user = User::firstOrCreate(
                ['email' => $tutor->email],
                [
                    'name' => $tutor->name,
                    'password' => Hash::make(Str::random(12)),
                    'role' => 'tutor',
                ]
            );
            $tutor->update(['user_id' => $user->id]);
            $tutor->refresh();
        }

        // Validate basic update info (Admin can override most fields)
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'hourly_rate' => 'nullable|numeric',
            'status' => 'required|in:pending,interviewing,approved,rejected',
            'internal_notes' => 'nullable|string',
            'interview_at' => 'nullable|date',
            'program' => 'nullable|string',
            'major' => 'nullable|string',
            'university' => 'nullable|string',
            'bio' => 'nullable|string',
            'teaching_experience' => 'nullable|string',
            'tutoring_preference' => 'nullable|in:online,home,both',
        ]);

        // Specific derived booleans
        if (isset($data['tutoring_preference'])) {
            $data['is_online'] = in_array($data['tutoring_preference'], ['online', 'both']);
            $data['is_home'] = in_array($data['tutoring_preference'], ['home', 'both']);
        }

        $data['is_approved'] = ($data['status'] === 'approved');

        // Handle Profile Image Override by Admin
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = $path;
            if ($tutor->user) {
                $tutor->user->update(['profile_image' => $path]);
            }
        }

        $tutor->update($data);

        // Sync Name to User
        if ($tutor->user) {
            $tutor->user->update(['name' => $data['name']]);
        }

        // Notifications
        if ($data['status'] === 'approved' && $tutor->wasChanged('status')) {
            Mail::to($tutor->email)->send(new TutorAccountApproved($tutor));
        }

        if ($data['status'] === 'interviewing' && ($tutor->wasChanged('status') || $tutor->wasChanged('interview_at')) && $tutor->interview_at) {
            Mail::to($tutor->email)->send(new \App\Mail\TutorInterviewRequested($tutor));
        }

        return redirect()->route('admin.tutors')->with('success', 'Tutor updated successfully!');
    }

    public function destroyTutor($id)
    {
        $tutor = TutorRegistration::findOrFail($id);
        StudentRequest::where('assigned_tutor_id', $tutor->id)->update(['assigned_tutor_id' => null, 'status' => 'pending']);
        $tutor->delete();
        return back()->with('success', 'Tutor registration deleted successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function destroyStudent($id)
    {
        StudentRequest::findOrFail($id)->delete();
        return back()->with('success', 'Student request deleted successfully!');
    }

    public function destroyInquiry($id)
    {
        ContactMessage::findOrFail($id)->delete();
        return back()->with('success', 'Contact inquiry deleted successfully!');
    }

    public function destroyTutorInquiry($id)
    {
        TutorInquiry::findOrFail($id)->delete();
        return back()->with('success', 'Tutor hire lead deleted successfully!');
    }

    public function destroyBooking($id)
    {
        \App\Models\Booking::findOrFail($id)->delete();
        return back()->with('success', 'Booking deleted successfully!');
    }

    public function inquiries()
    {
        $inquiries = ContactMessage::orderBy('created_at', 'desc')->get();
        return view('admin.inquiries', compact('inquiries'));
    }

    public function bookings(Request $request)
    {
        $bookings = \App\Models\Booking::with(['tutor', 'student'])->orderBy('start_time', 'desc')->take(500)->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function payments()
    {
        $allBookings = \App\Models\Booking::whereIn('payment_status', ['paid', 'unpaid', 'failed'])
            ->where('status', '!=', 'cancelled')
            ->get();

        $totalRevenue = $allBookings->where('payment_status', 'paid')->sum('price_at_booking');
        $pendingSettlements = $allBookings->where('payment_status', 'unpaid')
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('price_at_booking');
        
        $totalTransactions = $allBookings->where('payment_status', 'paid')->count();

        $transactions = \App\Models\Booking::with(['tutor', 'student'])
            ->whereNotNull('payment_status')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.payments', compact('transactions', 'totalRevenue', 'pendingSettlements', 'totalTransactions'));
    }

    public function tutorInquiries()
    {
        $inquiries = TutorInquiry::with(['student', 'tutor'])->latest()->paginate(20);
        return view('admin.tutor-inquiries', compact('inquiries'));
    }

    public function matches()
    {
        // 1. Direct Hire Matches (Finalized in Chat)
        $directMatches = TutorInquiry::where('status', 'hired')
            ->with(['student', 'tutor'])
            ->latest()
            ->get();

        // 2. Manual Matches (Assigned by Admin)
        $adminMatches = StudentRequest::where('status', 'matched')
            ->with(['user', 'assignedTutor'])
            ->latest()
            ->get();

        return view('admin.matches', compact('directMatches', 'adminMatches'));
    }
    public function apiCounts()
    {
        return response()->json([
            'pendingStudents' => StudentRequest::whereIn('status', ['pending', 'reviewing'])->count(),
            'pendingTutors' => TutorRegistration::where('status', 'pending')->count(),
            'upcomingInterviews' => TutorRegistration::where('status', 'interviewing')->count(),
            'pendingHireLeads' => TutorInquiry::where('status', 'pending')->count(),
        ]);
    }
}
