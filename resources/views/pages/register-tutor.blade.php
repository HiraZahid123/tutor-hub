@extends('layouts.app')
@section('title', 'Tutor Application - TutorHub')

@section('content')

<style>
/* ===== GOOGLE FONT ===== */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

:root {
    --blue: #2563EB;
    --blue-light: #EFF6FF;
    --blue-ring: rgba(37,99,235,0.15);
    --green: #10b981;
    --gray-bg: #F7F8FA;
    --border: #E5E7EB;
    --text: #111827;
    --muted: #6B7280;
    --label: #374151;
}

.apply-wrapper {
    font-family: 'Inter', sans-serif;
    background: var(--gray-bg);
    min-height: 100vh;
    padding: 3rem 1rem 5rem;
}

.apply-card {
    max-width: 860px;
    margin: 0 auto;
    background: #fff;
    border-radius: 2rem;
    box-shadow: 0 20px 80px rgba(37,99,235,0.07), 0 2px 12px rgba(0,0,0,0.04);
    border: 1px solid var(--border);
    overflow: hidden;
}

/* ===== HEADER ===== */
.apply-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    padding: 2.5rem 3rem 2rem;
    color: #fff;
}
.apply-header h1 {
    font-size: 1.75rem;
    font-weight: 900;
    letter-spacing: -0.02em;
    margin-bottom: 0.25rem;
}
.apply-header p {
    font-size: 0.9rem;
    opacity: 0.75;
    font-weight: 500;
}

/* ===== HORIZONTAL STEPPER ===== */
.h-stepper {
    display: flex;
    align-items: stretch;
    background: rgba(255,255,255,0.12);
    border-radius: 0.85rem;
    padding: 0.3rem;
    margin-top: 1.75rem;
    gap: 0.2rem;
}
.h-step {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 1rem;
    border-radius: 0.6rem;
    cursor: default;
    transition: background 0.3s, opacity 0.3s;
    opacity: 0.5;
    position: relative;
}
.h-step.active {
    background: #fff;
    opacity: 1;
    box-shadow: 0 4px 16px rgba(37,99,235,0.12);
}
.h-step.completed {
    opacity: 0.85;
    cursor: pointer;
}
.h-step-num {
    width: 28px; height: 28px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; font-weight: 900;
    flex-shrink: 0;
    transition: all 0.3s;
    color: rgba(255,255,255,0.9);
}
.h-step.active .h-step-num {
    background: var(--blue);
    border-color: var(--blue);
    color: #fff;
}
.h-step.completed .h-step-num {
    background: var(--green);
    border-color: var(--green);
    color: #fff;
}
.h-step-info {
    flex: 1;
    min-width: 0;
}
.h-step-label {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: rgba(255,255,255,0.8);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.h-step.active .h-step-label {
    color: var(--blue);
}
.h-step.completed .h-step-label {
    color: var(--green);
}
.h-step-sub {
    font-size: 0.6rem;
    color: rgba(255,255,255,0.5);
    font-weight: 600;
    margin-top: 1px;
}
.h-step.active .h-step-sub {
    color: var(--muted);
}
.h-step-arrow {
    font-size: 0.55rem;
    color: rgba(255,255,255,0.35);
}
.h-step.active .h-step-arrow { color: #cbd5e1; }

/* ===== IDENTITY BADGE ===== */
.identity-badge {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--blue-light);
    border: 1px solid #dbeafe;
    border-radius: 1rem;
    padding: 1rem 1.25rem;
    margin: 0 3rem 2rem;
}
.identity-name {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--text);
}
.identity-email {
    font-size: 0.8rem;
    color: var(--muted);
    font-weight: 500;
    margin-top: 1px;
}
.identity-role-badge {
    background: var(--blue);
    color: #fff;
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.35rem 0.85rem;
    border-radius: 50px;
}

/* ===== FORM BODY ===== */
.apply-body {
    padding: 0 3rem 3rem;
}
.form-step { display: none; }
.form-step.active {
    display: block;
    animation: stepIn 0.45s cubic-bezier(0.23, 1, 0.32, 1);
}
@keyframes stepIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== STEP HEADER ===== */
.step-heading {
    text-align: center;
    margin-bottom: 2.5rem;
    padding-bottom: 1.75rem;
    border-bottom: 1px solid var(--border);
}
.step-heading h2 {
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.02em;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
}
.step-heading p {
    font-size: 0.9rem;
    color: var(--muted);
    margin-top: 0.5rem;
    font-weight: 500;
}

/* ===== GRID ===== */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.form-group { position: relative; }
.full-width { grid-column: 1 / -1; }

