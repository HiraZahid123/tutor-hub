@extends('layouts.app')
@section('title', 'Our Best Tutors - TutorHub')

@section('content')
<style>
@keyframes activeTabPulse {
    0%   { transform: scale(1);     box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4); }
    25%  { transform: scale(1.03);  box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6); }
    50%  { transform: scale(1.015); box-shadow: 0 5px 16px rgba(37, 99, 235, 0.5); }
    75%  { transform: scale(1.03);  box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6); }
    100% { transform: scale(1);     box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4); }
}
.active-tab-pulse {
    animation: activeTabPulse 1.8s ease-in-out infinite !important;
}
.active-tab-pulse:hover {
    animation: none !important;
    transform: scale(1.05) !important;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.5) !important;
}

@keyframes blink-glow {
    0%, 100% { box-shadow: 0 0 0 0 rgba(234,88,12,0.55); opacity: 1; }
    50%       { box-shadow: 0 0 0 8px rgba(234,88,12,0); opacity: 0.75; }
}
.view-more-btn { animation: blink-glow 1.8s ease-in-out infinite; }
.view-more-btn:hover { animation: none; opacity: 1; }

#tutor-modal { transition: opacity 0.2s ease; }
#tutor-modal.flex { display: flex !important; }

@keyframes directoryFadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}
.directory-panel:not(.hidden) {
    animation: directoryFadeIn 0.35s ease-out forwards;
}
@keyframes tabPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4); }
    50% { box-shadow: 0 0 0 8px rgba(37, 99, 235, 0); }
}
.city-filter-btn {
    transition: all 0.25s ease-in-out !important;
    animation: tabPulse 2s infinite ease-in-out;
}
.city-filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(37, 99, 235, 0.12) !important;
}
.directory-panel a i {
    transition: transform 0.2s ease-in-out !important;
}
.directory-panel a:hover i {
    transform: translateX(4px);
}

/* Card lift + image zoom on hover — same as Leadership Team */
.tutor-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.tutor-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 24px 44px rgba(0,0,0,0.14);
}
.tutor-photo-wrap { overflow: hidden; }
.tutor-photo-wrap img {
    transition: transform 0.5s ease;
}
.tutor-card:hover .tutor-photo-wrap img {
    transform: scale(1.08);
}

/* CSS sharpening for soft-focus photos */
.img-sharpen {
    filter: contrast(1.13) saturate(1.07);
}

/* City filter buttons */
@keyframes city-btn-enter {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes city-active-pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(251,191,36,0.7); }
    50%       { box-shadow: 0 0 0 10px rgba(251,191,36,0); }
}
.city-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 800;
    color: #fff;
    border: 2px solid rgba(255,255,255,0.28);
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(6px);
    cursor: pointer;
    letter-spacing: 0.02em;
    opacity: 0;
    animation: city-btn-enter 0.5s ease forwards;
    transition: background 0.22s, border-color 0.22s, transform 0.22s, box-shadow 0.22s;
}
.city-filter-btn:hover {
    background: rgba(255,255,255,0.26);
    border-color: rgba(255,255,255,0.65);
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.22);
}
.city-filter-btn:active { transform: translateY(0); }
.city-filter-btn.active {
    background: #fbbf24 !important;
    border-color: #fbbf24 !important;
    color: #1e3a8a !important;
    animation: city-btn-enter 0.5s ease forwards, city-active-pulse 1.6s ease-in-out 0.5s infinite !important;
}
</style>
@php
// Tutors are now loaded from the database via PageController::forStudents()
// $tutors is passed from the controller (approved tutors only)
@endphp

{{-- ==================== HERO ==================== --}}
<section style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);" class="py-16 text-white overflow-hidden relative">
    <div class="absolute inset-0 opacity-10" style="background-image:url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="container relative text-center" data-aos="fade-up">
        <span class="inline-block bg-white/15 backdrop-blur-sm text-white text-xs font-black uppercase tracking-[0.25em] px-5 py-2 rounded-full mb-5">
            TutorHub Certified
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">
            Our <span class="text-yellow-300">Best Tutors</span>
        </h1>
        {{-- City Quick-Filter Buttons --}}
        <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-4">Find tutors near you</p>
        <div class="flex flex-wrap items-center justify-center gap-3">
            <button onclick="filterByCity('Pakistan', '')"
                    class="city-filter-btn active" data-city=""
                    style="animation-delay:0.1s;">
                <i class="fas fa-globe-asia text-yellow-300"></i> All Pakistan
            </button>
            <button onclick="filterByCity('Pakistan', 'Lahore')"
                    class="city-filter-btn" data-city="Lahore"
                    style="animation-delay:0.22s;">
                <i class="fas fa-map-marker-alt text-yellow-300"></i> Tutors in Lahore
            </button>
            <button onclick="filterByCity('Pakistan', 'Karachi')"
                    class="city-filter-btn" data-city="Karachi"
                    style="animation-delay:0.34s;">
                <i class="fas fa-map-marker-alt text-yellow-300"></i> Tutors in Karachi
            </button>
            <button onclick="filterByCity('Pakistan', 'Islamabad')"
                    class="city-filter-btn" data-city="Islamabad"
                    style="animation-delay:0.46s;">
                <i class="fas fa-map-marker-alt text-yellow-300"></i> Tutors in Islamabad
            </button>
        </div>
    </div>
</section>

{{-- ==================== STICKY FILTER BAR ==================== --}}
<div class="sticky top-0 z-40 bg-white shadow-md border-b border-gray-100">
    <div class="container py-4">
        <div class="flex flex-wrap gap-3 items-end">

            {{-- Subject --}}
            <div style="flex:1;min-width:160px;">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Subject</label>
                <select id="filter-subject" onchange="filterTutors()"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                    <option value="">All Subjects</option>
                    <option value="Primary and Middle Grades">Primary and Middle Grades</option>
                    <option value="Cambridge O Level / IGCSE / ICE">Cambridge O Level / IGCSE / ICE</option>
                    <option value="Cambridge A Level / Pre-U / AICE">Cambridge A Level / Pre-U / AICE</option>
                    <option value="AP (Advanced Placement®)">AP (Advanced Placement®)</option>
                    <option value="Standard Tests">Standard Tests</option>
                    <option value="IB Diploma Programme">IB Diploma Programme</option>
                    <option value="Matriculation">Matriculation</option>
                    <option value="F.Sc / I.Com / ICS">F.Sc / I.Com / ICS</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Business and Social Sciences">Business and Social Sciences</option>
                    <option value="Languages and Literature">Languages and Literature</option>
                    <option value="Computer Languages">Computer Languages</option>
                    <option value="Quran">Quran</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            {{-- Country --}}
            <div style="flex:1;min-width:140px;">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Country</label>
                <select id="filter-country" onchange="onCountryChange()"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                    <option value="">All Countries</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="UAE">UAE</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Oman">Oman</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Egypt">Egypt</option>
                    <option value="Turkey">Turkey</option>
                    <option value="India">India</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Kenya">Kenya</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Canada">Canada</option>
                    <option value="Australia">Australia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Germany">Germany</option>
                    <option value="France">France</option>
                    <option value="Netherlands">Netherlands</option>
                </select>
            </div>

            {{-- City --}}
            <div style="flex:1;min-width:140px;">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">City</label>
                <select id="filter-city" onchange="onCityChange()" disabled
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                    <option value="">All Cities</option>
                </select>
            </div>

            {{-- Area --}}
            <div style="flex:1;min-width:140px;">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Area</label>
                <select id="filter-area" onchange="filterTutors()" disabled
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                    <option value="">All Areas</option>
                </select>
            </div>

            {{-- Reset --}}
            <div class="flex-shrink-0">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 invisible">x</label>
                <button onclick="resetFilters()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-xl text-sm font-black transition-all active:scale-95">
                    <i class="fas fa-undo mr-1 text-xs"></i> Reset
                </button>
            </div>
        </div>

        {{-- Result Count --}}
        <div class="mt-3 flex items-center gap-2" style="display: none;">
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Showing</span>
            <span id="tutor-count" class="text-sm font-black text-blue-600">15</span>
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">tutors</span>
            <span id="filter-badge" class="hidden ml-2 bg-orange-100 text-orange-600 text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider">
                Filtered
            </span>
        </div>
    </div>
