@extends('layouts.dashboard')
@section('title', 'Tutor Dashboard - TutorHub')

@section('dashboard-content')
<div class="max-w-5xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-1">Welcome Back, {{ Auth::user()->name }}!</h1>
        <p class="text-xs font-semibold text-slate-500">Here's what's happening with your tutoring portal today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fas fa-handshake text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Total Leads</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Active Requests</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $stats['pending'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fas fa-chart-line text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Acceptance Rate</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $stats['acceptance_rate'] }}%</h3>
            </div>
        </div>
    </div>

    <!-- Main Content Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Registration Status Card -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Profile Status</h3>
                
                @if($registration)
                    @if($registration->status === 'interviewing')
                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-blue-50/50 border border-blue-100 mb-4 animate-pulse">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-blue-100 text-blue-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-blue-900">Virtual Interview Scheduled</h4>
                                <p class="text-[11px] text-blue-700 font-semibold leading-relaxed mt-1">
                                    You are scheduled for an interview on <strong class="font-extrabold">{{ $registration->interview_at ? $registration->interview_at->format('l, F j, Y \a\t g:i A') : 'TBD' }}</strong>. Please check your email for further instructions.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-4 p-5 rounded-2xl {{ $registration->is_approved ? 'bg-emerald-50/40 border border-emerald-100' : 'bg-amber-50/40 border border-amber-100' }}">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $registration->is_approved ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $registration->is_approved ? 'M5 13l4 4L19 7' : 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">{{ $registration->is_approved ? 'Approved and Listed' : 'Profile Under Review' }}</h4>
                                <p class="text-[11px] text-slate-500 font-semibold leading-relaxed mt-1">
                                    {{ $registration->is_approved ? 'Students can now find and book you through the find-a-tutor search catalog.' : 'Our team is verifying your credentials. You will be listed on the search catalog soon!' }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Subject Expertise</p>
                            <p class="text-xs font-bold text-slate-700">{{ $registration->subject }}</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Primary Location</p>
                            <p class="text-xs font-bold text-slate-700">{{ $registration->city }}</p>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50/40 border border-blue-100 p-8 rounded-2xl text-center">
                        <p class="text-xs font-bold text-slate-600 mb-4">Complete your application to start teaching.</p>
                        <a href="{{ route('register-tutor') }}" class="inline-block bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-md shadow-blue-500/20">Apply Now</a>
                    </div>
                @endif
            </div>

            @if($registration && $registration->is_approved)
                <!-- Assigned Students Section -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Assigned Students</h3>
                    
                    @if(isset($assignedStudents) && $assignedStudents->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($assignedStudents as $req)
                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/20 hover:border-blue-100 hover:bg-white transition-all duration-300 group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-blue-600 font-bold text-sm border border-slate-100 shadow-sm group-hover:scale-105 transition-transform">{{ substr($req->student_name, 0, 1) }}</div>
                                        <div>
                                            <h4 class="text-xs font-bold text-slate-800">{{ $req->student_name }}</h4>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight mt-0.5">
                                                {{ is_array($req->subject) ? implode(', ', $req->subject) : $req->subject }} • {{ $req->grade }}
                                                @if($req->tutoring_type)
                                                    <span class="text-blue-500 mx-1">•</span>
                                                    <span class="text-blue-500">{{ $req->tutoring_type === 'online' ? 'Online' : ($req->tutoring_type === 'home' ? 'Home' : 'Both') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-[8px] font-bold text-blue-500 uppercase tracking-wider bg-blue-50 px-2.5 py-1 rounded-full">Active Match</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-10 text-center opacity-40">
                            <i class="fas fa-user-slash text-2xl text-slate-300 mb-3 block"></i>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400">No students assigned yet</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="space-y-6">
            @if($registration && $registration->is_approved)
                <!-- Mini Appointments list -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-100">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Session Feed</h3>
                        <a href="{{ route('tutor.appointments') }}" class="text-[9px] font-bold text-blue-600 hover:underline">History</a>
                    </div>

                    <div class="space-y-5">
                        @forelse($upcomingBookings as $booking)
                            <div class="relative pl-5 border-l-2 border-blue-100">
                                <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-blue-600"></div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">{{ $booking->start_time->format('M d • g:i A') }}</p>
                                <h4 class="text-xs font-bold text-slate-800 line-clamp-1">{{ $booking->student_name }}</h4>
                            </div>
                        @empty
                            <p class="text-[9px] text-slate-300 font-bold uppercase text-center py-6 tracking-widest italic">Quiet day...</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div></div>
@endsection
