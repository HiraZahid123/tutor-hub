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
                    <div class="flex justify-center gap-4 w-full mb-8">
                        <a href="{{ route('for-students') }}"
                           class="hero-btn inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-base px-8 py-3 rounded-full transition-all duration-300 active:scale-95 flex-1 max-w-[195px]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                            Find Tutor
                        </a>
                        <a href="{{ route('register-tutor') }}"
                           class="hero-btn inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-base px-8 py-3 rounded-full transition-all duration-300 active:scale-95 flex-1 max-w-[195px]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/></svg>
                            Apply Tutor
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
                            <button onclick="if(document.getElementById('hero-subject-input').value.trim()){window.location.href='{{ route('for-students') }}?q='+encodeURIComponent(document.getElementById('hero-subject-input').value.trim().toLowerCase())}"
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
        <div class="counter_grid text-black text-center">
            <div class="mb-6 lg:mb-0">
                <p class="text-4xl font-bold"><span class="counter" data-target="{{ $stats['tutors'] }}" data-suffix="+">0</span></p>
                <p class="text-lg font-medium mt-1">Expert tutors</p>
            </div>
            <div class="mb-6 lg:mb-0">
                <p class="text-4xl font-bold"><span class="counter" data-target="{{ $stats['hours'] }}" data-suffix="">0</span></p>
                <p class="text-lg font-medium mt-1">Hours content</p>
            </div>
            <div class="mb-6 lg:mb-0">
                <p class="text-4xl font-bold"><span class="counter" data-target="{{ $stats['subjects'] }}" data-suffix="">0</span></p>
                <p class="text-lg font-medium mt-1">Subject and courses</p>
            </div>
            <div>
                <p class="text-4xl font-bold"><span class="counter" data-target="{{ $stats['students'] }}" data-suffix="">0</span></p>
                <p class="text-lg font-medium mt-1">Active students</p>
            </div>
        </div>
    </div>
</section>

