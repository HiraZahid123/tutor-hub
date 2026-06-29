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
        $countries = $tutors->pluck('country')->unique()->sort();
        $programs = $tutors->pluck('program')->unique()->sort();
        $statusFilters = ['pending', 'interviewing', 'approved', 'rejected'];
    @endphp

    <!-- Country Filter -->
    <select id="country-filter" onchange="applyFilters()" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
        <option value="">All Countries</option>
        @foreach($countries as $country)
            <option value="{{ $country }}">{{ $country }}</option>
        @endforeach
    </select>

    <!-- Program Filter -->
    <select id="program-filter" onchange="applyFilters()" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
        <option value="">All Programs</option>
        @foreach($programs as $program)
            <option value="{{ $program }}">{{ $program }}</option>
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
                                <span class="text-[10px] font-black uppercase text-gray-500 tracking-tighter country-val">{{ $tutor->country }}</span>
                                <div class="text-[10px] text-gray-400">{{ $tutor->timezone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-gray-800 program-val">{{ $tutor->program }}</div>
                                <div class="text-[10px] text-gray-400">{{ $tutor->major }}</div>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-blue-600 whitespace-nowrap">
                                <span class="text-[10px] text-gray-400 mr-1 font-normal">PKR</span>{{ number_format($tutor->hourly_rate) }}
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
function applyFilters() {
    const search = document.getElementById('tutor-search').value.toLowerCase();
    const country = document.getElementById('country-filter').value.toLowerCase();
    const program = document.getElementById('program-filter').value.toLowerCase();
    const status = document.getElementById('status-filter').value.toLowerCase();
    const mode = document.getElementById('mode-filter').value;
    
    const rows = document.querySelectorAll('.tutor-row');
    
    rows.forEach(row => {
        const rowName = row.querySelector('.tutor-name').textContent.toLowerCase();
        const rowCountry = row.getAttribute('data-country');
        const rowProgram = row.getAttribute('data-program');
        const rowStatus = row.getAttribute('data-status');
        const isOnline = row.getAttribute('data-online') === '1';
        const isHome = row.getAttribute('data-home') === '1';
        
        const matchesSearch = rowName.includes(search);
        const matchesCountry = country === "" || rowCountry === country;
        const matchesProgram = program === "" || rowProgram === program;
        const matchesStatus = status === "" || rowStatus === status;
        
        let matchesMode = true;
        if (mode === "online") matchesMode = isOnline;
        else if (mode === "home") matchesMode = isHome;
        else if (mode === "both") matchesMode = isOnline && isHome;
        
        if (matchesSearch && matchesCountry && matchesProgram && matchesStatus && matchesMode) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection
