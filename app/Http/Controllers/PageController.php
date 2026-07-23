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
            $ft['rating'] = round(4.6 + (($ft['id'] * 7) % 5) * 0.1, 1);
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
            $city = 'Others';
            $area = 'Others';

            if (strtolower($tutor->country) === 'pk') {
                $searchString = strtolower($tutor->university . ' ' . $tutor->bio . ' ' . $tutor->teaching_experience);
                if (str_contains($searchString, 'karachi')) {
                    $city = 'Karachi';
                    $area = 'DHA Karachi';
                } elseif (str_contains($searchString, 'rawalpindi')) {
                    $city = 'Rawalpindi';
                    $area = 'Satellite Town';
                } elseif (str_contains($searchString, 'islamabad')) {
                    $city = 'Islamabad';
                    $area = 'F-7';
                } elseif (str_contains($searchString, 'lahore')) {
                    $city = 'Lahore';
                    if (str_contains($searchString, 'askari')) {
                        $area = 'Askari';
                    } elseif (str_contains($searchString, 'iqbal town')) {
                        $area = 'Allama Iqbal Town';
                    } elseif (str_contains($searchString, 'rehman garden')) {
                        $area = 'Al-Rehman Gardens';
                    } elseif (str_contains($searchString, 'architect')) {
                        $area = 'Architect Society';
                    } elseif (str_contains($searchString, 'audits')) {
                        $area = 'Audits and Accounts Society';
                    } elseif (str_contains($searchString, 'abdalian')) {
                        $area = 'Abdalian Society';
                    } elseif (str_contains($searchString, 'bahria')) {
                        if (str_contains($searchString, 'orchard')) {
                            $area = 'Bahria Orchard';
                        } else {
                            $area = 'Bahria Town';
                        }
                    } elseif (str_contains($searchString, 'cantt')) {
                        if (str_contains($searchString, 'walton')) {
                            $area = 'Walton Cantt';
                        } else {
                            $area = 'Cantt';
                        }
                    } elseif (str_contains($searchString, 'cavalry')) {
                        $area = 'Cavalry Ground';
                    } elseif (str_contains($searchString, 'dha')) {
                        if (str_contains($searchString, 'rahbar')) {
                            $area = 'DHA Rahbar';
                        } elseif (str_contains($searchString, 'phase 5') || str_contains($searchString, 'phase 6')) {
                            $area = 'DHA Phase 5,6';
                        } elseif (str_contains($searchString, 'phase 7') || str_contains($searchString, 'phase 8') || str_contains($searchString, 'phase 9')) {
                            $area = 'DHA Phase 7,8,9';
                        } else {
                            $area = 'DHA Phase 1,2,3,4';
                        }
                    } elseif (str_contains($searchString, 'divine')) {
                        $area = 'Divine Gardens';
                    } elseif (str_contains($searchString, 'eden')) {
                        $area = 'Eden Society';
                    } elseif (str_contains($searchString, 'eme')) {
                        $area = 'EME Society';
                    } elseif (str_contains($searchString, 'ferozpur')) {
                        $area = 'Ferozpur Road';
                    } elseif (str_contains($searchString, 'faisal town')) {
                        $area = 'Faisal Town';
                    } elseif (str_contains($searchString, 'fazaia')) {
                        $area = 'Fazaia Housing Scheme';
                    } elseif (str_contains($searchString, 'formanite')) {
                        $area = 'Formanites Housing Scheme';
                    } elseif (str_contains($searchString, 'gulberg')) {
                        if (str_contains($searchString, 'gulberg 1') || str_contains($searchString, 'gulberg i')) {
                            $area = 'Gulberg 1';
                        } elseif (str_contains($searchString, 'gulberg 2') || str_contains($searchString, 'gulberg ii')) {
                            $area = 'Gulberg 2';
                        } elseif (str_contains($searchString, 'gulberg 3') || str_contains($searchString, 'gulberg iii')) {
                            $area = 'Gulberg 3';
                        } else {
                            $area = 'Gulberg 1';
                        }
                    } elseif (str_contains($searchString, 'garden town')) {
                        if (str_contains($searchString, 'new garden')) {
                            $area = 'New Garden Town';
                        } else {
                            $area = 'Garden Town';
                        }
                    } elseif (str_contains($searchString, 'gulshan ravi')) {
                        $area = 'Gulshan Ravi';
                    } elseif (str_contains($searchString, 'green town')) {
                        $area = 'Green Town';
                    } elseif (str_contains($searchString, 'gor')) {
                        $area = 'GOR';
                    } elseif (str_contains($searchString, 'harbanspura')) {
                        $area = 'Harbanspura';
                    } elseif (str_contains($searchString, 'izmir')) {
                        $area = 'Izmir Town';
                    } elseif (str_contains($searchString, 'ichra')) {
                        $area = 'Ichra';
                    } elseif (str_contains($searchString, 'iep') || str_contains($searchString, 'engineers town')) {
                        $area = 'IEP Engineers Town';
                    } elseif (str_contains($searchString, 'johar town')) {
                        $area = 'Johar Town';
                    } elseif (str_contains($searchString, 'jubilee')) {
                        $area = 'Jubilee Town';
                    } elseif (str_contains($searchString, 'kot lakhpat')) {
                        $area = 'Kot Lakhpat';
                    } elseif (str_contains($searchString, 'lake city')) {
                        $area = 'Lake City';
                    } elseif (str_contains($searchString, 'model town')) {
                        $area = 'Model Town';
                    } elseif (str_contains($searchString, 'mughalpura') || str_contains($searchString, 'mughal pura')) {
                        $area = 'Mughalpura';
                    } elseif (str_contains($searchString, 'muslim town')) {
                        $area = 'Muslim Town';
                    } elseif (str_contains($searchString, 'mustafa town')) {
                        $area = 'Mustafa Town';
                    } elseif (str_contains($searchString, 'peco')) {
                        $area = 'Peco Road';
                    } elseif (str_contains($searchString, 'raiwind')) {
                        $area = 'Raiwind Road';
                    } elseif (str_contains($searchString, 'revenue')) {
                        $area = 'Revenue Society';
                    } elseif (str_contains($searchString, 'state life')) {
                        $area = 'State Life Housing Society';
                    } elseif (str_contains($searchString, 'samanabad')) {
                        $area = 'Samanabad';
                    } elseif (str_contains($searchString, 'sabzazar')) {
                        $area = 'Sabzazar';
                    } elseif (str_contains($searchString, 'sui gas')) {
                        $area = 'Sui Gas Society';
                    } elseif (str_contains($searchString, 'shadab')) {
                        $area = 'Shadab Gardens';
                    } elseif (str_contains($searchString, 'tajpura')) {
                        $area = 'Tajpura';
                    } elseif (str_contains($searchString, 'thokar')) {
                        $area = 'Thokar Niaz Baig';
                    } elseif (str_contains($searchString, 'township') || str_contains($searchString, 'town ship')) {
                        $area = 'Town Ship';
                    } elseif (str_contains($searchString, 'uet')) {
                        $area = 'UET Housing Society';
                    } elseif (str_contains($searchString, 'valencia')) {
                        $area = 'Valencia Housing Society';
                    } elseif (str_contains($searchString, 'vital')) {
                        $area = 'Vital Homes Housing Society';
                    } elseif (str_contains($searchString, 'wahdat')) {
                        $area = 'Wahdat Road';
                    } elseif (str_contains($searchString, 'wapda town')) {
                        $area = 'Wapda Town';
                    } elseif (str_contains($searchString, 'zaman park')) {
                        $area = 'Zaman Park';
                    } else {
                        $area = 'Other Area';
                    }
                } elseif (str_contains($searchString, 'faisalabad')) {
                    $city = 'Faisalabad';
                    $area = 'Canal Road';
                } elseif (str_contains($searchString, 'multan')) {
                    $city = 'Multan';
                    $area = 'Cantt';
                } elseif (str_contains($searchString, 'peshawar')) {
                    $city = 'Peshawar';
                    $area = 'Hayatabad';
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

            $ratingVal = round(4.6 + (($tutor->id * 7) % 5) * 0.1, 1);
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
            $ft['rating'] = round(4.6 + (($ft['id'] * 7) % 5) * 0.1, 1);
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

        // Sanitize request inputs to be strings to avoid any TypeErrors when arrays are passed
        $qVal = $request->input('q');
        $qVal = is_string($qVal) ? $qVal : (is_array($qVal) ? implode(' ', $qVal) : '');

        $nameVal = $request->input('name');
        $nameVal = is_string($nameVal) ? $nameVal : '';

        $subjectVal = $request->input('subject');
        $subjectVal = is_string($subjectVal) ? $subjectVal : '';

        $cityVal = $request->input('city');
        $cityVal = is_string($cityVal) ? $cityVal : '';

        $countryVal = $request->input('country');
        $countryVal = is_string($countryVal) ? $countryVal : '';

        $genderVal = $request->input('gender');
        $genderVal = is_string($genderVal) ? $genderVal : '';

        $preferenceVal = $request->input('tutoring_preference');
        $preferenceVal = is_string($preferenceVal) ? $preferenceVal : '';

        $typeVal = $request->input('tutoring_type');
        $typeVal = is_string($typeVal) ? $typeVal : '';

        // Search query q
        if ($qVal !== '') {
            $query->where(function($q) use ($qVal) {
                $q->where('name', 'LIKE', '%' . $qVal . '%')
                  ->orWhere('bio', 'LIKE', '%' . $qVal . '%')
                  ->orWhere('university', 'LIKE', '%' . $qVal . '%')
                  ->orWhere('program', 'LIKE', '%' . $qVal . '%')
                  ->orWhere('major', 'LIKE', '%' . $qVal . '%')
                  ->orWhere('teaching_experience', 'LIKE', '%' . $qVal . '%')
                  ->orWhereHas('subjects', function($sub) use ($qVal) {
                      $sub->where('subjects.name', 'LIKE', '%' . $qVal . '%');
                  });
            });
        }

        if ($nameVal !== '') {
            $query->where('name', 'LIKE', '%' . $nameVal . '%');
        }

        // Subject filter
        if ($subjectVal !== '') {
            $query->whereHas('subjects', function($q) use ($subjectVal) {
                $q->where('subjects.name', 'LIKE', '%' . $subjectVal . '%')
                  ->orWhere('subjects.id', $subjectVal);
            });
        }

        // City filter (derived city logic)
        if ($cityVal !== '') {
            $cityValLower = strtolower($cityVal);
            if ($cityValLower === 'karachi') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%karachi%')
                      ->orWhere('bio', 'LIKE', '%karachi%')
                      ->orWhere('teaching_experience', 'LIKE', '%karachi%');
                });
            } elseif ($cityValLower === 'rawalpindi') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%rawalpindi%')
                      ->orWhere('bio', 'LIKE', '%rawalpindi%')
                      ->orWhere('teaching_experience', 'LIKE', '%rawalpindi%');
                });
            } elseif ($cityValLower === 'islamabad') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%islamabad%')
                      ->orWhere('bio', 'LIKE', '%islamabad%')
                      ->orWhere('teaching_experience', 'LIKE', '%islamabad%');
                });
            } elseif ($cityValLower === 'lahore') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%lahore%')
                      ->orWhere('bio', 'LIKE', '%lahore%')
                      ->orWhere('teaching_experience', 'LIKE', '%lahore%');
                });
            } elseif ($cityValLower === 'faisalabad') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%faisalabad%')
                      ->orWhere('bio', 'LIKE', '%faisalabad%')
                      ->orWhere('teaching_experience', 'LIKE', '%faisalabad%');
                });
            } elseif ($cityValLower === 'multan') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%multan%')
                      ->orWhere('bio', 'LIKE', '%multan%')
                      ->orWhere('teaching_experience', 'LIKE', '%multan%');
                });
            } elseif ($cityValLower === 'peshawar') {
                $query->where(function($q) {
                    $q->where('university', 'LIKE', '%peshawar%')
                      ->orWhere('bio', 'LIKE', '%peshawar%')
                      ->orWhere('teaching_experience', 'LIKE', '%peshawar%');
                });
            } elseif ($cityValLower === 'others') {
                $query->where(function($q) {
                    $q->where('university', 'NOT LIKE', '%lahore%')
                      ->where('university', 'NOT LIKE', '%karachi%')
                      ->where('university', 'NOT LIKE', '%islamabad%')
                      ->where('university', 'NOT LIKE', '%rawalpindi%')
                      ->where('university', 'NOT LIKE', '%faisalabad%')
                      ->where('university', 'NOT LIKE', '%multan%')
                      ->where('university', 'NOT LIKE', '%peshawar%')
                      ->where('bio', 'NOT LIKE', '%lahore%')
                      ->where('bio', 'NOT LIKE', '%karachi%')
                      ->where('bio', 'NOT LIKE', '%islamabad%')
                      ->where('bio', 'NOT LIKE', '%rawalpindi%')
                      ->where('bio', 'NOT LIKE', '%faisalabad%')
                      ->where('bio', 'NOT LIKE', '%multan%')
                      ->where('bio', 'NOT LIKE', '%peshawar%')
                      ->where('teaching_experience', 'NOT LIKE', '%lahore%')
                      ->where('teaching_experience', 'NOT LIKE', '%karachi%')
                      ->where('teaching_experience', 'NOT LIKE', '%islamabad%')
                      ->where('teaching_experience', 'NOT LIKE', '%rawalpindi%')
                      ->where('teaching_experience', 'NOT LIKE', '%faisalabad%')
                      ->where('teaching_experience', 'NOT LIKE', '%multan%')
                      ->where('teaching_experience', 'NOT LIKE', '%peshawar%');
                });
            } else {
                $query->where(function($q) use ($cityVal) {
                    $q->where('university', 'LIKE', '%' . $cityVal . '%')
                      ->orWhere('bio', 'LIKE', '%' . $cityVal . '%')
                      ->orWhere('teaching_experience', 'LIKE', '%' . $cityVal . '%');
                });
            }
        }

        if ($countryVal !== '') {
            $query->where('country', 'LIKE', '%' . $countryVal . '%');
        }

        // Gender filter
        if ($genderVal !== '' && $genderVal !== 'both' && $genderVal !== 'all') {
            $query->where('gender', $genderVal);
        }

        // Tutoring preference/type
        if ($preferenceVal !== '' && $preferenceVal !== 'both') {
            if ($preferenceVal === 'online') {
                $query->where('is_online', true);
            } elseif ($preferenceVal === 'home') {
                $query->where('is_home', true);
            }
        } elseif ($typeVal !== '' && $typeVal !== 'both') {
            if ($typeVal === 'online') {
                $query->where('is_online', true);
            } elseif ($typeVal === 'home') {
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
            $city = 'Others';
            $area = 'Others';

            if (strtolower($tutor->country) === 'pk') {
                $searchString = strtolower($tutor->university . ' ' . $tutor->bio . ' ' . $tutor->teaching_experience);
                if (str_contains($searchString, 'karachi')) {
                    $city = 'Karachi';
                    $area = 'DHA Karachi';
                } elseif (str_contains($searchString, 'rawalpindi')) {
                    $city = 'Rawalpindi';
                    $area = 'Satellite Town';
                } elseif (str_contains($searchString, 'islamabad')) {
                    $city = 'Islamabad';
                    $area = 'F-7';
                } elseif (str_contains($searchString, 'lahore')) {
                    $city = 'Lahore';
                    if (str_contains($searchString, 'askari')) {
                        $area = 'Askari';
                    } elseif (str_contains($searchString, 'iqbal town')) {
                        $area = 'Allama Iqbal Town';
                    } elseif (str_contains($searchString, 'rehman garden')) {
                        $area = 'Al-Rehman Gardens';
                    } elseif (str_contains($searchString, 'architect')) {
                        $area = 'Architect Society';
                    } elseif (str_contains($searchString, 'audits')) {
                        $area = 'Audits and Accounts Society';
                    } elseif (str_contains($searchString, 'abdalian')) {
                        $area = 'Abdalian Society';
                    } elseif (str_contains($searchString, 'bahria')) {
                        if (str_contains($searchString, 'orchard')) {
                            $area = 'Bahria Orchard';
                        } else {
                            $area = 'Bahria Town';
                        }
                    } elseif (str_contains($searchString, 'cantt')) {
                        if (str_contains($searchString, 'walton')) {
                            $area = 'Walton Cantt';
                        } else {
                            $area = 'Cantt';
                        }
                    } elseif (str_contains($searchString, 'cavalry')) {
                        $area = 'Cavalry Ground';
                    } elseif (str_contains($searchString, 'dha')) {
                        if (str_contains($searchString, 'rahbar')) {
                            $area = 'DHA Rahbar';
                        } elseif (str_contains($searchString, 'phase 5') || str_contains($searchString, 'phase 6')) {
                            $area = 'DHA Phase 5,6';
                        } elseif (str_contains($searchString, 'phase 7') || str_contains($searchString, 'phase 8') || str_contains($searchString, 'phase 9')) {
                            $area = 'DHA Phase 7,8,9';
                        } else {
                            $area = 'DHA Phase 1,2,3,4';
                        }
                    } elseif (str_contains($searchString, 'divine')) {
                        $area = 'Divine Gardens';
                    } elseif (str_contains($searchString, 'eden')) {
                        $area = 'Eden Society';
                    } elseif (str_contains($searchString, 'eme')) {
                        $area = 'EME Society';
                    } elseif (str_contains($searchString, 'ferozpur')) {
                        $area = 'Ferozpur Road';
                    } elseif (str_contains($searchString, 'faisal town')) {
                        $area = 'Faisal Town';
                    } elseif (str_contains($searchString, 'fazaia')) {
                        $area = 'Fazaia Housing Scheme';
                    } elseif (str_contains($searchString, 'formanite')) {
                        $area = 'Formanites Housing Scheme';
                    } elseif (str_contains($searchString, 'gulberg')) {
                        if (str_contains($searchString, 'gulberg 1') || str_contains($searchString, 'gulberg i')) {
                            $area = 'Gulberg 1';
                        } elseif (str_contains($searchString, 'gulberg 2') || str_contains($searchString, 'gulberg ii')) {
                            $area = 'Gulberg 2';
                        } elseif (str_contains($searchString, 'gulberg 3') || str_contains($searchString, 'gulberg iii')) {
                            $area = 'Gulberg 3';
                        } else {
                            $area = 'Gulberg 1';
                        }
                    } elseif (str_contains($searchString, 'garden town')) {
                        if (str_contains($searchString, 'new garden')) {
                            $area = 'New Garden Town';
                        } else {
                            $area = 'Garden Town';
                        }
                    } elseif (str_contains($searchString, 'gulshan ravi')) {
                        $area = 'Gulshan Ravi';
                    } elseif (str_contains($searchString, 'green town')) {
                        $area = 'Green Town';
                    } elseif (str_contains($searchString, 'gor')) {
                        $area = 'GOR';
                    } elseif (str_contains($searchString, 'harbanspura')) {
                        $area = 'Harbanspura';
                    } elseif (str_contains($searchString, 'izmir')) {
                        $area = 'Izmir Town';
                    } elseif (str_contains($searchString, 'ichra')) {
                        $area = 'Ichra';
                    } elseif (str_contains($searchString, 'iep') || str_contains($searchString, 'engineers town')) {
                        $area = 'IEP Engineers Town';
                    } elseif (str_contains($searchString, 'johar town')) {
                        $area = 'Johar Town';
                    } elseif (str_contains($searchString, 'jubilee')) {
                        $area = 'Jubilee Town';
                    } elseif (str_contains($searchString, 'kot lakhpat')) {
                        $area = 'Kot Lakhpat';
                    } elseif (str_contains($searchString, 'lake city')) {
                        $area = 'Lake City';
                    } elseif (str_contains($searchString, 'model town')) {
                        $area = 'Model Town';
                    } elseif (str_contains($searchString, 'mughalpura') || str_contains($searchString, 'mughal pura')) {
                        $area = 'Mughalpura';
                    } elseif (str_contains($searchString, 'muslim town')) {
                        $area = 'Muslim Town';
                    } elseif (str_contains($searchString, 'mustafa town')) {
                        $area = 'Mustafa Town';
                    } elseif (str_contains($searchString, 'peco')) {
                        $area = 'Peco Road';
                    } elseif (str_contains($searchString, 'raiwind')) {
                        $area = 'Raiwind Road';
                    } elseif (str_contains($searchString, 'revenue')) {
                        $area = 'Revenue Society';
                    } elseif (str_contains($searchString, 'state life')) {
                        $area = 'State Life Housing Society';
                    } elseif (str_contains($searchString, 'samanabad')) {
                        $area = 'Samanabad';
                    } elseif (str_contains($searchString, 'sabzazar')) {
                        $area = 'Sabzazar';
                    } elseif (str_contains($searchString, 'sui gas')) {
                        $area = 'Sui Gas Society';
                    } elseif (str_contains($searchString, 'shadab')) {
                        $area = 'Shadab Gardens';
                    } elseif (str_contains($searchString, 'tajpura')) {
                        $area = 'Tajpura';
                    } elseif (str_contains($searchString, 'thokar')) {
                        $area = 'Thokar Niaz Baig';
                    } elseif (str_contains($searchString, 'township') || str_contains($searchString, 'town ship')) {
                        $area = 'Town Ship';
                    } elseif (str_contains($searchString, 'uet')) {
                        $area = 'UET Housing Society';
                    } elseif (str_contains($searchString, 'valencia')) {
                        $area = 'Valencia Housing Society';
                    } elseif (str_contains($searchString, 'vital')) {
                        $area = 'Vital Homes Housing Society';
                    } elseif (str_contains($searchString, 'wahdat')) {
                        $area = 'Wahdat Road';
                    } elseif (str_contains($searchString, 'wapda town')) {
                        $area = 'Wapda Town';
                    } elseif (str_contains($searchString, 'zaman park')) {
                        $area = 'Zaman Park';
                    } else {
                        $area = 'Other Area';
                    }
                } elseif (str_contains($searchString, 'faisalabad')) {
                    $city = 'Faisalabad';
                    $area = 'Canal Road';
                } elseif (str_contains($searchString, 'multan')) {
                    $city = 'Multan';
                    $area = 'Cantt';
                } elseif (str_contains($searchString, 'peshawar')) {
                    $city = 'Peshawar';
                    $area = 'Hayatabad';
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

            $ratingVal = round(4.6 + (($tutor->id * 7) % 5) * 0.1, 1);
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
