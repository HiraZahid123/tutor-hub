@extends('layouts.app')
@section('title', 'Tutoring Process - TutorHub')

@section('content')
<div class="bg-white min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12" data-aos="fade-down">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Tutor Onboarding Process</h1>
            <p class="text-lg text-gray-600">Our 6-step selection ensures quality education standards</p>
        </div>

        @php
            $steps = [
                ['title' => '1. Application Submission', 'desc' => 'Complete our online application form with your details, qualifications, and teaching preferences.', 'icon' => 'fas fa-file-alt', 'color' => 'bg-blue-100 text-blue-600'],
                ['title' => '2. Initial Contact', 'desc' => 'Our team will reach out via email or WhatsApp within 48 hours to acknowledge your application.', 'icon' => 'fas fa-envelope', 'color' => 'bg-green-100 text-green-600'],
                ['title' => '3. Screening Call', 'desc' => 'A short phone interview to discuss your experience, availability, and teaching approach.', 'icon' => 'fas fa-phone-alt', 'color' => 'bg-purple-100 text-purple-600'],
                ['title' => '4. Demo Session', 'desc' => 'Conduct a 15-20 minute demo lesson on a topic of your choice to showcase your teaching style.', 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'bg-amber-100 text-amber-600'],
                ['title' => '5. Assessment Test', 'desc' => 'Complete a subject-specific test to verify your expertise in your chosen teaching area.', 'icon' => 'fas fa-clipboard-check', 'color' => 'bg-red-100 text-red-600'],
                ['title' => '6. Final Approval', 'desc' => 'Successful candidates receive onboarding materials and can start accepting tutoring sessions.', 'icon' => 'fas fa-user-check', 'color' => 'bg-teal-100 text-teal-600'],
            ];
        @endphp

        <!-- Timeline -->
        <div class="relative">
            <!-- Timeline line -->
            <div class="hidden md:block absolute left-1/2 h-full w-1 bg-gray-200 transform -translate-x-1/2"></div>

            <div class="space-y-10 md:space-y-0">
                @foreach($steps as $index => $step)
                    <div class="relative flex flex-col md:flex-row items-center {{ $index % 2 === 0 ? 'md:flex-row-reverse' : '' }}"
                         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <!-- Content Card -->
                        <div class="md:w-5/12 p-6 rounded-lg shadow-sm border border-gray-100 {{ $step['color'] }} transition-all duration-300 hover:shadow-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-white bg-opacity-80 mr-4">
                                    <i class="{{ $step['icon'] }} text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $step['title'] }}</h3>
                                    <p class="mt-1 text-gray-600">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline dot (mobile) -->
                        <div class="md:hidden flex-shrink-0 w-5 h-5 rounded-full bg-blue-500 border-4 border-white shadow-sm my-4"></div>

                        <!-- Timeline dot (desktop) -->
                        <div class="hidden md:flex flex-shrink-0 absolute left-1/2 transform -translate-x-1/2 w-5 h-5 rounded-full bg-blue-500 border-4 border-white shadow-sm">
                            <span class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-gray-500">
                                Step {{ $index + 1 }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-20" data-aos="fade-up" data-aos-delay="400">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-md p-8 md:p-10 border border-gray-200">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                        Ready to Begin Your Teaching Journey?
                    </h2>
                    <p class="text-gray-600 mb-6 text-lg">
                        Join our network of passionate educators and make a lasting impact on students worldwide.
                    </p>
                    <div class="flex justify-center">
                        <a href="{{ route('register-tutor') }}"
                           class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-md transition-all duration-300 hover:from-blue-700 hover:to-indigo-700 hover:scale-103 hover:shadow-lg">
                            Start Your Application
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">Application takes less than 5 minutes to complete</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
