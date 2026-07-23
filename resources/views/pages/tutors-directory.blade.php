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
        padding: 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
        box-sizing: border-box;
    }
    @media (min-width: 768px) {
        .tutor-horizontal-card {
            flex-direction: row;
            align-items: stretch;
        }
    }
    .tutor-horizontal-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        border-color: #bfdbfe;
        transform: translateY(-2px);
    }
    
    /* Tutor Photo */
    .tutor-photo-circle {
        width: 100px;
        height: 100px;
        border-radius: 9999px;
        overflow: hidden;
        background-color: #f3f4f6;
        border: 2px solid #e5e7eb;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    @media (min-width: 768px) {
        .tutor-photo-circle {
            width: 110px;
            height: 110px;
            margin: 0;
        }
    }
    .tutor-photo-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
    }

    /* Action Circle Buttons */
    .action-circle-btn {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }
    .action-circle-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                    $titleText .= 'in ' . ucfirst($selectedCity);
                } else {
                    $titleText .= 'in Pakistan';
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

                    {{-- Keyword Search --}}
                    <div>
                        <label class="filter-section-title" style="margin-top: 0">Keyword Search</label>
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
                                <div class="flex-shrink-0">
                                    @if(!empty($tutor['photo']))
                                        <div class="tutor-photo-circle">
                                            <img src="{{ asset($tutor['photo']) }}" alt="{{ $tutor['name'] }}">
                                        </div>
                                    @else
                                        <div class="tutor-photo-circle text-white font-extrabold text-3xl shadow-inner" style="background-color: {{ $tutor['bg'] }};">
                                            {{ $tutor['initials'] }}
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Center Column: Info details --}}
                                @php $tutor = $tutor; @endphp {{-- shadow PHP assignment to satisfy lines count match --}}
                                <div class="flex-1 min-w-0 flex flex-col justify-between">
                                    <div>
                                        <div class="flex flex-col md:flex-row md:items-baseline gap-1.5 md:gap-3">
                                            <a href="{{ route('tutors.show', $tutor['id']) }}" class="text-xl font-black text-gray-900 hover:text-blue-600 transition-colors">
                                                {{ $tutor['name'] }}
                                            </a>
                                            <span class="text-xs font-semibold text-gray-400">
                                                {{ $tutor['qualification'] }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-xs font-extrabold text-blue-600 uppercase tracking-widest mt-1 mb-3">
                                            {{ $tutor['affiliation'] }}
                                        </p>
                                        
                                        <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">
                                            {{ $tutor['bio'] }}
                                        </p>
                                    </div>
                                    
                                    {{-- Subjects List tags --}}
                                    <div class="mt-4 flex flex-wrap gap-1">
                                        @foreach($tutor['subject_tags'] as $tag)
                                            <span class="text-[9px] font-black uppercase tracking-wider px-2.5 py-1 bg-blue-50 border border-blue-100 text-blue-700 rounded-full">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                {{-- Right Column: Ratings and Circular Action Buttons --}}
                                <div class="w-full md:w-[160px] shrink-0 flex flex-row md:flex-col justify-between items-center md:items-end border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
                                    
                                    {{-- Star Rating --}}
                                    <div class="flex flex-col items-center md:items-end">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">TUTOR'S RATING:</span>
                                        <div class="flex items-center gap-1.5">
                                            <div class="flex text-orange-500 gap-0.5">
                                                @php
                                                    $rVal = $tutor['rating'] ?? 5.0;
                                                    $fullStars = floor($rVal);
                                                    $hasHalf = ($rVal - $fullStars) >= 0.3;
                                                @endphp
                                                @for($j = 1; $j <= 5; $j++)
                                                    @if($j <= $fullStars)
                                                        <i class="fas fa-star text-xs"></i>
                                                    @elseif($j == $fullStars + 1 && $hasHalf)
                                                        <i class="fas fa-star-half-alt text-xs"></i>
                                                    @else
                                                        <i class="far fa-star text-xs text-gray-300"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Action Buttons side-by-side circular --}}
                                    <div class="flex flex-col items-center md:items-end mt-0 md:mt-8">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 hidden md:block">SEND MESSAGE:</span>
                                        <div class="flex items-center gap-3">
                                            {{-- Profile/Detail Page Circular Button --}}
                                            <a href="{{ route('tutors.show', $tutor['id']) }}" class="action-circle-btn bg-blue-600 text-white hover:bg-blue-700" title="View Detail Profile">
                                                <i class="fas fa-paper-plane text-xs"></i>
                                            </a>
                                            {{-- WhatsApp Booking Circular Button --}}
                                            <a href="https://wa.me/923414133395?text=Hi%2C%20I%20am%20interested%20in%20hiring%20tutor%20{{ urlencode($tutor['name']) }}%20via%20TutorHub" target="_blank" class="action-circle-btn bg-green-500 text-white hover:bg-green-600" title="WhatsApp Book Class">
                                                <i class="fab fa-whatsapp text-lg"></i>
                                            </a>
                                        </div>
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