</div>

{{-- ==================== TUTOR GRID ==================== --}}
<section class="py-12 bg-gray-50">
    <div class="container">
        <div id="tutors-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tutors as $tutor)
            <div class="tutor-card group bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 hover:scale-[1.01] transition-all duration-300 overflow-hidden flex flex-col"
                 data-country="{{ $tutor['country'] }}"
                 data-city="{{ $tutor['city'] }}"
                 data-area="{{ $tutor['area'] }}"
                 data-subjects="{{ $tutor['subjects'] }}"
                 data-aos="fade-up"
                 data-aos-delay="{{ (($loop->index % 3) + 1) * 100 }}">

                {{-- Card Header --}}
                <div class="p-7 pb-4">
                    <div class="flex items-start gap-5">
                        {{-- Avatar / Photo --}}
                        <div class="flex-shrink-0">
                            @if(!empty($tutor['photo']))
                                <div class="tutor-photo-wrap rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden"
                                     style="width:118px;height:118px;flex-shrink:0;background:#ffffff;">
                                    <img src="{{ asset($tutor['photo']) }}"
                                         alt="{{ $tutor['name'] }}"
                                         class="{{ !empty($tutor['sharpen']) ? 'img-sharpen' : '' }} transition-transform duration-500 group-hover:scale-110"
                                         style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block;">
                                </div>
                            @else
                                <div class="rounded-2xl flex items-center justify-center text-white font-black shadow-lg"
                                     style="width:118px;height:118px;font-size:2rem;background-color:{{ $tutor['bg'] }};">
                                    {{ $tutor['initials'] }}
                                </div>
                            @endif
                        </div>
                        {{-- Name & Qualification --}}
                        <div class="flex-1 min-w-0 pt-1">
                            <h3 class="text-[20px] font-black text-gray-900 leading-tight mb-1.5">{{ $tutor['name'] }}</h3>
                            <p class="text-[11px] text-blue-600 font-bold leading-snug mb-3">{{ $tutor['qualification'] }}</p>
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full"
                                  style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;">
                                <i class="fas fa-star text-[9px]"></i> {{ $tutor['experience'] }}+ Yrs Exp
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Subject Tags --}}
                <div class="px-7 pb-4 flex flex-wrap gap-2">
                    @foreach($tutor['subject_tags'] as $tag)
                    <span class="text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider"
                          style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>

                {{-- Spacer: pushes bottom section to a consistent position --}}
                <div class="flex-1"></div>

                {{-- Divider --}}
                <div class="mx-7 border-t border-gray-100"></div>

                {{-- Reviews & Stars --}}
                <div class="px-7 py-3.5">
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400 gap-0.5">
                            @php
                                $rVal = $tutor['rating'] ?? 4.7;
                                $fullStars = floor($rVal);
                                $hasHalf = ($rVal - $fullStars) >= 0.3;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fas fa-star text-[11px]"></i>
                                @elseif($i == $fullStars + 1 && $hasHalf)
                                    <i class="fas fa-star-half-alt text-[11px]"></i>
                                @else
                                    <i class="far fa-star text-[11px] text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm font-black text-gray-900 ml-1">{{ $tutor['rating'] ?? 4.7 }}</span>
                        <span class="text-xs text-gray-400 font-semibold">({{ isset($tutor['review_count']) && $tutor['review_count'] > 0 ? $tutor['review_count'] : ((($tutor['id'] * 7 + 13) % 20) + 15) }} reviews)</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-7 pb-6 pt-1 flex gap-3">
                    <a href="https://wa.me/923414133395?text=Hi%2C%20I%20am%20interested%20in%20{{ urlencode($tutor['name']) }}"
                       target="_blank"
                       class="flex-1 text-center text-[10px] font-black uppercase tracking-widest py-3.5 rounded-xl transition-all active:scale-95 hover:bg-blue-700 hover:shadow-lg duration-300"
                       style="background:#2563EB;color:#fff;">
                        Book Session
                    </a>
                    <button onclick="openTutorModal({{ $tutor['id'] }})"
                            class="view-more-btn px-4 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5 cursor-pointer hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all duration-300"
                            style="background:#fff7ed;color:#ea580c;border:2px solid #ea580c;">
                        <i class="fas fa-eye text-[9px]"></i> View More
                    </button>
                </div>
            </div>
            @empty
                <!-- No dynamic or static tutors found -->
            @endforelse
        </div>

        {{-- No Results Message --}}
        <div id="no-results" class="hidden text-center py-24">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-search text-gray-300 text-3xl"></i>
            </div>
            <p class="text-base font-black text-gray-400 uppercase tracking-widest">No tutors found</p>
            <p class="text-sm text-gray-400 mt-1 mb-5">Try adjusting your filters or reset to see all tutors.</p>
            <button onclick="resetFilters()"
                    class="text-xs font-black uppercase tracking-widest px-6 py-3 rounded-xl transition-all"
                    style="background:#eff6ff;color:#2563EB;border:1px solid #bfdbfe;">
                <i class="fas fa-undo mr-1"></i> Reset All Filters
            </button>
        </div>
    </div>
</section>

