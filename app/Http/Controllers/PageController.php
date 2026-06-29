<?php

namespace App\Http\Controllers;

use App\Models\TutorRegistration;
use App\Models\Subject;
use App\Models\Booking;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $tutors = TutorRegistration::where('is_approved', true)
            ->has('reviews')
            ->with(['user', 'subjects.category', 'reviews' => function($q) {
                $q->whereNotNull('comment')->latest()->take(1);
            }])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(8)
            ->get();

        $categories = \App\Models\SubjectCategory::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // Dynamic counts for homepage
        $stats = [
            'tutors' => TutorRegistration::where('is_approved', true)->count(),
            'subjects' => Subject::count(),
            'students' => \App\Models\User::where('role', 'student')->count(), 
            'hours' => 2500 + (Booking::whereIn('status', ['confirmed', 'completed'])
                ->selectRaw('SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours')
                ->value('total_hours') ?? 0),
        ];

        return view('pages.home', compact('tutors', 'categories', 'stats'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function forStudents(Request $request)
    {
        $query = TutorRegistration::where('is_approved', true)
            ->with('subjects')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('subject')) {
            $query->whereHas('subjects', function($q) use ($request) {
                $q->where('subjects.name', $request->subject);
            });
        }

        if ($request->filled('country')) {
            $query->where('country', 'LIKE', '%' . $request->country . '%');
        }

        if ($request->has('is_online') && !$request->has('is_home')) {
            $query->where('is_online', true);
        } elseif (!$request->has('is_online') && $request->has('is_home')) {
            $query->where('is_home', true);
        }

        $tutors = $query->orderBy('created_at', 'desc')
            ->get();

        $subjects = Subject::orderBy('name')->get();

        return view('pages.for-students', compact('tutors', 'subjects'));
    }

    public function tutorPolicy()
    {
        return view('pages.tutor-policy');
    }

    public function tutoringFlow()
    {
        return view('pages.tutoring-flow');
    }

    public function tutorProfile($id)
    {
        $tutor = TutorRegistration::where('is_approved', true)
            ->with(['subjects.category'])
            ->findOrFail($id);
        $availabilities = \App\Models\TutorAvailability::where('tutor_id', $tutor->id)->get();
        return view('pages.tutor-profile', compact('tutor', 'availabilities'));
    }
}
