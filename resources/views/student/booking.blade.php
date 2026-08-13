@extends('layouts.app')

@section('title', 'Book a Session - ' . $tutor->name)

@section('content')
<section class="min-h-screen py-16 md:py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-blue-600 transition-colors mb-6">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    Back to Dashboard
                </a>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-2">Book Your Session</h1>
                <p class="text-slate-500 font-medium">
                    Scheduling with <span class="text-blue-600 font-bold">{{ $tutor->name }}</span>
                </p>
            </div>

            <x-booking-calendar :tutorId="$tutor->id" :currency="$tutor->display_currency" />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 text-left">
                <div class="bg-white p-5 rounded-2xl border border-sky-100 shadow-sm">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3 text-sm font-black shadow-sm" style="background-color: #0284c7; color: #ffffff;">1</div>
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide mb-2">Select Date</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Today is pre-selected. Tap the date box to open the calendar.</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-sky-100 shadow-sm">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center mb-3 text-sm font-black shadow-sm shadow-blue-200">2</div>
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide mb-2">Pick Time</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Choose start & end from dropdowns in 5-minute steps.</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-sky-100 shadow-sm">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center mb-3 text-sm font-black shadow-sm shadow-emerald-200">3</div>
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide mb-2">Confirm</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Add notes if needed and confirm your session request.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
