@extends('layouts.app')
@section('title', 'TutorHub - Find Your Perfect Tutor')

@section('content')
{{-- ==================== HERO SECTION ==================== --}}
<section>
    <div class="container">
        <div class="flex items-center justify-between flex-col md:flex-row">
            <div class="flex items-center justify-center flex-col md:items-start" data-aos="fade-right">
                <style>
                    @keyframes softBlink {
                        0%, 100% { opacity: 1; }
                        50% { opacity: 0.25; }
                    }
                    .blink-promo {
                        animation: softBlink 1.4s ease-in-out infinite;
                        display: inline-block;
                    }
                </style>
                <h3 class="text-blue-600 text-lg font-semibold mb-3" data-aos="fade-right" data-aos-delay="100">
                    <span class="blink-promo">🎓 Get <span class="underline decoration-[#2563EB]">2 Days of Free Demo Classes</span> – No cost, just learning!</span>
                </h3>
                <h1 class="text-5xl font-semibold text-center mb-4 leading-tight md:text-6xl md:text-left lg:max-w-[365px] lg:leading-[65px]" data-aos="fade-right" data-aos-delay="200">
                    Find Your Perfect <span class="text-blue-600">Tutor</span>
                </h1>
                <p class="text-center text-gray-600 text-lg mb-5 md:text-left md:max-w-[385px]" data-aos="fade-right" data-aos-delay="300">
                    We help you find the perfect tutor for 1-on-1 lessons. It is completely free and private
                </p>
                <style>
                    @keyframes btnPulse {
                        0%   { transform: scale(1);     box-shadow: 0 4px 20px rgba(249,115,22,0.4);  opacity: 1; }
                        25%  { transform: scale(1.045); box-shadow: 0 8px 32px rgba(249,115,22,0.65); opacity: 1; }
                        50%  { transform: scale(1.02);  box-shadow: 0 6px 24px rgba(249,115,22,0.5);  opacity: 0.6; }
                        75%  { transform: scale(1.045); box-shadow: 0 8px 32px rgba(249,115,22,0.65); opacity: 1; }
                        100% { transform: scale(1);     box-shadow: 0 4px 20px rgba(249,115,22,0.4);  opacity: 1; }
                    }
                    .hero-btn {
                        animation: btnPulse 1.8s ease-in-out infinite;
                    }
                    .hero-btn:nth-child(2) {
                        animation-delay: 0.9s;
                    }
                    .hero-btn:hover {
                        animation: none;
                        transform: scale(1.07);
                        opacity: 1;
                    }
                </style>
                <div class="w-full max-w-[420px] flex flex-col items-center md:items-start mt-6" data-aos="fade-up" data-aos-delay="400">
                    {{-- Buttons Wrapper --}}
                    <div class="flex justify-center gap-4 w-full mb-8 flex-wrap">
                        <a href="{{ route('for-students') }}"
                           class="hero-btn inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-base px-8 py-3 rounded-full transition-all duration-300 active:scale-95 whitespace-nowrap">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                            Find Tutor
                        </a>
                        <a href="{{ route('register-tutor') }}"
                           class="hero-btn inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-base px-8 py-3 rounded-full transition-all duration-300 active:scale-95 whitespace-nowrap">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/></svg>
                            Apply as a Tutor
                        </a>
                    </div>

                    {{-- Subject Search Bar --}}
                    <div class="relative w-full" id="hero-search-wrapper">
                        <div class="flex items-center bg-white rounded-2xl shadow-xl border border-gray-200 focus-within:border-blue-400 focus-within:shadow-blue-100 transition-all duration-200 overflow-hidden">
                            <i class="fas fa-search text-gray-400 text-sm ml-4 flex-shrink-0"></i>
                            <input type="text"
                                   id="hero-subject-input"
                                   placeholder="e.g. Physics, IELTS, Quran…"
                                   autocomplete="off"
                                   class="flex-1 px-3 py-3.5 text-sm font-medium text-gray-700 bg-transparent outline-none placeholder-gray-400">
                            <button onclick="if(document.getElementById('hero-subject-input').value.trim()){window.location.href='{{ route('tutors.directory') }}?q='+encodeURIComponent(document.getElementById('hero-subject-input').value.trim())}"
                                    class="m-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all flex-shrink-0 active:scale-95">
                                Search
                            </button>
                        </div>
                        <ul id="hero-suggestions"
                            class="hidden absolute left-0 right-0 bg-white border border-gray-200 rounded-2xl shadow-2xl z-50 overflow-hidden"
                            style="top:calc(100% + 8px);max-height:260px;overflow-y:auto;">
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <img data-aos="fade-left" data-aos-delay="200" data-aos-duration="1200"
                     class="mt-6 w-[350px] md:w-[550px] xl:w-[600px] m-auto"
                     src="{{ asset('images/tutorhub5.png') }}" alt="TutorHub Hero">
            </div>
        </div>
    </div>
</section>

{{-- ==================== COUNTER SECTION ==================== --}}
<section class="bg-primary">
    <div class="container">
        <div class="counter_grid text-black text-center py-6">
            <div class="mb-6 lg:mb-0">
                <p class="text-3xl md:text-[32px] font-black"><span class="counter" data-target="3029" data-suffix="+">0</span></p>
                <p class="text-[15px] font-bold text-gray-800 mt-1">Expert tutors</p>
            </div>
            <div class="mb-6 lg:mb-0">
                <p class="text-3xl md:text-[32px] font-black"><span class="counter" data-target="3025" data-suffix="+">0</span></p>
                <p class="text-[15px] font-bold text-gray-800 mt-1">Hours content</p>
            </div>
            <div class="mb-6 lg:mb-0">
                <p class="text-3xl md:text-[32px] font-black"><span class="counter" data-target="4.6" data-suffix="+">4.6+</span></p>
                <p class="text-[15px] font-bold text-gray-800 mt-1">Ranked on google</p>
            </div>
            <div>
                <p class="text-3xl md:text-[32px] font-black"><span class="counter" data-target="798" data-suffix="+">0</span></p>
                <p class="text-[15px] font-bold text-gray-800 mt-1">Active students</p>
            </div>
        </div>
    </div>
</section>

{{-- ==================== GOOGLE REVIEWS BADGE SECTION ==================== --}}
<section class="bg-gray-50 border-b border-gray-100 py-6">
    <div class="container">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 max-w-4xl mx-auto px-4">
            {{-- Left: Text --}}
            <div class="text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight">
                    What People say about us on Google
                </h2>
            </div>
            
            {{-- Right: Interactive Badge --}}
            <div onclick="openGoogleReviewsModal()" 
                 class="bg-white border border-gray-200 rounded-xl px-5 py-3.5 shadow-sm hover:shadow-md hover:border-blue-400 transition-all duration-300 flex items-center gap-4 cursor-pointer select-none">
                {{-- Google G Bubble --}}
                <div class="w-12 h-12 flex items-center justify-center bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0">
                    <svg class="w-6 h-6" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.22-.67-.35-1.37-.35-2.09z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                </div>
                
                {{-- Stats --}}
                <div class="flex flex-col">
                    <span class="text-xs text-gray-500 font-bold tracking-tight">Google Reviews</span>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-2xl font-black text-gray-900">4.9</span>
                        <div class="flex flex-col">
                            <div class="flex text-yellow-400 gap-0.5">
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                                <i class="fas fa-star text-[10px]"></i>
                            </div>
                            <span class="text-[10px] text-gray-400 font-bold">289 reviews</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SELECT THE TUTORS SECTION ==================== --}}