/* ===== LABELS ===== */
.field-label {
    display: block;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--label);
    margin-bottom: 0.6rem;
}
.field-label .req { color: #ef4444; margin-left: 2px; }

/* ===== INPUTS ===== */
.field-wrap { position: relative; }
.field-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 0.9rem;
    pointer-events: none;
    z-index: 1;
}
.field-wrap input,
.field-wrap select {
    width: 100%;
    border: 1.5px solid var(--border);
    background: #fafafa;
    padding: 0.85rem 1rem 0.85rem 2.75rem;
    border-radius: 0.85rem;
    outline: none;
    transition: all 0.25s;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text);
    font-family: inherit;
}
.field-wrap input:focus,
.field-wrap select:focus {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 4px var(--blue-ring);
}
.field-wrap select {
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
}

/* Phone Input with Prefix */
.phone-wrap {
    display: flex;
    align-items: stretch;
    border: 1.5px solid var(--border);
    border-radius: 0.85rem;
    background: #fafafa;
    overflow: hidden;
    transition: all 0.25s;
}
.phone-wrap:focus-within {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 4px var(--blue-ring);
}
.phone-prefix {
    background: var(--blue);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 800;
    padding: 0 1.1rem;
    display: flex;
    align-items: center;
    white-space: nowrap;
    flex-shrink: 0;
}
.phone-wrap input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.85rem 1rem;
    outline: none;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text);
    font-family: inherit;
    box-shadow: none !important;
}
.phone-hint {
    font-size: 0.72rem;
    color: var(--muted);
    margin-top: 0.45rem;
    font-style: italic;
}

/* ===== RADIO CARDS ===== */
.radio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.85rem;
}
.radio-card { cursor: pointer; position: relative; }
.radio-card input {
    position: absolute;
    opacity: 0;
    width: 0; height: 0;
}
.radio-body {
    padding: 1.1rem 0.75rem;
    border: 1.5px solid var(--border);
    border-radius: 0.85rem;
    text-align: center;
    background: #fafafa;
    transition: all 0.25s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}
.radio-card input:checked + .radio-body {
    border-color: var(--blue);
    background: var(--blue-light);
    box-shadow: 0 4px 16px rgba(37,99,235,0.12);
}
.radio-body i { font-size: 1.2rem; color: #9ca3af; }
.radio-card input:checked + .radio-body i { color: var(--blue); }
.radio-body span {
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted);
}
.radio-card input:checked + .radio-body span { color: var(--blue); }

/* ===== FEE INPUT ===== */
.fee-wrap {
    display: flex;
    align-items: stretch;
    border: 1.5px solid var(--border);
    border-radius: 0.85rem;
    background: #fafafa;
    overflow: hidden;
    transition: all 0.25s;
}
.fee-wrap:focus-within {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 4px var(--blue-ring);
}
.fee-wrap input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.85rem 1rem;
    outline: none;
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text);
    font-family: inherit;
}
.fee-suffix {
    background: #f3f4f6;
    color: var(--muted);
    font-size: 0.8rem;
    font-weight: 700;
    padding: 0 1rem;
    display: flex;
    align-items: center;
    border-left: 1.5px solid var(--border);
}

