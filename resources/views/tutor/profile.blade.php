@extends('layouts.dashboard')
@section('title', 'Professional Profile - TutorHub')

@section('dashboard-content')
<div class="max-w-5xl">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2">My Professional Profile</h1>
        <p class="text-gray-500 font-medium">Update your core identity and subject expertise.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50/50 border border-green-100 text-green-700 p-5 rounded-3xl mb-8 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 p-5 rounded-3xl mb-8">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-bold">Please correct the following:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-medium opacity-80">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tutor.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar: Avatar & Resume -->
            <div class="space-y-8">
                <!-- Profile Image -->
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                    
                    <div class="mb-8 font-black text-[11px] text-gray-400 uppercase tracking-widest">Profile Image</div>
                    
                    <div class="relative inline-block mb-2">
                        <div class="rounded-3xl bg-gray-50 border-4 border-white shadow-2xl overflow-hidden relative mx-auto" style="width: 150px; height: 150px;">
                            @if($registration && $registration->profile_image)
                                <img id="profile-preview" src="{{ asset('storage/' . $registration->profile_image) }}" class="w-full h-full object-cover">
                            @else
                                <div id="profile-placeholder" class="w-full h-full flex items-center justify-center text-blue-600 font-black text-5xl bg-blue-50">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <img id="profile-preview" src="#" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        <label for="profile_image" class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-blue-600 text-white p-3.5 rounded-2xl shadow-2xl cursor-pointer hover:bg-blue-700 transition-all transform hover:scale-110 active:scale-95 z-20 border-4 border-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </label>
                        <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-50">
                        <p class="text-sm font-black text-gray-900 tracking-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-tighter mt-1">Professional Tutor</p>
                    </div>
                </div>

                <!-- Resume -->
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                    <div class="mb-6 font-black text-[11px] text-gray-400 uppercase tracking-widest text-center">Resume / CV</div>
                    
                    <div class="space-y-4">
                        <label class="block">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Update PDF</span>
                            <input type="file" name="resume" class="mt-2 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition-all cursor-pointer" accept=".pdf">
                        </label>

                        @if($registration && $registration->resume_path)
                            <div class="pt-4 border-t border-gray-50 mt-4">
                                <a href="{{ asset('storage/' . $registration->resume_path) }}" target="_blank" class="flex items-center justify-center gap-2 text-blue-600 bg-blue-50 py-3 rounded-2xl hover:bg-blue-600 hover:text-white transition-all group/resume">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">View Current Resume</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info Card -->
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Basic Information</h3>
                            <p class="text-xs font-bold text-gray-400">Core details for your account.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" required>
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $registration?->phone) }}" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" placeholder="+92 300 1234567" required>
                        </div>

                        <!-- Tutoring Mode Presence -->
                        <div class="md:col-span-2 space-y-4 py-4 mt-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Tutoring Mode Presence</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                @php
                                    $currentPreference = old('tutoring_preference', $registration?->tutoring_preference ? $registration->tutoring_preference : ($registration?->is_online && $registration?->is_home ? 'both' : ($registration?->is_online ? 'online' : 'home')));
                                @endphp
                                <label class="radio-card-lite">
                                    <input type="radio" name="tutoring_preference" value="online" {{ $currentPreference == 'online' ? 'checked' : '' }} required class="hidden">
                                    <div class="card-body">
                                        <i class="fas fa-laptop text-lg mb-1"></i>
                                        <span>Online</span>
                                    </div>
                                </label>
                                <label class="radio-card-lite">
                                    <input type="radio" name="tutoring_preference" value="home" {{ $currentPreference == 'home' ? 'checked' : '' }} class="hidden">
                                    <div class="card-body">
                                        <i class="fas fa-house-user text-lg mb-1"></i>
                                        <span>Home</span>
                                    </div>
                                </label>
                                <label class="radio-card-lite">
                                    <input type="radio" name="tutoring_preference" value="both" {{ $currentPreference == 'both' ? 'checked' : '' }} class="hidden">
                                    <div class="card-body">
                                        <i class="fas fa-sync text-lg mb-1"></i>
                                        <span>Both</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subjects Accordion Section -->
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Subject Expertise</h3>
                            <p class="text-xs font-bold text-gray-400">Select all subjects you can teach.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @php
                            $selectedSubjects = $registration ? $registration->subjects->pluck('id')->toArray() : [];
                        @endphp
                        @foreach($categories as $category)
                            <div class="subject-category-card border border-gray-100 rounded-3xl overflow-hidden transition-all duration-300">
                                <button type="button" onclick="toggleAccordion('cat-{{ $category->id }}')" class="w-full flex items-center justify-between p-5 bg-white hover:bg-gray-50/50 transition-colors text-left group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 transition-transform group-hover:scale-110">
                                            <i class="fas fa-plus text-[10px] accordion-plus" id="plus-cat-{{ $category->id }}"></i>
                                            <i class="fas fa-minus text-[10px] accordion-minus hidden" id="minus-cat-{{ $category->id }}"></i>
                                        </div>
                                        <div>
                                            <span class="text-xs font-black text-gray-900 uppercase tracking-tight">{{ $category->name }}</span>
                                            @php
                                                $categorySubjectIds = $category->subjects->pluck('id')->toArray();
                                                $selectedInCategory = count(array_intersect($categorySubjectIds, $selectedSubjects));
                                            @endphp
                                            <p class="text-[8px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">
                                                <span class="selected-count" id="count-cat-{{ $category->id }}">{{ $selectedInCategory }}</span> Selected
                                            </p>
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-300 text-xs transition-transform transform group-hover:text-blue-500"></i>
                                </button>
                                
                                <div id="cat-{{ $category->id }}" class="accordion-content hidden border-t border-gray-50 bg-gray-50/30">
                                    <div class="p-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach($category->subjects as $subject)
                                                <label class="flex items-center gap-3 p-3 bg-white border border-gray-100 rounded-2xl cursor-pointer hover:border-blue-200 hover:bg-blue-50/20 transition-all select-none group">
                                                    <div class="relative flex items-center justify-center">
                                                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" 
                                                            {{ in_array($subject->id, $selectedSubjects) ? 'checked' : '' }}
                                                            class="subject-input hidden" onchange="updateSelectedCount({{ $category->id }})">
                                                        <div class="custom-checkbox w-5 h-5 rounded-lg border-2 border-gray-200 flex items-center justify-center transition-all group-hover:border-blue-400">
                                                            <i class="fas fa-check text-[9px] text-white opacity-0 transition-opacity"></i>
                                                        </div>
                                                    </div>
                                                    <span class="text-[11px] font-bold text-gray-600 group-hover:text-blue-600 transition-colors">{{ $subject->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Security Section -->
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Security</h3>
                            <p class="text-xs font-bold text-gray-400">Update your password (keep empty to remain unchanged).</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">New Password</label>
                            <input type="password" name="password" class="w-full bg-gray-50 border-transparent rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all shadow-inner" placeholder="••••••••">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="w-full bg-gray-50 border-transparent rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all shadow-inner" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 pb-10">
                    <button type="submit" class="bg-blue-600 text-white px-12 py-5 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 flex items-center gap-3">
                        <i class="fas fa-save text-sm"></i>
                        Update Profile
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .radio-card-lite { cursor: pointer; display: block; }
    .radio-card-lite .card-body {
        padding: 1rem;
        border: 2px solid #f3f4f6;
        border-radius: 1.25rem;
        text-align: center;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #fafafa;
        color: #9ca3af;
    }
    .radio-card-lite input:checked + .card-body {
        border-color: #3b82f6;
        background: #f0f7ff;
        color: #3b82f6;
        box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.1);
    }
    .radio-card-lite .card-body span {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .subject-input:checked + .custom-checkbox { background: #3b82f6; border-color: #3b82f6; }
    .subject-input:checked + .custom-checkbox i { opacity: 1; }
    
    .subject-category-card.active-cat { border-color: #bfdbfe; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }

    .accordion-content { transition: max-height 0.3s ease-out; }
</style>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profile-preview');
                const placeholder = document.getElementById('profile-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleAccordion(id) {
        const content = document.getElementById(id);
        const plus = document.getElementById('plus-' + id);
        const minus = document.getElementById('minus-' + id);
        const card = content.closest('.subject-category-card');
        const isHidden = content.classList.contains('hidden');
        
        if (isHidden) {
            content.classList.remove('hidden');
            plus.classList.add('hidden');
            minus.classList.remove('hidden');
            card.classList.add('active-cat');
        } else {
            content.classList.add('hidden');
            plus.classList.remove('hidden');
            minus.classList.add('hidden');
            card.classList.remove('active-cat');
        }
    }

    function updateSelectedCount(categoryId) {
        const container = document.getElementById('cat-' + categoryId);
        const checked = container.querySelectorAll('input[type="checkbox"]:checked');
        document.getElementById('count-cat-' + categoryId).textContent = checked.length;
    }
</script>
@endsection