{{-- ==================== TUTOR DETAIL MODAL ==================== --}}
<div id="tutor-modal"
     class="hidden fixed inset-0 z-50 items-center justify-center p-4"
     style="background:rgba(0,0,0,0.72);backdrop-filter:blur(5px);"
     onclick="if(event.target===this)closeTutorModal()">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg relative overflow-hidden"
         style="max-height:90vh;overflow-y:auto;">

        {{-- Close --}}
        <button onclick="closeTutorModal()"
                class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-all"
                style="flex-shrink:0;">
            <i class="fas fa-times text-gray-500 text-sm"></i>
        </button>

        {{-- Header --}}
        <div class="p-7 pb-5 flex items-start gap-5">
            <div id="modal-avatar" class="flex-shrink-0"></div>
            <div class="flex-1 min-w-0 pt-1">
                <h2 id="modal-name" class="text-2xl font-black text-gray-900 leading-tight mb-1.5"></h2>
                <p id="modal-qual" class="text-xs text-blue-600 font-bold leading-snug mb-3"></p>
                <span id="modal-exp"
                      class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full"
                      style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;"></span>
            </div>
        </div>

        <div class="mx-7 border-t border-gray-100"></div>

        {{-- Body --}}
        <div class="px-7 py-5 space-y-5">

            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Subjects</p>
                <div id="modal-tags" class="flex flex-wrap gap-2"></div>
            </div>

            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">About</p>
                <p id="modal-bio" class="text-sm text-gray-600 leading-relaxed"></p>
            </div>

            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Schools & Institutions</p>
                <p id="modal-affiliation" class="text-sm text-gray-600 font-semibold leading-relaxed"></p>
            </div>

        </div>

        <div class="mx-7 border-t border-gray-100"></div>

        {{-- Footer Buttons --}}
        <div class="px-7 py-6 flex gap-3">
            <a id="modal-book" href="#" target="_blank"
               class="flex-1 text-center text-[11px] font-black uppercase tracking-widest py-4 rounded-xl transition-all active:scale-95 flex items-center justify-center gap-2"
               style="background:#2563EB;color:#fff;">
                <i class="fas fa-calendar-check"></i> Book Session
            </a>
            <a href="https://wa.me/923414133395" target="_blank"
               class="flex items-center justify-center px-5 rounded-xl transition-all hover:bg-green-100"
               style="background:#f0fdf4;border:2px solid #bbf7d0;color:#16a34a;">
                <i class="fab fa-whatsapp text-xl"></i>
            </a>
        </div>
    </div>
</div>