/* ===== UPLOAD AREA ===== */
.upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 1rem;
    padding: 2.5rem;
    text-align: center;
    cursor: pointer;
    background: #fafafa;
    transition: all 0.25s;
}
.upload-area:hover {
    border-color: var(--blue);
    background: var(--blue-light);
}
.upload-area i { font-size: 2.25rem; color: #93c5fd; margin-bottom: 0.75rem; display: block; }
.upload-area p { font-size: 0.9rem; color: var(--label); font-weight: 600; }
.upload-area p strong { color: var(--blue); }
.upload-area span { font-size: 0.77rem; color: #9ca3af; display: block; margin-top: 0.3rem; }
.upload-preview {
    display: flex; align-items: center; justify-content: center; gap: 1rem;
}
.upload-preview i { font-size: 2rem; color: #ef4444; }
.file-remove { background: none; border: none; color: #9ca3af; font-size: 1.5rem; cursor: pointer; }
.file-remove:hover { color: #ef4444; }

/* ===== PHOTO UPLOAD ===== */
.photo-area {
    display: flex;
    align-items: center;
    gap: 2rem;
    background: var(--blue-light);
    border: 1px solid #dbeafe;
    border-radius: 1.1rem;
    padding: 1.5rem 2rem;
}
.photo-preview-circle {
    width: 90px; height: 90px;
    border-radius: 50%;
    background: #dbeafe;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    border: 3px solid #fff;
    box-shadow: 0 4px 16px rgba(37,99,235,0.15);
}
.photo-preview-circle i { font-size: 2.5rem; color: #93c5fd; }
.btn-photo {
    background: var(--blue);
    color: #fff;
    border: none;
    padding: 0.65rem 1.25rem;
    border-radius: 0.65rem;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.25s;
}
.btn-photo:hover { background: #1d4ed8; transform: translateY(-1px); }

/* ===== TEXTAREA ===== */
.form-textarea {
    width: 100%;
    border: 1.5px solid var(--border);
    background: #fafafa;
    border-radius: 0.85rem;
    padding: 1rem 1.15rem;
    outline: none;
    transition: all 0.25s;
    font-size: 0.9rem;
    font-weight: 500;
    line-height: 1.65;
    color: var(--text);
    font-family: inherit;
    resize: vertical;
}
.form-textarea:focus {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 4px var(--blue-ring);
}
.char-counter {
    text-align: right;
    font-size: 0.7rem;
    font-weight: 700;
    color: #9ca3af;
    margin-top: 0.4rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* ===== SUBJECT ACCORDION ===== */
.subject-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 1.1rem;
    overflow: hidden;
    transition: all 0.25s;
}
.subject-card:hover { border-color: #bfdbfe; }
.subject-card.has-selected { border-color: #bfdbfe; box-shadow: 0 0 0 3px rgba(37,99,235,0.06); }
.subject-toggle {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.1rem 1.35rem;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    gap: 1rem;
}
.subject-toggle-left {
    display: flex; align-items: center; gap: 0.85rem;
}
.subject-icon {
    width: 36px; height: 36px;
    background: var(--blue-light);
    border-radius: 0.65rem;
    display: flex; align-items: center; justify-content: center;
    color: var(--blue);
    font-size: 0.75rem;
    flex-shrink: 0;
}
.subject-title {
    font-size: 0.87rem;
    font-weight: 800;
    color: var(--text);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.subject-count {
    font-size: 0.68rem;
    color: var(--muted);
    font-weight: 600;
    margin-top: 1px;
}
.subject-chevron { color: #d1d5db; font-size: 0.8rem; transition: transform 0.25s; }
.subject-chevron.open { transform: rotate(180deg); }

.subject-panel { display: none; border-top: 1px solid #f1f5f9; background: #fafafa; padding: 1.25rem; }
.subject-panel.open { display: block; }
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 0.65rem;
}
.subject-check-item {
    display: flex; align-items: center; gap: 0.6rem;
    padding: 0.7rem 0.85rem;
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 0.7rem;
    cursor: pointer;
    transition: all 0.2s;
    user-select: none;
}
.subject-check-item:hover { border-color: #93c5fd; background: var(--blue-light); }
.subject-input { display: none; }
.custom-check {
    width: 18px; height: 18px;
    border-radius: 5px;
    border: 2px solid #d1d5db;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
}
.subject-input:checked + .custom-check {
    background: var(--blue);
    border-color: var(--blue);
}
.custom-check i { font-size: 0.6rem; color: #fff; opacity: 0; }
.subject-input:checked + .custom-check i { opacity: 1; }
.subject-input:checked ~ .subject-name { color: var(--blue); font-weight: 800; }
.subject-name { font-size: 0.78rem; font-weight: 600; color: var(--muted); transition: color 0.2s; }

/* ===== ACTION BUTTONS ===== */
.step-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}
.btn-back {
    background: none;
    border: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--muted);
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    padding: 0.75rem 1.25rem;
    border-radius: 0.65rem;
    transition: all 0.25s;
}
.btn-back:hover { color: var(--blue); background: var(--blue-light); }
.btn-next {
    background: var(--text);
    color: #fff;
    border: none;
    padding: 0.9rem 2.25rem;
    border-radius: 0.85rem;
    font-size: 0.82rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    cursor: pointer;
    display: flex; align-items: center; gap: 0.65rem;
    transition: all 0.25s;
}
.btn-next:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.18); }
.btn-submit {
    background: var(--blue);
    color: #fff;
    border: none;
    padding: 0.9rem 2.25rem;
    border-radius: 0.85rem;
    font-size: 0.82rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    cursor: pointer;
    display: flex; align-items: center; gap: 0.65rem;
    transition: all 0.25s;
}
.btn-submit:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,0.35); }

/* ===== ERRORS ===== */
.error-box {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-radius: 1rem;
    padding: 1.1rem 1.35rem;
    margin-bottom: 1.75rem;
    color: #b91c1c;
    font-size: 0.85rem;
}

/* ===== SHAKE ANIM ===== */
.shake { animation: shakeIt 0.4s cubic-bezier(.36,.07,.19,.97) both; }
@keyframes shakeIt {
    10%, 90% { transform: translateX(-1px); }
    20%, 80% { transform: translateX(2px); }
    30%, 50%, 70% { transform: translateX(-4px); }
    40%, 60% { transform: translateX(4px); }
}

@media (max-width: 700px) {
    .apply-header, .apply-body { padding-left: 1.5rem; padding-right: 1.5rem; }
    .identity-badge { margin: 0 1.5rem 2rem; }
    .form-grid { grid-template-columns: 1fr; }
    .full-width { grid-column: 1; }
    .h-step-sub, .h-step-arrow { display: none; }
    .h-step-label { font-size: 0.6rem; }
}
</style>

<div class="apply-wrapper">
<div class="apply-card">

    {{-- ===== HEADER & STEPPER ===== --}}
    <div class="apply-header">
        <h1>Complete Your Profile</h1>
        <p>Fill in all four steps to submit your tutor application for review.</p>

        <div class="h-stepper" id="hStepper">
            <div class="h-step active" data-step="1" onclick="goToStep(1)">
                <div class="h-step-num">1</div>
                <div class="h-step-info">
                    <div class="h-step-label">Basic Info</div>
                    <div class="h-step-sub">Location & Preferences</div>
                </div>
                <i class="fas fa-chevron-right h-step-arrow"></i>
            </div>
            <div class="h-step" data-step="2" onclick="goToStep(2)">
                <div class="h-step-num">2</div>
                <div class="h-step-info">
                    <div class="h-step-label">Career</div>
                    <div class="h-step-sub">Education & Resume</div>
                </div>
                <i class="fas fa-chevron-right h-step-arrow"></i>
            </div>
            <div class="h-step" data-step="3" onclick="goToStep(3)">
                <div class="h-step-num">3</div>
                <div class="h-step-info">
                    <div class="h-step-label">About Me</div>
                    <div class="h-step-sub">Bio & Experience</div>
                </div>
                <i class="fas fa-chevron-right h-step-arrow"></i>
            </div>
            <div class="h-step" data-step="4" onclick="goToStep(4)">
                <div class="h-step-num">4</div>
                <div class="h-step-info">
                    <div class="h-step-label">Subjects</div>
                    <div class="h-step-sub">Teaching Areas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== IDENTITY BADGE ===== --}}
    <div style="padding: 2rem 3rem 0;">
        <div class="identity-badge">
            <div>
                <div style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:2px;">Applying as</div>
                <div class="identity-name">{{ Auth::user()->name }}</div>
                <div class="identity-email">{{ Auth::user()->email }}</div>
            </div>
            <span class="identity-role-badge"><i class="fas fa-chalkboard-teacher mr-1"></i> Tutor Account</span>
        </div>
    </div>

    <div class="apply-body">

        {{-- Errors --}}
        @if ($errors->any())
            <div class="error-box">
                <p style="font-weight:800;margin-bottom:0.5rem;"><i class="fas fa-exclamation-circle mr-1"></i> Please correct the following errors:</p>
                <ul style="margin:0;padding-left:1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="applyForm" action="{{ route('register-tutor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ============ STEP 1: BASIC INFO ============ --}}
            <div class="form-step active" id="step-1">
                <div class="step-heading">
                    <h2><span>🌍</span> Basic Info</h2>
                    <p>Tell us your location, contact details and teaching preferences.</p>
                </div>

                <div class="form-grid">
                    {{-- Country --}}
                    <div class="form-group">
                        <label class="field-label">Country <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-globe field-icon"></i>
                            <select id="country" name="country" required>
                                <option value="" disabled selected>Select your country</option>
                                <optgroup label="🌟 Popular">
                                    <option value="PK" {{ old('country') == 'PK' ? 'selected' : '' }}>🇵🇰 Pakistan</option>
                                    <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>🇦🇪 UAE</option>
                                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>🇸🇦 Saudi Arabia</option>
                                    <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>🇬🇧 United Kingdom</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>🇺🇸 United States</option>
                                </optgroup>
                                <optgroup label="🌍 Middle East & Asia">
                                    <option value="QA" {{ old('country') == 'QA' ? 'selected' : '' }}>🇶🇦 Qatar</option>
                                    <option value="KW" {{ old('country') == 'KW' ? 'selected' : '' }}>🇰🇼 Kuwait</option>
                                    <option value="BH" {{ old('country') == 'BH' ? 'selected' : '' }}>🇧🇭 Bahrain</option>
                                    <option value="OM" {{ old('country') == 'OM' ? 'selected' : '' }}>🇴🇲 Oman</option>
                                    <option value="JO" {{ old('country') == 'JO' ? 'selected' : '' }}>🇯🇴 Jordan</option>
                                    <option value="EG" {{ old('country') == 'EG' ? 'selected' : '' }}>🇪🇬 Egypt</option>
                                    <option value="TR" {{ old('country') == 'TR' ? 'selected' : '' }}>🇹🇷 Turkey</option>
                                    <option value="IN" {{ old('country') == 'IN' ? 'selected' : '' }}>🇮🇳 India</option>
                                    <option value="BD" {{ old('country') == 'BD' ? 'selected' : '' }}>🇧🇩 Bangladesh</option>
                                    <option value="LK" {{ old('country') == 'LK' ? 'selected' : '' }}>🇱🇰 Sri Lanka</option>
                                    <option value="MY" {{ old('country') == 'MY' ? 'selected' : '' }}>🇲🇾 Malaysia</option>
                                    <option value="SG" {{ old('country') == 'SG' ? 'selected' : '' }}>🇸🇬 Singapore</option>
                                    <option value="ID" {{ old('country') == 'ID' ? 'selected' : '' }}>🇮🇩 Indonesia</option>
                                    <option value="PH" {{ old('country') == 'PH' ? 'selected' : '' }}>🇵🇭 Philippines</option>
                                    <option value="AF" {{ old('country') == 'AF' ? 'selected' : '' }}>🇦🇫 Afghanistan</option>
                                    <option value="IR" {{ old('country') == 'IR' ? 'selected' : '' }}>🇮🇷 Iran</option>
                                    <option value="IQ" {{ old('country') == 'IQ' ? 'selected' : '' }}>🇮🇶 Iraq</option>
                                    <option value="YE" {{ old('country') == 'YE' ? 'selected' : '' }}>🇾🇪 Yemen</option>
                                </optgroup>
                                <optgroup label="🌍 Africa">
                                    <option value="NG" {{ old('country') == 'NG' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                                    <option value="KE" {{ old('country') == 'KE' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                                    <option value="ZA" {{ old('country') == 'ZA' ? 'selected' : '' }}>🇿🇦 South Africa</option>
                                    <option value="GH" {{ old('country') == 'GH' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                                    <option value="TZ" {{ old('country') == 'TZ' ? 'selected' : '' }}>🇹🇿 Tanzania</option>
                                </optgroup>
                                <optgroup label="🌎 Americas & Oceania">
                                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>🇨🇦 Canada</option>
                                    <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>🇦🇺 Australia</option>
                                    <option value="NZ" {{ old('country') == 'NZ' ? 'selected' : '' }}>🇳🇿 New Zealand</option>
                                    <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>🇩🇪 Germany</option>
                                    <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>🇫🇷 France</option>
                                    <option value="NL" {{ old('country') == 'NL' ? 'selected' : '' }}>🇳🇱 Netherlands</option>
                                </optgroup>
                                <option value="OTHER" {{ old('country') == 'OTHER' ? 'selected' : '' }}>🌐 Other</option>
                            </select>
                        </div>
                    </div>

                    {{-- Timezone --}}
                    <div class="form-group">
                        <label class="field-label">Timezone <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-clock field-icon"></i>
                            <select id="timezone" name="timezone" required>
                                <option value="" disabled selected>Select country first</option>
                            </select>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="form-group full-width">
                        <label class="field-label">Phone Number <span class="req">*</span></label>
                        <div class="phone-wrap">
                            <div class="phone-prefix" id="phonePrefix"><i class="fas fa-phone mr-1 text-xs"></i> +92</div>
                            <input type="text" id="phone" name="phone"
                                   placeholder="e.g. 3001234567"
                                   value="{{ old('phone') }}"
                                   required>
                        </div>
                        <div class="phone-hint"><i class="fas fa-lock text-xs mr-1"></i> Your phone number will remain private. We use it only for account notifications.</div>
                    </div>

                    {{-- Gender --}}
                    <div class="form-group full-width">
                        <label class="field-label">Choose Gender <span class="req">*</span></label>
                        <div class="radio-grid">
                            <label class="radio-card">
                                <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                <div class="radio-body">
                                    <i class="fas fa-mars"></i>
                                    <span>Male</span>
                                </div>
                            </label>
                            <label class="radio-card">
                                <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <div class="radio-body">
                                    <i class="fas fa-venus"></i>
                                    <span>Female</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Tutoring Preference --}}
                    <div class="form-group full-width">
                        <label class="field-label">Tutoring Preference <span class="req">*</span></label>
                        <div class="radio-grid">
                            <label class="radio-card">
                                <input type="radio" name="tutoring_preference" value="online" {{ old('tutoring_preference') == 'online' ? 'checked' : '' }} required>
                                <div class="radio-body">
                                    <i class="fas fa-laptop"></i>
                                    <span>Online</span>
                                </div>
                            </label>
                            <label class="radio-card">
                                <input type="radio" name="tutoring_preference" value="home" {{ old('tutoring_preference') == 'home' ? 'checked' : '' }}>
                                <div class="radio-body">
                                    <i class="fas fa-house-user"></i>
                                    <span>Home</span>
                                </div>
                            </label>
                            <label class="radio-card">
                                <input type="radio" name="tutoring_preference" value="both" {{ old('tutoring_preference') == 'both' ? 'checked' : '' }}>
                                <div class="radio-body">
                                    <i class="fas fa-sync-alt"></i>
                                    <span>Both</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Hourly Rate --}}
                    <div class="form-group full-width">
                        <label class="field-label">Average Tutoring Rate per Hour <span class="req">*</span></label>
                        <div class="fee-wrap">
                            <input type="number" id="hourly_rate" name="hourly_rate"
                                   placeholder="e.g. 2000"
                                   value="{{ old('hourly_rate') }}"
                                   required min="0">
                            <div class="fee-suffix">PKR / hr</div>
                        </div>
                    </div>
                </div>

                <div class="step-actions">
                    <div></div>
                    <button type="button" class="btn-next" onclick="nextStep(1)">Continue <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- ============ STEP 2: CAREER ============ --}}
            <div class="form-step" id="step-2">
                <div class="step-heading">
                    <h2><span>📚</span> Career</h2>
                    <p>Tell us about your academic credentials and upload your resume.</p>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="field-label">Program / Degree <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-graduation-cap field-icon"></i>
                            <select id="program" name="program" required>
                                <option value="" disabled selected>Select Degree</option>
                                <option value="Bachelors" {{ old('program')=='Bachelors' ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="Masters" {{ old('program')=='Masters' ? 'selected' : '' }}>Master's Degree</option>
                                <option value="PhD" {{ old('program')=='PhD' ? 'selected' : '' }}>PhD / Doctorate</option>
                                <option value="Diploma" {{ old('program')=='Diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="Other" {{ old('program')=='Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="field-label">Major / Field <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-book-open field-icon"></i>
                            <input type="text" id="major" name="major"
                                   placeholder="e.g. Computer Science"
                                   value="{{ old('major') }}" required>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="field-label">University / Institution <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-university field-icon"></i>
                            <input type="text" id="university" name="university"
                                   placeholder="e.g. University of the Punjab, Lahore"
                                   value="{{ old('university') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="field-label">From Year <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-calendar-alt field-icon"></i>
                            <select id="study_year_from" name="study_year_from" required>
                                <option value="" disabled selected>Start Year</option>
                                @for($y = date('Y'); $y >= 1985; $y--)
                                    <option value="{{ $y }}" {{ old('study_year_from') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="field-label">To Year <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-calendar-check field-icon"></i>
                            <select id="study_year_to" name="study_year_to" required>
                                <option value="" disabled selected>End Year</option>
                                <option value="Present" {{ old('study_year_to')=='Present' ? 'selected' : '' }}>Present (Ongoing)</option>
                                @for($y = date('Y') + 5; $y >= 1985; $y--)
                                    <option value="{{ $y }}" {{ old('study_year_to') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="field-label">Upload Resume (PDF) <span class="req">*</span></label>
                        <div class="upload-area" id="resumeUploadArea" onclick="document.getElementById('resume').click()">
                            <input type="file" id="resume" name="resume" accept=".pdf" required class="file-input-hidden" style="display:none;">
                            <div id="resumeContent">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p><strong>Click to upload</strong> or drag & drop your CV</p>
                                <span>PDF only — Max 5MB</span>
                            </div>
                            <div class="upload-preview" id="resumePreview" style="display:none;">
                                <i class="fas fa-file-pdf"></i>
                                <span id="resumeFileName" style="font-size:0.9rem;font-weight:700;color:#374151;"></span>
                                <button type="button" class="file-remove" onclick="event.stopPropagation();removeFile('resume')">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step-actions">
                    <button type="button" class="btn-back" onclick="prevStep(2)"><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="button" class="btn-next" onclick="nextStep(2)">Continue <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- ============ STEP 3: ABOUT ME ============ --}}
            <div class="form-step" id="step-3">
                <div class="step-heading">
                    <h2><span>✨</span> About Me</h2>
                    <p>Help students understand who you are and what you bring to the table.</p>
                </div>

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="field-label">Profile Photo <span class="req">*</span></label>
                        <div class="photo-area">
                            <div class="photo-preview-circle" id="photoPreviewCircle">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div>
                                <input type="file" id="profile_image" name="profile_image" accept="image/*" required style="display:none;">
                                <button type="button" class="btn-photo" onclick="document.getElementById('profile_image').click()">
                                    <i class="fas fa-camera"></i> Choose Photo
                                </button>
                                <div style="font-size:0.75rem;color:#9ca3af;margin-top:0.6rem;font-style:italic;">
                                    Square photo recommended. JPG, PNG. Max 2MB.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="field-label">Personal Bio <span class="req">*</span></label>
                        <textarea id="bio" name="bio" class="form-textarea" rows="5"
                                  required minlength="50"
                                  placeholder="Share your academic background, teaching philosophy, and personality...">{{ old('bio') }}</textarea>
                        <div class="char-counter"><span id="bioCount">0</span> / 50 min characters</div>
                    </div>

                    <div class="form-group full-width">
                        <label class="field-label">Teaching Experience <span class="req">*</span></label>
                        <textarea id="teaching_experience" name="teaching_experience" class="form-textarea" rows="5"
                                  required minlength="30"
                                  placeholder="Describe where and how long you have been teaching (schools, academies, private tuition, etc.)...">{{ old('teaching_experience') }}</textarea>
                        <div class="char-counter"><span id="expCount">0</span> / 30 min characters</div>
                    </div>
                </div>

                <div class="step-actions">
                    <button type="button" class="btn-back" onclick="prevStep(3)"><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="button" class="btn-next" onclick="nextStep(3)">Continue <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- ============ STEP 4: SUBJECTS ============ --}}
            <div class="form-step" id="step-4">
                <div class="step-heading">
                    <h2><span>🎓</span> Academic Subjects</h2>
                    <p>Select all subjects you are qualified and experienced to teach.</p>
                </div>

                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($categories as $category)
                        <div class="subject-card" id="card-cat-{{ $category->id }}">
                            <button type="button"
                                    onclick="toggleSubjectPanel('panel-cat-{{ $category->id }}', 'chevron-cat-{{ $category->id }}')"
                                    class="subject-toggle">
                                <div class="subject-toggle-left">
                                    <div class="subject-icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div>
                                        <div class="subject-title">{{ $category->name }}</div>
                                        <div class="subject-count">
                                            <span id="count-cat-{{ $category->id }}">0</span> selected
                                        </div>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down subject-chevron" id="chevron-cat-{{ $category->id }}"></i>
                            </button>
                            <div class="subject-panel" id="panel-cat-{{ $category->id }}">
                                <div class="subjects-grid">
                                    @foreach($category->subjects as $subject)
                                        <label class="subject-check-item">
                                            <input type="checkbox"
                                                   name="subjects[]"
                                                   value="{{ $subject->id }}"
                                                   class="subject-input"
                                                   onchange="updateSubjectCount({{ $category->id }})">
                                            <div class="custom-check">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="subject-name">{{ $subject->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="step-actions">
                    <button type="button" class="btn-back" onclick="prevStep(4)"><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        Submit Application <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = 4;

/* ===== SHOW STEP ===== */
function showStep(step) {
    currentStep = step;

    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step-' + step).classList.add('active');

    document.querySelectorAll('.h-step').forEach(el => {
        const s = parseInt(el.dataset.step);
        el.classList.remove('active', 'completed');
        if (s === step) el.classList.add('active');
        else if (s < step) el.classList.add('completed');
        el.style.cursor = s <= step ? 'pointer' : 'default';
    });

    /* Update num icons for completed steps */
    document.querySelectorAll('.h-step').forEach(el => {
        const s = parseInt(el.dataset.step);
        const numEl = el.querySelector('.h-step-num');
        if (s < step) {
            numEl.innerHTML = '<i class="fas fa-check" style="font-size:0.65rem;"></i>';
        } else {
            numEl.textContent = s;
        }
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ===== GO TO STEP (click on header tab) ===== */
function goToStep(target) {
    if (target < currentStep) { showStep(target); return; }
    if (target > currentStep) {
        if (!validateStep(currentStep)) {
            shake('step-' + currentStep);
            return;
        }
        showStep(target);
    }
}

/* ===== VALIDATE ===== */
function validateStep(step) {
    const el = document.getElementById('step-' + step);
    let valid = true;

    el.querySelectorAll('[required]').forEach(input => {
        if (input.type === 'radio') {
            const radios = el.querySelectorAll(`input[name="${input.name}"]`);
            if (!Array.from(radios).some(r => r.checked)) valid = false;
        } else if (input.type === 'file') {
            // File inputs: check files array
            if (!input.files || input.files.length === 0) valid = false;
        } else if (input.tagName === 'TEXTAREA' || input.type === 'text' || input.type === 'number') {
            if (!input.value.trim()) valid = false;
            // Enforce minlength if set
            const minLen = parseInt(input.getAttribute('minlength') || '0');
            if (minLen > 0 && input.value.trim().length < minLen) valid = false;
        } else {
            if (!input.value.trim()) valid = false;
        }
    });

    // Also validate textareas (they may not always be caught by querySelectorAll('[required]') in some browsers)
    el.querySelectorAll('textarea[required]').forEach(ta => {
        if (!ta.value.trim()) valid = false;
        const minLen = parseInt(ta.getAttribute('minlength') || '0');
        if (minLen > 0 && ta.value.trim().length < minLen) valid = false;
    });

    if (step === 4) {
        if (!document.querySelectorAll('input[name="subjects[]"]:checked').length) valid = false;
    }
    return valid;
}

function nextStep(current) {
    if (!validateStep(current)) { shake('step-' + current); return; }
    if (current < totalSteps) showStep(current + 1);
}
function prevStep(current) { if (current > 1) showStep(current - 1); }

function shake(id) {
    const el = document.getElementById(id);
    el.classList.add('shake');
    setTimeout(() => el.classList.remove('shake'), 400);
}

/* ===== SUBJECT ACCORDION ===== */
function toggleSubjectPanel(panelId, chevronId) {
    const panel = document.getElementById(panelId);
    const chevron = document.getElementById(chevronId);
    const isOpen = panel.classList.contains('open');
    panel.classList.toggle('open', !isOpen);
    chevron.classList.toggle('open', !isOpen);
}

function updateSubjectCount(catId) {
    const card = document.getElementById('card-cat-' + catId);
    const panel = document.getElementById('panel-cat-' + catId);
    const count = panel.querySelectorAll('input:checked').length;
    document.getElementById('count-cat-' + catId).textContent = count;
    card.classList.toggle('has-selected', count > 0);
}

/* ===== COUNTRY → PREFIX & TIMEZONE ===== */
const countryData = {
    'PK': { prefix: '+92', tz: ['Asia/Karachi'] },
    'AE': { prefix: '+971', tz: ['Asia/Dubai'] },
    'SA': { prefix: '+966', tz: ['Asia/Riyadh'] },
    'QA': { prefix: '+974', tz: ['Asia/Qatar'] },
    'KW': { prefix: '+965', tz: ['Asia/Kuwait'] },
    'BH': { prefix: '+973', tz: ['Asia/Bahrain'] },
    'OM': { prefix: '+968', tz: ['Asia/Muscat'] },
    'JO': { prefix: '+962', tz: ['Asia/Amman'] },
    'EG': { prefix: '+20',  tz: ['Africa/Cairo'] },
    'TR': { prefix: '+90',  tz: ['Europe/Istanbul'] },
    'IR': { prefix: '+98',  tz: ['Asia/Tehran'] },
    'IQ': { prefix: '+964', tz: ['Asia/Baghdad'] },
    'YE': { prefix: '+967', tz: ['Asia/Aden'] },
    'AF': { prefix: '+93',  tz: ['Asia/Kabul'] },
    'IN': { prefix: '+91',  tz: ['Asia/Kolkata'] },
    'BD': { prefix: '+880', tz: ['Asia/Dhaka'] },
    'LK': { prefix: '+94',  tz: ['Asia/Colombo'] },
    'MY': { prefix: '+60',  tz: ['Asia/Kuala_Lumpur'] },
    'SG': { prefix: '+65',  tz: ['Asia/Singapore'] },
    'ID': { prefix: '+62',  tz: ['Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura'] },
    'PH': { prefix: '+63',  tz: ['Asia/Manila'] },
    'GB': { prefix: '+44',  tz: ['Europe/London'] },
    'US': { prefix: '+1',   tz: ['America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles'] },
    'CA': { prefix: '+1',   tz: ['America/Toronto', 'America/Vancouver', 'America/Winnipeg'] },
    'AU': { prefix: '+61',  tz: ['Australia/Sydney', 'Australia/Melbourne', 'Australia/Perth'] },
    'NZ': { prefix: '+64',  tz: ['Pacific/Auckland'] },
    'DE': { prefix: '+49',  tz: ['Europe/Berlin'] },
    'FR': { prefix: '+33',  tz: ['Europe/Paris'] },
    'NL': { prefix: '+31',  tz: ['Europe/Amsterdam'] },
    'NG': { prefix: '+234', tz: ['Africa/Lagos'] },
    'KE': { prefix: '+254', tz: ['Africa/Nairobi'] },
    'ZA': { prefix: '+27',  tz: ['Africa/Johannesburg'] },
    'GH': { prefix: '+233', tz: ['Africa/Accra'] },
    'TZ': { prefix: '+255', tz: ['Africa/Dar_es_Salaam'] },
    'OTHER': { prefix: '+', tz: ['UTC', 'Asia/Dubai', 'Asia/Karachi', 'Europe/London', 'America/New_York'] }
};

document.getElementById('country').addEventListener('change', function () {
    const data = countryData[this.value] || countryData['OTHER'];
    const tzSelect = document.getElementById('timezone');
    const prefixEl = document.getElementById('phonePrefix');

    // Update phone prefix
    prefixEl.innerHTML = `<i class="fas fa-phone mr-1 text-xs"></i> ${data.prefix}`;

    // Update timezone
    tzSelect.innerHTML = '<option value="" disabled selected>Select Timezone</option>';
    data.tz.forEach(z => {
        const opt = document.createElement('option');
        opt.value = opt.textContent = z;
        tzSelect.appendChild(opt);
    });
    if (data.tz.length === 1) tzSelect.value = data.tz[0];
});

/* ===== FILE PREVIEWS ===== */
document.getElementById('resume').addEventListener('change', function () {
    if (this.files.length) {
        document.getElementById('resumeFileName').textContent = this.files[0].name;
        document.getElementById('resumePreview').style.display = 'flex';
        document.getElementById('resumeContent').style.display = 'none';
    }
});

document.getElementById('profile_image').addEventListener('change', function () {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photoPreviewCircle').innerHTML =
                `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        };
        reader.readAsDataURL(this.files[0]);
    }
});

function removeFile(id) {
    document.getElementById(id).value = '';
    if (id === 'resume') {
        document.getElementById('resumePreview').style.display = 'none';
        document.getElementById('resumeContent').style.display = 'block';
    }
}

/* ===== CHAR COUNTERS ===== */
document.getElementById('bio').addEventListener('input', e => document.getElementById('bioCount').textContent = e.target.value.length);
document.getElementById('teaching_experience').addEventListener('input', e => document.getElementById('expCount').textContent = e.target.value.length);
</script>
@endpush
@endsection
