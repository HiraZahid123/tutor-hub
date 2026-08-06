@extends('layouts.app')

@section('title')
    @php
        $selectedSubject = request('subject');
        $selectedSubject = is_string($selectedSubject) ? $selectedSubject : '';
        
        $selectedCity = request('city');
        $selectedCity = is_string($selectedCity) ? $selectedCity : '';
        
        $selectedType = request('tutoring_preference') ?: request('tutoring_type') ?: (request('is_online') && !request('is_home') ? 'online' : (!request('is_online') && request('is_home') ? 'home' : ''));
        $selectedType = is_string($selectedType) ? $selectedType : '';
        
        $titleParts = [];
        if ($selectedSubject !== '') {
            $titleParts[] = ucfirst($selectedSubject);
        }
        if ($selectedType !== '') {
            $titleParts[] = ucfirst($selectedType);
        }
        $titleParts[] = 'Tutors';
        if ($selectedCity !== '') {
            $titleParts[] = 'in ' . ucfirst($selectedCity);
        } else {
            $titleParts[] = 'in Pakistan';
        }
        
        echo implode(' ', $titleParts) . ' | TutorHub';
    @endphp
@endsection

@section('content')
<style>
    /* Hero Banner matching the reference structure */
    .tutor-hero-banner {
        background: linear-gradient(rgba(17, 24, 39, 0.8), rgba(30, 58, 138, 0.85)), url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        padding: 5rem 1rem;
        text-align: center;
        color: #ffffff;
    }
    .tutor-hero-title {
        font-size: 2.25rem;
        font-weight: 800;
        line-height: 1.25;
        max-width: 900px;
        margin: 0 auto 1rem;
    }
    
    /* Grid Layout */
    .directory-layout-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 3rem 1rem;
    }
    
    /* Sidebar Filter Panel */
    .sidebar-filter-box {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .filter-section-title {
        font-size: 0.75rem;
        font-weight: 800;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        display: block;
    }
    .sidebar-input-field {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        color: #1f2937;
        background-color: #f9fafb;
        transition: all 0.2s;
        margin-bottom: 1rem;
    }
    .sidebar-input-field:focus {
        border-color: #2563eb;
        background-color: #ffffff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    /* Choose Radios */
    .sidebar-radio-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }
    .sidebar-radio-option input {
        width: 1rem;
        height: 1rem;
        accent-color: #2563eb;
    }

    /* Horizontal List Row Cards */
    .tutor-list-stack {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }
    .tutor-horizontal-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1.25rem;
        padding: 1.75rem;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }
    @media (min-width: 768px) {
        .tutor-horizontal-card {
            flex-direction: row;
            align-items: flex-start;
            gap: 1.5rem;
        }
    }
    .tutor-horizontal-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        border-color: #bfdbfe;
        transform: translateY(-2px);
    }

    /* Tutor Photo */
    .tutor-photo-column {
        flex-shrink: 0;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }
    .tutor-photo-circle {
        width: 90px;
        height: 90px;
        border-radius: 9999px;
        overflow: hidden;
        background-color: #f3f4f6;
        border: 3px solid #e5e7eb;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .tutor-photo-circle {
            width: 100px;
            height: 100px;
        }
    }
    .tutor-photo-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
    }

    /* Center Info Column */
    .tutor-info-column {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .tutor-name-row {
        display: flex;
        align-items: baseline;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .tutor-name-link {
        font-size: 1.15rem;
        font-weight: 900;
        color: #111827;
        text-decoration: none;
        transition: color 0.2s;
        white-space: nowrap;
    }
    .tutor-name-link:hover {
        color: #2563eb;
    }
    .tutor-qualification {
        font-size: 0.8rem;
        font-weight: 600;
        color: #9ca3af;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
    }
    .tutor-affiliation {
        font-size: 0.7rem;
        font-weight: 800;
        color: #2563eb;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-top: 0.15rem;
    }
    .tutor-bio {
        font-size: 0.85rem;
        color: #6b7280;
        line-height: 1.6;
        margin-top: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .tutor-tags-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        margin-top: 0.75rem;
    }
    .tutor-tag {
        font-size: 0.625rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.3rem 0.65rem;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #1d4ed8;
        border-radius: 9999px;
        white-space: nowrap;
    }

    /* Right Actions Column */
    .tutor-actions-column {
        flex-shrink: 0;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-top: 1px solid #f3f4f6;
        padding-top: 1rem;
    }
    @media (min-width: 768px) {
        .tutor-actions-column {
            flex-direction: column;
            align-items: flex-end;
            justify-content: flex-start;
            width: 170px;
            border-top: none;
            border-left: 1px solid #f3f4f6;
            padding-top: 0;
            padding-left: 1.5rem;
            gap: 0.75rem;
        }
    }

    /* Rating */
    .tutor-rating-block {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    @media (min-width: 768px) {
        .tutor-rating-block {
            align-items: flex-end;
        }
    }
    .tutor-rating-label {
        font-size: 0.6rem;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.25rem;
    }
    .tutor-stars {
        display: flex;
        gap: 0.15rem;
        color: #f59e0b;
    }
    .tutor-stars i {
        font-size: 0.75rem;
    }
    .tutor-stars .empty-star {
        color: #d1d5db;
    }

    /* Book Button */
    .tutor-book-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        border-radius: 0.75rem;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        white-space: nowrap;
        width: auto;
    }
    @media (min-width: 768px) {
        .tutor-book-btn {
            width: 100%;
        }
    }
    .tutor-book-btn:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }

    /* Action Circle Buttons */
    .tutor-secondary-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .tutor-secondary-actions {
            justify-content: flex-end;
        }
    }
    .action-circle-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
        transition: all 0.2s;
        text-decoration: none;
    }
    .action-circle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    }
