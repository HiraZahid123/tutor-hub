@extends('layouts.app')
@section('title', 'Tutor Policy - TutorHub')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-6 md:px-20 min-h-screen">
    <div class="max-w-4xl mx-auto" data-aos="fade-up">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8" data-aos="fade-right">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6">
                <h1 class="text-3xl md:text-4xl font-bold text-white" data-aos="fade-up" data-aos-delay="100">
                    Tutor Guidelines & Privacy
                </h1>
                <p class="mt-2 text-blue-100" data-aos="fade-up" data-aos-delay="200">
                    Our tutors play a vital role in maintaining a safe, private, and supportive learning environment.
                </p>
            </div>

            <div class="p-6 md:p-8">
                <p class="text-gray-700 text-lg leading-relaxed mb-8 border-l-4 border-blue-500 pl-4" data-aos="fade-up">
                    These responsibilities ensure student privacy, platform integrity, and quality education for all learners.
                </p>

                @php
                    $policies = [
                        ['title' => '1. Professional Behavior', 'text' => 'Tutors are expected to act respectfully and professionally at all times, especially when representing the platform. Communication should remain clear, appropriate, and inclusive.'],
                        ['title' => '2. Privacy & Data Protection', 'text' => 'All student information, including names, academic records, and personal identifiers, must be kept confidential. Tutors may not store, share, or disclose this data outside the session context.'],
                        ['title' => '3. Session Attendance', 'text' => 'Tutors must attend sessions promptly. If a cancellation is necessary, advance notice (ideally 12 hours) should be provided to minimize disruption for learners.'],
                        ['title' => '4. Preparedness & Structure', 'text' => 'Tutors should prepare relevant and personalized content for each session. Lessons must be structured, focused, and free from random or unverified materials.'],
                        ['title' => '5. No Unauthorized Recording', 'text' => 'Recording of sessions, screen captures, or saving chat logs without written permission is prohibited. Tutors are not allowed to store or share such content for personal or public use.'],
                        ['title' => '6. Student Respect & Safety', 'text' => 'Tutors must foster a safe, non-judgmental environment. Discrimination, bias, or coercion of any kind is not tolerated, and violations may lead to account suspension.'],
                        ['title' => '7. Academic Integrity', 'text' => 'Tutors should not complete student assignments or tests on their behalf. The goal is to guide students to learn — not to bypass academic effort.'],
                        ['title' => '8. Communication Boundaries', 'text' => 'All contact with students should occur within platform-approved channels. Personal messaging or off-platform contact without consent is not permitted.'],
                        ['title' => '9. Use of Learning Resources', 'text' => 'Only appropriate, age-aligned, and verified content should be used. Avoid using uncredited sources, AI-generated answers, or copyrighted material without permission.'],
                        ['title' => '10. Platform Compliance', 'text' => 'Tutors agree to follow all platform rules and updates, including privacy practices, code of conduct, and content guidelines as updated from time to time.'],
                    ];
                @endphp

                <div class="space-y-8">
                    @foreach($policies as $index => $item)
                        <div class="p-4 rounded-lg hover:bg-blue-50 transition-colors duration-200 hover:translate-x-1 transform"
                             data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                            <h2 class="text-xl font-semibold text-blue-700">{{ $item['title'] }}</h2>
                            <p class="mt-2 text-gray-700">{{ $item['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
