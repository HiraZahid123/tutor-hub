@extends('layouts.app')
@section('title', 'Our Best Tutors - TutorHub')

@section('content')
<style>
@keyframes blink-glow {
    0%, 100% { box-shadow: 0 0 0 0 rgba(234,88,12,0.55); opacity: 1; }
    50%       { box-shadow: 0 0 0 8px rgba(234,88,12,0); opacity: 0.75; }
}
.view-more-btn { animation: blink-glow 1.8s ease-in-out infinite; }
.view-more-btn:hover { animation: none; opacity: 1; }

#tutor-modal { transition: opacity 0.2s ease; }
#tutor-modal.flex { display: flex !important; }

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
$featuredTutors = [
    [
        'id'            => 1,
        'name'          => 'Murtaza Ali',
        'qualification' => 'M.Sc. Applied Mathematics, University of the Punjab',
        'bio'           => 'Expert in O/A Level and IGCSE Mathematics with 25+ years of experience. Specialist in SAT, GRE, GAT and entry test preparation for NUST, UET, FAST, LUMS, and IIU.',
        'subjects'      => 'mathematics|o level mathematics|a level mathematics|igcse mathematics|additional mathematics|sat|gre|gat|f.sc|b.sc|entry test',
        'subject_tags'  => ['Mathematics', 'O/A Level', 'SAT · GRE · GAT'],
        'experience'    => 25,
        'affiliation'   => 'Beaconhouse, LGS, Roots International, HITEC Cambridge, Zawiya Academy',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'DHA',
        'initials'      => 'MA',
        'bg'            => '#2563EB',
        'photo'         => 'images/Murtaza ali.png',
        'sharpen'       => true,
    ],
    [
        'id'            => 2,
        'name'          => 'Shamoil',
        'qualification' => 'MPhil Physics, UET Lahore',
        'bio'           => 'Specialized in CAIE O/A Level and IGCSE Physics with 19+ years at top international schools. Deep expertise in IBDP and MYP Physics.',
        'subjects'      => 'physics|o level physics|a level physics|igcse physics|ibdp physics|myp physics|caie',
        'subject_tags'  => ['Physics', 'O/A Level', 'IBDP · MYP'],
        'experience'    => 19,
        'affiliation'   => 'LGS, ISL, Oneiro School House, King\'s House School London, Army Public School',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Allama Iqbal Town',
        'initials'      => 'SM',
        'bg'            => '#7c3aed',
        'photo'         => 'images/Shamoil.png',
        'sharpen'       => true,
    ],
    [
        'id'            => 3,
        'name'          => 'Faiza Javaid',
        'qualification' => 'M.A., M.Ed., B.S. Zoology/Botany/Chemistry, B.Ed.',
        'bio'           => 'Versatile science educator with 15 years of experience in Cambridge Sciences, AP Chemistry, and IB Chemistry at top international schools.',
        'subjects'      => 'chemistry|biology|zoology|botany|physics|o level chemistry|a level chemistry|ap chemistry|ib chemistry|cambridge science',
        'subject_tags'  => ['Chemistry', 'Biology · Zoology', 'O/A Level · AP · IB'],
        'experience'    => 15,
        'affiliation'   => 'Beaconhouse, The City School, Bloomfield Hall, Froebels International',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Johar Town',
        'initials'      => 'FJ',
        'bg'            => '#16a34a',
        'photo'         => 'images/faiza javad.png',
    ],
    [
        'id'            => 4,
        'name'          => 'Iqra',
        'qualification' => 'MPhil Microbiology, University of Agriculture, Faisalabad',
        'bio'           => 'Chemistry expert with 28 years of teaching and pharmaceutical industry experience, bridging academic chemistry with real-world applications.',
        'subjects'      => 'chemistry|o level chemistry|a level chemistry|ap chemistry|ib chemistry|microbiology|pharmaceutical',
        'subject_tags'  => ['Chemistry', 'O/A Level · AP', 'IB Chemistry'],
        'experience'    => 28,
        'affiliation'   => 'Roots International, Bloomfield Hall, The City School',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Gulberg',
        'initials'      => 'IQ',
        'bg'            => '#0d9488',
        'photo'         => 'images/Iqra.png',
        'sharpen'       => true,
    ],
    [
        'id'            => 5,
        'name'          => 'Areej',
        'qualification' => 'Diploma in Montessori Education (AMI Certified)',
        'bio'           => 'Specialist in Montessori early childhood education with 15 years of experience. AMI-trained with expertise in child development and activity-based learning.',
        'subjects'      => 'montessori|early childhood|nursery|kindergarten|phonics|child development|activity based learning|creative arts',
        'subject_tags'  => ['Montessori', 'Early Childhood', 'Phonics · Nursery'],
        'experience'    => 15,
        'affiliation'   => 'Beaconhouse (Montessori), LGS, Cornerstone School',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Model Town',
        'initials'      => 'AR',
        'bg'            => '#ec4899',
        'photo'         => 'images/Areej.png',
    ],
    [
        'id'            => 6,
        'name'          => 'Samiya',
        'qualification' => 'Chartered Accountant (CA) — ICAP',
        'bio'           => 'CA-qualified educator with 19 years of experience in CAIE O/A Level Accounting, Business, and Economics. Expert in IGCSE and Edexcel curricula.',
        'subjects'      => 'accounting|business|economics|financial management|cost accounting|auditing|igcse|edexcel|caie|entry test',
        'subject_tags'  => ['Accounting', 'Business · Economics', 'O/A Level · IGCSE'],
        'experience'    => 19,
        'affiliation'   => 'American International School (AIS), International School of Lahore (ISL)',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Gulberg',
        'initials'      => 'SA',
        'bg'            => '#ea580c',
        'photo'         => 'images/Samiya.png',
    ],
    [
        'id'            => 7,
        'name'          => 'Rotua',
        'qualification' => 'Master\'s in German Language & Literature, NUML Islamabad',
        'bio'           => 'German language specialist (A1–C1) with 16 years of experience in Goethe Certification preparation, O/A Level German, and multilingual education.',
        'subjects'      => 'german|german language|goethe|o level german|a level german|language|grammar|translation',
        'subject_tags'  => ['German A1–C1', 'Goethe Certification', 'O/A Level German'],
        'experience'    => 16,
        'affiliation'   => 'Roots International, Roots Millennium, Aitchison College, C.A.S. School Karachi',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Garden Town',
        'initials'      => 'RO',
        'bg'            => '#dc2626',
        'photo'         => 'images/Rotua.png',
    ],
    [
        'id'            => 8,
        'name'          => 'Nicolas',
        'qualification' => 'Master\'s in French Language & Linguistics, Sorbonne Nouvelle, Paris',
        'bio'           => 'Native-level French educator (A1–C2) with 30 years of international experience. Expert in DELF/DALF preparation, O/A Level French, and immersive language teaching.',
        'subjects'      => 'french|french language|delf|dalf|o level french|a level french|grammar|translation|essay writing|oral expression',
        'subject_tags'  => ['French A1–C2', 'DELF/DALF', 'O/A Level French'],
        'experience'    => 30,
        'affiliation'   => 'TNS Beaconhouse, Lahore American School, ISIL Islamabad, Lycée Louis-le-Grand (France)',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Gulberg',
        'initials'      => 'NC',
        'bg'            => '#4f46e5',
        'photo'         => 'images/Nicolas.png',
        'sharpen'       => true,
    ],
    [
        'id'            => 9,
        'name'          => 'Ali',
        'qualification' => 'MCS (Master\'s in Computer Science), UET Lahore',
        'bio'           => 'Computer Science expert with 16 years of experience in Python, OOP, Data Structures, Web Development, IGCSE/A Level CS, and university-level programming.',
        'subjects'      => 'computer science|python|programming|oop|data structures|algorithms|web development|flask|django|igcse computer science|a level computer science|entry test',
        'subject_tags'  => ['Computer Science', 'Python · Programming', 'IGCSE · A Level CS'],
        'experience'    => 16,
        'affiliation'   => 'Roots International School; FAST/NUST/GIK/UET entry test specialist',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Garden Town',
        'initials'      => 'AL',
        'bg'            => '#0891b2',
        'photo'         => 'images/Ali.png',
    ],
    [
        'id'            => 10,
        'name'          => 'Sean',
        'qualification' => 'PhD in Artificial Intelligence & Robotics, UET Lahore',
        'bio'           => 'PhD-level AI and Robotics specialist with 16 years of experience in Machine Learning, Deep Learning, Computer Vision, and research supervision.',
        'subjects'      => 'artificial intelligence|machine learning|deep learning|robotics|python|computer vision|reinforcement learning|ros|ai|research|university',
        'subject_tags'  => ['Artificial Intelligence', 'Machine Learning', 'Robotics · Deep Learning'],
        'experience'    => 16,
        'affiliation'   => 'UET Lahore, UMT Lahore, Beaconhouse International College',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Johar Town',
        'initials'      => 'SN',
        'bg'            => '#475569',
        'photo'         => 'images/Sean.png',
    ],
    [
        'id'            => 11,
        'name'          => 'Ali Murtaza',
        'qualification' => 'Master\'s in History & Geography, University of the Punjab',
        'bio'           => 'Humanities expert with 20 years of experience in O/A Level History, Pakistan Studies, Geography, and Cambridge exam techniques.',
        'subjects'      => 'history|world history|pakistan studies|geography|o level history|a level history|igcse global perspectives|essay writing|source analysis|map work',
        'subject_tags'  => ['History & Geography', 'Pakistan Studies', 'O/A Level · IGCSE'],
        'experience'    => 20,
        'affiliation'   => 'LGS, Beaconhouse, The City School, Roots International',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'DHA',
        'initials'      => 'AM',
        'bg'            => '#d97706',
        'photo'         => null,
    ],
    [
        'id'            => 12,
        'name'          => 'Qari Jawad',
        'qualification' => 'Dars-e-Nizami, Jamia Ashrafia, Lahore',
        'bio'           => 'Experienced Quran educator with 25 years of teaching Nazra, Tajweed, Hifz, Tafseer and Islamic Studies online and through home tuition.',
        'subjects'      => 'quran|tajweed|hifz|tafseer|islamic studies|seerah|fiqh|aqeedah|duas|namaz|islmic rulings|nazra',
        'subject_tags'  => ['Quran (Tajweed · Hifz)', 'Islamic Studies', 'Online & Home'],
        'experience'    => 25,
        'affiliation'   => 'Serving as Imam Masjid; online Quran teaching platform',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Raiwind',
        'initials'      => 'QJ',
        'bg'            => '#059669',
        'photo'         => 'images/Qari javad.png',
    ],
    [
        'id'            => 13,
        'name'          => 'Jessica',
        'qualification' => 'Doctor of Musical Arts (DMA), University of London',
        'bio'           => 'DMA-qualified music educator with 15 years of experience in O/A Level Music, ABRSM (Grades 1–8), Piano, Guitar, Violin, and Vocal Training.',
        'subjects'      => 'music|o level music|a level music|abrsm|piano|guitar|violin|vocal|music theory|western classical|music composition|harmony',
        'subject_tags'  => ['Music (O/A Level)', 'ABRSM Grades 1–8', 'Piano · Guitar · Violin'],
        'experience'    => 15,
        'affiliation'   => 'LGS Music Department',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'DHA',
        'initials'      => 'JS',
        'bg'            => '#e11d48',
        'photo'         => 'images/Jessica.png',
        'sharpen'       => true,
    ],
    [
        'id'            => 14,
        'name'          => 'Shoaib',
        'qualification' => 'MPhil Educational Leadership, Beaconhouse National University (BNU)',
        'bio'           => 'Business and Economics specialist with 21 years of experience in Marketing Management, Business Studies, Microeconomics, and corporate training.',
        'subjects'      => 'marketing|business studies|economics|microeconomics|management|academic coordination|curriculum',
        'subject_tags'  => ['Business Studies', 'Economics · Marketing', 'Management'],
        'experience'    => 21,
        'affiliation'   => 'FAST National University (Visiting), Educational Services Pvt. Ltd.',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Johar Town',
        'initials'      => 'SB',
        'bg'            => '#7c3aed',
        'photo'         => 'images/Shoib.png',
    ],
    [
        'id'            => 15,
        'name'          => 'Mohsin',
        'qualification' => 'M.A. English, University of the Punjab, Lahore',
        'bio'           => 'English Language and Literature specialist with 15 years of experience in CAIE O/A Levels, IGCSE, Edexcel, IELTS/TOEFL, and academic writing.',
        'subjects'      => 'english|english language|english literature|igcse english|a level english|ielts|toefl|academic writing|essay writing|creative writing|grammar|communication',
        'subject_tags'  => ['English Language', 'English Literature', 'IELTS · TOEFL · IGCSE'],
        'experience'    => 15,
        'affiliation'   => 'Beaconhouse, LGS, Army Public School, KIPS, Bloomfield Hall',
        'country'       => 'Pakistan',
        'city'          => 'Lahore',
        'area'          => 'Model Town',
        'initials'      => 'MH',
        'bg'            => '#1d4ed8',
        'photo'         => 'images/Mohsin.png',
    ],
];
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
                    <optgroup label="Sciences">
                        <option value="mathematics">Mathematics</option>
                        <option value="physics">Physics</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="biology">Biology</option>
                        <option value="computer">Computer Science</option>
                        <option value="artificial intelligence">Artificial Intelligence</option>
                    </optgroup>
                    <optgroup label="Commerce & Humanities">
                        <option value="accounting">Accounting</option>
                        <option value="business">Business Studies</option>
                        <option value="economics">Economics</option>
                        <option value="marketing">Marketing</option>
                        <option value="history">History</option>
                        <option value="pakistan studies">Pakistan Studies</option>
                        <option value="geography">Geography</option>
                    </optgroup>
                    <optgroup label="Languages">
                        <option value="english">English</option>
                        <option value="german">German</option>
                        <option value="french">French</option>
                    </optgroup>
                    <optgroup label="Religious & Arts">
                        <option value="quran">Quran</option>
                        <option value="islamic">Islamic Studies</option>
                        <option value="music">Music</option>
                        <option value="montessori">Montessori</option>
                    </optgroup>
                </select>
            </div>

            {{-- Country --}}
            <div style="flex:1;min-width:140px;">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Country</label>
                <select id="filter-country" onchange="onCountryChange()"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                    <option value="">All Countries</option>
                    <option value="Pakistan">Pakistan</option>
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
            @foreach($featuredTutors as $tutor)
            <div class="tutor-card bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col"
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
                                <div class="tutor-photo-wrap rounded-2xl shadow-lg border-2 border-gray-100"
                                     style="width:118px;height:118px;flex-shrink:0;background:#ffffff;">
                                    <img src="{{ asset($tutor['photo']) }}"
                                         alt="{{ $tutor['name'] }}"
                                         class="{{ !empty($tutor['sharpen']) ? 'img-sharpen' : '' }}"
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

                {{-- Location --}}
                <div class="px-7 py-3.5">
                    <div class="flex items-center gap-2.5">
                        <i class="fas fa-map-marker-alt text-orange-500 text-xs w-4 text-center flex-shrink-0"></i>
                        <span class="text-sm font-bold text-gray-700">{{ $tutor['area'] }}, {{ $tutor['city'] }}, {{ $tutor['country'] }}</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-7 pb-6 pt-1 flex gap-3">
                    <a href="https://wa.me/923414133395?text=Hi%2C%20I%20am%20interested%20in%20{{ urlencode($tutor['name']) }}"
                       target="_blank"
                       class="flex-1 text-center text-[10px] font-black uppercase tracking-widest py-3.5 rounded-xl transition-all active:scale-95"
                       style="background:#2563EB;color:#fff;">
                        Book Session
                    </a>
                    <button onclick="openTutorModal({{ $tutor['id'] }})"
                            class="view-more-btn px-4 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5 cursor-pointer"
                            style="background:#fff7ed;color:#ea580c;border:2px solid #ea580c;">
                        <i class="fas fa-eye text-[9px]"></i> View More
                    </button>
                </div>
            </div>
            @endforeach
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

            <div class="flex items-center gap-2.5">
                <i class="fas fa-map-marker-alt text-orange-500 text-sm flex-shrink-0"></i>
                <span id="modal-location" class="text-sm font-bold text-gray-700"></span>
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