<section class="py-12 bg-white overflow-hidden">
    <div class="container">
        <div class="text-center mb-10">
            <h3 class="text-blue-600 text-lg md:text-xl font-black uppercase tracking-[0.20em] block mb-3">Select the tutors why?</h3>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">Truly suits you:</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-9">
            @php
                $tutorSections = [
                    [
                        'title' => 'Home Tutors in Lahore',
                        'url'   => route('for-students', ['city' => 'Lahore']),
                        'delay' => 100
                    ],
                    [
                        'title' => 'Home Tutors in Karachi',
                        'url'   => route('for-students', ['city' => 'Karachi']),
                        'delay' => 200
                    ],
                    [
                        'title' => 'Home Tutors in Islamabad',
                        'url'   => route('for-students', ['city' => 'Islamabad']),
                        'delay' => 300
                    ],
                    [
                        'title' => 'Quran Tutors',
                        'url'   => route('for-students', ['q' => 'Quran']),
                        'delay' => 400
                    ],
                    [
                        'title' => 'Home Tutors in Pakistan',
                        'url'   => route('for-students'),
                        'delay' => 500
                    ],
                    [
                        'title' => 'Other Tutors',
                        'url'   => route('contact'),
                        'delay' => 600
                    ]
                ];
            @endphp
            
            @foreach($tutorSections as $sec)
                <a href="{{ $sec['url'] }}"
                   class="group block bg-[#2563EB] text-white p-8 rounded-2xl text-center shadow-[0_8px_20px_rgba(37,99,235,0.2)] transform hover:-translate-y-3 hover:scale-[1.06] hover:shadow-[0_20px_40px_rgba(37,99,235,0.45)] transition-all duration-300"
                   data-aos="fade-up" data-aos-delay="{{ $sec['delay'] }}">
                    <h3 class="text-base sm:text-lg font-black tracking-tight leading-tight mb-2.5">{{ $sec['title'] }}</h3>
                    <p class="text-[10px] text-blue-100 font-bold uppercase tracking-wider inline-flex items-center gap-1.5 justify-center">
                        Explore Tutors <i class="fas fa-chevron-right text-[8px] transition-transform group-hover:translate-x-1 duration-300"></i>
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== SCHEDULE SECTION ==================== --}}
<section class="bg-[#f9f9f9]">
    <div class="container">
        {{-- First Row --}}
        <div class="flex items-center flex-col md:flex-row md:justify-between mb-10">
            <img data-aos="zoom-in" data-aos-delay="200"
                 class="w-[400px] h-[300px] mb-3 md:mb-0 object-cover rounded-lg border-4 border-secondary shadow-lg"
                 src="{{ asset('images/tutorhub.png.png') }}" alt="Schedule">
            <div class="text-center md:text-left max-w-[500px]" data-aos="fade-up" data-aos-delay="300">
                <span class="text-sm font-semibold text-blue-700 mb-3 block">CUSTOMIZE WITH YOUR SCHEDULE</span>
                <h1 class="text-2xl font-semibold mb-3">Personalized Professional Online Tutor on Your Schedule</h1>
                <p class="text-base text-gray-500">
                    Our scheduling system allows you to select based on your free time. Lorem ipsum demo text for template. Keep track of your students class and tutoring schedules, and never miss your lectures. The best online class scheduling system with easy accessibility. Lorem ipsum is a placeholder text commonly used to demonstrate the visual form.
                </p>
                <a href="{{ route('find-a-tutor') }}">
                    <button class="bg-primary rounded-full capitalize py-3 px-11 text-lg font-medium mt-5 hover:bg-secondary transition-transform transform hover:scale-105">
                        Get Started
                    </button>
                </a>
            </div>
        </div>
        {{-- Second Row --}}
        <div class="flex items-center flex-col md:flex-row md:justify-between">
            <div class="text-center md:text-left max-w-[500px] order-2 md:order-1" data-aos="fade-up" data-aos-delay="300">
                <span class="text-sm font-semibold text-blue-700 mb-3 block">CUSTOMIZE WITH YOUR SCHEDULE</span>
                <h1 class="text-2xl font-semibold mb-3">Talented and Qualified Tutors to Serve You for Help</h1>
                <p class="text-base text-gray-500">
                    Our scheduling system allows you to select based on your free time. Lorem ipsum demo text for template. Keep track of your students class and tutoring schedules, and never miss your lectures. The best online class scheduling system with easy accessibility. Lorem ipsum is a placeholder text commonly used.
                </p>
                <a href="{{ route('find-a-tutor') }}">
                    <button class="bg-primary rounded-full capitalize py-3 px-11 text-lg font-medium mt-5 hover:bg-secondary transition-transform transform hover:scale-105">
                        Get Started
                    </button>
                </a>
            </div>
            <img data-aos="zoom-in" data-aos-delay="200"
                 class="w-[400px] h-[300px] mb-3 md:mb-0 object-cover rounded-lg border-4 border-secondary shadow-lg order-1 md:order-2"
                 src="{{ asset('images/tutorhub3.png') }}" alt="Schedule">
        </div>
    </div>
</section>

{{-- ==================== SUBJECT CARDS ==================== --}}
<section>
    <div class="container">
        <div class="text-center">
            <span class="text-xl capitalize tracking-wide font-bold text-orange-400 mb-2 block">Our tutor subjects</span>
            <h1 class="text-3xl font-bold">Find Online Tutor in Any Subject</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
            @foreach($categories as $index => $category)
                <div class="border border-secondary/20 rounded-md p-4 flex items-center gap-3 hover:shadow-lg duration-300 cursor-pointer" data-aos="fade-right" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-md text-white bg-blue-600">
                        <span class="text-xl"><i class="{{ $category->icon ?? 'fas fa-graduation-cap' }}"></i></span>
                    </div>
                    <span class="text-lg">{{ ucfirst(strtolower($category->name)) }}</span>
                </div>
            @endforeach
            <a href="{{ route('for-students') }}" class="border border-secondary/20 rounded-md p-4 flex items-center gap-3 hover:shadow-lg duration-300 cursor-pointer" data-aos="fade-right" data-aos-delay="800">
                <div style="background-color: #464646" class="w-10 h-10 flex items-center justify-center rounded-md text-white">
                    <span class="text-xl"><i class="fas fa-book"></i></span>
                </div>
                <span class="text-lg">See all</span>
            </a>
        </div>
    </div>
</section>