{{-- ==================== WHY CHOOSE US ==================== --}}
<section class="overflow-x-hidden">
    <div class="container">
        <div class="text-center">
            <span class="text-blue-700 text-lg font-semibold uppercase">Why Choose us</span>
            <h1 class="text-3xl md:text-4xl font-semibold mt-2 max-w-[500px] m-auto leading-tight">
                Benefits of online tutoring services with us
            </h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-9">
            @php
                $whyChooseData = [
                    ['title' => 'One-on-one Teaching', 'desc' => 'All of our special education experts have a degree in special education.', 'icon' => 'fas fa-om', 'bgColor' => '#0063ff', 'delay' => 100],
                    ['title' => '24/7 Tutor Availability', 'desc' => 'Our tutors are always available to respond as quick as possible for you', 'icon' => 'fas fa-dumbbell', 'bgColor' => '#73bc00', 'delay' => 200],
                    ['title' => 'Interactive Whiteboard', 'desc' => 'Our digital whiteboard equipped with audio and video chat features.', 'icon' => 'fas fa-briefcase', 'bgColor' => '#fa6400', 'delay' => 300],
                    ['title' => 'Affordable Prices', 'desc' => 'Choose an expert tutor based on your budget and per hour.', 'icon' => 'fas fa-tags', 'bgColor' => '#fe6baa', 'delay' => 400],
                ];
            @endphp
            @foreach($whyChooseData as $data)
                <div class="bg-slate-50 shadow-[0_0_22px_0_rgba(0,0,0,0.15)] p-7 rounded-xl" data-aos="fade-left" data-aos-delay="{{ $data['delay'] }}">
                    <div style="background-color: {{ $data['bgColor'] }}" class="w-10 h-10 flex items-center justify-center rounded-lg mb-2">
                        <span class="text-2xl text-white"><i class="{{ $data['icon'] }}"></i></span>
                    </div>
                    <h3 class="text-[21px] lg:text-lg mb-1 font-semibold">{{ $data['title'] }}</h3>
                    <p class="text-lg lg:text-base text-gray-600">{{ $data['desc'] }}</p>
                </div>
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
        </style>

        <div class="relative px-4 md:px-12 mb-10" data-aos="fade-up">
            {{-- Prev Arrow --}}
            <button id="tutors-prev" class="slider-arrow-btn left-0 md:left-2">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>

            {{-- Slider Container --}}
            <div id="tutors-slider" class="slick-slider-custom">
                @php
                $homeTutors = [
                    ['id'=>1, 'name'=>'Murtaza Ali','qual'=>'M.Sc. Applied Mathematics, Punjab University','tags'=>['Mathematics','O/A Level','SAT·GRE·GAT'],'exp'=>25,'city'=>'Lahore','initials'=>'MA','bg'=>'#2563EB','photo'=>'images/Murtaza ali.png'],
                    ['id'=>2, 'name'=>'Shamoil','qual'=>'MPhil Physics, UET Lahore','tags'=>['Physics','O/A Level','IBDP·MYP'],'exp'=>19,'city'=>'Lahore','initials'=>'SM','bg'=>'#7c3aed','photo'=>'images/Shamoil.png'],
                    ['id'=>3, 'name'=>'Faiza Javaid','qual'=>'M.A., M.Ed., B.S. Chemistry/Biology','tags'=>['Chemistry','Biology','O/A Level·AP·IB'],'exp'=>15,'city'=>'Lahore','initials'=>'FJ','bg'=>'#16a34a','photo'=>'images/faiza javad.png'],
                    ['id'=>4, 'name'=>'Iqra','qual'=>'MPhil Microbiology, UAF','tags'=>['Chemistry','O/A Level · AP','IB Chemistry'],'exp'=>28,'city'=>'Lahore','initials'=>'IQ','bg'=>'#0d9488','photo'=>'images/Iqra.png'],
                    ['id'=>5, 'name'=>'Areej','qual'=>'Diploma in Montessori Education (AMI)','tags'=>['Montessori','Early Childhood','Phonics'],'exp'=>15,'city'=>'Lahore','initials'=>'AR','bg'=>'#ec4899','photo'=>'images/Areej.png'],
                    ['id'=>6, 'name'=>'Samiya','qual'=>'Chartered Accountant (CA) — ICAP','tags'=>['Accounting','Business','O/A Level'],'exp'=>19,'city'=>'Lahore','initials'=>'SA','bg'=>'#ea580c','photo'=>'images/Samiya.png'],
                    ['id'=>7, 'name'=>'Rotua','qual'=>'Master\'s in German, NUML','tags'=>['German','Goethe Prep','O/A Level'],'exp'=>16,'city'=>'Lahore','initials'=>'RO','bg'=>'#dc2626','photo'=>'images/Rotua.png'],
                    ['id'=>8, 'name'=>'Nicolas','qual'=>'Master\'s in French, Sorbonne','tags'=>['French','DELF/DALF','O/A Level'],'exp'=>30,'city'=>'Lahore','initials'=>'NL','bg'=>'#1e3a8a','photo'=>'images/Nicolas.png'],
                ];
                @endphp
                @foreach($homeTutors as $ht)
                <div class="px-3 h-full">
                    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1.5 hover:scale-[1.01] transition-all duration-300 overflow-hidden h-full flex flex-col justify-between" style="border: 1px solid #f3f4f6;">
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start gap-4 mb-4">
                                    @if(!empty($ht['photo']))
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-md flex-shrink-0"
                                             style="background-color:#ffffff;transform:translateZ(0);backface-visibility:hidden;">
                                            <img src="{{ asset($ht['photo']) }}" alt="{{ $ht['name'] }}" class="transition-transform duration-500 group-hover:scale-110" style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block;transform:translateZ(0);backface-visibility:hidden;">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-lg font-black shadow-md flex-shrink-0"
                                             style="background-color:{{ $ht['bg'] }};">
                                            {{ $ht['initials'] }}
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0 pt-0.5">
                                        <h3 class="text-lg font-black text-gray-900 mb-1 leading-tight">{{ $ht['name'] }}</h3>
                                        <p class="text-[11px] text-blue-600 font-bold leading-snug">{{ $ht['qual'] }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-1.5 mb-5">
                                    @foreach($ht['tags'] as $tag)
                                    <span class="text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider" style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-xs font-bold text-gray-500"><i class="fas fa-star text-orange-400 mr-1"></i>{{ $ht['exp'] }}+ Years · {{ $ht['city'] }}</span>
                                <a href="javascript:void(0)" onclick="openTutorModal({{ $ht['id'] }})"
                                   class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full bg-blue-50 text-blue-600 border border-blue-100 transition-all duration-300 hover:scale-105 active:scale-95 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 group-hover:shadow-lg group-hover:shadow-blue-500/25">
                                    <span>View</span>
                                    <i class="fas fa-arrow-right text-[8px] transition-transform duration-300 group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Next Arrow --}}
            <button id="tutors-next" class="slider-arrow-btn right-0 md:right-2">
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

{{-- FAQ SECTION --}}
<section class="pt-4 pb-12 bg-white overflow-hidden">
    <div class="container">
        <div class="text-center mb-16">
            <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] mb-4 block">Got Questions?</span>
            <h2 class="text-4xl font-black text-gray-900 leading-tight">Frequently Asked Questions</h2>
        </div>

        <div class="max-w-3xl mx-auto space-y-4">
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
            @endphp

            @foreach($faqs as $index => $faq)
                <div class="faq-item border border-gray-100 rounded-3xl overflow-hidden transition-all hover:border-blue-200 mt-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
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

            <div class="flex items-center gap-2.5">
                <i class="fas fa-map-marker-alt text-orange-500 text-sm flex-shrink-0"></i>
                <span id="modal-location" class="text-sm font-bold text-gray-700"></span>
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
@endsection

@push('scripts')
<script>
    // CountUp animation
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-target'));
                    const suffix = el.getAttribute('data-suffix') || '';
                    
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

        $('#tutors-slider').slick({
            dots: true,
            arrows: true,
            prevArrow: $('#tutors-prev'),
            nextArrow: $('#tutors-next'),
            infinite: true,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: 2, slidesToScroll: 1 }},
                { breakpoint: 640, settings: { slidesToShow: 1, slidesToScroll: 1 }}
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
    // Mathematics
    { label:'Mathematics',              value:'mathematics',           icon:'fa-square-root-alt' },
    { label:'O Level Mathematics',      value:'mathematics',           icon:'fa-square-root-alt' },
    { label:'A Level Mathematics',      value:'mathematics',           icon:'fa-square-root-alt' },
    { label:'IGCSE Mathematics',        value:'mathematics',           icon:'fa-square-root-alt' },
    { label:'Additional Mathematics',   value:'mathematics',           icon:'fa-square-root-alt' },
    { label:'SAT Preparation',          value:'mathematics',           icon:'fa-square-root-alt' },
    { label:'GRE / GAT Prep',           value:'mathematics',           icon:'fa-square-root-alt' },
    { label:'Entry Test Prep',          value:'mathematics',           icon:'fa-square-root-alt' },
    // Physics
    { label:'Physics',                  value:'physics',               icon:'fa-atom' },
    { label:'O Level Physics',          value:'physics',               icon:'fa-atom' },
    { label:'A Level Physics',          value:'physics',               icon:'fa-atom' },
    { label:'IGCSE Physics',            value:'physics',               icon:'fa-atom' },
    { label:'IBDP Physics',             value:'physics',               icon:'fa-atom' },
    { label:'MYP Physics',              value:'physics',               icon:'fa-atom' },
    // Chemistry
    { label:'Chemistry',                value:'chemistry',             icon:'fa-flask' },
    { label:'O Level Chemistry',        value:'chemistry',             icon:'fa-flask' },
    { label:'A Level Chemistry',        value:'chemistry',             icon:'fa-flask' },
    { label:'AP Chemistry',             value:'chemistry',             icon:'fa-flask' },
    { label:'IB Chemistry',             value:'chemistry',             icon:'fa-flask' },
    // Biology
    { label:'Biology',                  value:'biology',               icon:'fa-leaf' },
    { label:'Zoology',                  value:'biology',               icon:'fa-leaf' },
    { label:'Botany',                   value:'biology',               icon:'fa-leaf' },
    // CS
    { label:'Computer Science',         value:'computer',              icon:'fa-laptop-code' },
    { label:'Python Programming',       value:'computer',              icon:'fa-laptop-code' },
    { label:'OOP',                      value:'computer',              icon:'fa-laptop-code' },
    { label:'Data Structures',          value:'computer',              icon:'fa-laptop-code' },
    { label:'Algorithms',               value:'computer',              icon:'fa-laptop-code' },
    { label:'Web Development',          value:'computer',              icon:'fa-laptop-code' },
    { label:'IGCSE Computer Science',   value:'computer',              icon:'fa-laptop-code' },
    { label:'A Level Computer Science', value:'computer',              icon:'fa-laptop-code' },
    // AI
    { label:'Artificial Intelligence',  value:'artificial intelligence', icon:'fa-robot' },
    { label:'Machine Learning',         value:'artificial intelligence', icon:'fa-robot' },
    { label:'Deep Learning',            value:'artificial intelligence', icon:'fa-robot' },
    { label:'Robotics',                 value:'artificial intelligence', icon:'fa-robot' },
    { label:'Computer Vision',          value:'artificial intelligence', icon:'fa-robot' },
    // Commerce
    { label:'Accounting',               value:'accounting',            icon:'fa-calculator' },
    { label:'O Level Accounting',       value:'accounting',            icon:'fa-calculator' },
    { label:'A Level Accounting',       value:'accounting',            icon:'fa-calculator' },
    { label:'Business Studies',         value:'business',              icon:'fa-briefcase' },
    { label:'Economics',                value:'economics',             icon:'fa-chart-line' },
    { label:'Microeconomics',           value:'economics',             icon:'fa-chart-line' },
    { label:'Marketing',                value:'marketing',             icon:'fa-bullhorn' },
    // Humanities
    { label:'History',                  value:'history',               icon:'fa-landmark' },
    { label:'World History',            value:'history',               icon:'fa-landmark' },
    { label:'Pakistan Studies',         value:'pakistan studies',      icon:'fa-flag' },
    { label:'Geography',                value:'geography',             icon:'fa-globe' },
    // English
    { label:'English Language',         value:'english',               icon:'fa-language' },
    { label:'English Literature',       value:'english',               icon:'fa-language' },
    { label:'IGCSE English',            value:'english',               icon:'fa-language' },
    { label:'A Level English',          value:'english',               icon:'fa-language' },
    { label:'IELTS Preparation',        value:'english',               icon:'fa-language' },
    { label:'TOEFL Preparation',        value:'english',               icon:'fa-language' },
    { label:'Essay Writing',            value:'english',               icon:'fa-language' },
    // German
    { label:'German Language',          value:'german',                icon:'fa-language' },
    { label:'Goethe Certification',     value:'german',                icon:'fa-language' },
    { label:'O Level German',           value:'german',                icon:'fa-language' },
    // French
    { label:'French Language',          value:'french',                icon:'fa-language' },
    { label:'DELF / DALF',              value:'french',                icon:'fa-language' },
    { label:'O Level French',           value:'french',                icon:'fa-language' },
    // Quran & Islamic
    { label:'Quran (Tajweed)',          value:'quran',                 icon:'fa-book-open' },
    { label:'Quran Hifz',              value:'quran',                 icon:'fa-book-open' },
    { label:'Nazra',                    value:'quran',                 icon:'fa-book-open' },
    { label:'Islamic Studies',          value:'islamic',               icon:'fa-mosque' },
    { label:'Tafseer',                  value:'quran',                 icon:'fa-book-open' },
    // Music
    { label:'Music',                    value:'music',                 icon:'fa-music' },
    { label:'Piano Lessons',            value:'music',                 icon:'fa-music' },
    { label:'Guitar Lessons',           value:'music',                 icon:'fa-music' },
    { label:'Violin Lessons',           value:'music',                 icon:'fa-music' },
    { label:'ABRSM Grades 1–8',        value:'music',                 icon:'fa-music' },
    { label:'Vocal Training',           value:'music',                 icon:'fa-music' },
    // Montessori
    { label:'Montessori',               value:'montessori',            icon:'fa-child' },
    { label:'Early Childhood Education',value:'montessori',            icon:'fa-child' },
    { label:'Phonics',                  value:'montessori',            icon:'fa-child' },
    { label:'Nursery / KG',             value:'montessori',            icon:'fa-child' },
];