</style>

{{-- 1. Dark Image Bookshelf Hero Banner --}}
<div class="tutor-hero-banner pt-28">
    <div class="container mx-auto px-4">
        <h1 class="tutor-hero-title">
            @php
                $titleText = '';
                if ($selectedSubject) {
                    $titleText .= ucfirst($selectedSubject) . ' ';
                }
                if ($selectedType) {
                    $titleText .= ucfirst($selectedType) . ' ';
                }
                $titleText .= 'Tutors ';
                if ($selectedCity) {
                    $titleText .= 'Across' . ucfirst($selectedCity);
                } else {
                    $titleText .= 'Across the Globe';
                }
                echo $titleText;
            @endphp
        </h1>
        
        {{-- Breadcrumbs --}}
        <div class="flex items-center justify-center gap-2 text-xs font-semibold text-gray-300 uppercase tracking-widest mt-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[8px] text-gray-400"></i>
            <a href="{{ route('tutors.directory') }}" class="hover:text-white transition-colors">Tutors in Pakistan</a>
            @if($selectedSubject)
                <i class="fas fa-chevron-right text-[8px] text-gray-400"></i>
                <span class="text-orange-400">{{ ucfirst($selectedSubject) }}</span>
            @endif
        </div>
    </div>
</div>

{{-- 2. Layout --}}
<div class="bg-gray-50 min-h-screen">
    <div class="directory-layout-container">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- Column 1: Sidebar Filter Panel --}}
            <div class="lg:col-span-1">
                {{-- Mobile Filter Toggle Button --}}
                <div class="lg:hidden mb-4">
                    <button type="button" onclick="toggleMobileFilters()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl flex items-center justify-center gap-2 shadow-md transition-all">
                        <i class="fas fa-filter"></i> Filter by Options
                    </button>
                </div>

                {{-- Sidebar Filters Form --}}
                <form id="filters-form" method="GET" action="{{ route('tutors.directory') }}" class="sidebar-filter-box hidden lg:block">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-sliders-h text-blue-600"></i> Filter by:
                        </h3>
                        <a href="{{ route('tutors.directory') }}" class="text-xs font-bold text-red-500 hover:text-red-700 transition-colors uppercase">
                            Reset
                        </a>
                    </div>

                    {{-- Category Search --}}
                    <div>
                        <label class="filter-section-title" style="margin-top: 0">Search by Category</label>
                        <input type="text" name="q" value="{{ is_string(request('q')) ? request('q') : '' }}" placeholder="e.g. Algebra, Leslie..." class="sidebar-input-field">
                    </div>

                    {{-- Subject selector --}}
                    <div>
                        <label class="filter-section-title">Select Subject</label>
                        <select name="subject" class="sidebar-input-field" onchange="this.form.submit()">
                            <option value="">Choose Subject</option>
                            @foreach($subjects as $subj)
                                <option value="{{ $subj->name }}" {{ request('subject') == $subj->name ? 'selected' : '' }}>
                                    {{ $subj->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- City selector --}}
                    <div>
                        <label class="filter-section-title">Select City</label>
                        <select name="city" class="sidebar-input-field" onchange="this.form.submit()">
                            <option value="">Choose City</option>
                            <option value="Lahore" {{ request('city') == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                            <option value="Karachi" {{ request('city') == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                            <option value="Islamabad" {{ in_array(request('city'), ['Islamabad', 'rawalpindi']) ? 'selected' : '' }}>Islamabad / Rawalpindi</option>
                        </select>
                    </div>

                    {{-- Tutoring preference --}}
                    <div>
                        <span class="filter-section-title">Choose Tutor Type</span>
                        <div class="space-y-2.5">
                            <label class="sidebar-radio-option">
                                <input type="radio" name="tutoring_preference" value="both" {{ request('tutoring_preference', 'both') == 'both' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Online & Home</span>
                            </label>
                            <label class="sidebar-radio-option">
                                <input type="radio" name="tutoring_preference" value="online" {{ request('tutoring_preference') == 'online' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Online Tutors Only</span>
                            </label>
                            <label class="sidebar-radio-option">
                                <input type="radio" name="tutoring_preference" value="home" {{ request('tutoring_preference') == 'home' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Home Tutors Only</span>
                            </label>
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div>
                        <span class="filter-section-title">Choose Gender</span>
                        <div class="space-y-2.5">
                            <label class="sidebar-radio-option">
                                <input type="radio" name="gender" value="both" {{ request('gender', 'both') == 'both' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Both Gender</span>
                            </label>
                            <label class="sidebar-radio-option">
                                <input type="radio" name="gender" value="male" {{ request('gender') == 'male' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Male</span>
                            </label>
                            <label class="sidebar-radio-option">
                                <input type="radio" name="gender" value="female" {{ request('gender') == 'female' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span>Female</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow hover:shadow-blue-500/10 uppercase text-xs tracking-wider">
                        Search Tutors
                    </button>
                </form>
            </div>

            {{-- Column 2: Main Search Results List --}}
            <div class="lg:col-span-3">
                <div class="mb-6 flex items-center justify-between">
                    <span class="text-xs font-extrabold uppercase text-gray-400 tracking-wider">
                        SHOWING: {{ count($tutors) }} OUT OF HUNDREDS OF TUTORS
                    </span>
                </div>

                @if(count($tutors) > 0)
                    <div class="tutor-list-stack">
                        @foreach($tutors as $tutor)
                            <div class="tutor-horizontal-card">
                                
                                {{-- Left Column: Avatar Photo --}}
                                <div class="tutor-photo-column">
                                    @if(!empty($tutor['photo']))
                                        <div class="tutor-photo-circle">
                                            <img src="{{ asset($tutor['photo']) }}" alt="{{ $tutor['name'] }}">
                                        </div>
                                    @else
                                        <div class="tutor-photo-circle text-white font-extrabold text-2xl" style="background-color: {{ $tutor['bg'] }};">
                                            {{ $tutor['initials'] }}
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Center Column: Info details --}}
                                <div class="tutor-info-column">
                                    <div class="tutor-name-row">
                                        <a href="{{ route('tutors.show', $tutor['id']) }}" class="tutor-name-link">
                                            {{ $tutor['name'] }}
                                        </a>
                                        <span class="tutor-qualification" title="{{ $tutor['qualification'] }}">
                                            {{ $tutor['qualification'] }}
                                        </span>
                                    </div>
                                    
                                    <p class="tutor-affiliation">
                                        {{ $tutor['affiliation'] }}
                                    </p>
                                    
                                    @if(!empty($tutor['bio']))
                                        <p class="tutor-bio">
                                            {{ $tutor['bio'] }}
                                        </p>
                                    @endif
                                    
                                    {{-- Subjects tags --}}
                                    <div class="tutor-tags-row">
                                        @foreach($tutor['subject_tags'] as $tag)
                                            <span class="tutor-tag">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                {{-- Right Column: Rating + Actions --}}
                                <div class="tutor-actions-column">
                                    
                                    {{-- Star Rating --}}
                                    <div class="tutor-rating-block">
                                        <span class="tutor-rating-label">Tutor's Rating</span>
                                        <div class="tutor-stars">
                                            @php
                                                $rVal = $tutor['rating'] ?? 5.0;
                                                $fullStars = floor($rVal);
                                                $hasHalf = ($rVal - $fullStars) >= 0.3;
                                            @endphp
                                            @for($j = 1; $j <= 5; $j++)
                                                @if($j <= $fullStars)
                                                    <i class="fas fa-star"></i>
                                                @elseif($j == $fullStars + 1 && $hasHalf)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star empty-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    {{-- Book / Hire Button --}}
                                    @auth
                                        <a href="{{ route('student.book', $tutor['id']) }}" class="tutor-book-btn">
                                            <i class="fas fa-calendar-plus"></i> Book Session
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ urlencode(route('student.book', $tutor['id'])) }}" class="tutor-book-btn">
                                            <i class="fas fa-sign-in-alt"></i> Login to Hire
                                        </a>
                                    @endauth

                                    {{-- View Profile + WhatsApp --}}
                                    <div class="tutor-secondary-actions">
                                        <a href="{{ route('tutors.show', $tutor['id']) }}"
                                           class="action-circle-btn bg-gray-100 text-gray-600 hover:bg-gray-200"
                                           title="View Full Profile">
                                            <i class="fas fa-user" style="font-size: 0.75rem;"></i>
                                        </a>
                                        <a href="https://wa.me/923414133395?text=Hi%2C%20I%20am%20interested%20in%20hiring%20tutor%20{{ urlencode($tutor['name']) }}%20via%20TutorHub"
                                           target="_blank"
                                           class="action-circle-btn bg-green-500 text-white hover:bg-green-600"
                                           title="WhatsApp Enquiry">
                                            <i class="fab fa-whatsapp" style="font-size: 1.1rem;"></i>
                                        </a>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="bg-white border border-gray-200 rounded-[2rem] p-12 text-center shadow-sm" data-aos="fade-up">
                        <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-user-slash text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Approved Tutors Found</h3>
                        <p class="text-gray-500 max-w-md mx-auto text-sm leading-relaxed mb-6">
                            We couldn't find any approved tutors matching your criteria. Try adjusting your filter settings or request a customized tutor match directly.
                        </p>
                        <div class="flex flex-wrap justify-center gap-3">
                            <a href="{{ route('tutors.directory') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold py-3 px-6 rounded-xl transition-all">
                                Reset Filters
                            </a>
                            <a href="{{ route('find-a-tutor') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-3 px-6 rounded-xl shadow transition-all">
                                Request a Custom Match
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>

<script>
    function toggleMobileFilters() {
        const sidebar = document.getElementById('filters-form');
        sidebar.classList.toggle('hidden');
    }
</script>
@endsection
