@extends('layouts.dashboard')
@section('title', 'Sent Hire Requests - TutorHub')

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2">Sent Hire Requests</h1>
        <p class="text-gray-500 font-medium">Track your inquiries to tutors and their current status.</p>
    </div>

    @if($inquiries->isEmpty())
        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-20 text-center shadow-xl shadow-blue-500/5">
            <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-300">
                <i class="fas fa-paper-plane text-3xl"></i>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-2">No requests sent yet</h3>
            <p class="text-gray-400 text-sm font-medium">Browse our tutor list and find your perfect match today!</p>
            <a href="{{ url('/') }}" class="inline-block mt-8 bg-blue-600 text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">Find a Tutor</a>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($inquiries as $inquiry)
                <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-xl shadow-blue-500/5 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden group hover:border-blue-100 transition-all">
                    <!-- Tutor Image & Info -->
                    <div class="flex-shrink-0">
                        @php
                            $profilePic = $inquiry->tutor->profile_image 
                                ? asset('storage/' . $inquiry->tutor->profile_image) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($inquiry->tutor->name) . '&background=EBF4FF&color=3b82f6';
                        @endphp
                        <div class="w-24 h-24 rounded-3xl overflow-hidden border-4 border-gray-50 shadow-md flex-shrink-0 bg-gray-50">
                            <img src="{{ $profilePic }}" 
                                 alt="{{ $inquiry->tutor->name }}" 
                                 width="96" height="96"
                                 class="w-full h-full object-cover"
                                 style="width: 96px; height: 96px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-2 mb-3">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">{{ $inquiry->tutor->name }}</h3>
                            <span class="inline-block px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ 
                                $inquiry->status === 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 
                                ($inquiry->status === 'hired' ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-gray-50 text-gray-400 border border-gray-100')
                            }}">
                                {{ strtoupper($inquiry->status === 'hired' ? 'Accepted' : $inquiry->status) }}
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-6">
                            @if(is_array($inquiry->subjects))
                                @foreach($inquiry->subjects as $subject)
                                    <span class="px-3 py-1 bg-gray-50 text-gray-500 text-[9px] font-black uppercase tracking-tight rounded-xl border border-gray-100">
                                        {{ $subject }}
                                    </span>
                                @endforeach
                            @endif
                        </div>

                        <div class="p-4 bg-gray-50/50 rounded-2xl border border-gray-50 italic">
                            <p class="text-xs text-gray-500 line-clamp-1">"{{ $inquiry->message ?? 'No message provided.' }}"</p>
                        </div>
                    </div>

                    <div class="flex-shrink-0 text-center md:text-right">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Sent On</p>
                        <p class="text-sm font-black text-gray-900 mb-6">{{ $inquiry->created_at->format('M d, Y') }}</p>
                        
                        <div class="flex items-center gap-2 justify-center md:justify-end mb-4">
                            @if($inquiry->hiring_type === 'home')
                                <i class="fas fa-home text-indigo-500 text-xs"></i>
                                <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest">Home Tutoring</span>
                            @else
                                <i class="fas fa-globe text-blue-500 text-xs"></i>
                                <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest">Online Tutoring</span>
                            @endif
                        </div>

                        {{-- Message link removed --}}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $inquiries->links() }}
        </div>
    @endif
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
@endsection
