<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TutorRegistration;
use Illuminate\Support\Facades\DB;

echo "Scanning for duplicate tutor registrations...\n";

// Find user_ids that have more than 1 registration
$duplicates = TutorRegistration::select('user_id', DB::raw('count(*) as count'))
    ->whereNotNull('user_id')
    ->groupBy('user_id')
    ->having('count', '>', 1)
    ->get();

if ($duplicates->isEmpty()) {
    echo "No duplicate tutor registrations found.\n";
    exit(0);
}

echo "Found " . $duplicates->count() . " users with duplicate profiles.\n\n";

foreach ($duplicates as $dup) {
    echo "Processing User ID: {$dup->user_id}\n";
    
    // Get all registrations for this user, sorted by ID ascending (keeping the oldest/first submission)
    $registrations = TutorRegistration::where('user_id', $dup->user_id)
        ->orderBy('id', 'asc')
        ->get();
    
    // Keep the first (oldest) one
    $primary = $registrations->shift();
    echo "  -> Keeping primary registration (ID: {$primary->id}, Status: {$primary->status}, Approved: " . ($primary->is_approved ? 'Yes' : 'No') . ", Name: {$primary->name})\n";
    
    // Delete the others
    foreach ($registrations as $extra) {
        echo "  -> Deleting duplicate registration (ID: {$extra->id}, Name: {$extra->name}, Created: {$extra->created_at})\n";
        
        try {
            DB::table('tutor_registration_subject')
                ->where('tutor_registration_id', $extra->id)
                ->delete();
            echo "     * Deleted subject pivot records for ID: {$extra->id}\n";
        } catch (\Exception $e) {
            echo "     * Warning: Could not delete pivot entries: " . $e->getMessage() . "\n";
        }
        
        $extra->delete();
        echo "     * Deleted registration record.\n";
    }
    echo "\n";
}

echo "Cleanup completed successfully!\n";
