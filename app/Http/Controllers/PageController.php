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
        // 1. Load static featured tutors from the file
        $featuredPath = app_path('Http/Controllers/featured_tutors.php');
        $featuredTutors = file_exists($featuredPath) ? require $featuredPath : [];

        // Shift static tutor IDs to avoid conflict with database tutor IDs (which start at 1)
        foreach ($featuredTutors as &$ft) {
            $ft['id'] = (int)$ft['id'] + 1000;
        }
        unset($ft);

        // 2. Fetch approved database tutors
        $dbTutors = TutorRegistration::where('is_approved', true)
            ->with('subjects')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Map database tutors to the exact same array structure
        $countryNames = [
            'PK' => 'Pakistan', 'AE' => 'UAE', 'SA' => 'Saudi Arabia', 'QA' => 'Qatar', 'KW' => 'Kuwait',
            'BH' => 'Bahrain', 'OM' => 'Oman', 'JO' => 'Jordan', 'EG' => 'Egypt', 'TR' => 'Turkey',
            'IN' => 'India', 'BD' => 'Bangladesh', 'LK' => 'Sri Lanka', 'MY' => 'Malaysia', 'SG' => 'Singapore',
            'ID' => 'Indonesia', 'PH' => 'Philippines', 'AF' => 'Afghanistan', 'IR' => 'Iran', 'IQ' => 'Iraq',
            'YE' => 'Yemen', 'NG' => 'Nigeria', 'KE' => 'Kenya', 'ZA' => 'South Africa', 'GH' => 'Ghana',
            'TZ' => 'Tanzania', 'CA' => 'Canada', 'AU' => 'Australia', 'NZ' => 'New Zealand', 'DE' => 'Germany',
            'FR' => 'France', 'NL' => 'Netherlands',
        ];

        $mappedTutors = [];
        foreach ($dbTutors as $tutor) {
            $city = 'Lahore';
            $area = 'Johar Town';

            if (strtolower($tutor->country) === 'pk') {
                $searchString = strtolower($tutor->university . ' ' . $tutor->bio . ' ' . $tutor->teaching_experience);
                if (str_contains($searchString, 'karachi')) {
                    $city = 'Karachi';
                    $area = 'DHA Karachi';
                } elseif (str_contains($searchString, 'islamabad') || str_contains($searchString, 'rawalpindi')) {
                    $city = 'Islamabad';
                    $area = 'F-7';
                }
            } else {
                $city = $countryNames[$tutor->country] ?? $tutor->country;
                $area = 'Central';
            }

            $subjectNames = $tutor->subjects->pluck('name')->toArray();
            $subjectsString = strtolower(implode('|', $subjectNames));
            $subjectTags = array_slice($subjectNames, 0, 3);

            $experience = max(1, date('Y') - (int)$tutor->study_year_from);
            
            $words = explode(' ', trim($tutor->name));
            $initials = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));

            $ratingVal = round($tutor->reviews_avg_rating ?? $tutor->rating ?? 5.0, 1);
            $reviewCountVal = (int)($tutor->reviews_count ?? 0);

            $mappedTutors[] = [
                'id'            => (int)$tutor->id,
                'name'          => $tutor->name,
                'qualification' => $tutor->program . ' in ' . $tutor->major . ', ' . $tutor->university,
                'bio'           => $tutor->bio,
                'subjects'      => $subjectsString,
                'subject_tags'  => $subjectTags,
                'experience'    => $experience,
                'affiliation'   => $tutor->university,
                'country'       => $countryNames[$tutor->country] ?? $tutor->country,
                'city'          => $city,
                'area'          => $area,
                'initials'      => $initials,
                'bg'            => '#' . substr(md5($tutor->name), 0, 6),
                'photo'         => $tutor->profile_image ? 'storage/' . $tutor->profile_image : null,
                'sharpen'       => false,
                'rating'        => $ratingVal,
                'review_count'  => $reviewCountVal,
            ];
        }

        // 4. Only show featured static tutors on the homepage, not database tutors
        $tutors = $featuredTutors;

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
        // 1. Load static featured tutors from the file
        $featuredPath = app_path('Http/Controllers/featured_tutors.php');
        $featuredTutors = file_exists($featuredPath) ? require $featuredPath : [];

        // Shift static tutor IDs to avoid conflict with database tutor IDs (which start at 1)
        foreach ($featuredTutors as &$ft) {
            $ft['id'] = (int)$ft['id'] + 1000;
        }
        unset($ft);

        // Admin-approved tutors (from "Apply as a Tutor" requests) are intentionally kept off this
        // page and off the homepage. They only appear on the dedicated tutors directory page
        // (see tutorsDirectory()) once an admin approves them.
        $tutors = $featuredTutors;

        $subjects = Subject::orderBy('name')->get();

        return view('pages.for-students', compact('tutors', 'subjects'));
    }

    /**
     * Directory of admin-approved tutors only (from the "Apply as a Tutor" request flow).
     * Kept as a separate page from the homepage and the for-students page.
     */
    public function tutorsDirectory(Request $request)
    {
        $query = TutorRegistration::where('is_approved', true)
            ->with('subjects')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search query q
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('bio', 'LIKE', '%' . $search . '%')
                  ->orWhere('university', 'LIKE', '%' . $search . '%')
                  ->orWhere('program', 'LIKE', '%' . $search . '%')
                  ->orWhere('major', 'LIKE', '%' . $search . '%')
                  ->orWhere('teaching_experience', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('subjects', function($sub) use ($search) {
                      $sub->where('subjects.name', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Subject filter
        if ($request->filled('subject')) {
            $subjectVal = $request->subject;
            $query->whereHas('subjects', function($q) use ($subjectVal) {
                $q->where('subjects.name', 'LIKE', '%' . $subjectVal . '%')
                  ->orWhere('subjects.id', $subjectVal);
            });
        }

        // City filter (derived city logic)
        if ($request->filled('city')) {
            $cityVal = strtolower($request->city);
            if ($cityVal === 'karachi') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%karachi%')
                      ->orWhere('bio', 'LIKE', '%karachi%')
                      ->orWhere('teaching_experience', 'LIKE', '%karachi%');
                });
            } elseif (in_array($cityVal, ['islamabad', 'rawalpindi'])) {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%islamabad%')
                      ->orWhere('bio', 'LIKE', '%islamabad%')
                      ->orWhere('teaching_experience', 'LIKE', '%islamabad%')
                      ->orWhere('university', 'LIKE', '%rawalpindi%')
                      ->orWhere('bio', 'LIKE', '%rawalpindi%')
                      ->orWhere('teaching_experience', 'LIKE', '%rawalpindi%');
                });
            } elseif ($cityVal === 'lahore') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%lahore%')
                      ->orWhere('bio', 'LIKE', '%lahore%')
                      ->orWhere('teaching_experience', 'LIKE', '%lahore%')
                      ->orWhere(function($sq) {
                          $sq->where('university', 'NOT LIKE', '%karachi%')
                            ->where('university', 'NOT LIKE', '%islamabad%')
                            ->where('university', 'NOT LIKE', '%rawalpindi%')
                            ->where('bio', 'NOT LIKE', '%karachi%')
                            ->where('bio', 'NOT LIKE', '%islamabad%')
                            ->where('bio', 'NOT LIKE', '%rawalpindi%')
                            ->where('teaching_experience', 'NOT LIKE', '%karachi%')
                            ->where('teaching_experience', 'NOT LIKE', '%islamabad%')
                            ->where('teaching_experience', 'NOT LIKE', '%rawalpindi%');
                      });
                });
            } else {
                $query->where(function($q) use ($cityVal) {
                    $q->where('university', 'LIKE', '%' . $cityVal . '%')
                      ->orWhere('bio', 'LIKE', '%' . $cityVal . '%')
                      ->orWhere('teaching_experience', 'LIKE', '%' . $cityVal . '%');
                });
            }
        }

        if ($request->filled('country')) {
            $query->where('country', 'LIKE', '%' . $request->country . '%');
        }

        // Gender filter
        if ($request->filled('gender') && $request->gender !== 'both' && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // Tutoring preference/type
        if ($request->filled('tutoring_preference') && $request->tutoring_preference !== 'both') {
            if ($request->tutoring_preference === 'online') {
                $query->where('is_online', true);
            } elseif ($request->tutoring_preference === 'home') {
                $query->where('is_home', true);
            }
        } elseif ($request->filled('tutoring_type') && $request->tutoring_type !== 'both') {
            if ($request->tutoring_type === 'online') {
                $query->where('is_online', true);
            } elseif ($request->tutoring_type === 'home') {
                $query->where('is_home', true);
            }
        } else {
            // Fallback to legacy parameters
            if ($request->has('is_online') && !$request->has('is_home')) {
                $query->where('is_online', true);
            } elseif (!$request->has('is_online') && $request->has('is_home')) {
                $query->where('is_home', true);
            }
        }

        $dbTutors = $query->orderBy('created_at', 'desc')->get();

        $countryNames = [
            'PK' => 'Pakistan', 'AE' => 'UAE', 'SA' => 'Saudi Arabia', 'QA' => 'Qatar', 'KW' => 'Kuwait',
            'BH' => 'Bahrain', 'OM' => 'Oman', 'JO' => 'Jordan', 'EG' => 'Egypt', 'TR' => 'Turkey',
            'IN' => 'India', 'BD' => 'Bangladesh', 'LK' => 'Sri Lanka', 'MY' => 'Malaysia', 'SG' => 'Singapore',
            'ID' => 'Indonesia', 'PH' => 'Philippines', 'AF' => 'Afghanistan', 'IR' => 'Iran', 'IQ' => 'Iraq',
            'YE' => 'Yemen', 'NG' => 'Nigeria', 'KE' => 'Kenya', 'ZA' => 'South Africa', 'GH' => 'Ghana',
            'TZ' => 'Tanzania', 'CA' => 'Canada', 'AU' => 'Australia', 'NZ' => 'New Zealand', 'DE' => 'Germany',
            'FR' => 'France', 'NL' => 'Netherlands',
        ];

        $tutors = [];
        foreach ($dbTutors as $tutor) {
            $city = 'Lahore';
            $area = 'Johar Town';

            if (strtolower($tutor->country) === 'pk') {
                $searchString = strtolower($tutor->university . ' ' . $tutor->bio . ' ' . $tutor->teaching_experience);
                if (str_contains($searchString, 'karachi')) {
                    $city = 'Karachi';
                    $area = 'DHA Karachi';
                } elseif (str_contains($searchString, 'islamabad') || str_contains($searchString, 'rawalpindi')) {
                    $city = 'Islamabad';
                    $area = 'F-7';
                }
            } else {
                $city = $countryNames[$tutor->country] ?? $tutor->country;
                $area = 'Central';
            }

            $subjectNames = $tutor->subjects->pluck('name')->toArray();
            $subjectsString = strtolower(implode('|', $subjectNames));
            $subjectTags = array_slice($subjectNames, 0, 3);

            $experience = max(1, date('Y') - (int)$tutor->study_year_from);

            $words = explode(' ', trim($tutor->name));
            $initials = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));

            $ratingVal = round($tutor->reviews_avg_rating ?? $tutor->rating ?? 5.0, 1);
            $reviewCountVal = (int)($tutor->reviews_count ?? 0);

            $tutors[] = [
                'id'            => (int)$tutor->id,
                'name'          => $tutor->name,
                'qualification' => $tutor->program . ' in ' . $tutor->major . ', ' . $tutor->university,
                'bio'           => $tutor->bio,
                'subjects'      => $subjectsString,
                'subject_tags'  => $subjectTags,
                'experience'    => $experience,
                'affiliation'   => $tutor->university,
                'country'       => $countryNames[$tutor->country] ?? $tutor->country,
                'city'          => $city,
                'area'          => $area,
                'initials'      => $initials,
                'bg'            => '#' . substr(md5($tutor->name), 0, 6),
                'photo'         => $tutor->profile_image ? 'storage/' . $tutor->profile_image : null,
                'sharpen'       => false,
                'rating'        => $ratingVal,
                'review_count'  => $reviewCountVal,
            ];
        }

        $subjects = Subject::orderBy('name')->get();

        return view('pages.tutors-directory', compact('tutors', 'subjects'));
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
