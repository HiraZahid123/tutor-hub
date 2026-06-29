<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\StudentRequest;
use App\Models\TutorRegistration;
use App\Models\TutorInquiry;

class AdminSidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $counts = [
            'pendingStudents' => StudentRequest::whereIn('status', ['pending', 'reviewing'])->count(),
            'pendingTutors' => TutorRegistration::where('status', 'pending')->count(),
            'upcomingInterviews' => TutorRegistration::where('status', 'interviewing')->count(),
            'pendingHireLeads' => TutorInquiry::where('status', 'pending')->count(),
        ];

        $view->with('adminSidebarCounts', $counts);
    }
}