const _forStudentsUrl = "{{ route('for-students') }}";
const _heroInput      = document.getElementById('hero-subject-input');
const _heroList       = document.getElementById('hero-suggestions');

function _renderSuggestions(q) {
    _heroList.innerHTML = '';
    if (!q) { _heroList.classList.add('hidden'); return; }
    const hits = _heroSubjects.filter(s => s.label.toLowerCase().includes(q.toLowerCase()));
    if (!hits.length) { _heroList.classList.add('hidden'); return; }
    hits.slice(0, 9).forEach(function(s, i) {
        const li = document.createElement('li');
        li.style.cssText = 'display:flex;align-items:center;gap:12px;padding:12px 18px;cursor:pointer;border-bottom:1px solid #f3f4f6;transition:background 0.15s;' + (i === hits.length - 1 ? 'border:none;' : '');
        li.onmouseenter = function(){ this.style.background='#eff6ff'; };
        li.onmouseleave = function(){ this.style.background=''; };
        li.innerHTML = '<i class="fas ' + s.icon + '" style="color:#2563eb;font-size:13px;width:16px;text-align:center;flex-shrink:0;"></i>'
                     + '<span style="font-size:13px;font-weight:600;color:#374151;">' + s.label + '</span>'
                     + '<span style="margin-left:auto;font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;white-space:nowrap;">View Tutors</span>';
        li.addEventListener('mousedown', function(e) {
            e.preventDefault();
            window.location.href = _forStudentsUrl + '?q=' + encodeURIComponent(s.value);
        });
        _heroList.appendChild(li);
    });
    _heroList.classList.remove('hidden');
}

