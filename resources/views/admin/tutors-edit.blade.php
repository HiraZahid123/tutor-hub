@extends('layouts.admin')
@section('title', 'Review Tutor - Admin')

@section('content')
<section class="min-h-screen p-6 bg-gradient-to-br from-blue-50 to-white">
    <div class="max-w-5xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.tutors') }}" class="text-xs font-black text-blue-600 uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Roster
                </a>
                <h2 class="text-4xl font-black text-gray-900 mt-2 tracking-tight">Review Application</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white rounded-2xl shadow-sm border border-gray-100 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    Current Status: <span class="text-blue-600 ml-1">{{ ucfirst($tutor->status) }}</span>
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.tutors.approve', $tutor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Sidebar: Profile & Files -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-50 text-center">
                        <div class="relative inline-block mb-3">
                            @if($tutor->profile_image)
                                <img src="{{ asset('storage/' . $tutor->profile_image) }}" class="rounded-xl object-cover mx-auto shadow-2xl ring-4 ring-white" style="width: 100px !important; height: 100px !important;" alt="Profile">
                            @else
                                <div class="bg-blue-100 rounded-xl mx-auto flex items-center justify-center text-blue-500 shadow-inner" style="width: 100px !important; height: 100px !important;">
                                    <i class="fas fa-user-circle text-4xl"></i>
                                </div>
                            @endif
                            <label class="absolute -bottom-1 -right-1 bg-white p-1.5 rounded-lg shadow-lg border border-gray-50 cursor-pointer hover:scale-110 transition-transform">
                                <i class="fas fa-camera text-blue-600 text-xs"></i>
                                <input type="file" name="profile_image" class="hidden">
                            </label>
                        </div>
                        
                        <h3 class="text-lg font-black text-gray-900 tracking-tight">{{ $tutor->name }}</h3>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $tutor->email }}</p>
                        
                        <div class="mt-6 pt-6 border-t border-gray-50 space-y-3">
                            @if($tutor->resume_path)
                                <a href="{{ asset('storage/' . $tutor->resume_path) }}" target="_blank" class="flex items-center justify-center gap-2 bg-blue-50 py-3 rounded-xl text-blue-600 hover:bg-blue-600 hover:text-white transition-all border border-blue-50/50">
                                    <i class="fas fa-file-pdf"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Download Resume</span>
                                </a>
                            @else
                                <div class="py-3 bg-gray-50 rounded-xl text-gray-400 text-[9px] uppercase font-black tracking-widest border border-dashed border-gray-200 text-center">
                                    No Resume Attached
                                </div>
                            @endif

                            <div class="p-4 bg-gray-50/50 rounded-2xl border border-gray-100 text-left">
                                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-2">Location & Pref</p>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-bold text-gray-700"><i class="fas fa-globe mr-1 opacity-50"></i> {{ $tutor->country }} ({{ $tutor->timezone }})</p>
                                    <p class="text-[10px] font-bold text-gray-700"><i class="fas fa-phone mr-1 opacity-50"></i> {{ $tutor->phone }}</p>
                                    <p class="text-[10px] font-bold text-blue-600"><i class="fas fa-laptop mr-1 opacity-50"></i> {{ ucfirst($tutor->tutoring_preference) }} Mode</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Form -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-50">
                        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-50">
                            <h4 class="text-xs font-black text-gray-900 tracking-widest uppercase">Structured Application Data</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Overrides -->
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Display Name</label>
                                <input type="text" name="name" value="{{ $tutor->name }}" class="w-full bg-gray-50/50 border border-gray-100 p-3 rounded-xl font-bold text-sm">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Hourly Rate (PKR)</label>
                                <input type="number" name="hourly_rate" value="{{ $tutor->hourly_rate }}" class="w-full bg-gray-50/50 border border-gray-100 p-3 rounded-xl font-bold text-sm">
                            </div>

                            <!-- Career Details -->
                            <div class="md:col-span-2 grid grid-cols-3 gap-4 p-4 bg-blue-50/30 rounded-2xl border border-blue-50">
                                <div class="space-y-1">
                                    <label class="block text-[9px] font-black text-blue-400 uppercase tracking-widest ml-1">Degree</label>
                                    <input type="text" name="program" value="{{ $tutor->program }}" class="w-full bg-white border border-gray-100 p-2 rounded-lg font-bold text-[11px]">
                                </div>
                                <div class="space-y-1 col-span-2">
                                    <label class="block text-[9px] font-black text-blue-400 uppercase tracking-widest ml-1">Major / Field</label>
                                    <input type="text" name="major" value="{{ $tutor->major }}" class="w-full bg-white border border-gray-100 p-2 rounded-lg font-bold text-[11px]">
                                </div>
                                <div class="space-y-1 col-span-3">
                                    <label class="block text-[9px] font-black text-blue-400 uppercase tracking-widest ml-1">University</label>
                                    <input type="text" name="university" value="{{ $tutor->university }}" class="w-full bg-white border border-gray-100 p-2 rounded-lg font-bold text-[11px]">
                                </div>
                                <div class="col-span-3 p-2 bg-white rounded-xl border border-blue-50">
                                    <label class="block text-[8px] font-black text-blue-300 uppercase tracking-widest ml-1 mb-2">Teaching Subjects</label>
                                    <div class="flex flex-wrap gap-2">
                                        @if($tutor->subjects->count() > 0)
                                            @foreach($tutor->subjects as $subject)
                                                <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase tracking-tight rounded-lg shadow-sm">
                                                    {{ $subject->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-[9px] font-bold text-gray-300 italic">No subjects selected</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Pref & Bio -->
                            <div class="md:col-span-2 space-y-4">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Teaching Experience Summary</label>
                                    <textarea name="teaching_experience" rows="3" class="w-full bg-gray-50/50 border border-gray-100 p-3 rounded-xl font-medium text-[11px]">{{ $tutor->teaching_experience }}</textarea>
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Personal Bio</label>
                                    <textarea name="bio" rows="4" class="w-full bg-gray-50/50 border border-gray-100 p-3 rounded-xl font-medium text-[11px]">{{ $tutor->bio }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Assessment -->
                        <div class="bg-white p-6 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-50 flex flex-col">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Internal Notes</h4>
                            <textarea name="internal_notes" class="flex-grow w-full bg-gray-50/50 border border-gray-100 p-4 rounded-2xl outline-none font-medium text-xs leading-relaxed" placeholder="Internal assessment...">{{ $tutor->internal_notes }}</textarea>
                            
                        </div>

                        <!-- Actions -->
                        <div class="bg-gray-900 p-6 rounded-[2.5rem] shadow-2xl flex flex-col justify-center gap-4">
                            <div class="space-y-1">
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Interview Time (Optional)</label>
                                <input type="datetime-local" name="interview_at" value="{{ $tutor->interview_at ? $tutor->interview_at->format('Y-m-d\TH:i') : '' }}" class="w-full bg-white border border-gray-200 p-3 rounded-xl font-bold text-xs text-gray-900 shadow-inner">
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <button type="submit" name="status" value="interviewing" class="w-full bg-blue-600 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-blue-700 transition-all active:scale-95">
                                    Request Interview
                                </button>
                                
                                <button type="submit" name="status" value="approved" class="w-full bg-white text-gray-900 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-50 transition-all active:scale-95">
                                    Approve Profile
                                </button>

                                <button type="submit" name="status" value="rejected" class="w-full bg-red-600 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all active:scale-95">
                                    Reject Application
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
