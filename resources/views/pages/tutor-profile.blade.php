@extends('layouts.app')

@section('title', $tutor->name . ' - Tutor Profile')

@section('content')
<style>
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #e2e8f0 transparent;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
<section class="min-h-screen py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Left: Profile Info -->
                <div class="lg:col-span-1">
                    @if(session('success'))
                        <div class="mb-8 bg-green-50 border border-green-100 rounded-[2.5rem] p-6 flex items-center gap-4 shadow-xl shadow-green-500/5 animate-fade-in">
                            <div class="w-12 h-12 bg-green-500 text-white rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-1">Success</p>
                                <p class="text-sm font-bold text-green-800 leading-tight">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error') || $errors->any())
                        <div class="mb-8 bg-red-50 border border-red-100 rounded-[2.5rem] p-6 flex items-center gap-4 shadow-xl shadow-red-500/5 animate-fade-in">
                            <div class="w-12 h-12 bg-red-500 text-white rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Attention</p>
                                <p class="text-sm font-bold text-red-800 leading-tight">
                                    {{ session('error') ?? 'Please select at least one subject.' }}
                                </p>
                            </div>
                        </div>
                    @endif
                    <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl sticky top-24">
                        <div class="flex flex-col items-center text-center mb-8">
                            @php
                                $profilePic = $tutor->profile_image 
                                    ? asset('storage/' . $tutor->profile_image) 
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($tutor->name) . '&color=7F9CF5&background=EBF4FF';
                            @endphp
                            <div class="w-32 h-32 mb-6 relative flex justify-center items-center overflow-hidden rounded-[2rem] border-4 border-blue-50 shadow-2xl">
                                <img src="{{ $profilePic }}" alt="{{ $tutor->name }}" class="w-full h-full object-cover">
                                <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-2 border-white rounded-full shadow-sm"></div>
                            </div>
                            <h1 class="text-3xl font-black text-gray-900 leading-tight mb-2 tracking-tight">{{ $tutor->name }}</h1>
                            <p class="text-blue-600 font-black text-[10px] uppercase tracking-widest">{{ $tutor->program }} in {{ $tutor->major }}</p>
                            
                            <div class="mt-4 flex items-center justify-center gap-1.5">
                                <div class="flex items-center gap-1 text-amber-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= round($tutor->average_rating) ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-gray-900 font-black text-sm">{{ number_format($tutor->average_rating, 1) }}</span>
                                <span class="text-gray-400 text-[10px] font-bold">({{ $tutor->review_count }} reviews)</span>
                            </div>

                            <div class="mt-6 flex flex-wrap justify-center gap-2">
                                <span class="bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border border-blue-100">{{ $tutor->country }}</span>
                                <span class="bg-gray-50 text-gray-400 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border border-gray-100 italic">{{ ucfirst($tutor->tutoring_preference) }} Mode</span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Fee</p>
                                    <p class="text-sm font-black text-gray-900">PKR {{ number_format($tutor->hourly_rate) }}</p>
                                </div>
                                <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Timezone</p>
                                    <p class="text-[10px] font-black text-gray-900">{{ $tutor->timezone }}</p>
                                </div>
                                <div class="col-span-2 bg-blue-50/30 p-5 rounded-3xl border border-blue-100/50">
                                    <p class="text-[9px] text-blue-400 font-black uppercase tracking-widest mb-2">Education</p>
                                    <p class="text-xs font-bold text-gray-900 mb-1">{{ $tutor->program }}</p>
                                    <p class="text-[10px] text-gray-500 font-medium">{{ $tutor->university }}</p>
                                    <p class="text-[9px] text-gray-400 mt-2 italic font-medium">Period: {{ $tutor->study_year_from }} - {{ $tutor->study_year_to }}</p>
                                </div>
                            </div>
                            

                            @auth
                                @if(auth()->user()->role === 'student')
                                    @php $isBlocked = \App\Models\Booking::hasUnpaidSessions(Auth::id()); @endphp
                                    @if($isBlocked)
                                        <div class="mb-6 bg-red-50 border border-red-100 rounded-[1.5rem] p-4 flex items-center gap-3">
                                            <i class="fas fa-lock text-red-500"></i>
                                            <p class="text-[10px] font-bold text-red-700 uppercase tracking-tight">Booking restricted. <a href="{{ route('student.dashboard') }}" class="underline">Settle dues</a></p>
                                        </div>
                                        <button disabled class="w-full bg-gray-200 text-gray-400 rounded-[1.5rem] py-4 font-black text-[10px] uppercase tracking-[0.2em] flex items-center justify-center gap-3 mb-6 cursor-not-allowed border border-gray-300">
                                            <i class="fas fa-lock text-sm"></i>
                                            Hire Feature Locked
                                        </button>
                                    @else
                                        <button onclick="openMessageModal()" class="w-full bg-blue-600 text-white rounded-[1.5rem] py-4 font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:bg-blue-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95 group mb-6">
                                            <i class="fas fa-handshake text-sm group-hover:rotate-12 transition-transform"></i>
                                            Hire {{ explode(' ', $tutor->name)[0] }}
                                        </button>
                                    @endif
                                @else
                                    <div class="w-full bg-gray-100 text-gray-400 rounded-[1.5rem] py-4 font-black text-[10px] uppercase tracking-[0.2em] flex items-center justify-center gap-3 mb-6 cursor-not-allowed border border-gray-200">
                                        <i class="fas fa-lock text-sm"></i>
                                        Students Only
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full bg-blue-600 text-white rounded-[1.5rem] py-4 font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:bg-blue-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95 group mb-6">
                                    <i class="fas fa-sign-in-alt text-sm group-hover:translate-x-1 transition-transform"></i>
                                    Log in to Hire
                                </a>
                            @endauth
                            <a href="https://wa.me/923414133395" target="_blank" class="w-full bg-emerald-600 text-white rounded-[1.5rem] py-4 font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95 group">
                                <i class="fab fa-whatsapp text-sm group-hover:rotate-12 transition-transform"></i>
                                Direct Contact
                            </a>
                        </div>
                    </div>
                </div>

                    <!-- Right: About & Expertise -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Card 1: Expertise & Subjects -->
                        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-xl">
                            <h2 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-8">Expertise & Subjects</h2>
                            @php
                                $groupedSubjects = $tutor->subjects->groupBy(function($subject) {
                                    return $subject->category->name ?? 'General Subjects';
                                });
                            @endphp
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @if($groupedSubjects->count() > 0)
                                    @foreach($groupedSubjects as $categoryName => $subjects)
                                        <div class="group">
                                            <h4 class="text-[9px] font-black text-blue-600/70 uppercase tracking-widest mb-4 flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                {{ $categoryName ?: 'General Subjects' }}
                                            </h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($subjects as $subj)
                                                    <div class="subject-badge inline-block px-3 py-1.5 rounded-xl border border-gray-100 bg-white text-gray-400 text-[10px] font-black uppercase tracking-tight shadow-sm">
                                                        {{ $subj->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full text-center py-6">
                                        <p class="text-[10px] text-gray-400 italic font-black uppercase tracking-widest">No subjects defined for this professional.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card 2: Professional Bio & Experience -->
                        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-xl">
                            <div class="mb-10">
                                <h2 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-4">Professional Bio</h2>
                                <p class="text-xl font-bold text-gray-800 leading-relaxed mb-6 break-all" style="word-break: break-all !important; overflow-wrap: anywhere !important;">"{{ $tutor->bio }}"</p>
                            </div>

                            <div class="border-t border-gray-50 pt-10">
                                <h2 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-4">Teaching Experience</h2>
                                @if($tutor->teaching_experience)
                                    <p class="text-[13px] font-semibold text-gray-700 leading-relaxed break-all" style="word-break: break-all !important; overflow-wrap: anywhere !important;">{{ $tutor->teaching_experience }}</p>
                                @else
                                    <p class="text-[10px] text-gray-400 italic font-black tracking-widest uppercase">Professional experience details have not been provided yet.</p>
                                @endif
                            </div>
                        </div>


                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 bg-blue-600 rounded-[3rem] p-12 text-white relative overflow-hidden shadow-2xl shadow-blue-500/20">
                    <div class="absolute -right-20 -bottom-20 opacity-[0.05]">
                        <i class="fas fa-rocket text-[15rem]"></i>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-4xl font-black mb-4 leading-tight tracking-tight">Start Your Journey Today</h3>
                        <p class="text-blue-100 mb-10 max-w-lg text-sm font-medium leading-relaxed opacity-90">Experience personalized learning with {{ $tutor->name }}. Our 1-on-1 sessions are designed to help you master your subjects at your own pace.</p>
                        
                        @auth
                            @if(auth()->user()->role === 'student')
                                <button onclick="openMessageModal()" class="inline-flex items-center gap-3 bg-white text-blue-600 px-10 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white/90 transition-all shadow-xl hover:-translate-y-1">
                                    HIRE THIS TUTOR NOW
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            @else
                                <div class="inline-block px-8 py-4 bg-blue-700/50 rounded-2xl border border-blue-500/50 text-[10px] font-black uppercase tracking-widest">
                                    Access restricted to student accounts
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-3 bg-white text-blue-600 px-10 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white/90 transition-all shadow-xl hover:-translate-y-1">
                                LOG IN TO GET STARTED
                                <i class="fas fa-sign-in-alt"></i>
                            </a>
                        @endauth
                </div>
            </div>
        </div>
    </div>
</section>

@push('modals')
<!-- Hire/Message Modal Overlay -->
<div id="message-modal" class="fixed inset-0 hidden flex items-center justify-center p-4 md:p-12" style="z-index: 99999;">
    <!-- Backdrop -->
    <div class="fixed inset-0 backdrop-blur-sm" style="background-color: rgba(17, 24, 39, 0.6);" onclick="closeMessageModal()"></div>
    
    <!-- Modal Box -->
    <div class="bg-white rounded-[2.5rem] w-full max-w-xl relative shadow-2xl overflow-hidden transform transition-all border border-gray-100 max-h-[80vh] flex flex-col m-4" style="z-index: 10;">
        <!-- Header: Fixed -->
        <div class="pt-6 px-8 pb-4 border-b border-gray-50 flex justify-between items-center bg-white flex-shrink-0 z-20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-handshake text-sm"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-gray-900 tracking-tight">Hire {{ explode(' ', $tutor->name)[0] }}</h3>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Submit Hiring Request</p>
                </div>
            </div>
            <button onclick="closeMessageModal()" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:text-red-500 transition-all flex items-center justify-center">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <form id="hire-tutor-form" action="{{ route('tutor.inquiry.store') }}" method="POST" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
            
            <!-- Scrollable Body -->
            <div class="p-6 md:p-8 overflow-y-auto flex-1 custom-scrollbar space-y-6">
                
                <!-- Tutor Snapshot Card -->
            <div class="bg-blue-50/40 rounded-[1rem] p-4 border border-blue-100/50 flex flex-col md:flex-row items-center gap-4 mb-4 shadow-sm flex-shrink-0">
                <div class="w-12 h-12 rounded-xl overflow-hidden shadow-lg border-2 border-white flex-shrink-0">
                    @php
                        $profilePic = $tutor->profile_image 
                            ? asset('storage/' . $tutor->profile_image) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($tutor->name) . '&background=EBF4FF&color=3b82f6';
                    @endphp
                    <img src="{{ $profilePic }}" 
                         alt="{{ $tutor->name }}" 
                         class="w-full h-full object-cover">
                </div>
                <div class="flex-1 text-center md:text-left min-w-0">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-0.5">
                        <span class="text-[8px] font-black text-blue-600 uppercase tracking-widest">{{ $tutor->program ?? 'Professional' }}</span>
                    </div>
                    <h4 class="text-base font-black text-gray-900 mb-0.5 truncate">{{ $tutor->name }}</h4>
                    <div class="flex items-center justify-center md:justify-start gap-1.5">
                        <div class="flex items-center gap-0.5 text-amber-400 text-[10px]">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= round($tutor->average_rating) ? 's' : 'r' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-gray-900 font-black text-[10px]">{{ number_format($tutor->average_rating, 1) }}</span>
                    </div>
                </div>
                <div class="text-center md:text-right flex-shrink-0 bg-blue-50/50 px-4 py-2 rounded-2xl border border-blue-100/50">
                    <span class="block text-[7px] font-black text-gray-400 uppercase tracking-widest">Fee</span>
                    <span class="text-lg font-black text-blue-600 tracking-tight leading-none">PKR {{ number_format($tutor->hourly_rate) }}</span>
                </div>
            </div>

            <!-- Subjects & Format Row -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <!-- Subject Selection -->
                <div class="flex flex-col">
                    <label class="block text-[10px] font-black text-gray-900 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                        <i class="fas fa-book text-blue-600"></i>
                        Subjects
                    </label>
                    <div class="space-y-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100 flex-1 overflow-y-auto custom-scrollbar max-h-[180px]">
                        @foreach($groupedSubjects as $categoryName => $subjects)
                            <div>
                                <h4 class="text-[8px] font-black text-blue-600/70 uppercase tracking-widest mb-2 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    {{ $categoryName ?: 'General Subjects' }}
                                </h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($subjects as $subj)
                                        <label class="cursor-pointer select-none">
                                            <input type="checkbox" name="hiring_subjects[]" value="{{ $subj->name }}" class="sr-only subject-checkbox" onchange="toggleSubjectBadge(this)" {{ is_array(old('hiring_subjects')) && in_array($subj->name, old('hiring_subjects')) ? 'checked' : '' }}>
                                            <div class="subject-badge inline-block px-2.5 py-1 rounded-lg border transition-all shadow-sm hover:shadow-md active:scale-95 duration-200 text-[9px] font-black uppercase tracking-tight {{ is_array(old('hiring_subjects')) && in_array($subj->name, old('hiring_subjects')) ? 'bg-blue-600 text-white border-blue-600 shadow-blue-500/20' : 'bg-white text-gray-400 border-gray-100' }}">
                                                {{ $subj->name }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Hiring Format Selection -->
                <div class="flex flex-col">
                    <label class="block text-[10px] font-black text-gray-900 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                        Format
                    </label>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="group cursor-pointer">
                            <input type="radio" name="hiring_type" value="home" class="sr-only" {{ old('hiring_type') === 'home' ? 'checked' : ($tutor->is_home && !old('hiring_type') ? 'checked' : (!$tutor->is_home ? 'disabled' : '')) }} onchange="toggleHiringFormat(this)">
                            <div class="hiring-format-box p-3 rounded-xl transition-all duration-300 flex items-center gap-3 {{ (old('hiring_type') === 'home' || ($tutor->is_home && !old('hiring_type'))) ? 'bg-blue-50 border-2 border-blue-200 shadow-blue-100/50' : 'bg-gray-50 border border-gray-100' . (!$tutor->is_home ? ' opacity-40 cursor-not-allowed' : '') }}">
                                <div class="hiring-format-icon w-8 h-8 rounded-lg shadow-sm flex items-center justify-center flex-shrink-0 transition-all {{ $tutor->is_home ? 'bg-blue-600 text-white' : 'bg-white text-blue-600' }}">
                                    <i class="fas fa-home text-xs"></i>
                                </div>
                                <span class="hiring-format-text font-black text-[10px] uppercase tracking-widest {{ $tutor->is_home ? 'text-blue-700' : 'text-gray-500' }}">Home Tuition</span>
                            </div>
                        </label>
                        
                        <label class="group cursor-pointer">
                            <input type="radio" name="hiring_type" value="online" class="sr-only" {{ old('hiring_type') === 'online' ? 'checked' : (!$tutor->is_home && $tutor->is_online && !old('hiring_type') ? 'checked' : (!$tutor->is_online ? 'disabled' : '')) }} onchange="toggleHiringFormat(this)">
                            <div class="hiring-format-box p-3 rounded-xl transition-all duration-300 flex items-center gap-3 {{ (old('hiring_type') === 'online' || (!$tutor->is_home && $tutor->is_online && !old('hiring_type'))) ? 'bg-blue-50 border-2 border-blue-200 shadow-blue-100/50' : 'bg-gray-50 border border-gray-100' . (!$tutor->is_online ? ' opacity-40 cursor-not-allowed' : '') }}">
                                <div class="hiring-format-icon w-8 h-8 rounded-lg shadow-sm flex items-center justify-center flex-shrink-0 transition-all {{ !$tutor->is_home && $tutor->is_online ? 'bg-blue-600 text-white' : 'bg-white text-blue-600' }}">
                                    <i class="fas fa-globe text-xs"></i>
                                </div>
                                <span class="hiring-format-text font-black text-[10px] uppercase tracking-widest {{ !$tutor->is_home && $tutor->is_online ? 'text-blue-700' : 'text-gray-500' }}">Online Session</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Message Area -->
            <div class="mb-2">
                <label class="block text-[9px] font-black text-gray-900 uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                    <i class="fas fa-comment-alt text-blue-600"></i>
                    Message (Optional)
                </label>
                <textarea name="request_message" rows="2" 
                          class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl p-4 text-xs font-medium text-gray-800 placeholder-gray-400 focus:ring-4 focus:ring-blue-500/5 focus:bg-white focus:border-blue-500/30 transition-all outline-none resize-none"
                          placeholder="Goal..."></textarea>
            </div>

            </div> <!-- End Scrollable Body -->
            
            <!-- Footer: Fixed -->
            <div class="p-6 md:px-8 md:py-6 border-t border-gray-50 bg-gray-50/30 flex-shrink-0">
                <button type="submit" class="w-full bg-blue-600 text-white rounded-2xl py-4 px-6 font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:bg-blue-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3">
                    <span class="tracking-[0.1em]">Send Hire Request</span>
                    <i class="fas fa-paper-plane text-[9px]"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

<script>
    function toggleSubjectBadge(input) {
        const badge = input.nextElementSibling;
        if (input.checked) {
            badge.classList.remove('bg-white', 'text-gray-400', 'border-gray-100');
            badge.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-blue-500/20');
        } else {
            badge.classList.add('bg-white', 'text-gray-400', 'border-gray-100');
            badge.classList.remove('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-blue-500/20');
        }
    }

    function toggleHiringFormat(input) {
        // Reset all format boxes
        document.querySelectorAll('.hiring-format-box').forEach(box => {
            box.classList.remove('bg-blue-50', 'border-2', 'border-blue-200', 'shadow-blue-100/50');
            box.classList.add('bg-gray-50', 'border', 'border-gray-100');
        });
        document.querySelectorAll('.hiring-format-icon').forEach(icon => {
            icon.classList.remove('bg-blue-600', 'text-white');
            icon.classList.add('bg-white', 'text-blue-600');
        });
        document.querySelectorAll('.hiring-format-text').forEach(text => {
            text.classList.remove('text-blue-700');
            text.classList.add('text-gray-500');
        });

        // Activate the selected one
        const box = input.nextElementSibling;
        const icon = box.querySelector('.hiring-format-icon');
        const text = box.querySelector('.hiring-format-text');
        
        box.classList.add('bg-blue-50', 'border-2', 'border-blue-200', 'shadow-blue-100/50');
        box.classList.remove('bg-gray-50', 'border', 'border-gray-100');
        icon.classList.add('bg-blue-600', 'text-white');
        icon.classList.remove('bg-white', 'text-blue-600');
        text.classList.add('text-blue-700');
        text.classList.remove('text-gray-500');
    }

    function openMessageModal() {
        const modal = document.getElementById('message-modal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeMessageModal() {
        const modal = document.getElementById('message-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeMessageModal();
        }
    });

    // Auto-open modal on validation errors
    @if($errors->any())
        openMessageModal();
    @endif

    // Form Submission check
    document.getElementById('hire-tutor-form').addEventListener('submit', function(e) {
        const subjectsCount = document.querySelectorAll('input[name="hiring_subjects[]"]:checked').length;
        if (subjectsCount === 0) {
            e.preventDefault();
            alert('Please select at least one subject before sending your request.');
        }
    });
</script>
@endsection
