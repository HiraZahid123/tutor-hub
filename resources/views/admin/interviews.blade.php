@extends('layouts.admin')
@section('title', 'Upcoming Interviews - Admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Upcoming Interviews</h2>
        <p class="text-gray-500 font-medium">Manage all scheduled tutor verification interviews.</p>
    </div>
    <div class="px-6 py-3 bg-white rounded-3xl border border-gray-100 shadow-sm">
        <div class="text-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Scheduled</p>
            <p class="text-xl font-black text-blue-600 tracking-tight">{{ $interviews->count() }}</p>
        </div>
    </div>
</div>

@if($interviews->isEmpty())
    <div class="bg-white rounded-[2.5rem] border border-gray-100 p-20 text-center shadow-xl shadow-blue-500/5">
        <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-300">
            <i class="fas fa-calendar-alt text-3xl"></i>
        </div>
        <h3 class="text-lg font-black text-gray-900 mb-2">No interviews scheduled</h3>
        <p class="text-gray-400 text-sm font-medium">Go to the Tutor Roster to request interviews for pending applications.</p>
    </div>
@else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($interviews as $interview)
                @php 
                    $isPast = \Carbon\Carbon::parse($interview->interview_at)->isPast();
                    $isToday = \Carbon\Carbon::parse($interview->interview_at)->isToday();
                @endphp
                
                <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-500/5 border border-gray-100 p-6 relative overflow-hidden flex flex-col transition-transform hover:-translate-y-1">
                    @if($isToday && !$isPast)
                        <div class="absolute top-0 right-0 bg-blue-500 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-bl-xl z-10">Today</div>
                    @elseif($isPast)
                        <div class="absolute top-0 right-0 bg-red-100 text-red-600 text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-bl-xl z-10">Overdue</div>
                    @endif

                    <!-- Header: Date and Time -->
                    <div class="flex items-start gap-4 mb-6 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex flex-col items-center justify-center shrink-0 border border-blue-100 text-blue-600">
                            <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($interview->interview_at)->format('M') }}</span>
                            <span class="text-xl font-black leading-none">{{ \Carbon\Carbon::parse($interview->interview_at)->format('d') }}</span>
                        </div>
                        <div>
                            <h3 class="font-black text-gray-900 text-lg leading-tight">{{ \Carbon\Carbon::parse($interview->interview_at)->format('g:i A') }}</h3>
                            <p class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($interview->interview_at)->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Body: Tutor Details -->
                    <div class="flex-1 space-y-4">
                        <div class="flex items-center gap-3">
                            @if($interview->profile_image)
                                <img src="{{ asset('storage/' . $interview->profile_image) }}" alt="{{ $interview->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-50">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-sm">
                                    {{ substr($interview->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-sm text-gray-900 line-clamp-1">{{ $interview->name }}</h4>
                                <div class="flex flex-wrap items-center gap-1 mt-0.5">
                                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wider bg-blue-50 px-2 py-0.5 rounded-full inline-block">{{ $interview->subject }}</p>
                                    <div class="flex items-center gap-1">
                                        @if($interview->is_online)
                                            <span class="text-[9px] font-bold bg-green-50 text-green-600 px-1.5 py-0.5 rounded border border-green-100 uppercase tracking-tighter">Online</span>
                                        @endif
                                        @if($interview->is_home)
                                            <span class="text-[9px] font-bold bg-amber-50 text-amber-600 px-1.5 py-0.5 rounded border border-amber-100 uppercase tracking-tighter">Home</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pb-2 border-b border-gray-50">
                            <div>
                                <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Contact</span>
                                <span class="block text-xs text-gray-700 font-medium truncate" title="{{ $interview->email }}">{{ $interview->email }}</span>
                            </div>
                            <div>
                                <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Location</span>
                                <span class="block text-xs text-gray-700 font-medium truncate">{{ $interview->city }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.tutors.edit', $interview->id) }}" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold uppercase tracking-widest hover:bg-blue-700 transition-colors shadow-sm" style="background-color: #2563eb !important; color: #ffffff !important;">
                            <span>Open Review Page</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