{{-- ==================== CTA BANNER ==================== --}}
<section class="py-14 bg-white">
    <div class="container">
        <div class="rounded-3xl overflow-hidden text-white text-center py-14 px-6 relative"
             style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
            <h2 class="text-3xl md:text-4xl font-black mb-4">Can't Find Your Subject?</h2>
            <p class="text-blue-100 mb-8 max-w-lg mx-auto font-medium">
                We have many more qualified tutors available. Tell us what you need and we'll find the perfect match within 24 hours.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('find-a-tutor') }}"
                   class="inline-flex items-center gap-2 font-black text-sm uppercase tracking-widest px-8 py-4 rounded-xl transition-all active:scale-95"
                   style="background:#ff6700;color:#fff;">
                    <i class="fas fa-search"></i> Submit a Request
                </a>
                <a href="https://wa.me/923414133395" target="_blank"
                   class="inline-flex items-center gap-2 font-black text-sm uppercase tracking-widest px-8 py-4 rounded-xl transition-all active:scale-95"
                   style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:#fff;">
                    <i class="fab fa-whatsapp"></i> WhatsApp Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Tutor data for modal
const tutorsData = @json($featuredTutors);
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
    document.getElementById('modal-location').textContent    = `${tutor.area}, ${tutor.city}, ${tutor.country}`;

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

