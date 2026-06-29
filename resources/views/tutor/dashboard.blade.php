@extends('layouts.dashboard')
@section('title', 'Tutor Dashboard - TutorHub')

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2">Welcome Back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-500 font-medium">Here's what's happening with your tutoring portal today.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5 flex items-center gap-5 group hover:-translate-y-1 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all">
                <i class="fas fa-handshake text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Leads</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5 flex items-center gap-5 group hover:-translate-y-1 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Active Requests</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $stats['pending'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5 flex items-center gap-5 group hover:-translate-y-1 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Acceptance Rate</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $stats['acceptance_rate'] }}%</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        <div class="lg:col-span-2 space-y-8">
            <!-- Registration Status Card -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden relative">
                <div class="relative z-10">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Profile Status</h3>
                    
                    @if($registration)
                        @if($registration->status === 'interviewing')
                            <div class="flex items-start gap-4 p-5 rounded-3xl bg-blue-50/50 border border-blue-100 mb-4 animate-pulse">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center bg-blue-100 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-blue-900">Virtual Interview Scheduled</h4>
                                    <p class="text-[11px] text-blue-700 font-medium leading-relaxed mt-1">
                                        You are scheduled for an interview on <strong class="font-black">{{ $registration->interview_at ? $registration->interview_at->format('l, F j, Y \a\t g:i A') : 'TBD' }}</strong>. Please check your email for further instructions.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-4 p-5 rounded-3xl {{ $registration->is_approved ? 'bg-green-50/50 border border-green-100' : 'bg-yellow-50/50 border border-yellow-100' }}">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center {{ $registration->is_approved ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $registration->is_approved ? 'M5 13l4 4L19 7' : 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-gray-900">{{ $registration->is_approved ? 'Approved and Listed' : 'Profile Under Review' }}</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed mt-1">
                                        {{ $registration->is_approved ? 'Students can now find and book you through the homepage.' : 'Our team is verifying your credentials. Youll be listed soon!' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50/50 rounded-2xl border border-gray-100">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Subject Expertise</p>
                                <p class="text-xs font-bold text-gray-700">{{ $registration->subject }}</p>
                            </div>
                            <div class="p-4 bg-gray-50/50 rounded-2xl border border-gray-100">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Primary Location</p>
                                <p class="text-xs font-bold text-gray-700">{{ $registration->city }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-blue-50/50 border border-blue-100 p-8 rounded-[2rem] text-center">
                            <p class="text-sm font-bold text-gray-600 mb-6">Complete your application to start teaching.</p>
                            <a href="{{ route('register-tutor') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">Apply Now</a>
                        </div>
                    @endif
                </div>
            </div>

            @if($registration && $registration->is_approved)
                <!-- Your Students Section -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-8">Assigned Students</h3>
                    
                    @if(isset($assignedStudents) && $assignedStudents->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($assignedStudents as $req)
                                <div class="flex items-center justify-between p-4 rounded-3xl border border-gray-50 bg-gray-50/30 hover:border-blue-100 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 font-black text-lg border border-gray-100 italic">{{ substr($req->student_name, 0, 1) }}</div>
                                        <div>
                                            <h4 class="text-sm font-black text-gray-900">{{ $req->student_name }}</h4>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">
                                                {{ is_array($req->subject) ? implode(', ', $req->subject) : $req->subject }} • {{ $req->grade }}
                                                @if($req->tutoring_type)
                                                    <span class="text-blue-500 mx-1">•</span>
                                                    <span class="text-blue-500">{{ $req->tutoring_type === 'online' ? 'Online' : ($req->tutoring_type === 'home' ? 'Home' : 'Both') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full">Active Match</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-12 text-center opacity-30">
                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 14v6m-3-3h6M6 10h2m4 0h2m4 0h2M5 20h5m4 0h3"></path></svg>
                            <p class="text-[10px] font-black uppercase tracking-widest">No students assigned yet</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="space-y-6">
            @if($registration && $registration->is_approved)
                <!-- Mini Appointments list -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Session Feed</h3>
                        <a href="{{ route('tutor.appointments') }}" class="text-[9px] font-black text-blue-600 hover:underline">Full History</a>
                    </div>

                    <div class="space-y-6">
                        @forelse($upcomingBookings as $booking)
                            <div class="relative pl-6 border-l-2 border-blue-50">
                                <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-blue-600"></div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $booking->start_time->format('M d • g:i A') }}</p>
                                <h4 class="text-xs font-black text-gray-900 line-clamp-1">{{ $booking->student_name }}</h4>
                            </div>
                        @empty
                            <p class="text-[9px] text-gray-300 font-bold uppercase text-center py-10 tracking-widest italic">Quiet day...</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