{{-- ==================== BEST TUTORS PREVIEW ==================== --}}
<section class="py-16 bg-gray-50">
    <div class="container">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="text-xl capitalize tracking-wide font-bold text-orange-400 mb-2 block">Hand-Picked Educators</span>
            <h1 class="text-3xl md:text-4xl font-bold mb-3">Meet Our Best Tutors</h1>
            <p class="text-gray-500 max-w-xl mx-auto text-base">Discover highly qualified tutors with decades of experience, ready to guide your child to excellence.</p>
        </div>

        <style>
            /* Keep all tutor cards in the slider at the exact same height */
            .slick-slider-custom .slick-track {
                display: flex !important;
            }
            .slick-slider-custom .slick-slide {
                height: inherit !important;
                display: flex !important;
            }
            .slick-slider-custom .slick-slide > div {
                width: 100%;
                display: flex;
            }
            /* Custom styling for the navigation arrows */
            .slider-arrow-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: #ffffff;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                border: 1px solid #f3f4f6;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #2563eb;
                transition: all 0.3s ease;
                z-index: 10;
                cursor: pointer;
            }
            .slider-arrow-btn:hover {
                background: #2563eb;
                color: #ffffff;
                border-color: #2563eb;
                box-shadow: 0 6px 20px rgba(37,99,235,0.25);
            }
            .slider-arrow-btn:active {
                transform: translateY(-50%) scale(0.92);
            }

            /* Custom profile photo hover animation */
            .tutor-photo-wrap-interactive {
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
            }
            .tutor-photo-wrap-interactive:hover {
                transform: translateY(-8px) scale(1.03);
                box-shadow: 0 16px 32px rgba(0,0,0,0.18);
            }
            
            /* Custom subject tags hover animation */
            .subject-tag-interactive {
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s, border-color 0.2s, box-shadow 0.3s;
                cursor: pointer;
            }
            .subject-tag-interactive:hover {
                transform: translateY(-4px) scale(1.05);
                box-shadow: 0 6px 12px rgba(37,99,235,0.15);
                background-color: #dbeafe !important;
                border-color: #3b82f6 !important;
                color: #1d4ed8 !important;
            }

            /* Custom text interactive hover animation */
            .text-interactive-hover {
                display: block;
                width: fit-content;
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.3s ease;
            }
            .text-interactive-hover:hover {
                transform: translateY(-4px);
            }

            /* Custom button interactive hover animation */
            .button-interactive-hover {
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
            }
            .button-interactive-hover:hover {
                transform: translateY(-3px) scale(1.01);
                box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            }

            /* Custom badge interactive hover animation */
            .badge-interactive-hover {
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
                cursor: pointer;
            }
            .badge-interactive-hover:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 4px 10px rgba(234, 88, 12, 0.15);
            }
        </style>

        @php
            $homeTutors = $tutors;
        @endphp

        <!-- Desktop Slider Section (Visible on lg screens and up) -->
        <div class="hidden lg:block relative px-12 mb-10" data-aos="fade-up">
            {{-- Prev Arrow --}}
            <button id="tutors-prev-desktop" class="slider-arrow-btn left-2">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>

            {{-- Slider Container --}}
            <div id="tutors-slider-desktop" class="slick-slider-custom">
                @foreach(array_chunk($homeTutors, 6) as $chunk)
                <div class="px-3 w-full">
                    <div class="grid grid-cols-3 gap-6">
                        @foreach($chunk as $ht)
                            @include('partials.tutor-card', ['ht' => $ht])
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Next Arrow --}}
            <button id="tutors-next-desktop" class="slider-arrow-btn right-2">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>
        </div>

        <!-- Mobile/Tablet Slider Section (Visible on md/sm screens) -->
        <div class="block lg:hidden relative px-4 md:px-12 mb-10" data-aos="fade-up">
            {{-- Prev Arrow --}}
            <button id="tutors-prev-mobile" class="slider-arrow-btn left-0 md:left-2">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>

            {{-- Slider Container --}}
            <div id="tutors-slider-mobile" class="slick-slider-custom">
                @foreach($homeTutors as $ht)
                <div class="px-3 h-full">
                    @include('partials.tutor-card', ['ht' => $ht])
                </div>
                @endforeach
            </div>

            {{-- Next Arrow --}}
            <button id="tutors-next-mobile" class="slider-arrow-btn right-0 md:right-2">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>
        </div>


    </div>
</section>

{{-- ==================== TESTIMONIALS ==================== --}}
<div class="py-14">
    <div class="container">
        <div class="text-center mb-9">
            <span class="text-xl capitalize tracking-wide font-bold text-orange-400 mb-2 block">Student Success Stories</span>
            <h1 class="text-3xl font-bold">What Our Students Are Saying</h1>
        </div>

        <style>
            #testimonial-slider .slick-track {
                display: flex !important;
                gap: 0;
            }
            #testimonial-slider .slick-slide {
                height: inherit !important;
                display: flex !important;
                justify-content: center;
            }
            #testimonial-slider .slick-slide > div {
                width: 100%;
                display: flex;
            }
            .tutor-card-body {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                min-height: 4.5rem; /* Exactly 3 lines at 1.5 line-height */
            }
            
            /* Custom slick dots matching card borders */
            #testimonial-slider .slick-dots {
                display: flex !important;
                justify-content: center;
                align-items: center;
                gap: 10px;
                list-style: none;
                margin-top: 32px;
                padding: 0;
                position: static !important; /* Prevent absolute positioning from clipping */
            }
            #testimonial-slider .slick-dots li {
                margin: 0;
                width: 6px;
                height: 6px;
            }
            #testimonial-slider .slick-dots li button {
                width: 6px;
                height: 6px;
                padding: 0;
                border: none;
                border-radius: 50%;
                background: rgba(251, 161, 19, 0.3); /* Solid inactive color */
                text-indent: -9999px;
                overflow: hidden;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            #testimonial-slider .slick-dots li button:before {
                display: none; /* Hide default slick font icons */
            }
            #testimonial-slider .slick-dots li.slick-active button {
                background-color: rgba(251, 161, 19, 1); /* Solid active color */
                transform: scale(1.3);
            }
            #testimonial-slider .slick-dots li button:hover {
                background-color: rgba(251, 161, 19, 0.6);
            }
        </style>


        <div id="testimonial-slider" class="mt-12 px-4 pb-8">
            @php
                $platformTestimonials = [
                    [
                        'name' => 'Ayesha Khan',
                        'location' => 'Lahore, Pakistan',
                        'review' => 'Tutor Hub made it so easy to find the perfect math tutor for my son. His grades improved within weeks, and the tutor’s dedication was beyond our expectations.'
                    ],
                    [
                        'name' => 'Bilal Ahmed',
                        'location' => 'Karachi, Pakistan',
                        'review' => 'I applied as a tutor on Tutor Hub and was matched with students within a few days. The platform is professional, and payments are always on time.'
                    ],
                    [
                        'name' => 'Emily Thompson',
                        'location' => 'Toronto, Canada',
                        'review' => 'TutorHub helped my Grade 11 son finally understand chemistry and advanced functions. His confidence in class has skyrocketed, and his teacher even commented on his progress.'
                    ],
                    [
                        'name' => 'Olivia Anderson',
                        'location' => 'London, United Kingdom',
                        'review' => 'My daughter was preparing for her GCSE maths and science exams under the UK National Curriculum. The tutor from TutorHub made complex topics simple, and her predicted grades have already improved.'
                    ],
                    [
                        'name' => 'Omar Al Suwaidi',
                        'location' => 'Dubai, UAE',
                        'review' => 'Our son follows the British Curriculum here in Dubai and needed help with A-Level physics. TutorHub found us a tutor who explained concepts so clearly that his mock exam scores went from 65% to 88% in just two months.'
                    ],
                    [
                        'name' => 'Sarah Johnson',
                        'location' => 'New York, USA',
                        'review' => 'My daughter is in Grade 11 under the US Common Core Curriculum and was struggling with Algebra II and AP Chemistry. TutorHub connected us with an exceptional tutor who broke down every concept into simple steps. Within weeks, her grades improved, and she now feels confident going into her college prep exams.'
                    ],
                    [
                        'name' => 'Sana Malik',
                        'location' => 'Karachi, Pakistan',
                        'review' => 'My son is enrolled in the IB Diploma Programme and was struggling with Higher Level Physics. TutorHub found a tutor with IB expertise who made the lessons interactive and easy to understand. His predicted grade improved from 5 to 7.'
                    ],
                    [
                        'name' => 'Maria Zafar',
                        'location' => 'Islamabad, Pakistan',
                        'review' => 'My daughter was preparing for her O-Level English Language exam. The tutor from TutorHub gave her targeted practice and valuable tips, and she achieved an A in her final result.'
                    ],
                    [
                        'name' => 'Omar Al Sudairy',
                        'location' => 'Dammam, Saudi Arabia',
                        'review' => 'We were looking for a qualified teacher for my son\'s A-Level Economics. TutorHub found the perfect match. The tutor not only covered the syllabus thoroughly but also trained him on exam techniques, boosting his confidence for finals.'
                    ]
                ];
            @endphp
            @foreach($platformTestimonials as $testimonial)
                <div class="px-3">
                    <div class="bg-white rounded-xl p-8 border border-secondary/20 shadow-sm hover:shadow-md transition-all duration-300 h-full flex flex-col" style="min-height: 300px;">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-full overflow-hidden shrink-0 border border-gray-100">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial['name']) }}&background=EBF4FF&color=3b82f6" alt="{{ $testimonial['name'] }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-800 leading-tight mb-1">{{ $testimonial['name'] }}</h4>
                                <p class="text-xs text-gray-600">{{ $testimonial['location'] }}</p>
                            </div>
                        </div>

                        <div class="flex-1 mb-6">
                            <p class="text-gray-500 text-sm leading-relaxed" style="display: -webkit-box; -webkit-line-clamp: 8; -webkit-box-orient: vertical; overflow: hidden;">
                                "{{ $testimonial['review'] }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-1 mt-auto">
                            @foreach(range(1, 5) as $star)
                                <i class="fas fa-star text-sm" style="color: #FBA113;"></i>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ==================== QUICK SEARCH DIRECTORY ==================== --}}
