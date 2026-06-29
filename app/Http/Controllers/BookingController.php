<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TutorAvailability;
use App\Models\TutorRegistration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function availableSlots(Request $request, $tutor_id)
    {
        try {
            $request->validate(['date' => 'required|date']);
            $date = Carbon::parse($request->date);
            $dayOfWeek = strtolower($date->format('l'));
            
            $availabilities = TutorAvailability::where('tutor_id', $tutor_id)
                ->where('day_of_week', $dayOfWeek)
                ->get();

            $existingBookings = Booking::where('tutor_id', $tutor_id)
                ->whereDate('start_time', $date)
                ->where('status', '!=', 'cancelled')
                ->orderBy('start_time')
                ->get();

            // Create initial free blocks from availability
            $freeBlocks = [];
            foreach ($availabilities as $avail) {
                // Ensure valid time parses, we just need H:i
                $freeBlocks[] = [
                    'start' => Carbon::parse($date->format('Y-m-d') . ' ' . $avail->start_time),
                    'end' => Carbon::parse($date->format('Y-m-d') . ' ' . $avail->end_time)
                ];
            }

            // Merge overlapping free blocks in case tutor submitted messy availability
            usort($freeBlocks, fn($a, $b) => $a['start'] <=> $b['start']);
            $mergedFree = [];
            foreach ($freeBlocks as $block) {
                if (empty($mergedFree)) {
                    $mergedFree[] = $block;
                } else {
                    $last = &$mergedFree[count($mergedFree) - 1];
                    if ($block['start'] <= $last['end']) {
                        $last['end'] = max($last['end'], $block['end']);
                    } else {
                        $mergedFree[] = $block;
                    }
                }
            }
            $freeBlocks = $mergedFree;

            // Subtract bookings
            foreach ($existingBookings as $booking) {
                $bStart = $booking->start_time;
                $bEnd = $booking->end_time;
                
                $newFree = [];
                foreach ($freeBlocks as $fb) {
                    // booking is entirely outside this free block
                    if ($bEnd <= $fb['start'] || $bStart >= $fb['end']) {
                        $newFree[] = $fb;
                        continue;
                    }
                    
                    // booking overlaps, slice the block
                    if ($fb['start'] < $bStart) {
                        $newFree[] = ['start' => $fb['start'], 'end' => $bStart];
                    }
                    if ($bEnd < $fb['end']) {
                        $newFree[] = ['start' => $bEnd, 'end' => $fb['end']];
                    }
                }
                $freeBlocks = $newFree;
            }

            // Format for frontend
            $slots = [];
            foreach ($freeBlocks as $fb) {
                // Ignore tiny blocks less than 15 minutes to avoid weird UI issues
                if ($fb['start']->diffInMinutes($fb['end']) >= 15) {
                    $slots[] = [
                        'start' => $fb['start']->format('H:i'),
                        'end' => $fb['end']->format('H:i'),
                        'formatted' => $fb['start']->format('h:i A') . ' - ' . $fb['end']->format('h:i A'),
                    ];
                }
            }

            return response()->json(['blocks' => $slots, 'hourly_rate' => TutorRegistration::find($tutor_id)->hourly_rate]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function book(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutor_registrations,id',
            'date' => 'required|date',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',
            'student_name' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if (Booking::hasUnpaidSessions(\Illuminate\Support\Facades\Auth::id())) {
            return response()->json(['success' => false, 'message' => 'Please settle your pending payments for previous sessions before booking a new one.'], 422);
        }

        $tutor = TutorRegistration::findOrFail($request->tutor_id);
        $start = Carbon::parse($request->date . ' ' . $request->start);
        $end = Carbon::parse($request->date . ' ' . $request->end);

        // Verify collision with other bookings
        $collision = Booking::where('tutor_id', $tutor->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    // Start of new overlaps existing
                    $q->where('start_time', '<=', $start)->where('end_time', '>', $start);
                })->orWhere(function ($q) use ($start, $end) {
                    // End of new overlaps existing
                    $q->where('start_time', '<', $end)->where('end_time', '>=', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    // New completely envelopes existing
                    $q->where('start_time', '>=', $start)->where('end_time', '<=', $end);
                });
            })
            ->exists();

        if ($collision) {
            return response()->json(['success' => false, 'message' => 'The selected time conflicts with an existing booking.'], 422);
        }

        // Trial Logic: Check if this is the first session between this student and tutor
        $isTrial = !Booking::where('tutor_id', $tutor->id)
            ->where('student_id', \Illuminate\Support\Facades\Auth::id())
            ->where('status', '!=', 'cancelled')
            ->exists();

        // Calculate dynamic prorated price
        $durationMinutes = $start->diffInMinutes($end);
        $price = $isTrial ? 0 : round(($durationMinutes / 60) * $tutor->hourly_rate, 2);

        $booking = Booking::create([
            'tutor_id' => $tutor->id,
            'student_id' => \Illuminate\Support\Facades\Auth::id(),
            'student_name' => $request->student_name,
            'start_time' => $start,
            'end_time' => $end,
            'price_at_booking' => $price,
            'is_trial' => $isTrial,
            'duration_extension_minutes' => 0, // Removed the 10 min free extension
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json(['success' => true, 'booking' => $booking]);
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Ensure the tutor owns this booking
        $tutorRegistration = TutorRegistration::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
        if (!$tutorRegistration || $booking->tutor_id != $tutorRegistration->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
            // Allow matching length 5 (H:i) or length 8 (H:i:s) dynamically via regex
            'end' => ['nullable', 'string', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
        ]);

        $updates = ['status' => $request->status];

        // If the tutor is confirming and providing a new end time (adjusting the session)
        if ($request->status === 'confirmed' && $request->has('end')) {
            $newEnd = Carbon::parse($booking->start_time->format('Y-m-d') . ' ' . $request->end);
            
            // Basic validation
            if ($newEnd > $booking->start_time) {
                // Ensure no conflict with the lowered duration? Since it's a subset or extension,
                // ideally they are shrinking it, but let's just allow it for now.
                $updates['end_time'] = $newEnd;

                // Recalculate price
                if (!$booking->is_trial) {
                    $durationMinutes = $booking->start_time->diffInMinutes($newEnd);
                    $updates['price_at_booking'] = round(($durationMinutes / 60) * $tutorRegistration->hourly_rate, 2);
                }
            }
        }

        $booking->update($updates);

        return response()->json(['success' => true, 'booking' => $booking]);
    }
}
