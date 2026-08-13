@extends('layouts.admin')
@section('title', 'Tutor Roster - Admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Tutor Roster</h2>
        <p class="text-gray-500 font-medium">Manage all registered tutors, verification statuses, and applications.</p>
    </div>
    
    <div class="px-6 py-3 bg-white rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="text-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Tutors</p>
            <p class="text-xl font-black text-blue-600 tracking-tight">{{ $tutors->count() }}</p>
        </div>
    </div>
</div>

<div class="mb-8 flex flex-wrap items-center gap-4 bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5">
    <!-- Search -->
    <div class="flex items-center bg-gray-50 border border-gray-100 rounded-2xl px-4 py-2.5 focus-within:ring-4 focus-within:ring-blue-500/10 focus-within:border-blue-500 transition-all w-64">
        <i class="fas fa-search text-gray-300 shrink-0"></i>
        <input type="text" id="tutor-search" onkeyup="applyFilters()" 
               class="w-full border-none focus:ring-0 p-0 ml-2.5 text-sm bg-transparent placeholder-gray-400 font-medium" 
               placeholder="Search name...">
    </div>
    
    @php
        $allCountries = [
            'PK' => 'Pakistan',
            'AE' => 'UAE',
            'SA' => 'Saudi Arabia',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'QA' => 'Qatar',
            'KW' => 'Kuwait',
            'BH' => 'Bahrain',
            'OM' => 'Oman',
            'JO' => 'Jordan',
            'EG' => 'Egypt',
            'TR' => 'Turkey',
            'IN' => 'India',
            'BD' => 'Bangladesh',
            'LK' => 'Sri Lanka',
            'MY' => 'Malaysia',
            'SG' => 'Singapore',
            'ID' => 'Indonesia',
            'PH' => 'Philippines',
            'AF' => 'Afghanistan',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'YE' => 'Yemen',
            'NG' => 'Nigeria',
            'KE' => 'Kenya',
            'ZA' => 'South Africa',
            'GH' => 'Ghana',
            'TZ' => 'Tanzania',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'NZ' => 'New Zealand',
            'DE' => 'Germany',
            'FR' => 'France',
            'NL' => 'Netherlands',
            'OTHER' => 'Other / International',
        ];
        asort($allCountries); // Sort countries alphabetically
        
        $allPrograms = ['Bachelors', 'Masters', 'PhD', 'Diploma', 'Other'];
        $statusFilters = ['pending', 'interviewing', 'approved', 'rejected'];
    @endphp

    <!-- Country Filter -->
    <select id="country-filter" onchange="updateAreasDropdown(); applyFilters();" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
        <option value="">All Countries</option>
        @foreach($allCountries as $code => $name)
            <option value="{{ strtolower($code) }}">{{ $name }}</option>
        @endforeach
    </select>

    <!-- Area Filter -->
    <select id="area-filter" onchange="applyFilters()" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none" disabled>
        <option value="">All Areas</option>
    </select>

    <!-- Program Filter -->
    <select id="program-filter" onchange="applyFilters()" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
        <option value="">All Programs</option>
        @foreach($allPrograms as $program)
            <option value="{{ strtolower($program) }}">{{ $program }}</option>
        @endforeach
    </select>

    <!-- Status Filter -->
    <select id="status-filter" onchange="applyFilters()" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
        <option value="">All Status</option>
        @foreach($statusFilters as $status)
            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
        @endforeach
    </select>

    <!-- Mode Filter -->
    <select id="mode-filter" onchange="applyFilters()" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
        <option value="">All Modes</option>
        <option value="online">Online</option>
        <option value="home">In-Person/Home</option>
        <option value="both">Both</option>
    </select>
</div>

@if($tutors->isEmpty())
    <div class="bg-white rounded-[2.5rem] border border-gray-100 p-20 text-center shadow-xl shadow-blue-500/5">
        <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-300">
            <i class="fas fa-chalkboard-teacher text-3xl"></i>
        </div>
        <h3 class="text-lg font-black text-gray-900 mb-2">Roster is empty</h3>
        <p class="text-gray-400 text-sm font-medium">When tutors register, their applications will appear here.</p>
    </div>
@else
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="tutors-table">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tutor Details</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Location</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Education</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Pricing</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($tutors as $tutor)
                        <tr class="hover:bg-blue-50/30 transition-colors tutor-row" 
                            data-country="{{ strtolower($tutor->country) }}" 
                            data-area="{{ strtolower($tutor->area) }}"
                            data-program="{{ strtolower($tutor->program) }}"
                            data-status="{{ strtolower($tutor->status ?? 'pending') }}"
                            data-online="{{ $tutor->is_online ? '1' : '0' }}"
                            data-home="{{ $tutor->is_home ? '1' : '0' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg overflow-hidden shrink-0 border border-gray-100 shadow-sm bg-blue-50 flex items-center justify-center">
                                        @if($tutor->profile_image)
                                            <img src="{{ asset('storage/' . $tutor->profile_image) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user text-blue-300 text-xs"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 tutor-name leading-tight">{{ $tutor->name }}</div>
                                        <div class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $tutor->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black uppercase text-gray-500 tracking-tighter country-val">{{ $tutor->country_name }}</span>
                                @if($tutor->area)
                                    <span class="text-[10px] font-bold text-blue-600 block leading-tight mt-0.5">{{ $tutor->area }}</span>
                                @endif
                                <div class="text-[10px] text-gray-400 mt-0.5">{{ $tutor->timezone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-gray-800 program-val">{{ $tutor->program }}</div>
                                <div class="text-[10px] text-gray-400">{{ $tutor->major }}</div>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-blue-600 whitespace-nowrap">
                                <span class="text-[10px] text-gray-400 mr-1 font-normal">{{ $tutor->display_currency }}</span>{{ number_format($tutor->hourly_rate) }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'approved' => 'green',
                                        'interviewing' => 'blue',
                                        'rejected' => 'red',
                                        'pending' => 'yellow'
                                    ];
                                    $color = $statusColors[$tutor->status] ?? 'gray';
                                @endphp
                                <span class="inline-flex items-center gap-1 text-{{ $color }}-600 font-black text-[9px] uppercase tracking-widest bg-{{ $color }}-50 px-2 py-1 rounded border border-{{ $color }}-100 {{ $tutor->status == 'interviewing' ? 'animate-pulse' : '' }}">
                                    {{ ucfirst($tutor->status) }}
                                </span>
                                
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.tutors.edit', $tutor->id) }}"
                                       class="bg-gray-900 text-white px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-blue-600 transition shadow-sm active:scale-95">
                                        Review
                                    </a>
                                    
                                    <form action="{{ route('admin.tutors.destroy', $tutor->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-600 transition" title="Delete">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>

                                    @if($tutor->resume_path)
                                        <a href="{{ asset('storage/' . $tutor->resume_path) }}" target="_blank" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="View CV">
                                            <i class="fas fa-file-pdf text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@push('scripts')
<script>
const countryAreas = {
    'pk': [
        'Askari', 'Allama Iqbal Town', 'Al-Rehman Gardens', 'Architect Society', 'Audits and Accounts Society', 'Abdalian Society',
        'Bahria Town', 'Bahria Orchard', 'Cantt', 'Cavalry Ground', 'DHA Phase 1,2,3,4', 'DHA Phase 5,6', 'DHA Phase 7,8,9',
        'DHA Rahbar', 'Divine Gardens', 'Eden Society', 'EME Society', 'Ferozpur Road', 'Faisal Town', 'Fazaia Housing Scheme',
        'Formanites Housing Scheme', 'Gulberg 1', 'Gulberg 2', 'Gulberg 3', 'Garden Town', 'New Garden Town', 'Gulshan Ravi',
        'Green Town', 'GOR', 'Harbanspura', 'Izmir Town', 'Ichra', 'IEP Engineers Town', 'Johar Town', 'Jubilee Town',
        'Kot Lakhpat', 'Lake City', 'Model Town', 'Mughalpura', 'Muslim Town', 'Mustafa Town', 'Peco Road', 'Raiwind Road',
        'Revenue Society', 'State Life Housing Society', 'Samanabad', 'Sabzazar', 'Sui Gas Society', 'Shadab Gardens',
        'Tajpura', 'Thokar Niaz Baig', 'Town Ship', 'UET Housing Society', 'Valencia Housing Society', 'Vital Homes Housing Society',
        'Walton Cantt', 'Wahdat Road', 'Wapda Town', 'Zaman Park', 'Satellite Town', 'Bahria Town Rawalpindi', 'Chaklala',
        'PWD Colony', 'DHA Karachi', 'Clifton', 'Gulshan-e-Iqbal', 'PECHS', 'North Nazimabad', 'Korangi', 'Madina Town',
        'Canal Road', 'Peoples Colony', 'Gulberg Faisalabad', 'Batala Colony', 'Hayatabad', 'University Town', 'Phase 5', 'Other Area'
    ],
    'ae': ['Downtown', 'Dubai Marina', 'Jumeirah', 'Palm Jumeirah', 'Al Barsha', 'Business Bay', 'Deira', 'Bur Dubai', 'Silicon Oasis', 'Yas Island', 'Al Reem Island', 'Khalifa City', 'Corniche', 'Al Khalidiyah', 'Al Majaz', 'Al Nahda', 'Muwaileh', 'Al Nuaimia', 'Al Rashidiya', 'Al Hamra', 'Al Marjan Island', 'Fujairah City', 'Dibba', 'Umm Al Quwain City', 'Other Area'],
    'sa': ['Olaya', 'Al Malaz', 'Al Yasmin', 'Al Sahafa', 'Al Muhammadiyah', 'Al Hamra', 'Al Naeem', 'Al Safa', 'Obhur', 'Al Haram', 'Aziziyah', 'Al Aqeeq', 'Al Shatea', 'Al Faisaliyah', 'Al Hizam', 'Al Thuqbah', 'Other Area'],
    'gb': ['Westminster', 'Kensington & Chelsea', 'Camden', 'Greenwich', 'Croydon', 'Ealing', 'City Centre', 'Edgbaston', 'Selly Oak', 'Solihull', 'Didsbury', 'Salford', 'Fallowfield', 'West End', 'Southside', 'Old Town', 'New Town', 'Leith', 'Anfield', 'Allerton', 'Headingley', 'Chapel Allerton', 'Other Area'],
    'us': ['Manhattan', 'Brooklyn', 'Queens', 'Bronx', 'Staten Island', 'Hollywood', 'Downtown LA', 'Santa Monica', 'Pasadena', 'Loop', 'Lincoln Park', 'Hyde Park', 'Downtown', 'Galleria', 'The Woodlands', 'Scottsdale', 'Tempe', 'Center City', 'University City', 'Alamo Heights', 'La Jolla', 'Gaslamp Quarter', 'Uptown', 'Plano', 'Silicon Valley', 'Other Area'],
    'qa': ['West Bay', 'The Pearl', 'Al Sadd', 'Madinat Khalifa', 'Al Wakrah City', 'Al Rayyan City', 'Al Khor City', 'Other Area'],
    'kw': ['Sharq', 'Mirgab', 'Qibla', 'Salmiya City', 'Hawally City', 'Farwaniya City', 'Other Area'],
    'bh': ['Juffair', 'Seef', 'Adliya', 'East Riffa', 'West Riffa', 'Amwaj Islands', 'Other Area'],
    'om': ['Ruwi', 'Al Khuwair', 'Muttrah', 'Salalah City', 'Sohar City', 'Other Area'],
    'jo': ['Jabal Amman', 'Abdoun', 'Sweifieh', 'Zarqa City', 'Irbid City', 'Other Area'],
    'eg': ['Maadi', 'Zamalek', 'Nasr City', 'Heliopolis', 'Sidi Gaber', 'Smouha', 'Stanley', 'Dokki', 'Mohandessin', '6th of October', 'Other Area'],
    'tr': ['Fatih', 'Beyoglu', 'Kadikoy', 'Besiktas', 'Cankaya', 'Kizilay', 'Alsancak', 'Karsiyaka', 'Other Area'],
    'in': ['Colaba', 'Bandra', 'Andheri', 'Worli', 'Connaught Place', 'South Delhi', 'Dwarka', 'Indiranagar', 'Koramangala', 'Whitefield', 'Gachibowli', 'Banjara Hills', 'Jubilee Hills', 'Adyar', 'T. Nagar', 'Velachery', 'Other Area'],
    'bd': ['Gulshan', 'Banani', 'Dhanmondi', 'Uttara', 'Panchlaish', 'Halishahar', 'Other Area'],
    'lk': ['Colombo 03 (Colpetty)', 'Colombo 07 (Cinnamon Gardens)', 'Colombo 04 (Bambalapitiya)', 'Kandy City', 'Other Area'],
    'my': ['KLCC', 'Bukit Bintang', 'Mont Kiara', 'Bangsar', 'George Town', 'Bayan Lepas', 'Tebrau', 'Bukit Indah', 'Other Area'],
    'sg': ['Orchard Road', 'Marina Bay', 'Sentosa', 'Jurong', 'Tampines', 'Other Area'],
    'id': ['Menteng', 'Sudirman', 'Kemang', 'Dharmahusada', 'Gubeng', 'Seminyak', 'Kuta', 'Ubud', 'Other Area']
};

function updateAreasDropdown() {
    const country = document.getElementById('country-filter').value;
    const areaFilter = document.getElementById('area-filter');
    
    // Clear existing options except default one
    areaFilter.innerHTML = '<option value="">All Areas</option>';
    
    if (country) {
        // Fallback to Central / Other Area if country not explicitly mapped in dictionary
        const areasList = countryAreas[country] || ['Central', 'Other Area'];
        const areas = [...areasList].sort();
        areas.forEach(area => {
            const opt = document.createElement('option');
            opt.value = area.toLowerCase();
            opt.textContent = area;
            areaFilter.appendChild(opt);
        });
        areaFilter.disabled = false;
    } else {
        areaFilter.disabled = true;
    }
}

function applyFilters() {
    const search = document.getElementById('tutor-search').value.toLowerCase();
    const country = document.getElementById('country-filter').value.toLowerCase();
    const area = document.getElementById('area-filter').value.toLowerCase();
    const program = document.getElementById('program-filter').value.toLowerCase();
    const status = document.getElementById('status-filter').value.toLowerCase();
    const mode = document.getElementById('mode-filter').value;
    
    const rows = document.querySelectorAll('.tutor-row');
    
    rows.forEach(row => {
        const rowName = row.querySelector('.tutor-name').textContent.toLowerCase();
        const rowCountry = row.getAttribute('data-country');
        const rowArea = row.getAttribute('data-area');
        const rowProgram = row.getAttribute('data-program');
        const rowStatus = row.getAttribute('data-status');
        const isOnline = row.getAttribute('data-online') === '1';
        const isHome = row.getAttribute('data-home') === '1';
        
        const matchesSearch = rowName.includes(search);
        const matchesCountry = country === "" || rowCountry === country;
        const matchesArea = area === "" || rowArea === area;
        const matchesProgram = program === "" || rowProgram === program;
        const matchesStatus = status === "" || rowStatus === status;
        
        let matchesMode = true;
        if (mode === "online") matchesMode = isOnline;
        else if (mode === "home") matchesMode = isHome;
        else if (mode === "both") matchesMode = isOnline && isHome;
        
        if (matchesSearch && matchesCountry && matchesArea && matchesProgram && matchesStatus && matchesMode) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection
