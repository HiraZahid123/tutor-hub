<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Mail\SessionReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendSessionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send 24-hour reminders to tutors and students for upcoming confirmed sessions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting session reminders check...');

        // Find confirmed bookings starting in the next 24-25 hours
        // We use 25h buffer to catch sessions that might have been skipped in the last hourly run
        $bookings = Booking::with(['tutor', 'student'])
            ->where('status', 'confirmed')
            ->whereNull('reminder_sent_at')
            ->whereBetween('start_time', [
                Carbon::now(),
                Carbon::now()->addHours(24)
            ])
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No upcoming sessions requiring reminders.');
            return;
        }

        foreach ($bookings as $booking) {
            $this->info("Processing Session #{$booking->id} starting at {$booking->start_time}");

            try {
                // 1. Send to Tutor
                $tutorEmail = $booking->tutor->email ?? null;
                if ($tutorEmail && filter_var($tutorEmail, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($tutorEmail)->send(new SessionReminder($booking, $booking->tutor->name));
                    $this->line("   - Reminder sent to Tutor: {$tutorEmail}");
                } else if ($tutorEmail) {
                    $this->warn("   - Invalid Tutor Email: {$tutorEmail}");
                }

                // 2. Send to Student
                $studentEmail = $booking->student->email ?? null;
                $studentName = $booking->student->name ?? $booking->student_name;

                if ($studentEmail && filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($studentEmail)->send(new SessionReminder($booking, $studentName));
                    $this->line("   - Reminder sent to Student: {$studentEmail}");
                } else if ($studentEmail) {
                    $this->warn("   - Invalid Student Email: {$studentEmail}");
                }

                // 3. Mark as sent regardless of individual mail success (to avoid infinite loops on bad data)
                $booking->update(['reminder_sent_at' => Carbon::now()]);
                
            } catch (\Exception $e) {
                $this->error("   - Failed to process Session #{$booking->id}: " . $e->getMessage());
                // We mark it as sent anyway to prevent the command from getting stuck on this row in future runs
                $booking->update(['reminder_sent_at' => Carbon::now()]);
            }
        }

        $this->info('Session reminders completed successfully!');
    }
}
