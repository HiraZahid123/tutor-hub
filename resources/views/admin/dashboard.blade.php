@extends('layouts.admin')
@section('title', 'Dashboard - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-1">Workspace Overview</h1>
            <p class="text-xs font-semibold text-slate-500">Your central command center for TutorHub platform activity.</p>
        </div>
        <div class="bg-white border border-slate-100 px-5 py-3 rounded-2xl shadow-sm text-right">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Current Date</p>
            <p class="text-xs font-bold text-blue-600">{{ now()->format('l, F d, Y') }}</p>
        </div>
    </div>

    <!-- Statistic Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Tutors -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fas fa-chalkboard-teacher text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Total Tutors</p>
                <h3 class="text-xl font-bold text-slate-800">{{ number_format($totalTutors) }}</h3>
            </div>
        </div>

        <!-- Total Student Leads -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fas fa-user-friends text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Student Leads</p>
                <h3 class="text-xl font-bold text-slate-800">{{ number_format($totalStudents) }}</h3>
            </div>
        </div>

        <!-- Total Matches -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fas fa-handshake text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Matches</p>
                <h3 class="text-xl font-bold text-slate-800">{{ number_format($activeMatches) }}</h3>
            </div>
        </div>

        <!-- Pending Inquiries -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pending Response</p>
                <h3 class="text-xl font-bold text-slate-800">{{ number_format($pendingLeads) }}</h3>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Links -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center">
                    <i class="fas fa-bolt text-xs"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Quick Portal Navigation</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.students') }}" class="group p-5 bg-slate-50 hover:bg-blue-600 rounded-xl border border-slate-100/80 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5 group-hover:text-blue-100">Leads</p>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-white">Review Student Requests</p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-white transition-all group-hover:translate-x-1"></i>
                    </div>
                </a>
                <a href="{{ route('admin.tutors') }}" class="group p-5 bg-slate-50 hover:bg-blue-600 rounded-xl border border-slate-100/80 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5 group-hover:text-blue-100">Tutor Roster</p>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-white">Manage & Approve Tutors</p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-white transition-all group-hover:translate-x-1"></i>
                    </div>
                </a>
                <a href="{{ route('admin.matches') }}" class="group p-5 bg-slate-50 hover:bg-blue-600 rounded-xl border border-slate-100/80 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5 group-hover:text-blue-100">Engagements</p>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-white">View Match Records</p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-white transition-all group-hover:translate-x-1"></i>
                    </div>
                </a>
                <a href="{{ route('admin.inquiries') }}" class="group p-5 bg-slate-50 hover:bg-blue-600 rounded-xl border border-slate-100/80 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5 group-hover:text-blue-100">Inquiries</p>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-white">General Inquiries</p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-white transition-all group-hover:translate-x-1"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="bg-slate-900 p-8 rounded-2xl text-white shadow-md relative overflow-hidden flex flex-col justify-between min-h-[320px]">
            <div class="relative z-10">
                <span class="text-[8px] font-black text-blue-500 uppercase tracking-[0.2em] mb-2 block">System Overview</span>
                <h3 class="text-xl font-bold tracking-tight mb-3 leading-snug">Elite Tutoring Network Management</h3>
                <p class="text-xs text-slate-400 leading-relaxed italic">
                   "Helping students find their perfect match through smart data and professional coordination."
                </p>
            </div>
            
            <div class="relative z-10 pt-6 border-t border-slate-800">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-600/20 text-blue-500 flex items-center justify-center font-bold italic text-lg border border-blue-500/20">A</div>
                    <div>
                        <p class="text-xs font-bold text-white">Logged in as</p>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Master Administrator</p>
                    </div>
                </div>
            </div>

            <!-- Design Overlay -->
            <div class="absolute -bottom-10 -right-10 w-44 h-44 bg-blue-600/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-10 -left-10 w-28 h-28 bg-indigo-500/10 rounded-full blur-2xl"></div>
        </div>
    </div>
</div>
@endsection