<section class="py-16 bg-slate-50/70 border-t border-b border-gray-100 overflow-hidden">
    <div class="container">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.25em] mb-3 block">Browse Directory</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-3">Quick Search Directory</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-[15px] leading-relaxed">Select a city or region below to quickly find certified home and online tutors near you.</p>
        </div>

        {{-- Directory Tabs --}}
        <div class="flex flex-wrap justify-center gap-3 mb-10" data-aos="fade-up">
            <button onclick="switchHomeDirectoryTab('Pakistan')" id="home-tab-btn-pakistan"
                    class="home-directory-tab-btn px-7 py-3.5 rounded-xl text-sm font-bold uppercase tracking-wider transition-all bg-blue-600 text-white shadow-md">
                <i class="fas fa-globe-asia mr-2 text-yellow-300"></i> Tutors in Pakistan
            </button>
            <button onclick="switchHomeDirectoryTab('Lahore')" id="home-tab-btn-lahore"
                    class="home-directory-tab-btn px-7 py-3.5 rounded-xl text-sm font-bold uppercase tracking-wider transition-all bg-white text-gray-600 hover:bg-gray-100 border border-gray-200">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Tutors in Lahore
            </button>
            <button onclick="switchHomeDirectoryTab('Karachi')" id="home-tab-btn-karachi"
                    class="home-directory-tab-btn px-7 py-3.5 rounded-xl text-sm font-bold uppercase tracking-wider transition-all bg-white text-gray-600 hover:bg-gray-100 border border-gray-200">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Tutors in Karachi
            </button>
            <button onclick="switchHomeDirectoryTab('Islamabad')" id="home-tab-btn-islamabad"
                    class="home-directory-tab-btn px-7 py-3.5 rounded-xl text-sm font-bold uppercase tracking-wider transition-all bg-white text-gray-600 hover:bg-gray-100 border border-gray-200">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Tutors in Islamabad
            </button>
        </div>

        {{-- Directory Panels Wrapper --}}
        <div class="space-y-12">
            @php
                $locations = [
                    'Pakistan' => '',
                    'Lahore' => 'Lahore',
                    'Karachi' => 'Karachi',
                    'Islamabad' => 'Islamabad'
                ];
            @endphp

            @foreach($locations as $name => $cityVal)
                <div id="home-directory-{{ strtolower($name) }}" class="home-directory-panel {{ $loop->first ? '' : 'hidden' }} space-y-12" data-aos="fade-up">
                    
                    {{-- Row 1: Home Tutors --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">
                                <i class="fas fa-home text-sm"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Home Tutors in {{ $name }}</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            {{-- O Level Home Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">O Level Home Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=chemistry{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Chemistry Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Math Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=physics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Physics Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=accounting{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Accounting Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=business{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Business Home Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>

                            {{-- A Level Home Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">A Level Home Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=chemistry{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Chemistry Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Math Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=physics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Physics Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=business{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Business Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=economics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Economics Home Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>

                            {{-- IB Home Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">IB Home Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=chemistry{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Chemistry Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Math Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=physics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Physics Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=business{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Business Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=economics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Economics Home Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>

                            {{-- Grade 1-8 Home Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">Grade 1-8 Home Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=montessori{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Montessori Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=child{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Primary Grade Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=english{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 5 Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 8 Home Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=quran{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Quran Home Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Online Tutors --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fas fa-laptop text-sm"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Online Tutors in {{ $name }}</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            {{-- O Level Online Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">O Level Online Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=chemistry{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Chemistry Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Math Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=physics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Physics Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=accounting{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Accounting Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=business{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Business Online Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>

                            {{-- A Level Online Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">A Level Online Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=chemistry{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Chemistry Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Math Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=physics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Physics Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=business{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Business Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=economics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Economics Online Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>

                            {{-- IB Online Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">IB Online Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=chemistry{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Chemistry Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Math Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=physics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Physics Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=business{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Business Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=economics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Economics Online Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>

                            {{-- Grade 1-8 Online Column --}}
                            <div>
                                <h4 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">Grade 1-8 Online Tutors</h4>
                                <ul class="space-y-2.5 text-[13px] text-gray-600">
                                    <li><a href="{{ route('for-students') }}?q=montessori{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Montessori Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=child{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Primary Grade Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=english{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 5 Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=mathematics{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 8 Online Tutor in {{ $name }}</span></a></li>
                                    <li><a href="{{ route('for-students') }}?q=quran{{ $cityVal ? '&city='.$cityVal : '' }}" class="text-blue-600 underline hover:no-underline flex items-start gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Quran Online Tutor in {{ $name }}</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- READ MORE Button --}}
                    <div class="text-center pt-4">
                        <a href="{{ route('for-students') }}{{ $cityVal ? '?city='.$cityVal : '' }}"
                           class="read-more-btn inline-flex items-center gap-2 font-black text-xs uppercase tracking-widest px-8 py-3.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white transition-all duration-300 hover:scale-105 active:scale-95 shadow-md hover:shadow-orange-500/25">
                            Read More Tutors in {{ $name }} <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ SECTION --}}
<section id="faq" class="pt-4 pb-12 bg-white overflow-hidden">
    <div class="container">
        <div class="text-center mb-16">
            <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] mb-4 block">Got Questions?</span>
            <h2 class="text-4xl font-black text-gray-900 leading-tight">Frequently Asked Questions</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-4 md:gap-6 max-w-6xl mx-auto items-start">
            @php
                $faqs = [
                    ['q' => 'Why choose Tutor Hub over other tutoring platforms?', 'a' => 'Tutor Hub is your trusted partner in unlocking academic excellence. Whether you prefer learning face to face in the comfort of your home or value the ease of personalized online sessions, Tutor Hub gives you both options with unmatched flexibility. We connect you with top-tier tutors who understand your needs and schedule. Begin your journey toward success with Tutor Hub today. Your goals are our priority.'],
                    ['q' => 'Is it safe to hire a tutor through Tutor Hub?', 'a' => 'At Tutor Hub, your safety and trust come first. Every tutor in our network is carefully screened with verified documents and professional references before joining our platform. We believe in full transparency so you can make informed decisions with confidence. Parents are always encouraged to stay involved, observe sessions, and evaluate tutors firsthand. With a built-in rating and review system, you get real insights from real families. Your peace of mind is our promise.'],
                    ['q' => 'How does Tutor Hub verify its tutors?', 'a' => 'At Tutor Hub, we follow a strict verification process to ensure only qualified and trustworthy individuals join our platform. Every tutor must submit personal identification documents, including CNIC and academic credentials. These are carefully cross-checked for authenticity. Until all required documents are reviewed and confirmed, no tutor is connected with any student. This process is in place to protect your trust and ensure quality at every step.'],
                    ['q' => 'Does Tutor Hub offer free trial sessions?', 'a' => 'Absolutely. At Tutor Hub, we believe you should experience the quality before making a commitment. That is why we offer free trial sessions to help you get comfortable with our teaching style. You can enjoy a 2-day free home tutoring trial or a 1-hour online session, all scheduled around your convenience. No pressure. Just a chance to see the difference the right tutor can make.'],
                    ['q' => 'How can I schedule a tutoring session with Tutor Hub?', 'a' => 'Scheduling a session with Tutor Hub is quick and easy. Whether you prefer home tutoring or online learning, our dedicated team is always ready to assist. Simply give us a call or send a message on WhatsApp, and our administrators will walk you through every step of the process with care and clarity. Your learning journey begins with one simple message. +92 3414133395'],
                    ['q' => 'How long is each tutoring session at Tutor Hub?', 'a' => 'At Tutor Hub, we understand that every learner has unique needs. That is why our sessions are designed with flexibility in mind. While the minimum booking time is 1 hour, you are free to extend your session based on your goals and pace. This gives you the freedom to dive deeper into your subject and get the most out of every moment with your tutor.'],
                    ['q' => 'How much do tutors earn at Tutor Hub?', 'a' => 'At Tutor Hub, we value the hard work and dedication of our tutors. That is why we offer a competitive monthly earning structure based on each tutor’s experience and qualifications. To support our platform’s operations and ensure top-quality service for students, a 50 percent commission is applied only on the first month’s earnings. This allows us to maintain a reliable system that benefits both tutors and learners alike.'],
                    ['q' => 'How can I become a tutor with Tutor Hub?', 'a' => 'Tutor Hub proudly welcomes passionate and qualified educators to join our growing team. The process is simple and straightforward. Just sign up through our website and share your profile along with your educational background. Once your documents and personal details are verified by our team, you will be ready to start connecting with students and making a real impact. Your journey toward meaningful teaching starts here.'],
                ];

                $leftFaqs = [];
                $rightFaqs = [];
                foreach ($faqs as $index => $faq) {
                    if ($index % 2 == 0) {
                        $leftFaqs[] = ['faq' => $faq, 'index' => $index];
                    } else {
                        $rightFaqs[] = ['faq' => $faq, 'index' => $index];
                    }
                }
            @endphp

            {{-- Left Column --}}
            <div class="space-y-4 md:space-y-6">
                @foreach($leftFaqs as $item)
                    @php
                        $faq = $item['faq'];
                        $index = $item['index'];
                    @endphp
                    <div class="faq-item border border-gray-100 rounded-3xl overflow-hidden transition-all hover:border-blue-200 w-full" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <button class="w-full text-left p-6 md:p-8 flex items-center justify-between gap-4 group" onclick="toggleFaq(this)">
                            <span class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $faq['q'] }}</span>
                            <span class="faq-icon w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div class="faq-content h-0 opacity-0 overflow-hidden transition-all duration-300 bg-gray-50/50">
                            <div class="p-8 pt-0 text-gray-500 leading-relaxed font-medium">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Right Column --}}
            <div class="space-y-4 md:space-y-6">
                @foreach($rightFaqs as $item)
                    @php
                        $faq = $item['faq'];
                        $index = $item['index'];
                    @endphp
                    <div class="faq-item border border-gray-100 rounded-3xl overflow-hidden transition-all hover:border-blue-200 w-full" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <button class="w-full text-left p-6 md:p-8 flex items-center justify-between gap-4 group" onclick="toggleFaq(this)">
                            <span class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $faq['q'] }}</span>
                            <span class="faq-icon w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div class="faq-content h-0 opacity-0 overflow-hidden transition-all duration-300 bg-gray-50/50">
                            <div class="p-8 pt-0 text-gray-500 leading-relaxed font-medium">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    function toggleFaq(btn) {
        const content = btn.nextElementSibling;
        const icon = btn.querySelector('.faq-icon');
        const allItems = document.querySelectorAll('.faq-content');
        const allIcons = document.querySelectorAll('.faq-icon');

        // Close others
        allItems.forEach((c, i) => {
            if (c !== content) {
                c.style.height = '0';
                c.style.opacity = '0';
                allIcons[i].style.transform = 'rotate(0deg)';
                c.parentElement.classList.remove('border-blue-200', 'shadow-xl', 'shadow-blue-500/5');
            }
        });

        if (content.style.height === '0px' || !content.style.height) {
            content.style.height = content.scrollHeight + 'px';
            content.style.opacity = '1';
            icon.style.transform = 'rotate(180deg)';
            btn.parentElement.classList.add('border-blue-200', 'shadow-xl', 'shadow-blue-500/5');
        } else {
            content.style.height = '0';
            content.style.opacity = '0';
            icon.style.transform = 'rotate(0deg)';
            btn.parentElement.classList.remove('border-blue-200', 'shadow-xl', 'shadow-blue-500/5');
        }
    }
</script>
    </div>
</div>

<style>
    #online-directory-section {
        background-color: #f4f4f5 !important;
        border-color: #e4e4e7 !important;
    }
    #online-directory-section h2 {
        color: #18181b !important;
    }
    #online-directory-section p {
        color: #52525b !important;
    }
    #online-directory-section h3 {
        color: #27272a !important;
        border-color: #d4d4d8 !important;
    }
    #online-directory-section ul {
        color: #52525b !important;
    }
    #online-directory-section ul a {
        text-decoration: underline !important;
    }
    #online-directory-section i {
        color: #a1a1aa !important;
    }
    #online-directory-section .view-all-btn,
    .read-more-btn {
        position: relative;
        z-index: 10;
        border-color: #f97316 !important;
        color: #ffffff !important;
        background-color: #f97316 !important;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3) !important;
    }
    #online-directory-section .view-all-btn:hover,
    .read-more-btn:hover {
        border-color: #ea580c !important;
        color: #ffffff !important;
        background-color: #ea580c !important;
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.5) !important;
    }
    #online-directory-section .view-all-btn i,
    .read-more-btn i {
        color: inherit !important;
    }
    #online-directory-section .view-all-btn::before,
    #online-directory-section .view-all-btn::after,
    .read-more-btn::before,
    .read-more-btn::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0.75rem; /* rounded-xl */
        background-color: #f97316;
        opacity: 0.6;
        z-index: -1;
        pointer-events: none;
    }
    #online-directory-section .view-all-btn::before,
    .read-more-btn::before {
        animation: orangePulseOut 2.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) infinite;
    }
    #online-directory-section .view-all-btn::after,
    .read-more-btn::after {
        animation: orangePulseOut 2.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) infinite;
        animation-delay: 1.1s;
    }
    @keyframes orangePulseOut {
        0% {
            transform: scale(1);
            opacity: 0.6;
        }
        50% {
            opacity: 0.4;
        }
        100% {
            transform: scale(1.15, 1.35);
            opacity: 0;
        }
    }
