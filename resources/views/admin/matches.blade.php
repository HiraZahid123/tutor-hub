@extends('layouts.admin')
@section('title', 'Tutor-Student Matches - Admin')

@section('content')
<section class="min-h-screen p-6 bg-gradient-to-br from-indigo-50 via-white to-blue-50">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Successful Matches</h2>
            <p class="text-gray-500 font-medium italic">Tracking the activation and engagement of our tutoring community.</p>
        </div>
        <div class="flex gap-4">
            <div class="px-6 py-4 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-indigo-500/5 text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Direct Hires</p>
                <p class="text-2xl font-black text-indigo-600 tracking-tight">{{ $directMatches->count() }}</p>
            </div>
            <div class="px-6 py-4 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-blue-500/5 text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Manual Matches</p>
                <p class="text-2xl font-black text-blue-600 tracking-tight">{{ $adminMatches->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Platform Matches (Direct Hires) -->
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <i class="fas fa-bolt text-sm"></i>
            </div>
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Platform Success</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Matched Directly in Chat</p>
            </div>
        </div>

        @if($directMatches->isEmpty())
            <div class="bg-white rounded-[2.5rem] border border-dashed border-gray-200 p-12 text-center">
                <p class="text-gray-400 text-sm font-medium">No direct hires recorded yet.</p>
            </div>
        @else
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-indigo-500/5 border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pairing</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Subject/Focus</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Matched On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($directMatches as $match)
                            <tr class="hover:bg-indigo-50/10 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex -space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 border-2 border-white flex items-center justify-center text-blue-600 font-black text-xs italic shadow-sm" title="Student: {{ $match->student->name }}">
                                                {{ substr($match->student->name, 0, 1) }}
                                            </div>
                                            <div class="w-10 h-10 rounded-xl bg-indigo-600 border-2 border-white flex items-center justify-center text-white font-black text-xs shadow-md" title="Tutor: {{ $match->tutor->name }}">
                                                {{ substr($match->tutor->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900">{{ $match->student->name }} <span class="text-gray-300 mx-1">/</span> {{ $match->tutor->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">Direct Hire via Messenger</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[9px] font-black uppercase tracking-tight rounded-full border border-gray-200">
                                            {{ is_array($match->subjects) ? implode(', ', $match->subjects) : 'All Subjects' }}
                                        </span>
                                        <i class="fas fa-chevron-right text-[8px] text-gray-300 mx-1"></i>
                                        <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest">{{ $match->hiring_type }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-[9px] font-black uppercase tracking-widest border border-emerald-200 shadow-sm">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                        Active Hire
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest">{{ $match->updated_at->format('M d, Y') }}</p>
                                    <p class="text-[9px] text-gray-400 font-bold tracking-tight">{{ $match->updated_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Admin Matches (Manual Assignments) -->
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/20">
                <i class="fas fa-user-cog text-sm"></i>
            </div>
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Manual Assignments</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Matched by the Admin Team</p>
            </div>
        </div>

        @if($adminMatches->isEmpty())
            <div class="bg-white rounded-[2.5rem] border border-dashed border-gray-200 p-12 text-center">
                <p class="text-gray-400 text-sm font-medium">No manual assignments recorded yet.</p>
            </div>
        @else
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pairing</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Requirement</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Assigned On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($adminMatches as $request)
                            <tr class="hover:bg-blue-50/10 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex -space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gray-100 border-2 border-white flex items-center justify-center text-gray-600 font-black text-xs shadow-sm">
                                                {{ substr($request->student_name, 0, 1) }}
                                            </div>
                                            <div class="w-10 h-10 rounded-xl bg-blue-600 border-2 border-white flex items-center justify-center text-white font-black text-xs shadow-md">
                                                {{ substr($request->assignedTutor->name ?? 'T', 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900">{{ $request->student_name }} <span class="text-gray-300 mx-1">/</span> {{ $request->assignedTutor->name ?? 'Tutor Deleted' }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">Formal Request ID: #{{ $request->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-black text-gray-700 bg-gray-50 border border-gray-100 px-3 py-1 rounded-full uppercase tracking-tight">
                                            {{ is_array($request->subject) ? implode(', ', $request->subject) : $request->subject }}
                                        </span>
                                        <span class="text-[8px] text-gray-300 font-bold uppercase tracking-widest">{{ $request->grade }}</span>
                                        <div class="px-2 py-0.5 rounded-full bg-blue-50/50 text-blue-500 text-[8px] font-black uppercase tracking-tight border border-blue-100/50">
                                            @if($request->tutoring_type === 'online') Online
                                            @elseif($request->tutoring_type === 'home') Home
                                            @else Both
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-[9px] font-black uppercase tracking-widest border border-blue-100">
                                        Matched Officially
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest">{{ $request->updated_at->format('M d, Y') }}</p>
                                    <p class="text-[9px] text-gray-400 font-bold tracking-tight">{{ $request->updated_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