// ── Auto-filter from homepage search (?q=) ───────────────────────
(function() {
    const params = new URLSearchParams(window.location.search);
    const q      = (params.get('q') || '').trim().toLowerCase();
    if (!q) return;
    const select = document.getElementById('filter-subject');
    // Try exact match first, then startsWith, then includes
    let matched = '';
    for (const opt of select.options) {
        if (!opt.value) continue;
        if (opt.value === q)             { matched = opt.value; break; }
    }
    if (!matched) {
        for (const opt of select.options) {
            if (!opt.value) continue;
            if (q.startsWith(opt.value) || opt.value.startsWith(q)) { matched = opt.value; break; }
        }
    }
    if (!matched) {
        for (const opt of select.options) {
            if (!opt.value) continue;
            if (q.includes(opt.value) || opt.value.includes(q)) { matched = opt.value; break; }
        }
    }
    if (matched) select.value = matched;
    filterTutors();
    setTimeout(function() {
        const grid = document.getElementById('tutors-grid');
        if (grid) grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 350);
})();

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
        'Lahore':     ['DHA', 'Gulberg', 'Model Town', 'Johar Town', 'Garden Town', 'Allama Iqbal Town', 'Bahria Town', 'Raiwind', 'Faisal Town', 'Wapda Town'],
        'Islamabad':  ['F-6', 'F-7', 'F-8', 'G-9', 'G-11', 'E-7', 'DHA Islamabad', 'Bahria Town Islamabad'],
        'Karachi':    ['DHA Karachi', 'Clifton', 'Gulshan-e-Iqbal', 'PECHS', 'North Nazimabad', 'Korangi'],
        'Faisalabad': ['Madina Town', 'Canal Road', 'Peoples Colony', 'Gulberg Faisalabad', 'Batala Colony'],
        'Rawalpindi': ['Satellite Town', 'Bahria Town Rawalpindi', 'Chaklala', 'PWD Colony'],
        'Multan':     ['Cantt', 'Qasimpur', 'Shah Rukn-e-Alam', 'Gulgasht'],
        'Peshawar':   ['Hayatabad', 'University Town', 'Cantt', 'Phase 5'],
    }
};

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
    const subject = document.getElementById('filter-subject').value.toLowerCase();
    const country = document.getElementById('filter-country').value;
    const city    = document.getElementById('filter-city').value;
    const area    = document.getElementById('filter-area').value;

    const cards = document.querySelectorAll('.tutor-card');
    let visible  = 0;

    cards.forEach(card => {
        const subs = (card.dataset.subjects || '').toLowerCase();
        const ok   =
            (!subject || subs.includes(subject)) &&
            (!country || card.dataset.country === country) &&
            (!city    || card.dataset.city    === city) &&
            (!area    || card.dataset.area    === area);

        card.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });

    document.getElementById('tutor-count').textContent = visible;
    document.getElementById('no-results').classList.toggle('hidden', visible > 0);

    const isFiltered = subject || country || city || area;
    document.getElementById('filter-badge').classList.toggle('hidden', !isFiltered);
}

function resetFilters() {
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
</script>
@endpush
