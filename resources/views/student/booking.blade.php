@extends('layouts.app')

@section('title', 'Book a Session - ' . $tutor->name)

@section('content')
<section class="min-h-screen py-20 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="mb-12">
                <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 hover:text-blue-600 transition-colors uppercase tracking-widest mb-6">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
                <h1 class="text-4xl font-black text-gray-900 mb-2">Book Your Session</h1>
                <p class="text-gray-500 font-medium">Scheduling time with <span class="text-blue-600 font-bold">{{ $tutor->name }}</span></p>
            </div>

            <div class="bg-white rounded-[2.5rem] p-4 shadow-2xl shadow-blue-500/5 mb-12">
                <x-booking-calendar :tutorId="$tutor->id" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100">
                    <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">1. Select Date</h4>
                    <p class="text-[11px] text-gray-600 font-medium leading-relaxed">Choose an available day from the interactive calendar on the left.</p>
                </div>
                <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100">
                    <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">2. Pick time</h4>
                    <p class="text-[11px] text-gray-600 font-medium leading-relaxed">Select a session slot that fits your schedule from the list.</p>
                </div>
                <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100">
                    <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">3. Confirm</h4>
                    <p class="text-[11px] text-gray-600 font-medium leading-relaxed">Add any specific notes for the tutor and confirm your request!</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
