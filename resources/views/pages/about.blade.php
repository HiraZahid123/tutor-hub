@extends('layouts.app')
@section('title', 'About Us - TutorHub')

@section('content')
<div class="text-[#2f2f2f] font-sans bg-white">
    <div class="max-w-6xl mx-auto px-6 py-16">

        <!-- Leadership Team (TOP) -->
        <div id="team" class="mb-20" data-aos="fade-up">
            <div class="text-center mb-16">
                <span class="text-sm font-black text-orange-400 tracking-widest uppercase mb-2 block">The Minds Behind</span>
                <h2 class="text-4xl font-extrabold text-gray-900">Meet Our Leadership Team</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- CEO/Co-Founder -->
                <div class="bg-white rounded-[2rem] p-8 shadow-md hover:shadow-xl border border-gray-100 text-center hover:-translate-y-2 transition-all duration-300 group h-full flex flex-col justify-between">
                    <div>
                        <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-6 border-4 border-white shadow-lg group-hover:scale-105 transition-transform duration-500">
                            <img src="{{ asset('images/aftab alam.png') }}" alt="Engr. Hafiz Aftab Alam" class="w-full h-full object-cover" style="transform: scale(1.35) translateY(10px); object-position: center 15%;">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Engr. Hafiz Aftab Alam</h3>
                        <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Co-Founder & CEO</p>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <a href="https://www.linkedin.com/in/hafiz-aftab-alam-b7b676411" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0a66c2] hover:bg-[#004182] text-white text-xs font-semibold rounded-full shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105 transform">
                            <i class="fab fa-linkedin text-sm"></i>
                            <span>Connect on LinkedIn</span>
                        </a>
                    </div>
                </div>

                <!-- Academic Director -->
                <div class="bg-white rounded-[2rem] p-8 shadow-md hover:shadow-xl border border-gray-100 text-center hover:-translate-y-2 transition-all duration-300 group h-full flex flex-col justify-between">
                    <div>
                        <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-6 border-4 border-white shadow-lg group-hover:scale-105 transition-transform duration-500">
                            <img src="{{ asset('images/Usama Mustafa Academic Director.png') }}" alt="Usama Mustafa" class="w-full h-full object-cover" style="object-position: center 15%;">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Usama Mustafa</h3>
                        <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Academic Director</p>
                    </div>
                </div>

                <!-- Head of Operations -->
                <div class="bg-white rounded-[2rem] p-8 shadow-md hover:shadow-xl border border-gray-100 text-center hover:-translate-y-2 transition-all duration-300 group h-full flex flex-col justify-between">
                    <div>
                        <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-6 border-4 border-white shadow-lg group-hover:scale-105 transition-transform duration-500">
                            <img src="{{ asset('images/Khurram Mustafa Head of Operational Excellence (2).png') }}" alt="Khurram Mustafa" class="w-full h-full object-cover" style="object-position: center 15%;">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Khurram Mustafa</h3>
                        <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Head of Operational Excellence</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Us Hero -->
        <div class="bg-white border border-blue-200 text-blue-700 p-12 rounded-3xl mb-16 shadow-xl" data-aos="fade-up">
            <h1 class="text-5xl font-extrabold mb-4 text-blue-600">About Us</h1>
            <p class="text-lg leading-relaxed text-[#444]">
                Welcome to TutorHub — your trusted partner in personalized education.
                We connect passionate, experienced tutors with students who seek academic growth,
                confidence, and excellence. Whether it's exam prep or conceptual clarity,
                we tailor our tutoring to every student's unique needs.
            </p>
        </div>

        <!-- Feature Cards -->
        <div class="pt-16 border-t border-blue-50">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up" data-aos-delay="200">
                @php
                    $features = [
                        ['title' => 'Our Mission', 'desc' => 'To make quality education accessible to every student by bridging the gap between learning and understanding with customized, one-on-one tutoring sessions.'],
                        ['title' => 'Why Choose Us?', 'desc' => 'We handpick tutors who not only excel in academics but also inspire, mentor, and motivate students to reach their full potential with consistent support and care.'],
                        ['title' => 'Flexible Scheduling', 'desc' => 'Learn at your pace and time. Our tutors adapt to your schedule, making education convenient and stress-free.'],
                        ['title' => 'Subjects We Cover', 'desc' => 'From Math and Science to Languages and Arts, we cover a broad range of subjects across multiple education boards and curriculums.'],
                    ];
                @endphp
                @foreach($features as $index => $item)
                    <div class="bg-white border border-blue-100 p-6 rounded-2xl shadow-md hover:-translate-y-2 hover:shadow-blue-200 transition-transform"
                         data-aos="zoom-in" data-aos-delay="{{ 100 * $index }}">
                        <h3 class="text-blue-600 font-semibold text-xl mb-2">{{ $item['title'] }}</h3>
                        <p class="text-[#555]">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