{{-- ==================== QUICK SEARCH DIRECTORY ==================== --}}
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="container">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.25em] mb-3 block">Browse Directory</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-3">Quick Search Directory</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-[15px] leading-relaxed">Select a city and category below to quickly find certified subject specialists in your area.</p>
        </div>

        {{-- Directory Tabs --}}
        <div class="flex justify-center gap-3 mb-10" data-aos="fade-up">
            <button onclick="switchDirectoryTab('Lahore')" id="tab-btn-lahore"
                    class="directory-tab-btn px-7 py-3.5 rounded-xl text-sm font-bold uppercase tracking-wider transition-all bg-blue-600 text-white shadow-md active-tab-pulse">
                <i class="fas fa-map-marker-alt mr-2 text-yellow-300"></i> Tutors in Lahore
            </button>
            <button onclick="switchDirectoryTab('Karachi')" id="tab-btn-karachi"
                    class="directory-tab-btn px-7 py-3.5 rounded-xl text-sm font-bold uppercase tracking-wider transition-all bg-white text-gray-600 hover:bg-gray-100 border border-gray-200">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Tutors in Karachi
            </button>
            <button onclick="switchDirectoryTab('Islamabad')" id="tab-btn-islamabad"
                    class="directory-tab-btn px-7 py-3.5 rounded-xl text-sm font-bold uppercase tracking-wider transition-all bg-white text-gray-600 hover:bg-gray-100 border border-gray-200">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Tutors in Islamabad
            </button>
        </div>

        {{-- Lahore Panel --}}
        <div id="directory-lahore" class="directory-panel grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up">
            {{-- O-Level Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">O Level Home Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Chemistry Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Math Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Physics Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Accounting Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Business Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Economics Home Tutor in Lahore</span></a></li>
                </ul>
            </div>

            {{-- A-Level Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">A Level Home Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Chemistry Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Math Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Physics Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Accounting Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Business Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Economics Home Tutor in Lahore</span></a></li>
                </ul>
            </div>

            {{-- IB Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">IB Home Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Chemistry Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Math Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Physics Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Business Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Economics Home Tutor in Lahore</span></a></li>
                </ul>
            </div>

            {{-- Grade 1-8 Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">Grade 1-8 Home Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade I Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade II Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade III Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade IV Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade V Home Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Lahore')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade VI Home Tutor in Lahore</span></a></li>
                </ul>
            </div>

            {{-- Online Tutors Divider --}}
            <div class="col-span-full mt-6 mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-laptop text-xs"></i>
                    </div>
                    <span class="text-[13px] font-bold text-gray-900 uppercase tracking-widest">Online Tutors in Lahore</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>
            </div>

            {{-- O Level Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">O Level Online Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Chemistry Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Math Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Physics Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Accounting Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Business Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Economics Online Tutor in Lahore</span></a></li>
                </ul>
            </div>

            {{-- A Level Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">A Level Online Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Chemistry Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Math Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Physics Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Accounting Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Business Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Economics Online Tutor in Lahore</span></a></li>
                </ul>
            </div>

            {{-- IB Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">IB Online Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Chemistry Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Math Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Physics Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Business Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Economics Online Tutor in Lahore</span></a></li>
                </ul>
            </div>

            {{-- Grade 1-8 Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">Grade 1-8 Online Tutors in Lahore</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Montessori Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('child', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Primary Grade Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('english', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 5 Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 8 Online Tutor in Lahore</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('quran', 'Lahore')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Quran Online Tutor in Lahore</span></a></li>
                </ul>
            </div>
        </div>

        {{-- Karachi Panel --}}
        <div id="directory-karachi" class="directory-panel hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- O-Level Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">O Level Home Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Chemistry Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Math Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Physics Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Accounting Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Business Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Economics Home Tutor in Karachi</span></a></li>
                </ul>
            </div>

            {{-- A-Level Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">A Level Home Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Chemistry Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Math Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Physics Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Accounting Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Business Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Economics Home Tutor in Karachi</span></a></li>
                </ul>
            </div>

            {{-- IB Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">IB Home Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Chemistry Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Math Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Physics Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Business Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Economics Home Tutor in Karachi</span></a></li>
                </ul>
            </div>

            {{-- Grade 1-8 Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">Grade 1-8 Home Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade I Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade II Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade III Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade IV Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade V Home Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Karachi')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade VI Home Tutor in Karachi</span></a></li>
                </ul>
            </div>

            {{-- Online Tutors Divider --}}
            <div class="col-span-full mt-6 mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-laptop text-xs"></i>
                    </div>
                    <span class="text-[13px] font-bold text-gray-900 uppercase tracking-widest">Online Tutors in Karachi</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>
            </div>

            {{-- O Level Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">O Level Online Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Chemistry Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Math Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Physics Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Accounting Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Business Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Economics Online Tutor in Karachi</span></a></li>
                </ul>
            </div>

            {{-- A Level Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">A Level Online Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Chemistry Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Math Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Physics Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Accounting Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Business Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Economics Online Tutor in Karachi</span></a></li>
                </ul>
            </div>

            {{-- IB Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">IB Online Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Chemistry Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Math Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Physics Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Business Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Economics Online Tutor in Karachi</span></a></li>
                </ul>
            </div>

            {{-- Grade 1-8 Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">Grade 1-8 Online Tutors in Karachi</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Montessori Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('child', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Primary Grade Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('english', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 5 Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 8 Online Tutor in Karachi</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('quran', 'Karachi')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Quran Online Tutor in Karachi</span></a></li>
                </ul>
            </div>
        </div>

        {{-- Islamabad Panel --}}
        <div id="directory-islamabad" class="directory-panel hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- O-Level Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">O Level Home Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Chemistry Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Math Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Physics Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Accounting Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Business Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">O Level Economics Home Tutor in Islamabad</span></a></li>
                </ul>
            </div>

            {{-- A-Level Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">A Level Home Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Chemistry Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Math Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Physics Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Accounting Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Business Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">A Level Economics Home Tutor in Islamabad</span></a></li>
                </ul>
            </div>

            {{-- IB Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">IB Home Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Chemistry Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Math Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Physics Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Business Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">IB Economics Home Tutor in Islamabad</span></a></li>
                </ul>
            </div>

            {{-- Grade 1-8 Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">Grade 1-8 Home Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade I Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade II Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade III Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade IV Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade V Home Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Islamabad')" class="hover:text-blue-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-gray-300 mt-1.5"></i><span class="leading-normal">Grade VI Home Tutor in Islamabad</span></a></li>
                </ul>
            </div>

            {{-- Online Tutors Divider --}}
            <div class="col-span-full mt-6 mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-laptop text-xs"></i>
                    </div>
                    <span class="text-[13px] font-bold text-gray-900 uppercase tracking-widest">Online Tutors in Islamabad</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>
            </div>

            {{-- O Level Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">O Level Online Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Chemistry Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Math Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Physics Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Accounting Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Business Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">O Level Economics Online Tutor in Islamabad</span></a></li>
                </ul>
            </div>

            {{-- A Level Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">A Level Online Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Chemistry Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Math Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Physics Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('accounting', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Accounting Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Business Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">A Level Economics Online Tutor in Islamabad</span></a></li>
                </ul>
            </div>

            {{-- IB Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">IB Online Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('chemistry', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Chemistry Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Math Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('physics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Physics Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('business', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Business Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('economics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">IB Economics Online Tutor in Islamabad</span></a></li>
                </ul>
            </div>

            {{-- Grade 1-8 Online Column --}}
            <div>
                <h3 class="text-[13.5px] font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2.5">Grade 1-8 Online Tutors in Islamabad</h3>
                <ul class="space-y-2.5 text-[13px] text-gray-600">
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('montessori', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Montessori Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('child', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Primary Grade Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('english', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 5 Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('mathematics', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Grade 8 Online Tutor in Islamabad</span></a></li>
                    <li><a href="javascript:void(0)" onclick="applyQuickFilter('quran', 'Islamabad')" class="hover:text-green-600 hover:underline flex items-start gap-2.5"><i class="fas fa-chevron-right text-[9px] text-green-300 mt-1.5 flex-shrink-0"></i><span class="leading-normal">Quran Online Tutor in Islamabad</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ==================== CTA BANNER ==================== --}}
<section class="py-14 bg-white">
    <div class="container">
        <div class="rounded-3xl overflow-hidden text-white text-center py-14 px-6 relative"
             style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
            <h2 class="text-3xl md:text-4xl font-black mb-4">Can't Find Your Subject?</h2>
            <p class="text-blue-100 mb-8 max-w-lg mx-auto font-medium">
                We have many more qualified tutors available. Tell us what you need and we'll find the perfect match within 24 hours.
            </p>
            <style>
                @keyframes ctaOrangePulse {
                    0%, 100% {
                        transform: scale(1);
                        box-shadow: 0 4px 15px rgba(255, 103, 0, 0.4);
                    }
                    50% {
                        transform: scale(1.03);
                        box-shadow: 0 8px 25px rgba(255, 103, 0, 0.6);
                    }
                }
                @keyframes ctaGreenPulse {
                    0%, 100% {
                        transform: scale(1);
                        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
                    }
                    50% {
                        transform: scale(1.03);
                        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.6);
                    }
                }
                .animate-cta-orange {
                    animation: ctaOrangePulse 2s infinite ease-in-out;
                    transition: all 0.3s ease !important;
                }
                .animate-cta-green {
                    animation: ctaGreenPulse 2s infinite ease-in-out;
                    animation-delay: 0.5s;
                    transition: all 0.3s ease !important;
                }
                .animate-cta-orange:hover {
                    animation: none !important;
                    transform: scale(1.06) !important;
                    box-shadow: 0 10px 25px rgba(255, 103, 0, 0.7) !important;
                }
                .animate-cta-green:hover {
                    animation: none !important;
                    transform: scale(1.06) !important;
                    box-shadow: 0 10px 25px rgba(37, 211, 102, 0.7) !important;
                }
            </style>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('find-a-tutor') }}"
                   class="animate-cta-orange inline-flex items-center justify-center gap-2 font-black text-sm uppercase tracking-widest px-4 py-4 rounded-xl transition-all active:scale-95 w-[250px] h-[54px]"
                   style="background:#ff6700;color:#fff;">
                    <i class="fas fa-search"></i> Submit a Request
                </a>
                <a href="https://wa.me/923414133395" target="_blank"
                   class="animate-cta-green inline-flex items-center justify-center gap-2 font-black text-sm uppercase tracking-widest px-4 py-4 rounded-xl transition-all active:scale-95 w-[250px] h-[54px]"
                   style="background:#25D366;color:#fff;border:none;">
                    <i class="fab fa-whatsapp text-lg"></i> WhatsApp Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Tutor data for modal
const tutorsData = @json($tutors);
const assetBase  = "{{ rtrim(asset(''), '/') }}";

function openTutorModal(id) {
    const tutor = tutorsData.find(t => t.id === id);
    if (!tutor) return;

    // Avatar
    const avatarHtml = tutor.photo
        ? `<div style="width:110px;height:110px;border-radius:1rem;overflow:hidden;border:2px solid #f1f5f9;background:#ffffff;">
               <img src="${assetBase}/${tutor.photo}" alt="${tutor.name}" style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block;">
           </div>`
        : `<div style="width:110px;height:110px;border-radius:1rem;display:flex;align-items:center;justify-content:center;color:#fff;font-size:2rem;font-weight:900;background:${tutor.bg};">
               ${tutor.initials}
           </div>`;
    document.getElementById('modal-avatar').innerHTML = avatarHtml;

    document.getElementById('modal-name').textContent = tutor.name;
    document.getElementById('modal-qual').textContent  = tutor.qualification;
    document.getElementById('modal-exp').innerHTML     = `<i class="fas fa-star" style="font-size:9px;"></i> ${tutor.experience}+ Years Experience`;
    document.getElementById('modal-bio').textContent         = tutor.bio;
    document.getElementById('modal-affiliation').textContent = tutor.affiliation;

    const tagsHtml = tutor.subject_tags.map(tag =>
        `<span style="font-size:10px;font-weight:900;padding:4px 12px;border-radius:9999px;text-transform:uppercase;letter-spacing:0.05em;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">${tag}</span>`
    ).join('');
    document.getElementById('modal-tags').innerHTML = tagsHtml;

    document.getElementById('modal-book').href =
        `https://wa.me/923414133395?text=Hi%2C%20I%20am%20interested%20in%20${encodeURIComponent(tutor.name)}`;

    const modal = document.getElementById('tutor-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeTutorModal() {
    const modal = document.getElementById('tutor-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeTutorModal(); });

let activeSearchQuery = '';

// ── Auto-filter from homepage search (?q=, ?city=) ───────────────────────
(function() {
    const params = new URLSearchParams(window.location.search);
    const q      = (params.get('q') || '').trim().toLowerCase();
    activeSearchQuery = q;
    const cityParam = (params.get('city') || '').trim();

    if (cityParam) {
        filterByCity('Pakistan', cityParam);
    }

    if (q) {
        const select = document.getElementById('filter-subject');
        
        // 1. Try exact match first (case-insensitive)
        let matched = '';
        for (const opt of select.options) {
            if (!opt.value) continue;
            if (opt.value.toLowerCase() === q) { matched = opt.value; break; }
        }
        
        // 2. If no exact match, try matching via keywords map
        if (!matched) {
            const subjectMap = {
                'Primary and Middle Grades': ['montessori', 'early childhood', 'nursery', 'kindergarten', 'phonics', 'child'],
                'Cambridge O Level / IGCSE / ICE': ['o level', 'igcse', 'ice', 'chemistry', 'physics', 'math', 'biology', 'accounting', 'business', 'economics', 'english'],
                'Cambridge A Level / Pre-U / AICE': ['a level', 'pre-u', 'aice'],
                'AP (Advanced Placement®)': ['ap', 'advanced placement'],
                'Standard Tests': ['sat', 'gre', 'gat', 'ielts', 'toefl', 'prep'],
                'IB Diploma Programme': ['ib', 'ibdp', 'myp'],
                'Matriculation': ['matric', 'matriculation'],
                'F.Sc / I.Com / ICS': ['f.sc', 'i.com', 'ics'],
                'Mathematics': ['mathematics', 'math'],
                'Business and Social Sciences': ['business', 'accounting', 'economics', 'marketing', 'history', 'geography', 'pakistan studies'],
                'Languages and Literature': ['english', 'german', 'french', 'language'],
                'Computer Languages': ['computer', 'python', 'programming', 'oop', 'data structures', 'algorithms', 'web development', 'artificial intelligence', 'machine learning', 'deep learning', 'robotics', 'computer vision'],
                'Quran': ['quran', 'islamic', 'tajweed', 'hifz', 'tafseer', 'nazra'],
                'Others': ['others', 'other', 'general', 'misc', 'miscellaneous']
            };
            for (const [cat, kws] of Object.entries(subjectMap)) {
                if (kws.some(kw => q.includes(kw) || kw.includes(q))) {
                    matched = cat;
                    break;
                }
            }
        }
        
        // 3. Fallback to basic options check
        if (!matched) {
            for (const opt of select.options) {
                if (!opt.value) continue;
                if (q.startsWith(opt.value.toLowerCase()) || opt.value.toLowerCase().startsWith(q)) { matched = opt.value; break; }
            }
        }
        if (!matched) {
            for (const opt of select.options) {
                if (!opt.value) continue;
                if (q.includes(opt.value.toLowerCase()) || opt.value.toLowerCase().includes(q)) { matched = opt.value; break; }
            }
        }
        
        if (matched) select.value = matched;
    }

    if (q || cityParam) {
        filterTutors();
        setTimeout(function() {
            const grid = document.getElementById('tutors-grid');
            if (grid) grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 350);
    }
})();

// Clear search query filter when the user manually changes the subject dropdown
document.getElementById('filter-subject').addEventListener('change', function() {
    activeSearchQuery = '';
    const url = new URL(window.location);
    url.searchParams.delete('q');
    window.history.pushState({}, '', url);
});

function filterByCity(country, city) {
    const countryEl = document.getElementById('filter-country');
    const cityEl    = document.getElementById('filter-city');
    const areaEl    = document.getElementById('filter-area');

    // Update country dropdown
    countryEl.value = country;

    // Populate & set city dropdown
    cityEl.innerHTML = '<option value="">All Cities</option>';
    if (country && locationData[country]) {
        Object.keys(locationData[country]).forEach(c => cityEl.add(new Option(c, c)));
        cityEl.disabled = false;
    } else {
        cityEl.disabled = true;
    }
    cityEl.value = city;

    // Reset area
    areaEl.innerHTML = '<option value="">All Areas</option>';
    areaEl.disabled  = true;

    // Filter the grid
    filterTutors();

    // Highlight active city button
    document.querySelectorAll('.city-filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.getAttribute('data-city') === city);
    });

    // Smooth scroll to grid
    document.getElementById('tutors-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

const locationData = {
    'Pakistan': {
        'Lahore':     [
            'Askari',
            'Allama Iqbal Town',
            'Al-Rehman Gardens',
            'Architect Society',
            'Audits and Accounts Society',
            'Abdalian Society',
            'Bahria Town',
            'Bahria Town Phase 1',
            'Bahria Town Phase 2',
            'Bahria Town Phase 3',
            'Bahria Town Phase 4',
            'Bahria Town Phase 5',
            'Bahria Town Phase 6',
            'Bahria Town Phase 7',
            'Bahria Town Phase 8',
            'Bahria Town Phase 9',
            'Bahria Town Phase 10',
            'Bahria Orchard',
            'Cantt',
            'Cavalry Ground',
            'DHA Phase 1,2,3,4',
            'DHA Phase 5,6',
            'DHA Phase 7,8,9',
            'DHA Rahbar',
            'Divine Gardens',
            'Eden Society',
            'EME Society',
            'Ferozpur Road',
            'Faisal Town',
            'Fazaia Housing Scheme',
            'Formanites Housing Scheme',
            'Gulberg 1',
            'Gulberg 2',
            'Gulberg 3',
            'Garden Town',
            'Gulshan Ravi',
            'Green Town',
            'GOR',
            'Harbanspura',
            'Izmir Town',
            'Ichra',
            'IEP Engineers Town',
            'Johar Town',
            'Jubilee Town',
            'Kot Lakhpat',
            'Lake City',
            'Model Town',
            'Mughalpura',
            'Muslim Town',
            'Mustafa Town',
            'New Garden Town',
            'Peco Road',
            'Raiwind Road',
            'Revenue Society',
            'State Life Housing Society',
            'Samanabad',
            'Sabzazar',
            'Sui Gas Society',
            'Shadab Gardens',
            'Tajpura',
            'Thokar Niaz Baig',
            'Town Ship',
            'UET Housing Society',
            'Valencia Housing Society',
            'Vital Homes Housing Society',
            'Walton Cantt',
            'Wahdat Road',
            'Wapda Town',
            'Zaman Park',
            'Other Area'
        ],
        'Islamabad':  ['F-6', 'F-7', 'F-8', 'G-9', 'G-11', 'E-7', 'DHA Islamabad', 'Bahria Town Islamabad'],
        'Karachi':    ['DHA Karachi', 'Clifton', 'Gulshan-e-Iqbal', 'PECHS', 'North Nazimabad', 'Korangi'],
        'Faisalabad': ['Madina Town', 'Canal Road', 'Peoples Colony', 'Gulberg Faisalabad', 'Batala Colony'],
        'Rawalpindi': ['Satellite Town', 'Bahria Town Rawalpindi', 'Chaklala', 'PWD Colony'],
        'Multan':     ['Cantt', 'Qasimpur', 'Shah Rukn-e-Alam', 'Gulgasht'],
        'Peshawar':   ['Hayatabad', 'University Town', 'Cantt', 'Phase 5'],
        'Others':     []
    },
    'UAE': {
        'Dubai': ['Downtown', 'Dubai Marina', 'Jumeirah', 'Palm Jumeirah', 'Al Barsha', 'Business Bay', 'Deira', 'Bur Dubai', 'Silicon Oasis', 'Other Area'],
        'Abu Dhabi': ['Yas Island', 'Al Reem Island', 'Khalifa City', 'Corniche', 'Al Khalidiyah', 'Other Area'],
        'Sharjah': ['Al Majaz', 'Al Nahda', 'Muwaileh', 'Other Area'],
        'Ajman': ['Al Nuaimia', 'Al Rashidiya', 'Other Area'],
        'Ras Al Khaimah': ['Al Hamra', 'Al Marjan Island', 'Other Area'],
        'Fujairah': ['Fujairah City', 'Dibba', 'Other Area'],
        'Umm Al Quwain': ['Umm Al Quwain City', 'Other Area']
    },
    'Saudi Arabia': {
        'Riyadh': ['Olaya', 'Al Malaz', 'Al Yasmin', 'Al Sahafa', 'Al Muhammadiyah', 'Other Area'],
        'Jeddah': ['Al Hamra', 'Al Naeem', 'Al Safa', 'Obhur', 'Other Area'],
        'Mecca': ['Al Haram', 'Aziziyah', 'Other Area'],
        'Medina': ['Al Haram', 'Al Aqeeq', 'Other Area'],
        'Dammam': ['Al Shatea', 'Al Faisaliyah', 'Other Area'],
        'Khobar': ['Al Hizam', 'Al Thuqbah', 'Other Area']
    },
    'United Kingdom': {
        'London': ['Westminster', 'Kensington & Chelsea', 'Camden', 'Greenwich', 'Croydon', 'Ealing', 'Other Area'],
        'Birmingham': ['City Centre', 'Edgbaston', 'Selly Oak', 'Solihull', 'Other Area'],
        'Manchester': ['City Centre', 'Didsbury', 'Salford', 'Fallowfield', 'Other Area'],
        'Glasgow': ['West End', 'City Centre', 'Southside', 'Other Area'],
        'Edinburgh': ['Old Town', 'New Town', 'Leith', 'Other Area'],
        'Liverpool': ['City Centre', 'Anfield', 'Allerton', 'Other Area'],
        'Leeds': ['City Centre', 'Headingley', 'Chapel Allerton', 'Other Area']
    },
    'United States': {
        'New York': ['Manhattan', 'Brooklyn', 'Queens', 'Bronx', 'Staten Island', 'Other Area'],
        'Los Angeles': ['Hollywood', 'Downtown LA', 'Santa Monica', 'Pasadena', 'Other Area'],
        'Chicago': ['Loop', 'Lincoln Park', 'Hyde Park', 'Other Area'],
        'Houston': ['Downtown', 'Galleria', 'The Woodlands', 'Other Area'],
        'Phoenix': ['Downtown', 'Scottsdale', 'Tempe', 'Other Area'],
        'Philadelphia': ['Center City', 'University City', 'Other Area'],
        'San Antonio': ['Downtown', 'Alamo Heights', 'Other Area'],
        'San Diego': ['Downtown', 'La Jolla', 'Gaslamp Quarter', 'Other Area'],
        'Dallas': ['Downtown', 'Uptown', 'Plano', 'Other Area'],
        'San Jose': ['Downtown', 'Silicon Valley', 'Other Area']
    },
    'Qatar': {
        'Doha': ['West Bay', 'The Pearl', 'Al Sadd', 'Madinat Khalifa', 'Other Area'],
        'Al Wakrah': ['Al Wakrah City', 'Other Area'],
        'Al Rayyan': ['Al Rayyan City', 'Other Area'],
        'Al Khor': ['Al Khor City', 'Other Area']
    },
    'Kuwait': {
        'Kuwait City': ['Sharq', 'Mirgab', 'Qibla', 'Other Area'],
        'Salmiya': ['Salmiya City', 'Other Area'],
        'Hawally': ['Hawally City', 'Other Area'],
        'Farwaniya': ['Farwaniya City', 'Other Area']
    },
    'Bahrain': {
        'Manama': ['Juffair', 'Seef', 'Adliya', 'Other Area'],
        'Riffa': ['East Riffa', 'West Riffa', 'Other Area'],
        'Muharraq': ['Amwaj Islands', 'Other Area']
    },
    'Oman': {
        'Muscat': ['Ruwi', 'Al Khuwair', 'Muttrah', 'Other Area'],
        'Salalah': ['Salalah City', 'Other Area'],
        'Sohar': ['Sohar City', 'Other Area']
    },
    'Jordan': {
        'Amman': ['Jabal Amman', 'Abdoun', 'Sweifieh', 'Other Area'],
        'Zarqa': ['Zarqa City', 'Other Area'],
        'Irbid': ['Irbid City', 'Other Area']
    },
    'Egypt': {
        'Cairo': ['Maadi', 'Zamalek', 'Nasr City', 'Heliopolis', 'Other Area'],
        'Alexandria': ['Sidi Gaber', 'Smouha', 'Stanley', 'Other Area'],
        'Giza': ['Dokki', 'Mohandessin', '6th of October', 'Other Area']
    },
    'Turkey': {
        'Istanbul': ['Fatih', 'Beyoglu', 'Kadikoy', 'Besiktas', 'Other Area'],
        'Ankara': ['Cankaya', 'Kizilay', 'Other Area'],
        'Izmir': ['Alsancak', 'Karsiyaka', 'Other Area']
    },
    'India': {
        'Mumbai': ['Colaba', 'Bandra', 'Andheri', 'Worli', 'Other Area'],
        'Delhi': ['Connaught Place', 'South Delhi', 'Dwarka', 'Other Area'],
        'Bangalore': ['Indiranagar', 'Koramangala', 'Whitefield', 'Other Area'],
        'Hyderabad': ['Gachibowli', 'Banjara Hills', 'Jubilee Hills', 'Other Area'],
        'Chennai': ['Adyar', 'T. Nagar', 'Velachery', 'Other Area']
    },
    'Bangladesh': {
        'Dhaka': ['Gulshan', 'Banani', 'Dhanmondi', 'Uttara', 'Other Area'],
        'Chittagong': ['Panchlaish', 'Halishahar', 'Other Area']
    },
    'Sri Lanka': {
        'Colombo': ['Colombo 03 (Colpetty)', 'Colombo 07 (Cinnamon Gardens)', 'Colombo 04 (Bambalapitiya)', 'Other Area'],
        'Kandy': ['Kandy City', 'Other Area']
    },
    'Malaysia': {
        'Kuala Lumpur': ['KLCC', 'Bukit Bintang', 'Mont Kiara', 'Bangsar', 'Other Area'],
        'Penang': ['George Town', 'Bayan Lepas', 'Other Area'],
        'Johor Bahru': ['Tebrau', 'Bukit Indah', 'Other Area']
    },
    'Singapore': {
        'Singapore': ['Orchard Road', 'Marina Bay', 'Sentosa', 'Jurong', 'Tampines', 'Other Area']
    },
    'Indonesia': {
        'Jakarta': ['Menteng', 'Sudirman', 'Kemang', 'Other Area'],
        'Surabaya': ['Dharmahusada', 'Gubeng', 'Other Area'],
        'Bali': ['Seminyak', 'Kuta', 'Ubud', 'Other Area']
    },
    'Philippines': {
        'Manila': ['Makati', 'Taguig (BGC)', 'Quezon City', 'Other Area'],
        'Cebu': ['Cebu IT Park', 'Lahug', 'Other Area']
    },
    'Afghanistan': {
        'Kabul': ['Karta Parwan', 'Wazir Akbar Khan', 'Other Area'],
        'Herat': ['Herat City', 'Other Area']
    },
    'Iran': {
        'Tehran': ['Tajrish', 'Valiasr', 'Other Area'],
        'Isfahan': ['Isfahan City', 'Other Area']
    },
    'Iraq': {
        'Baghdad': ['Karrada', 'Mansour', 'Other Area'],
        'Erbil': ['Ainkawa', 'Other Area']
    },
    'Yemen': {
        'Sanaa': ['Sanaa City', 'Other Area'],
        'Aden': ['Aden City', 'Other Area']
    },
    'Nigeria': {
        'Lagos': ['Ikeja', 'Victoria Island', 'Lekki', 'Other Area'],
        'Abuja': ['Garki', 'Wuse', 'Other Area']
    },
    'Kenya': {
        'Nairobi': ['Westlands', 'Kilimani', 'Karen', 'Other Area'],
        'Mombasa': ['Nyali', 'Other Area']
    },
    'South Africa': {
        'Johannesburg': ['Sandton', 'Rosebank', 'Soweto', 'Other Area'],
        'Cape Town': ['Green Point', 'Sea Point', 'Camps Bay', 'Other Area'],
        'Durban': ['Umhlanga', 'Other Area']
    },
    'Ghana': {
        'Accra': ['East Legon', 'Cantonments', 'Other Area'],
        'Kumasi': ['Kumasi City', 'Other Area']
    },
    'Tanzania': {
        'Dar es Salaam': ['Masaki', 'Mikocheni', 'Other Area'],
        'Arusha': ['Arusha City', 'Other Area']
    },
    'Canada': {
        'Toronto': ['Downtown Toronto', 'North York', 'Scarborough', 'Mississauga', 'Other Area'],
        'Vancouver': ['Downtown Vancouver', 'Kitsilano', 'Richmond', 'Other Area'],
        'Montreal': ['Downtown Montreal', 'Plateau Mont-Royal', 'Other Area'],
        'Calgary': ['Downtown Calgary', 'Beltline', 'Other Area']
    },
    'Australia': {
        'Sydney': ['Sydney CBD', 'Surry Hills', 'Parramatta', 'Other Area'],
        'Melbourne': ['Melbourne CBD', 'Fitzroy', 'St Kilda', 'Other Area'],
        'Brisbane': ['Brisbane CBD', 'Fortitude Valley', 'Other Area']
    },
    'New Zealand': {
        'Auckland': ['Auckland CBD', 'Ponsonby', 'Newmarket', 'Other Area'],
        'Wellington': ['Wellington CBD', 'Te Aro', 'Other Area']
    },
    'Germany': {
        'Berlin': ['Mitte', 'Kreuzberg', 'Prenzlauer Berg', 'Other Area'],
        'Munich': ['Altstadt-Lehel', 'Schwabing', 'Other Area'],
        'Frankfurt': ['Innenstadt', 'Sachsenhausen', 'Other Area']
    },
    'France': {
        'Paris': ['1st Arrondissement', 'Marais', 'Montmartre', 'Latin Quarter', 'Other Area'],
        'Lyon': ['Presqu\'ile', 'Vieux Lyon', 'Other Area']
    },
    'Netherlands': {
        'Amsterdam': ['Centrum', 'Jordaan', 'De Pijp', 'Other Area'],
        'Rotterdam': ['Centrum', 'Kop van Zuid', 'Other Area'],
        'The Hague': ['Centrum', 'Scheveningen', 'Other Area']
    }
};

// Function to dynamically merge tutor data locations into locationData
function mergeTutorsIntoLocationData() {
    if (typeof tutorsData !== 'undefined' && Array.isArray(tutorsData)) {
        tutorsData.forEach(tutor => {
            const country = tutor.country;
            const city = tutor.city;
            const area = tutor.area;

            if (country) {
                if (!locationData[country]) {
                    locationData[country] = {};
                }
                if (city) {
                    if (!locationData[country][city]) {
                        locationData[country][city] = [];
                    }
                    if (area && !locationData[country][city].includes(area)) {
                        locationData[country][city].push(area);
                    }
                }
            }
        });
    }
}

// Merge tutor locations at script load time
mergeTutorsIntoLocationData();

function onCountryChange() {
    const country = document.getElementById('filter-country').value;
    const cityEl  = document.getElementById('filter-city');
    const areaEl  = document.getElementById('filter-area');

    cityEl.innerHTML = '<option value="">All Cities</option>';
    areaEl.innerHTML = '<option value="">All Areas</option>';
    areaEl.disabled  = true;

    if (country && locationData[country]) {
        Object.keys(locationData[country]).forEach(c => {
            cityEl.add(new Option(c, c));
        });
        cityEl.disabled = false;
    } else {
        cityEl.disabled = true;
    }
    filterTutors();
}

function onCityChange() {
    const country = document.getElementById('filter-country').value;
    const city    = document.getElementById('filter-city').value;
    const areaEl  = document.getElementById('filter-area');

    areaEl.innerHTML = '<option value="">All Areas</option>';

    if (country && city && locationData[country] && locationData[country][city]) {
        locationData[country][city].forEach(a => areaEl.add(new Option(a, a)));
        areaEl.disabled = false;
    } else {
        areaEl.disabled = true;
    }
    filterTutors();
}

function filterTutors() {
    const subjectVal = document.getElementById('filter-subject').value;
    const country = document.getElementById('filter-country').value;
    const city    = document.getElementById('filter-city').value;
    const area    = document.getElementById('filter-area').value;

    const subjectMap = {
        'Primary and Middle Grades': ['montessori', 'early childhood', 'nursery', 'kindergarten', 'phonics', 'child'],
        'Cambridge O Level / IGCSE / ICE': ['o level', 'igcse', 'ice'],
        'Cambridge A Level / Pre-U / AICE': ['a level', 'pre-u', 'aice'],
        'AP (Advanced Placement®)': ['ap', 'advanced placement'],
        'Standard Tests': ['sat', 'gre', 'gat', 'ielts', 'toefl', 'prep'],
        'IB Diploma Programme': ['ib', 'ibdp', 'myp'],
        'Matriculation': ['matric', 'matriculation'],
        'F.Sc / I.Com / ICS': ['f.sc', 'i.com', 'ics'],
        'Mathematics': ['mathematics', 'math'],
        'Business and Social Sciences': ['business', 'accounting', 'economics', 'marketing', 'history', 'geography', 'pakistan studies'],
        'Languages and Literature': ['english', 'german', 'french', 'language'],
        'Computer Languages': ['computer', 'python', 'programming', 'oop', 'data structures', 'algorithms', 'web development', 'artificial intelligence', 'machine learning', 'deep learning', 'robotics', 'computer vision'],
        'Quran': ['quran', 'islamic', 'tajweed', 'hifz', 'tafseer', 'nazra']
    };

    const cards = document.querySelectorAll('.tutor-card');
    let visible  = 0;

    cards.forEach(card => {
        const subs = (card.dataset.subjects || '').toLowerCase();
        
        let subjectMatches = true;
        if (subjectVal) {
            if (subjectVal === 'Others') {
                let matchesStandardCategory = false;
                for (const [cat, keywords] of Object.entries(subjectMap)) {
                    if (keywords.some(kw => subs.includes(kw))) {
                        matchesStandardCategory = true;
                        break;
                    }
                }
                subjectMatches = !matchesStandardCategory;
            } else {
                const keywords = subjectMap[subjectVal];
                if (keywords) {
                    subjectMatches = keywords.some(kw => subs.includes(kw));
                } else {
                    subjectMatches = subs.includes(subjectVal.toLowerCase());
                }
            }
        }

        // Apply dynamic sub-subject keyword filter (e.g. chemistry, physics, etc.) from link query
        if (activeSearchQuery && !subs.includes(activeSearchQuery)) {
            subjectMatches = false;
        }

        const ok   =
            subjectMatches &&
            (!country || card.dataset.country === country) &&
            (!city    || card.dataset.city    === city) &&
            (!area    || card.dataset.area    === area);

        card.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });

    document.getElementById('tutor-count').textContent = visible;
    document.getElementById('no-results').classList.toggle('hidden', visible > 0);

    const isFiltered = subjectVal || country || city || area;
    document.getElementById('filter-badge').classList.toggle('hidden', !isFiltered);
}

function resetFilters() {
    activeSearchQuery = '';
    const url = new URL(window.location);
    url.searchParams.delete('q');
    url.searchParams.delete('city');
    window.history.pushState({}, '', url);

    document.getElementById('filter-subject').value  = '';
    document.getElementById('filter-country').value  = '';
    const cityEl = document.getElementById('filter-city');
    const areaEl = document.getElementById('filter-area');
    cityEl.innerHTML = '<option value="">All Cities</option>';
    cityEl.disabled  = true;
    areaEl.innerHTML = '<option value="">All Areas</option>';
    areaEl.disabled  = true;
    filterTutors();
    // Re-activate "All Pakistan" city button
    document.querySelectorAll('.city-filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.getAttribute('data-city') === '');
    });
}

function applyQuickFilter(subject, city) {
    const countryEl = document.getElementById('filter-country');
    if (countryEl) countryEl.value = 'Pakistan';

    const cityEl = document.getElementById('filter-city');
    if (cityEl) {
        if (cityEl.options.length <= 1 && locationData['Pakistan']) {
            Object.keys(locationData['Pakistan']).forEach(c => {
                cityEl.add(new Option(c, c));
            });
            cityEl.disabled = false;
        }
        cityEl.value = city;
    }

    const areaEl = document.getElementById('filter-area');
    if (areaEl) {
        areaEl.innerHTML = '<option value="">All Areas</option>';
        areaEl.disabled = true;
        if (city && locationData['Pakistan'] && locationData['Pakistan'][city]) {
            locationData['Pakistan'][city].forEach(a => areaEl.add(new Option(a, a)));
            areaEl.disabled = false;
        }
    }

    const subjectEl = document.getElementById('filter-subject');
    if (subjectEl) {
        let matched = '';
        const subjectMap = {
            'Primary and Middle Grades': ['montessori', 'early childhood', 'nursery', 'kindergarten', 'phonics', 'child'],
            'Cambridge O Level / IGCSE / ICE': ['o level', 'igcse', 'ice', 'chemistry', 'physics', 'math', 'biology', 'accounting', 'business', 'economics', 'english'],
            'Cambridge A Level / Pre-U / AICE': ['a level', 'pre-u', 'aice'],
            'AP (Advanced Placement®)': ['ap', 'advanced placement'],
            'Standard Tests': ['sat', 'gre', 'gat', 'ielts', 'toefl', 'prep'],
            'IB Diploma Programme': ['ib', 'ibdp', 'myp'],
            'Matriculation': ['matric', 'matriculation'],
            'F.Sc / I.Com / ICS': ['f.sc', 'i.com', 'ics'],
            'Mathematics': ['mathematics', 'math'],
            'Business and Social Sciences': ['business', 'accounting', 'economics', 'marketing', 'history', 'geography', 'pakistan studies'],
            'Languages and Literature': ['english', 'german', 'french', 'language'],
            'Computer Languages': ['computer', 'python', 'programming', 'oop', 'data structures', 'algorithms', 'web development', 'artificial intelligence', 'machine learning', 'deep learning', 'robotics', 'computer vision'],
            'Quran': ['quran', 'islamic', 'tajweed', 'hifz', 'tafseer', 'nazra'],
            'Others': ['others', 'other', 'general', 'misc', 'miscellaneous']
        };
        for (const [cat, kws] of Object.entries(subjectMap)) {
            if (kws.some(kw => subject.toLowerCase().includes(kw) || kw.includes(subject.toLowerCase()))) {
                matched = cat;
                break;
            }
        }
        subjectEl.value = matched;
        activeSearchQuery = subject.toLowerCase();
    }

    document.querySelectorAll('.city-filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.getAttribute('data-city') === city);
    });

    filterTutors();

    const grid = document.getElementById('tutors-grid');
    if (grid) {
        grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function switchDirectoryTab(city) {
    document.querySelectorAll('.directory-panel').forEach(p => p.classList.add('hidden'));
    const panel = document.getElementById(`directory-${city.toLowerCase()}`);
    if (panel) panel.classList.remove('hidden');

    document.querySelectorAll('.directory-tab-btn').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md', 'active-tab-pulse');
        btn.classList.add('bg-white', 'text-gray-600', 'hover:bg-gray-100', 'border', 'border-gray-200');
    });

    const activeBtn = document.getElementById(`tab-btn-${city.toLowerCase()}`);
    if (activeBtn) {
        activeBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md', 'active-tab-pulse');
        activeBtn.classList.remove('bg-white', 'text-gray-600', 'hover:bg-gray-100', 'border', 'border-gray-200');
    }
}
</script>
@endpush