_heroInput.addEventListener('input',  function() { _renderSuggestions(this.value.trim()); });
_heroInput.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { _heroList.classList.add('hidden'); this.blur(); }
    if (e.key === 'Enter' && this.value.trim()) {
        window.location.href = _forStudentsUrl + '?q=' + encodeURIComponent(this.value.trim().toLowerCase());
    }
});
document.addEventListener('click', function(e) {
    if (!document.getElementById('hero-search-wrapper').contains(e.target)) {
        _heroList.classList.add('hidden');
    }
});

// Tutor Modal functionality
const tutorsData = [
    {
        id: 1,
        name: "Murtaza Ali",
        qualification: "M.Sc. Applied Mathematics, Punjab University",
        bio: "Expert in O/A Level and IGCSE Mathematics with 25+ years of experience. Specialist in SAT, GRE, GAT and entry test preparation for NUST, UET, FAST, LUMS, and IIU.",
        subject_tags: ["Mathematics", "O/A Level", "SAT · GRE · GAT"],
        experience: 25,
        affiliation: "Beaconhouse, LGS, Roots International, HITEC Cambridge, Zawiya Academy",
        country: "Pakistan",
        city: "Lahore",
        area: "DHA",
        initials: "MA",
        bg: "#2563EB",
        photo: "images/Murtaza ali.png"
    },
    {
        id: 2,
        name: "Shamoil",
        qualification: "MPhil Physics, UET Lahore",
        bio: "Specialized in CAIE O/A Level and IGCSE Physics with 19+ years at top international schools. Deep expertise in IBDP and MYP Physics.",
        subject_tags: ["Physics", "O/A Level", "IBDP · MYP"],
        experience: 19,
        affiliation: "LGS, ISL, Oneiro School House, King's House School London, Army Public School",
        country: "Pakistan",
        city: "Lahore",
        area: "Allama Iqbal Town",
        initials: "SM",
        bg: "#7c3aed",
        photo: "images/Shamoil.png"
    },
    {
        id: 3,
        name: "Faiza Javaid",
        qualification: "M.A., M.Ed., B.S. Zoology/Botany/Chemistry, B.Ed.",
        bio: "Versatile science educator with 15 years of experience in Cambridge Sciences, AP Chemistry, and IB Chemistry at top international schools.",
        subject_tags: ["Chemistry", "Biology · Zoology", "O/A Level · AP · IB"],
        experience: 15,
        affiliation: "Beaconhouse, The City School, Bloomfield Hall, Froebels International",
        country: "Pakistan",
        city: "Lahore",
        area: "Johar Town",
        initials: "FJ",
        bg: "#16a34a",
        photo: "images/faiza javad.png"
    },
    {
        id: 4,
        name: "Iqra",
        qualification: "MPhil Microbiology, UAF",
        bio: "Chemistry expert with 28 years of teaching and pharmaceutical industry experience, bridging academic chemistry with real-world applications.",
        subject_tags: ["Chemistry", "O/A Level · AP", "IB Chemistry"],
        experience: 28,
        affiliation: "Roots International, Bloomfield Hall, The City School",
        country: "Pakistan",
        city: "Lahore",
        area: "Gulberg",
        initials: "IQ",
        bg: "#0d9488",
        photo: "images/Iqra.png"
    },
    {
        id: 5,
        name: "Areej",
        qualification: "Diploma in Montessori Education (AMI Certified)",
        bio: "Specialist in Montessori early childhood education with 15 years of experience. AMI-trained with expertise in child development and activity-based learning.",
        subject_tags: ["Montessori", "Early Childhood", "Phonics · Nursery"],
        experience: 15,
        affiliation: "Beaconhouse (Montessori), LGS, Cornerstone School",
        country: "Pakistan",
        city: "Lahore",
        area: "Model Town",
        initials: "AR",
        bg: "#ec4899",
        photo: "images/Areej.png"
    },
    {
        id: 6,
        name: "Samiya",
        qualification: "Chartered Accountant (CA) — ICAP",
        bio: "CA-qualified educator with 19 years of experience in CAIE O/A Level Accounting, Business, and Economics. Expert in IGCSE and Edexcel curricula.",
        subject_tags: ["Accounting", "Business · Economics", "O/A Level · IGCSE"],
        experience: 19,
        affiliation: "American International School (AIS), International School of Lahore (ISL)",
        country: "Pakistan",
        city: "Lahore",
        area: "Gulberg",
        initials: "SA",
        bg: "#ea580c",
        photo: "images/Samiya.png"
    },
    {
        id: 7,
        name: "Rotua",
        qualification: "Master's in German Language & Literature, NUML",
        bio: "German language specialist (A1–C1) with 16 years of experience in Goethe Certification preparation, O/A Level German, and multilingual education.",
        subject_tags: ["German A1–C1", "Goethe Certification", "O/A Level German"],
        experience: 16,
        affiliation: "Roots International, Roots Millennium, Aitchison College, C.A.S. School Karachi",
        country: "Pakistan",
        city: "Lahore",
        area: "Garden Town",
        initials: "RO",
        bg: "#dc2626",
        photo: "images/Rotua.png"
    },
    {
        id: 8,
        name: "Nicolas",
        qualification: "Master's in French Language & Linguistics, Sorbonne",
        bio: "Native-level French educator (A1–C2) with 30 years of international experience. Expert in DELF/DALF preparation, O/A Level French, and immersive language teaching.",
        subject_tags: ["French A1–C2", "DELF/DALF Prep", "O/A Level French"],
        experience: 30,
        affiliation: "Sorbonne, LGS, Roots, Aitchison",
        country: "Pakistan",
        city: "Lahore",
        area: "DHA",
        initials: "NL",
        bg: "#1e3a8a",
        photo: "images/Nicolas.png"
    }
];

const assetBase = "{{ rtrim(asset(''), '/') }}";

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
    document.getElementById('modal-location').textContent    = `${tutor.area}, ${tutor.city}, ${tutor.country}`;

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
</script>
@endpush