</style>
<section id="online-directory-section" class="py-16 bg-zinc-950 border-t border-zinc-900 text-white overflow-hidden">
    <div class="container">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-xs font-bold text-orange-500 uppercase tracking-[0.25em] mb-3 block">Global Learning</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-3">Online Tutors in Pakistan</h2>
            <p class="text-zinc-400 max-w-xl mx-auto text-[15px] leading-relaxed">Connect with top-rated online educators across various disciplines from the comfort of your home.</p>
        </div>

        {{-- Grid Container --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12" data-aos="fade-up">
            
            {{-- Column 1: O Level --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">O Level Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=chemistry&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Chemistry Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Math Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=physics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Physics Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=accounting&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Accounting Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=business&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Business Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=economics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Economics Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

            {{-- Column 2: A Level --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">A Level Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=chemistry&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Chemistry Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Math Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=physics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Physics Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=accounting&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Accounting Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=business&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Business Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=economics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Economics Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

            {{-- Column 3: Test Prep --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">Test Prep Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=sat&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">SAT Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=ielts&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IELTS Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=gre&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">GRE Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=prep&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">ECAT Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=prep&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">MDCAT Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=prep&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">ACT Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

            {{-- Column 4: IB --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">IB Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=chemistry&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Chemistry Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Math Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=physics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Physics Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=accounting&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Accounting Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=business&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Business Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=economics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Economics Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

            {{-- Column 5: AP --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">AP Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">AP Calculus Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=physics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">AP Physics Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=biology&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">AP Biology Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=english&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">AP English Literature Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=history&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">AP World History Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=child&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">AP Psychology Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

            {{-- Column 6: Mathematics --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">Mathematics Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Calculus Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Algebra Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Statistics Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Probability Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Discrete Math Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=mathematics&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Geometry Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

            {{-- Column 7: Computer Languages --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">Programming Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=programming&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">C++ Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=programming&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">JavaScript Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=python&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Python Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=programming&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">HTML Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=programming&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">CSS Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=programming&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Java Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

            {{-- Column 8: Languages & Literature --}}
            <div>
                <h3 class="text-sm font-bold text-zinc-200 uppercase tracking-wider mb-5 pb-3 border-b border-zinc-800/60">Languages Online Tutors</h3>
                <ul class="space-y-3 text-[13px] text-zinc-400">
                    <li><a href="{{ route('tutors.directory') }}?q=language&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Chinese Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=english&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">English Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=french&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">French Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=german&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">German Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=language&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Italian Online Tutor in Pakistan</span></a></li>
                    <li><a href="{{ route('tutors.directory') }}?q=language&tutoring_preference=online" class="hover:text-orange-500 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[8px] text-zinc-700 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Japanese Online Tutor in Pakistan</span></a></li>
                </ul>
            </div>

        </div>

        {{-- Center Button --}}
        <div class="text-center mt-16 pt-4">
            <a href="{{ route('tutors.directory') }}"
               class="view-all-btn inline-flex items-center gap-2.5 font-black text-xs uppercase tracking-widest px-8 py-4 rounded-xl border-2 border-zinc-800 hover:border-zinc-500 text-zinc-300 hover:text-white bg-transparent transition-all duration-300 hover:scale-105 active:scale-95 shadow-md">
                View All Disciplines <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</section>

{{-- ==================== TUTOR DETAIL MODAL ==================== --}}
<div id="tutor-modal"
     class="hidden fixed inset-0 z-50 items-center justify-center p-4"
     style="background:rgba(0,0,0,0.72);backdrop-filter:blur(5px);"
     onclick="if(event.target===this)closeTutorModal()">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg relative overflow-hidden"
         style="max-height:90vh;overflow-y:auto;">

        {{-- Close --}}
        <button onclick="closeTutorModal()"
                class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-all"
                style="flex-shrink:0;">
            <i class="fas fa-times text-gray-500 text-sm"></i>
        </button>

        {{-- Header --}}
        <div class="p-7 pb-5 flex items-start gap-5">
            <div id="modal-avatar" class="flex-shrink-0"></div>
            <div class="flex-1 min-w-0 pt-1">
                <h2 id="modal-name" class="text-2xl font-black text-gray-900 leading-tight mb-1.5"></h2>
                <p id="modal-qual" class="text-xs text-blue-600 font-bold leading-snug mb-3"></p>
                <span id="modal-exp"
                      class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full"
                      style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;"></span>
            </div>
        </div>

        <div class="mx-7 border-t border-gray-100"></div>

        {{-- Body --}}
        <div class="px-7 py-5 space-y-5">

            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Subjects</p>
                <div id="modal-tags" class="flex flex-wrap gap-2"></div>
            </div>

            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">About</p>
                <p id="modal-bio" class="text-sm text-gray-600 leading-relaxed"></p>
            </div>

            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Schools & Institutions</p>
                <p id="modal-affiliation" class="text-sm text-gray-600 font-semibold leading-relaxed"></p>
            </div>

        </div>

        <div class="mx-7 border-t border-gray-100"></div>

        {{-- Footer Buttons --}}
        <div class="px-7 py-6 flex gap-3">
            <a id="modal-book" href="#" target="_blank"
               class="flex-1 text-center text-[11px] font-black uppercase tracking-widest py-4 rounded-xl transition-all active:scale-95 flex items-center justify-center gap-2"
               style="background:#2563EB;color:#fff;">
                <i class="fas fa-calendar-check"></i> Book Session
            </a>
            <a href="https://wa.me/923414133395" target="_blank"
               class="flex items-center justify-center px-5 rounded-xl transition-all hover:bg-green-100"
               style="background:#f0fdf4;border:2px solid #bbf7d0;color:#16a34a;">
                <i class="fab fa-whatsapp text-xl"></i>
            </a>
        </div>
    </div>
</div>

{{-- ==================== GOOGLE REVIEWS MODAL ==================== --}}
<div id="google-reviews-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-950/70 backdrop-blur-md hidden" onclick="if(event.target===this)closeGoogleReviewsModal()">
    <div class="bg-white rounded-[2rem] w-full max-w-2xl overflow-hidden shadow-[0_24px_50px_-12px_rgba(0,0,0,0.25)] border border-gray-100 flex flex-col max-h-[85vh] animate-[modalFadeIn_0.3s_cubic-bezier(0.16,1,0.3,1)]">
        
        {{-- Header Section (Google Ratings Dashboard Layout) --}}
        <div class="relative p-6 sm:p-8 border-b border-gray-100 bg-gradient-to-b from-gray-50/80 to-white flex-shrink-0">
            {{-- Close Button --}}
            <button onclick="closeGoogleReviewsModal()" class="absolute top-4 sm:top-6 right-4 sm:right-6 text-gray-400 hover:text-gray-905 transition-colors p-2 rounded-full hover:bg-gray-100 cursor-pointer">
                <i class="fas fa-times text-lg"></i>
            </button>
            
            <div class="grid sm:grid-cols-2 gap-6 items-center pr-8">
                {{-- Overall Stats (Left) --}}
                <div class="flex flex-col items-center sm:items-start text-center sm:text-left">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-8 h-8" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.22-.67-.35-1.37-.35-2.09z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span class="text-base font-black text-gray-800 tracking-tight">Google Review Rating</span>
                    </div>
                    
                    <div class="flex items-baseline gap-2.5">
                        <span class="text-5xl font-black text-gray-900 tracking-tighter">4.9</span>
                        <span class="text-sm font-bold text-gray-400">/ 5.0</span>
                    </div>
                    
                    <div class="flex text-yellow-400 gap-1 my-2">
                        <i class="fas fa-star text-[14px]"></i>
                        <i class="fas fa-star text-[14px]"></i>
                        <i class="fas fa-star text-[14px]"></i>
                        <i class="fas fa-star text-[14px]"></i>
                        <i class="fas fa-star text-[14px]"></i>
                    </div>
                    
                    <span class="text-xs text-gray-500 font-bold">Based on 289 verified customer reviews</span>
                </div>
                
                {{-- Progress Bar Breakdown (Right) --}}
                <div class="space-y-1.5 text-xs font-semibold text-gray-500">
                    {{-- 5 Star --}}
                    <div class="flex items-center gap-3">
                        <span class="w-12 text-right">5 Star</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full" style="width: 95%"></div>
                        </div>
                        <span class="w-8 text-right text-gray-800 font-bold">95%</span>
                    </div>
                    {{-- 4 Star --}}
                    <div class="flex items-center gap-3">
                        <span class="w-12 text-right">4 Star</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full" style="width: 4%"></div>
                        </div>
                        <span class="w-8 text-right text-gray-800 font-bold">4%</span>
                    </div>
                    {{-- 3 Star --}}
                    <div class="flex items-center gap-3">
                        <span class="w-12 text-right">3 Star</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full" style="width: 1%"></div>
                        </div>
                        <span class="w-8 text-right text-gray-800 font-bold">1%</span>
                    </div>
                    {{-- 2 Star --}}
                    <div class="flex items-center gap-3">
                        <span class="w-12 text-right">2 Star</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full" style="width: 0%"></div>
                        </div>
                        <span class="w-8 text-right text-gray-800 font-bold">0%</span>
                    </div>
                    {{-- 1 Star --}}
                    <div class="flex items-center gap-3">
                        <span class="w-12 text-right">1 Star</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full" style="width: 0%"></div>
                        </div>
                        <span class="w-8 text-right text-gray-800 font-bold">0%</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Reviews List (Scrollable) --}}
        <div class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-5 bg-gray-50/50">
            @php
                $googleReviewsList = [
                    [
                        'name' => 'Ayesha Khan',
                        'avatar' => 'AK',
                        'bg' => 'linear-gradient(135deg, #3b82f6, #1d4ed8)',
                        'rating' => 5,
                        'time' => '2 weeks ago',
                        'text' => 'Tutor Hub has been an absolute game changer for my daughter\'s O Level Chemistry & Physics prep. Within 2 months, her concepts cleared up completely. Highly recommended!'
                    ],
                    [
                        'name' => 'Muhammad Bilal',
                        'avatar' => 'MB',
                        'bg' => 'linear-gradient(135deg, #10b981, #047857)',
                        'rating' => 5,
                        'time' => '1 month ago',
                        'text' => 'Extremely professional tutors. The convenience of learning from home while getting quality guidance is unmatched. The customer service support is very responsive.'
                    ],
                    [
                        'name' => 'Sarah Jenkins',
                        'avatar' => 'SJ',
                        'bg' => 'linear-gradient(135deg, #f59e0b, #b45309)',
                        'rating' => 5,
                        'time' => '2 months ago',
                        'text' => 'Highly qualified teachers who really focus on conceptual clarity rather than rote memorization. My son scored A* in O Level Math under Murtaza Ali\'s mentorship.'
                    ],
                    [
                        'name' => 'Dr. Kamran Malik',
                        'avatar' => 'KM',
                        'bg' => 'linear-gradient(135deg, #8b5cf6, #6d28d9)',
                        'rating' => 5,
                        'time' => '3 months ago',
                        'text' => 'As a parent, I was looking for a dedicated A Level Chemistry teacher. Tutor Hub helped me find the perfect matching profile within 24 hours. Exceptionally helpful coordinators!'
                    ]
                ];
            @endphp
            
            @foreach($googleReviewsList as $review)
                <div class="bg-white border border-gray-100 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md hover:scale-[1.005] hover:border-gray-200 transition-all duration-200 flex gap-4 items-start">
                    {{-- Avatar Wrapper with Google Icon Badge overlay --}}
                    <div class="relative flex-shrink-0">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md"
                             style="background: {{ $review['bg'] }}">
                            {{ $review['avatar'] }}
                        </div>
                        {{-- Small Google overlay icon badge --}}
                        <div class="absolute -bottom-1.5 -right-1.5 w-5.5 h-5.5 bg-white border border-gray-100 rounded-full flex items-center justify-center shadow-sm">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.22-.67-.35-1.37-.35-2.09z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-[15px] font-black text-gray-900 leading-tight">{{ $review['name'] }}</h4>
                            <span class="text-xs text-gray-400 font-bold">{{ $review['time'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex text-yellow-400 gap-0.5">
                                @for($i = 0; $i < $review['rating']; $i++)
                                    <i class="fas fa-star text-[10px]"></i>
                                @endfor
                            </div>
                            <span class="inline-flex items-center gap-1 text-[9px] font-black text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                <i class="fas fa-check-circle text-[9px]"></i> Verified Reviewer
                            </span>
                        </div>
                        <p class="text-[13.5px] text-gray-600 leading-relaxed font-medium">{{ $review['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- Modal Footer --}}
        <div class="p-6 bg-gradient-to-t from-gray-50/80 to-white border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 flex-shrink-0">
            <span class="text-[11px] text-gray-400 font-bold text-center sm:text-left leading-normal">
                Ratings are based on genuine surveys of parents & students.
            </span>
            <a href="https://www.google.com/search?q=TutorHub+Pakistan+reviews" target="_blank"
               class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-widest px-6 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 active:scale-95 whitespace-nowrap cursor-pointer">
                Write a Review
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes directoryFadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .home-directory-panel:not(.hidden) {
        animation: directoryFadeIn 0.35s ease-out forwards;
    }
    @keyframes tabPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(37, 99, 235, 0); }
    }
    .home-directory-tab-btn {
        transition: all 0.25s ease-in-out !important;
        animation: tabPulse 2s infinite ease-in-out;
    }
    .home-directory-tab-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(37, 99, 235, 0.12) !important;
    }
    .home-directory-panel a i {
        transition: transform 0.2s ease-in-out !important;
    }
    .home-directory-panel a:hover i {
        transform: translateX(4px);
    }
</style>
@endsection

@push('scripts')
<script>
    // Tab switcher for Home Directory Directory Links
    function switchHomeDirectoryTab(city) {
        document.querySelectorAll('.home-directory-panel').forEach(p => p.classList.add('hidden'));
        const panel = document.getElementById(`home-directory-${city.toLowerCase()}`);
        if (panel) panel.classList.remove('hidden');

        document.querySelectorAll('.home-directory-tab-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
            btn.classList.add('bg-white', 'text-gray-600', 'hover:bg-gray-100', 'border', 'border-gray-200');
            const icon = btn.querySelector('i');
            if (icon) {
                icon.classList.remove('text-yellow-300');
                icon.classList.add('text-blue-600');
            }
        });

        const activeBtn = document.getElementById(`home-tab-btn-${city.toLowerCase()}`);
        if (activeBtn) {
            activeBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
            activeBtn.classList.remove('bg-white', 'text-gray-600', 'hover:bg-gray-100', 'border', 'border-gray-200');
            const icon = activeBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('text-blue-600');
                icon.classList.add('text-yellow-300');
            }
        }
    }

    // CountUp animation
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const targetAttr = el.getAttribute('data-target');
                    const suffix = el.getAttribute('data-suffix') || '';
                    
                    if (isNaN(targetAttr) || targetAttr.includes('.')) {
                        el.textContent = targetAttr + suffix;
                        observer.unobserve(el);
                        return;
                    }
                    
                    const target = parseInt(targetAttr);
                    let current = 0;
                    const duration = 2000; // 2 seconds
                    const frameRate = 1000 / 60;
                    const totalFrames = Math.round(duration / frameRate);
                    let frame = 0;

                    const timer = setInterval(() => {
                        frame++;
                        const progress = frame / totalFrames;
                        current = Math.round(target * progress);
                        
                        if (frame >= totalFrames) {
                            current = target;
                            clearInterval(timer);
                        }
                        
                        el.textContent = current.toLocaleString() + suffix;
                    }, frameRate);
                    
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.1 });

        counters.forEach(counter => observer.observe(counter));
    });

    // Slick Testimonial & Tutors Slider
    $(document).ready(function() {
        $('#testimonial-slider').slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 500,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            cssEase: 'linear',
            pauseOnHover: true,
            pauseOnFocus: true,
            responsive: [
                { breakpoint: 10000, settings: { slidesToShow: 3, slidesToScroll: 1, infinite: true }},
                { breakpoint: 1024, settings: { slidesToShow: 2, slidesToScroll: 1, initialSlide: 2 }},
                { breakpoint: 640, settings: { slidesToShow: 1, slidesToScroll: 1 }}
            ]
        });
        $('#tutors-slider-desktop').slick({
            dots: true,
            arrows: true,
            prevArrow: $('#tutors-prev-desktop'),
            nextArrow: $('#tutors-next-desktop'),
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000
        });

        $('#tutors-slider-mobile').slick({
            dots: true,
            arrows: true,
            prevArrow: $('#tutors-prev-mobile'),
            nextArrow: $('#tutors-next-mobile'),
            infinite: true,
            speed: 500,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            responsive: [
                { breakpoint: 640, settings: { slidesToShow: 1, slidesToScroll: 1 } }
            ]
        });

        // Force AOS to recalculate offsets after slick slider pushes DOM height
        setTimeout(function() {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }, 500);
    });
</script>

<script>
// ── Hero Subject Search ──────────────────────────────────────────
const _heroSubjects = [
    { label:'Primary and Middle Grades',            value:'Primary and Middle Grades',            icon:'fa-child' },
    { label:'Cambridge O Level / IGCSE / ICE',      value:'Cambridge O Level / IGCSE / ICE',      icon:'fa-graduation-cap' },
    { label:'Cambridge A Level / Pre-U / AICE',     value:'Cambridge A Level / Pre-U / AICE',     icon:'fa-university' },
    { label:'AP (Advanced Placement®)',             value:'AP (Advanced Placement®)',             icon:'fa-award' },
    { label:'Standard Tests',                       value:'Standard Tests',                       icon:'fa-file-alt' },
    { label:'IB Diploma Programme',                 value:'IB Diploma Programme',                 icon:'fa-book-reader' },
    { label:'Matriculation',                        value:'Matriculation',                        icon:'fa-scroll' },
    { label:'F.Sc / I.Com / ICS',                   value:'F.Sc / I.Com / ICS',                   icon:'fa-school' },
    { label:'Mathematics',                          value:'Mathematics',                          icon:'fa-square-root-alt' },
    { label:'Business and Social Sciences',         value:'Business and Social Sciences',         icon:'fa-briefcase' },
    { label:'Languages and Literature',             value:'Languages and Literature',             icon:'fa-language' },
    { label:'Computer Languages',                   value:'Computer Languages',                   icon:'fa-laptop-code' },
    { label:'Quran',                                value:'Quran',                                icon:'fa-book-open' },
    { label:'Others',                              value:'Others',                               icon:'fa-ellipsis-h' }
];

const _tutorsDirectoryUrl = "{{ route('tutors.directory') }}";
const _heroInput      = document.getElementById('hero-subject-input');
const _heroList       = document.getElementById('hero-suggestions');

function _renderSuggestions(q) {
    _heroList.innerHTML = '';
    const hits = q 
        ? _heroSubjects.filter(s => s.label.toLowerCase().includes(q.toLowerCase()))
        : _heroSubjects;

    if (!hits.length) { _heroList.classList.add('hidden'); return; }
    hits.forEach(function(s, i) {
        const li = document.createElement('li');
        li.style.cssText = 'display:flex;align-items:center;gap:12px;padding:12px 18px;cursor:pointer;border-bottom:1px solid #f3f4f6;transition:background 0.15s;' + (i === hits.length - 1 ? 'border:none;' : '');
        li.onmouseenter = function(){ this.style.background='#eff6ff'; };
        li.onmouseleave = function(){ this.style.background=''; };
        li.innerHTML = '<i class="fas ' + s.icon + '" style="color:#2563eb;font-size:13px;width:16px;text-align:center;flex-shrink:0;"></i>'
                     + '<span style="font-size:13px;font-weight:600;color:#374151;">' + s.label + '</span>'
                     + '<span style="margin-left:auto;font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;white-space:nowrap;">View Tutors</span>';
        li.addEventListener('mousedown', function(e) {
            e.preventDefault();
            window.location.href = _tutorsDirectoryUrl + '?q=' + encodeURIComponent(s.value);
        });
        _heroList.appendChild(li);
    });
    _heroList.classList.remove('hidden');
}

_heroInput.addEventListener('input',  function() { _renderSuggestions(this.value.trim()); });
_heroInput.addEventListener('focus',  function() { _renderSuggestions(this.value.trim()); });
_heroInput.addEventListener('click',  function() { _renderSuggestions(this.value.trim()); });
_heroInput.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { _heroList.classList.add('hidden'); this.blur(); }
    if (e.key === 'Enter' && this.value.trim()) {
        window.location.href = _tutorsDirectoryUrl + '?q=' + encodeURIComponent(this.value.trim());
    }
});
document.addEventListener('click', function(e) {
    if (!document.getElementById('hero-search-wrapper').contains(e.target)) {
        _heroList.classList.add('hidden');
    }
});

// Tutor Modal functionality
const tutorsData = @json($tutors);
const assetBase  = "{{ rtrim(asset(''), '/') }}";
function openTutorModal(id) {
    const tutor = tutorsData.find(t => t.id === id);
    if (!tutor) return;

    // Avatar
    const avatarHtml = tutor.photo
        ? `<div style="width:110px;height:110px;border-radius:1rem;overflow:hidden;border:2px solid #f1f5f9;background:#ffffff;">
               <img src="${assetBase}/${tutor.photo}" alt="${tutor.name}" style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block;">
           </div>`
        : `<div style="width:110px;height:110px;border-radius:1rem;display:flex;align-items:center;justify-content:center;color:#fff;font-size:2rem;font-weight:900;background:${tutor.bg};">
               ${tutor.initials}
           </div>`;
    document.getElementById('modal-avatar').innerHTML = avatarHtml;

    document.getElementById('modal-name').textContent = tutor.name;
    document.getElementById('modal-qual').textContent  = tutor.qualification;
    document.getElementById('modal-exp').innerHTML     = `<i class="fas fa-star" style="font-size:9px;"></i> ${tutor.experience}+ Years Experience`;
    document.getElementById('modal-bio').textContent         = tutor.bio;
    document.getElementById('modal-affiliation').textContent = tutor.affiliation;

    const tagsHtml = tutor.subject_tags.map(tag =>
        `<span style="font-size:10px;font-weight:900;padding:4px 12px;border-radius:9999px;text-transform:uppercase;letter-spacing:0.05em;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">${tag}</span>`
    ).join('');
    document.getElementById('modal-tags').innerHTML = tagsHtml;

    document.getElementById('modal-book').href =
        `https://wa.me/923414133395?text=Hi%2C%20I%20am%20interested%20in%20${encodeURIComponent(tutor.name)}`;

    const modal = document.getElementById('tutor-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeTutorModal() {
    const modal = document.getElementById('tutor-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openGoogleReviewsModal() {
    window.open('https://www.google.com/search?q=TutorHub+Pakistan+reviews', '_blank');
    const modal = document.getElementById('google-reviews-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeGoogleReviewsModal() {
    const modal = document.getElementById('google-reviews-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}
</script>
@endpush
