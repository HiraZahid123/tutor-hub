@extends('layouts.app')
@section('title', 'Request a Tutor - TutorHub')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-gray-50/30 py-12 px-4 relative overflow-hidden">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-50 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl opacity-60"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-50 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl opacity-60"></div>

    <div class="w-full max-w-xl bg-white p-8 md:p-10 rounded-3xl shadow-xl shadow-blue-500/5 border border-blue-50/50 relative z-10" data-aos="fade-up">
        <div class="text-center mb-8">
            <span class="text-[11px] font-bold text-blue-600 uppercase tracking-[0.25em] mb-3 block">Quick & Easy</span>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight leading-tight">Request a Tutor</h2>
            <p class="text-gray-500 mt-2 text-sm font-normal">Fill in the details below and we'll match you with the perfect expert.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-lg"></i>
                {{ session('error') }}
            </div>
        @endif

        @auth
            @if(auth()->user()->role === 'student' && \App\Models\Booking::hasUnpaidSessions(Auth::id()))
                <div class="text-center py-8">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-red-100">
                        <i class="fas fa-lock text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Feature Locked</h3>
                    <p class="text-sm text-gray-500 font-normal leading-relaxed mb-8">Please settle your pending payments for previous sessions before submitting a new tutor request.</p>
                    <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                        <i class="fas fa-wallet text-sm"></i> Go to Payments
                    </a>
                </div>
            @else
                <form action="{{ route('find-a-tutor.store') }}" method="POST" class="space-y-5">
                    @csrf
            @endif
        @else
            <form action="{{ route('find-a-tutor.store') }}" method="POST" class="space-y-5">
                @csrf
        @endauth

            @guest
                {{-- Registration Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Full Name</label>
                        <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" required>
                        @error('name') <span class="text-red-500 text-[11px] mt-1 ml-1 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Email Address</label>
                        <input type="email" name="email" placeholder="email@example.com" value="{{ old('email') }}" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" required>
                        @error('email') <span class="text-red-500 text-[11px] mt-1 ml-1 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Create Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" required>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat password" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" required>
                    </div>
                    @error('password') <span class="text-red-500 text-[11px] mt-1 ml-1 font-semibold col-span-2">{{ $message }}</span> @enderror
                </div>
            @endguest

            {{-- Core Request Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">City / Area</label>
                    <input type="text" name="city" placeholder="e.g. Lahore, Gulberg" value="{{ old('city') }}" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" required>
                    @error('city') <span class="text-red-500 text-[11px] mt-1 ml-1 font-semibold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Grade / Level</label>
                    <select name="grade" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all cursor-pointer outline-none" required>
                        <option value="" disabled selected>Select Grade</option>
                        <option value="Primary (Grade 1-5)" {{ old('grade') == 'Primary (Grade 1-5)' ? 'selected' : '' }}>Primary (Grade 1-5)</option>
                        <option value="Middle (Grade 6-8)" {{ old('grade') == 'Middle (Grade 6-8)' ? 'selected' : '' }}>Middle (Grade 6-8)</option>
                        <option value="Secondary (O-Level/Matric)" {{ old('grade') == 'Secondary (O-Level/Matric)' ? 'selected' : '' }}>Secondary (O-Level/Matric)</option>
                        <option value="Higher Secondary (A-Level/Intermediate)" {{ old('grade') == 'Higher Secondary (A-Level/Intermediate)' ? 'selected' : '' }}>Higher Secondary (A-Level/Intermediate)</option>
                        <option value="University / Undergraduate" {{ old('grade') == 'University / Undergraduate' ? 'selected' : '' }}>University / Undergraduate</option>
                        <option value="Other" {{ old('grade') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('grade') <span class="text-red-500 text-[11px] mt-1 ml-1 font-semibold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Tutoring Mode Selection -->
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2.5 ml-1">Tutoring Mode Preference</label>
                <div class="flex flex-row gap-2.5" id="tutoring-type-container">
                    <label class="flex-1 tutoring-mode-btn cursor-pointer group {{ old('tutoring_type') == 'online' ? 'active' : '' }}">
                        <input type="radio" name="tutoring_type" value="online" class="hidden" {{ old('tutoring_type') == 'online' ? 'checked' : '' }} required onchange="updateTutoringModeUI()">
                        <div class="flex flex-col items-center justify-center gap-1.5 p-3 border border-gray-200 rounded-xl transition-all hover:bg-gray-50 bg-white shadow-sm shadow-gray-500/5">
                            <i class="fas fa-video text-base opacity-40 group-hover:opacity-100 transition-opacity"></i>
                            <span class="text-[11px] font-bold uppercase tracking-wider">Online</span>
                        </div>
                    </label>

                    <label class="flex-1 tutoring-mode-btn cursor-pointer group {{ old('tutoring_type') == 'home' ? 'active' : '' }}">
                        <input type="radio" name="tutoring_type" value="home" class="hidden" {{ old('tutoring_type') == 'home' ? 'checked' : '' }} onchange="updateTutoringModeUI()">
                        <div class="flex flex-col items-center justify-center gap-1.5 p-3 border border-gray-200 rounded-xl transition-all hover:bg-gray-50 bg-white shadow-sm shadow-gray-500/5">
                            <i class="fas fa-home text-base opacity-40 group-hover:opacity-100 transition-opacity"></i>
                            <span class="text-[11px] font-bold uppercase tracking-wider">Home</span>
                        </div>
                    </label>

                    <label class="flex-1 tutoring-mode-btn cursor-pointer group {{ old('tutoring_type', 'both') == 'both' ? 'active' : '' }}">
                        <input type="radio" name="tutoring_type" value="both" class="hidden" {{ old('tutoring_type', 'both') == 'both' ? 'checked' : '' }} onchange="updateTutoringModeUI()">
                        <div class="flex flex-col items-center justify-center gap-1.5 p-3 border border-gray-200 rounded-xl transition-all hover:bg-gray-50 bg-white shadow-sm shadow-gray-500/5">
                            <i class="fas fa-check-double text-base opacity-40 group-hover:opacity-100 transition-opacity"></i>
                            <span class="text-[11px] font-bold uppercase tracking-wider">Both</span>
                        </div>
                    </label>
                </div>
                @error('tutoring_type') <span class="text-red-500 text-[11px] mt-2 ml-1 font-semibold block">{{ $message }}</span> @enderror
            </div>

            <!-- Subjects Selection -->
            <div class="pt-5 border-t border-gray-100 mt-6">
                <label class="block text-base font-bold text-gray-900 mb-4">Required Subjects</label>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">1. Choose Category</label>
                        <select id="category-selector" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all cursor-pointer outline-none">
                            <option value="">Select Category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">2. Select Subject</label>
                        <select id="subject-selector" class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200/50 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all cursor-pointer outline-none" disabled>
                            <option value="">Choose Category first...</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <div id="selected-subjects-container" class="flex flex-wrap gap-2 min-h-[50px] p-4 bg-gray-50/50 border border-dashed border-gray-200 rounded-xl">
                        <p id="no-subjects-msg" class="text-[11px] font-bold text-gray-300 uppercase tracking-wider m-auto">No subjects selected</p>
                    </div>
                </div>
                <div id="hidden-subjects-inputs"></div>
                @error('subjects') <span class="text-red-500 text-[11px] mt-2 ml-1 font-semibold block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-sm uppercase tracking-wider transition-all shadow-lg shadow-blue-500/10 active:scale-95 mt-6 flex items-center justify-center gap-2 group">
                <span>Submit Request</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>
    </div>
</section>

<style>
    .tutoring-mode-btn.active div {
        border-color: #2563eb;
        background-color: #eff6ff;
        color: #1d4ed8;
    }
    .tutoring-mode-btn.active i {
        color: #2563eb;
        opacity: 1;
    }
</style>

@endsection

@push('scripts')
<script>
    function updateTutoringModeUI() {
        const btns = document.querySelectorAll('.tutoring-mode-btn');
        btns.forEach(btn => {
            const radio = btn.querySelector('input[type="radio"]');
            if (radio.checked) btn.classList.add('active');
            else btn.classList.remove('active');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateTutoringModeUI();
        
        const categories = @json($categories->keyBy('id'));
        const categorySelector = document.getElementById('category-selector');
        const subjectSelector = document.getElementById('subject-selector');
        const subjectsContainer = document.getElementById('selected-subjects-container');
        const hiddenInputsContainer = document.getElementById('hidden-subjects-inputs');
        const noSubjectsMsg = document.getElementById('no-subjects-msg');
        
        let selectedSubjects = new Set();
        const oldSubjects = @json(old('subjects', []));
        if (oldSubjects && oldSubjects.length > 0) oldSubjects.forEach(name => addSubjectTag(name));

        categorySelector.addEventListener('change', function() {
            const categoryId = this.value;
            subjectSelector.innerHTML = '';
            if (!categoryId) {
                subjectSelector.innerHTML = '<option value="">Choose Category first...</option>';
                subjectSelector.disabled = true;
                return;
            }
            const category = categories[categoryId];
            if (category && category.subjects.length > 0) {
                subjectSelector.disabled = false;
                subjectSelector.innerHTML = '<option value="" selected disabled>Pick a Subject...</option>';
                category.subjects.forEach(subject => {
                    subjectSelector.innerHTML += `<option value="${subject.name}">${subject.name}</option>`;
                });
            } else {
                subjectSelector.innerHTML = '<option value="">No subjects found</option>';
                subjectSelector.disabled = true;
            }
        });

        subjectSelector.addEventListener('change', function() {
            const subjectName = this.value;
            if (subjectName && !selectedSubjects.has(subjectName)) {
                addSubjectTag(subjectName);
                this.value = '';
            }
        });

        function addSubjectTag(name) {
            if (selectedSubjects.has(name)) return;
            selectedSubjects.add(name);
            noSubjectsMsg.style.display = 'none';

            const tag = document.createElement('div');
            tag.className = 'subject-tag inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-xl border border-blue-100 text-[11px] font-bold uppercase tracking-wider transition-all animate-in zoom-in-50 duration-200';
            tag.innerHTML = `
                <span>${name}</span>
                <button type="button" class="remove-btn hover:text-red-500">
                    <i class="fas fa-times-circle"></i>
                </button>
            `;
            tag.querySelector('.remove-btn').addEventListener('click', function() {
                selectedSubjects.delete(name);
                tag.remove();
                updateHiddenInputs();
                if (selectedSubjects.size === 0) noSubjectsMsg.style.display = 'block';
            });
            subjectsContainer.appendChild(tag);
            updateHiddenInputs();
        }

        function updateHiddenInputs() {
            hiddenInputsContainer.innerHTML = '';
            selectedSubjects.forEach(name => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'subjects[]';
                input.value = name;
                hiddenInputsContainer.appendChild(input);
            });
        }
    });
</script>
@endpush
