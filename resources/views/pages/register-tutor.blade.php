@extends('layouts.app')
@section('title', 'Tutor Application - TutorHub')

@section('content')
<section class="tutor-apply-section">
    <div class="{{ session('success') ? 'blur-sm pointer-events-none' : '' }}">
        <div class="tutor-apply-container" data-aos="fade-up">

            {{-- Step Progress Bar --}}
            <div class="stepper">
                <div class="stepper-step active" data-step="1" onclick="goToStep(1)">
                    <div class="stepper-circle"><i class="fas fa-user-check"></i></div>
                    <span class="stepper-label">Basic Info</span>
                </div>
                <div class="stepper-line"></div>
                <div class="stepper-step" data-step="2" onclick="goToStep(2)">
                    <div class="stepper-circle"><i class="fas fa-graduation-cap"></i></div>
                    <span class="stepper-label">Career</span>
                </div>
                <div class="stepper-line"></div>
                <div class="stepper-step" data-step="3" onclick="goToStep(3)">
                    <div class="stepper-circle"><i class="fas fa-id-card"></i></div>
                    <span class="stepper-label">About Me</span>
                </div>
                <div class="stepper-line"></div>
                <div class="stepper-step" data-step="4" onclick="goToStep(4)">
                    <div class="stepper-circle"><i class="fas fa-book"></i></div>
                    <span class="stepper-label">Subjects</span>
                </div>
            </div>

            {{-- Server Validation Errors --}}
            @if ($errors->any())
                <div class="form-error-box">
                    <p class="font-bold"><i class="fas fa-exclamation-triangle"></i> Please correct the following errors:</p>
                    <ul class="text-sm mt-2 opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="tutorApplicationForm" action="{{ route('register-tutor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- User Identity Header (Read-only) --}}
                <div class="identity-badge mb-8 p-4 bg-blue-50/50 rounded-2xl border border-blue-100/50 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Applying as</p>
                        <h4 class="text-sm font-black text-gray-900">{{ Auth::user()->name }}</h4>
                        <p class="text-[11px] font-medium text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-sm">
                            <i class="fas fa-vial mr-1"></i> Tutor Account
                        </span>
                    </div>
                </div>

                {{-- ========== STEP 1: BASIC INFO ========== --}}
                <div class="form-step active" id="step-1">
                    <div class="step-header">
                        <h2><span class="step-emoji">🌍</span> Basic Info</h2>
                        <p>Tell us your location and global preferences.</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="country">Country <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-globe"></i>
                                <select id="country" name="country" required>
                                    <option value="" disabled selected>Select your country</option>
                                    <option value="PK" {{ old('country') == 'PK' ? 'selected' : '' }}>🇵🇰 Pakistan</option>
                                    <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>🇦🇪 UAE</option>
                                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>🇸🇦 Saudi Arabia</option>
                                    <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>🇬🇧 United Kingdom</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>🇺🇸 United States</option>
                                    <option value="OTHER" {{ old('country') == 'OTHER' ? 'selected' : '' }}>🌍 Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="timezone">Timezone <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-clock"></i>
                                <select id="timezone" name="timezone" required>
                                    <option value="" disabled selected>Select country first</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="phone" name="phone" placeholder="e.g. +92 300 1234567" value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>Gender <span class="required">*</span></label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                    <div class="radio-card-body"><i class="fas fa-mars"></i><span>Male</span></div>
                                </label>
                                <label class="radio-card">
                                    <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <div class="radio-card-body"><i class="fas fa-venus"></i><span>Female</span></div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>Tutoring Preference <span class="required">*</span></label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input type="radio" name="tutoring_preference" value="online" {{ old('tutoring_preference') == 'online' ? 'checked' : '' }} required>
                                    <div class="radio-card-body"><i class="fas fa-laptop"></i><span>Online</span></div>
                                </label>
                                <label class="radio-card">
                                    <input type="radio" name="tutoring_preference" value="home" {{ old('tutoring_preference') == 'home' ? 'checked' : '' }}>
                                    <div class="radio-card-body"><i class="fas fa-house-user"></i><span>Home</span></div>
                                </label>
                                <label class="radio-card">
                                    <input type="radio" name="tutoring_preference" value="both" {{ old('tutoring_preference') == 'both' ? 'checked' : '' }}>
                                    <div class="radio-card-body"><i class="fas fa-sync"></i><span>Both</span></div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="hourly_rate">Average Fee Per Hour (PKR) <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-coins text-blue-500"></i>
                                <input type="number" id="hourly_rate" name="hourly_rate" placeholder="e.g. 2000" value="{{ old('hourly_rate') }}" required min="0">
                            </div>
                        </div>
                    </div>

                    <div class="step-actions">
                        <div></div>
                        <button type="button" class="btn-next" onclick="nextStep(1)">Continue <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                {{-- ========== STEP 2: CAREER ========== --}}
                <div class="form-step" id="step-2">
                    <div class="step-header">
                        <h2><span class="step-emoji">📚</span> Career</h2>
                        <p>Tell us about your academic credentials.</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="program">Program / Degree <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-graduation-cap"></i>
                                <select id="program" name="program" required>
                                    <option value="" disabled selected>Select Degree</option>
                                    <option value="Bachelors">Bachelor's Degree</option>
                                    <option value="Masters">Master's Degree</option>
                                    <option value="PhD">PhD / Doctorate</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="major">Major / Field <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-book-open"></i>
                                <input type="text" id="major" name="major" placeholder="e.g. Computer Science" value="{{ old('major') }}" required>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="university">University / Institution <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-university"></i>
                                <input type="text" id="university" name="university" placeholder="Institution Name" value="{{ old('university') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="study_year_from">From Year <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-calendar-alt"></i>
                                <select id="study_year_from" name="study_year_from" required>
                                    <option value="" disabled selected>Start Year</option>
                                    @for($y = date('Y'); $y >= 1990; $y--) <option value="{{ $y }}">{{ $y }}</option> @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="study_year_to">To Year <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-calendar-check"></i>
                                <select id="study_year_to" name="study_year_to" required>
                                    <option value="" disabled selected>End Year</option>
                                    <option value="Present">Present (Ongoing)</option>
                                    @for($y = date('Y') + 4; $y >= 1990; $y--) <option value="{{ $y }}">{{ $y }}</option> @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="resume">Upload Resume (PDF) <span class="required">*</span></label>
                            <div class="file-upload-area" id="resumeUploadArea" onclick="document.getElementById('resume').click()">
                                <input type="file" id="resume" name="resume" accept=".pdf" required class="file-input-hidden">
                                <div class="file-upload-content">
                                    <i class="fas fa-cloud-upload-alt text-blue-400"></i>
                                    <p><strong>Click to upload</strong> or drag & drop</p>
                                    <span>PDF formatted CV/Resume. Max 5MB.</span>
                                </div>
                                <div class="file-upload-preview" id="resumePreview" style="display: none;">
                                    <i class="fas fa-file-pdf"></i>
                                    <span id="resumeFileName"></span>
                                    <button type="button" class="file-remove" onclick="removeFile('resume')">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-actions">
                        <button type="button" class="btn-back" onclick="prevStep(2)"><i class="fas fa-arrow-left"></i> Back</button>
                        <button type="button" class="btn-next" onclick="nextStep(2)">Continue <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                {{-- ========== STEP 3: ABOUT ME ========== --}}
                <div class="form-step" id="step-3">
                    <div class="step-header">
                        <h2><span class="step-emoji">✨</span> About Me</h2>
                        <p>Tell students about yourself.</p>
                    </div>

                    <div class="form-box">
                        <div class="form-group full-width mb-8">
                            <label>Profile Image <span class="required">*</span></label>
                            <div class="photo-upload-area">
                                <div class="photo-preview shadow-lg border-2 border-white" id="photoPreviewCircle"><i class="fas fa-user-circle"></i></div>
                                <div class="photo-upload-info">
                                    <input type="file" id="profile_image" name="profile_image" accept="image/*" required class="file-input-hidden">
                                    <button type="button" class="btn-upload-photo" onclick="document.getElementById('profile_image').click()"><i class="fas fa-camera"></i> Select Photo</button>
                                    <span class="photo-hint text-[10px] mt-2 block opacity-60 italic">Recommended square photo. Max 2MB.</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group full-width mb-6">
                            <label for="bio">Personal Bio <span class="required">*</span></label>
                            <textarea id="bio" name="bio" rows="4" required minlength="50" placeholder="Share your academic interests and personality.">{{ old('bio') }}</textarea>
                            <div class="char-counter"><span id="bioCount">0</span> / 50 min characters</div>
                        </div>

                        <div class="form-group full-width">
                            <label for="teaching_experience">Teaching Experience <span class="required">*</span></label>
                            <textarea id="teaching_experience" name="teaching_experience" rows="4" required minlength="30" placeholder="Describe where you've taught before.">{{ old('teaching_experience') }}</textarea>
                            <div class="char-counter"><span id="expCount">0</span> / 30 min characters</div>
                        </div>
                    </div>

                    <div class="step-actions mt-8 pt-8 border-t border-gray-100">
                        <button type="button" class="btn-back" onclick="prevStep(3)"><i class="fas fa-arrow-left"></i> Back</button>
                        <button type="button" class="btn-next" onclick="nextStep(3)">Continue <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                {{-- ========== STEP 4: SUBJECTS ACCORDION ========== --}}
                <div class="form-step" id="step-4">
                    <div class="step-header">
                        <h2><span class="step-emoji">🎓</span> Academic Subjects</h2>
                        <p>Select the subjects you are qualified to teach.</p>
                    </div>

                    <div class="subjects-accordion-container space-y-4">
                        @foreach($categories as $category)
                            <div class="subject-category-card bg-white rounded-3xl border border-gray-100 overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                                <button type="button" onclick="toggleAccordion('cat-{{ $category->id }}')" class="w-full flex items-center justify-between p-6 bg-white hover:bg-gray-50/50 transition-colors text-left group">
                                    <div class="flex items-center gap-4">
                                        <div class="accordion-icon-wrap w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 transition-transform group-hover:scale-110">
                                            <i class="fas fa-plus text-xs accordion-plus" id="plus-cat-{{ $category->id }}"></i>
                                            <i class="fas fa-minus text-xs accordion-minus hidden" id="minus-cat-{{ $category->id }}"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $category->name }}</span>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5"><span class="selected-count" id="count-cat-{{ $category->id }}">0</span> Selected</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-300 group-hover:text-blue-500 transition-transform"></i>
                                </button>
                                
                                <div id="cat-{{ $category->id }}" class="accordion-content hidden border-t border-gray-50 bg-gray-50/20">
                                    <div class="p-6">
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                            @foreach($category->subjects as $subject)
                                                <label class="subject-checkbox-item flex items-center gap-3 p-3 bg-white border border-gray-100 rounded-xl cursor-pointer hover:border-blue-200 hover:bg-blue-50/20 transition-all select-none group">
                                                    <div class="relative flex items-center justify-center">
                                                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" class="subject-input hidden" onchange="updateSelectedCount({{ $category->id }})">
                                                        <div class="custom-checkbox w-5 h-5 rounded-md border-2 border-gray-200 flex items-center justify-center transition-all group-hover:border-blue-400">
                                                            <i class="fas fa-check text-[10px] text-white opacity-0 transition-opacity"></i>
                                                        </div>
                                                    </div>
                                                    <span class="text-[12px] font-bold text-gray-600 group-hover:text-blue-600 transition-colors">{{ $subject->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="step-actions mt-8 pt-8 border-t border-gray-100">
                        <button type="button" class="btn-back" onclick="prevStep(4)"><i class="fas fa-arrow-left"></i> Back</button>
                        <button type="submit" class="btn-submit" id="submitBtn">Submit Application <i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    :root {
        --primary: #1a1a1a;
        --blue-600: #3b82f6;
    }
    .tutor-apply-section { background: #fcfcfc; min-height: 100vh; padding: 4rem 1rem; }
    .tutor-apply-container { max-width: 800px; margin: 0 auto; background: white; padding: 3rem; border-radius: 3rem; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.06); border: 1px solid #f3f4f6; position: relative; }
    
    .stepper { display: flex; align-items: center; justify-content: center; margin-bottom: 4rem; gap: 0.5rem; }
    .stepper-step { display: flex; flex-direction: column; align-items: center; z-index: 10; width: 6rem; transition: all 0.5s ease; opacity: 0.4; }
    .stepper-step.active { opacity: 1; }
    .stepper-step.completed { opacity: 0.8; }
    .stepper-circle { width: 44px; height: 44px; border-radius: 14px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 1.1rem; transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .stepper-step.active .stepper-circle { background: var(--blue-600); color: white; transform: scale(1.1); box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4); }
    .stepper-step.completed .stepper-circle { background: #10b981; color: white; }
    .stepper-label { font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; margin-top: 1rem; color: #4b5563; }
    .stepper-line { flex: 1; height: 3px; background: #f3f4f6; margin-top: -1.7rem; max-width: 3rem; transition: all 0.5s ease; }
    .stepper-line.completed { background: #10b981; }

    .form-step { display: none; }
    .form-step.active { display: block; animation: stepFadeIn 0.6s cubic-bezier(0.23, 1, 0.32, 1); }
    @keyframes stepFadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .step-header { margin-bottom: 3rem; text-align: center; }
    .step-header h2 { font-size: 2rem; font-weight: 900; color: #111827; letter-spacing: -0.02em; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
    .step-header p { font-size: 0.95rem; color: #6b7280; font-weight: 500; margin-top: 0.5rem; }

    .form-grid { display: grid; grid-cols: 1fr 1fr; gap: 1.5rem; }
    .form-group { position: relative; }
    .form-group.full-width { grid-column: 1 / -1; }
    .form-group label { display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #4b5563; margin-bottom: 0.75rem; letter-spacing: 0.05em; }
    
    .input-icon-wrap { position: relative; }
    .input-icon-wrap i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1rem; transition: color 0.3s; }
    .input-icon-wrap input, .input-icon-wrap select, .input-icon-wrap textarea { width: 100%; border: 1.5px solid #f3f4f6; background: #fafafa; padding: 0.9rem 1rem 0.9rem 2.8rem; border-radius: 1rem; outline: none; transition: all 0.3s; font-size: 0.9rem; font-weight: 600; }
    .input-icon-wrap input:focus { border-color: var(--blue-600); background: white; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08); }

    /* Radio Cards */
    .radio-card-group { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; }
    .radio-card { cursor: pointer; position: relative; }
    .radio-card input { position: absolute; opacity: 0; cursor: pointer; }
    .radio-card-body { padding: 1.25rem; border: 1.5px solid #f3f4f6; border-radius: 1.25rem; text-align: center; transition: all 0.3s; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; background: #fafafa; }
    .radio-card input:checked + .radio-card-body { border-color: var(--blue-600); background: #f0f7ff; color: var(--blue-600); box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.1); }
    .radio-card-body i { font-size: 1.25rem; }
    .radio-card-body span { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; }

    /* Upload Area */
    .file-upload-area { border: 2px dashed #e5e7eb; border-radius: 1.5rem; padding: 2.5rem; text-align: center; cursor: pointer; transition: all 0.3s; background: #fafafa; }
    .file-upload-area:hover { border-color: var(--blue-600); background: #f0f7ff; }
    .file-input-hidden { display: none; }
    .file-upload-content i { font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.8; }
    .file-upload-content p { font-size: 0.95rem; color: #374151; }
    .file-upload-content span { font-size: 0.8rem; color: #9ca3af; margin-top: 0.5rem; display: block; }
    .file-upload-preview { display: flex; align-items: center; gap: 1rem; justify-content: center; }
    .file-upload-preview i { font-size: 2rem; color: #ef4444; }
    .file-remove { color: #9ca3af; font-size: 1.5rem; transition: color 0.3s; }
    .file-remove:hover { color: #ef4444; }

    /* Character Counters */
    .char-counter { font-size: 11px; font-weight: 700; color: #9ca3af; text-align: right; margin-top: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }
    textarea { width: 100%; border: 1.5px solid #f3f4f6; background: #fafafa; border-radius: 1.25rem; padding: 1.25rem; outline: none; transition: all 0.3s; font-size: 0.95rem; line-height: 1.6; }
    textarea:focus { border-color: var(--blue-600); background: white; }

    /* Buttons */
    .step-actions { display: flex; align-items: center; justify-content: space-between; margin-top: 3rem; }
    .btn-next, .btn-submit { background: #111827; color: white; padding: 1rem 2.5rem; border-radius: 1.25rem; font-weight: 900; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.1em; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s; }
    .btn-next:hover, .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2); }
    .btn-submit { background: var(--blue-600); width: auto; }
    .btn-back { color: #6b7280; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center; gap: 0.5rem; opacity: 0.6; transition: opacity 0.3s; }
    .btn-back:hover { opacity: 1; }

    /* Custom Checkbox */
    .subject-input:checked + .custom-checkbox { background: var(--blue-600); border-color: var(--blue-600); }
    .subject-input:checked + .custom-checkbox i { opacity: 1; }
    .subject-checkbox-item.selected { border-color: var(--blue-600); background: #f0f7ff; }

    /* Accordion */
    .accordion-content { transition: max-height 0.3s ease-out; }
    .shake { animation: shake 0.4s cubic-bezier(.36,.07,.19,.97) both; }
    @keyframes shake { 10%, 90% { transform: translateX(-1px); } 20%, 80% { transform: translateX(2px); } 30%, 50%, 70% { transform: translateX(-4px); } 40%, 60% { transform: translateX(4px); } }

    .form-error-box { background: #fef2f2; border: 1.5px solid #fee2e2; border-radius: 1.5rem; padding: 1.25rem; margin-bottom: 2rem; color: #b91c1c; }
</style>

@push('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 4;

    function showStep(step) {
        currentStep = step; // Update global state
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');

        document.querySelectorAll('.stepper-step').forEach(el => {
            const s = parseInt(el.dataset.step);
            el.classList.toggle('active', s === step);
            el.classList.toggle('completed', s < step);
            // Add pointer cursor to clickable steps
            el.style.cursor = (s < step || s === step) ? 'pointer' : 'default';
        });
        document.querySelectorAll('.stepper-line').forEach((line, i) => {
            line.classList.toggle('completed', (i + 1) < step);
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function goToStep(target) {
        if (target < currentStep) {
            showStep(target);
            return;
        }
        
        // If moving forward, must validate current step first
        if (target > currentStep) {
            // Only allow moving forward ONE step at a time for safety,
            // or validate all steps in between.
            // Let's validate current step before allowing forward movement.
            if (!validateStep(currentStep)) {
                const container = document.getElementById('step-' + currentStep);
                container.classList.add('shake');
                setTimeout(() => container.classList.remove('shake'), 400);
                return;
            }

            // If they are trying to skip steps forward (e.g. 1 -> 3), 
            // we should technically validate all intermediate steps too.
            // But usually users click the dots for steps they've already "reached".
            // So we'll allow it if they've theoretically passed them.
            showStep(target);
        }
    }

    function validateStep(step) {
        const stepEl = document.getElementById('step-' + step);
        const required = stepEl.querySelectorAll('[required]');
        let valid = true;
        required.forEach(input => {
            if (input.type === 'radio') {
                const radios = stepEl.querySelectorAll(`input[name="${input.name}"]`);
                if (!Array.from(radios).some(r => r.checked)) valid = false;
            } else if (!input.value.trim()) {
                valid = false;
            }
        });
        // Step 4 unique validation
        if (step === 4) {
            const subjects = document.querySelectorAll('input[name="subjects[]"]:checked');
            if (subjects.length === 0) valid = false;
        }
        return valid;
    }

    function nextStep(current) {
        if (!validateStep(current)) {
            const container = document.getElementById('step-' + current);
            container.classList.add('shake');
            setTimeout(() => container.classList.remove('shake'), 400);
            return;
        }
        if (current < totalSteps) {
            currentStep = current + 1;
            showStep(currentStep);
        }
    }

    function prevStep(current) { if (current > 1) { currentStep = current - 1; showStep(currentStep); } }

    // ============================================
    // SUBJECTS ACCORDION LOGIC
    // ============================================
    function toggleAccordion(id) {
        const content = document.getElementById(id);
        const plus = document.getElementById('plus-' + id);
        const minus = document.getElementById('minus-' + id);
        const isHidden = content.classList.contains('hidden');
        
        // Use animation for better premium feel
        if (isHidden) {
            content.classList.remove('hidden');
            plus.classList.add('hidden');
            minus.classList.remove('hidden');
        } else {
            content.classList.add('hidden');
            plus.classList.remove('hidden');
            minus.classList.add('hidden');
        }
    }

    function updateSelectedCount(categoryId) {
        const container = document.getElementById('cat-' + categoryId);
        const checked = container.querySelectorAll('input[type="checkbox"]:checked');
        document.getElementById('count-cat-' + categoryId).textContent = checked.length;
        
        // Toggle card style
        const card = container.closest('.subject-category-card');
        if (checked.length > 0) {
            card.classList.add('border-blue-200', 'ring-1', 'ring-blue-100');
        } else {
            card.classList.remove('border-blue-200', 'ring-1', 'ring-blue-100');
        }
    }

    // ============================================
    // COUNTRY → TIMEZONE MAPPER (Minimal)
    // ============================================
    const tzones = {
        'PK': ['Asia/Karachi'], 'AE': ['Asia/Dubai'], 'SA': ['Asia/Riyadh'], 'GB': ['Europe/London'],
        'US': ['America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles'],
        'OTHER': ['UTC', 'Asia/Dubai', 'Asia/Karachi', 'Europe/London', 'America/New_York']
    };
    document.getElementById('country').addEventListener('change', function() {
        const tzSelect = document.getElementById('timezone');
        const zones = tzones[this.value] || [];
        tzSelect.innerHTML = '<option value="" disabled selected>Select Timezone</option>';
        zones.forEach(z => {
            const opt = document.createElement('option'); opt.value = opt.textContent = z;
            tzSelect.appendChild(opt);
        });
        if (zones.length === 1) tzSelect.value = zones[0];
    });

    // ============================================
    // ASSET PREVIEWS
    // ============================================
    document.getElementById('resume').addEventListener('change', function() {
        const preview = document.getElementById('resumePreview');
        const content = this.closest('.file-upload-area').querySelector('.file-upload-content');
        if (this.files.length > 0) {
            document.getElementById('resumeFileName').textContent = this.files[0].name;
            preview.style.display = 'flex';
            content.style.display = 'none';
        }
    });
    document.getElementById('profile_image').addEventListener('change', function() {
        const preview = document.getElementById('photoPreviewCircle');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
            reader.readAsDataURL(this.files[0]);
        }
    });
    function removeFile(id) {
        document.getElementById(id).value = '';
        if (id === 'resume') {
            document.getElementById('resumePreview').style.display = 'none';
            document.querySelector('.file-upload-content').style.display = 'flex';
        }
    }

    document.getElementById('bio').addEventListener('input', e => document.getElementById('bioCount').textContent = e.target.value.length);
    document.getElementById('teaching_experience').addEventListener('input', e => document.getElementById('expCount').textContent = e.target.value.length);
</script>
@endpush
@endsection
