<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\TutorAvailability;
use App\Models\TutorRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function index()
    {
        $tutor = TutorRegistration::where('user_id', Auth::id())->first();
        $availabilities = $tutor ? $tutor->availabilities : collect();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        
        return view('tutor.availability', compact('availabilities', 'days', 'tutor'));
    }

    public function store(Request $request)
    {
        $tutor = TutorRegistration::where('user_id', Auth::id())->firstOrFail();
        
        $request->validate([
            'slots' => 'required|array',
            'slots.*.day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'slots.*.start' => 'required',
            'slots.*.end' => 'required',
            'slot_duration' => 'required|integer|min:15',
        ]);

        // Clear existing and replace (simple for now)
        $tutor->availabilities()->delete();

        foreach ($request->slots as $slot) {
            $tutor->availabilities()->create([
                'day_of_week' => $slot['day'],
                'start_time' => $slot['start'],
                'end_time' => $slot['end'],
                'slot_duration' => $request->slot_duration,
            ]);
        }

        return back()->with('success', 'Availability updated successfully!');
    }
}
