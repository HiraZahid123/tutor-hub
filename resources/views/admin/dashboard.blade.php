@extends('layouts.admin')
@section('title', 'Dashboard - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Workspace Overview</h1>
            <p class="text-gray-500 font-medium italic">Your central command center for TutorHub platform activity.</p>
        </div>
        <div class="text-right">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Current Date</p>
            <p class="text-sm font-black text-blue-600">{{ now()->format('l, F d, Y') }}</p>
        </div>
    </div>

    <!-- Statistic Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Tutors -->
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5 flex items-center gap-5 group hover:-translate-y-1 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Tutors</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($totalTutors) }}</h3>
            </div>
        </div>

        <!-- Total Student Leads -->
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5 flex items-center gap-5 group hover:-translate-y-1 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all">
                <i class="fas fa-user-friends text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Student Leads</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($totalStudents) }}</h3>
            </div>
        </div>

        <!-- Total Matches -->
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5 flex items-center gap-5 group hover:-translate-y-1 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                <i class="fas fa-handshake text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Successful Matches</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($activeMatches) }}</h3>
            </div>
        </div>

        <!-- Pending Inquiries -->
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5 flex items-center gap-5 group hover:-translate-y-1 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pending Response</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($pendingLeads) }}</h3>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Links -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 rounded-2xl bg-gray-900 text-white flex items-center justify-center">
                    <i class="fas fa-bolt text-sm"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">System Navigation</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.students') }}" class="group p-6 bg-gray-50 rounded-3xl border border-gray-100 hover:bg-blue-600 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-100">Leads Management</p>
                            <p class="text-sm font-black text-gray-900 group-hover:text-white">Review Student Requests</p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-white transition-colors"></i>
                    </div>
                </a>
                <a href="{{ route('admin.tutors') }}" class="group p-6 bg-gray-50 rounded-3xl border border-gray-100 hover:bg-blue-600 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-100">Tutor Roster</p>
                            <p class="text-sm font-black text-gray-900 group-hover:text-white">Manage & Approve Tutors</p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-white transition-colors"></i>
                    </div>
                </a>
                <a href="{{ route('admin.matches') }}" class="group p-6 bg-gray-50 rounded-3xl border border-gray-100 hover:bg-blue-600 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-100">Engagements</p>
                            <p class="text-sm font-black text-gray-900 group-hover:text-white">View Successful Matches</p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-white transition-colors"></i>
                    </div>
                </a>
                <a href="{{ route('admin.inquiries') }}" class="group p-6 bg-gray-50 rounded-3xl border border-gray-100 hover:bg-blue-600 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-blue-100">Communication</p>
                            <p class="text-sm font-black text-gray-900 group-hover:text-white">General Inquiries</p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-white transition-colors"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="bg-blue-600 p-10 rounded-[3rem] text-white shadow-xl shadow-blue-500/20 relative overflow-hidden flex flex-col justify-between min-h-[400px]">
            <div class="relative z-10">
                <h3 class="text-2xl font-black tracking-tight mb-4 leading-tight">Elite Tutoring Network Management</h3>
                <p class="text-sm font-medium text-blue-100 leading-relaxed italic mb-8">
                   "Helping students find their perfect match through smart data and professional coordination."
                </p>
            </div>
            
            <div class="relative z-10 pt-8 border-t border-white/20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center font-black italic text-xl border border-white/10">A</div>
                    <div>
                        <p class="text-xs font-black">Logged in as</p>
                        <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mt-0.5">Master Administrator</p>
                    </div>
                </div>
            </div>

            <!-- Design Overlay -->
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
        </div>
    </div>
</div>
@endsection
