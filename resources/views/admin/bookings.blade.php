@extends('layouts.admin')

@section('title', 'Session Oversight - TutorHub')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Session Oversight</h2>
        <p class="text-gray-500 font-medium">Monitor all scheduled, completed, and cancelled tutoring sessions.</p>
    </div>
    
    <div class="px-6 py-3 bg-white rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="text-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Sessions</p>
            <p class="text-xl font-black text-blue-600 tracking-tight">{{ $bookings->count() }}</p>
        </div>
    </div>
</div>

<div class="mb-8 flex flex-wrap items-center gap-4 bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-500/5">
    <!-- Search -->
    <div class="flex items-center bg-gray-50 border border-gray-100 rounded-2xl px-4 py-2.5 focus-within:ring-4 focus-within:ring-blue-500/10 focus-within:border-blue-500 transition-all w-64">
        <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input type="text" id="booking-search" onkeyup="filterBookings()" 
               class="w-full border-none focus:ring-0 p-0 ml-2.5 text-sm bg-transparent placeholder-gray-400 font-medium" 
               placeholder="Search name...">
    </div>

    <!-- Status Filter -->
    <select id="status-filter" onchange="filterBookings()" class="bg-gray-50 border border-gray-100 rounded-2xl text-[11px] font-black uppercase tracking-widest px-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
        <option value="">All Statuses</option>
        <option value="scheduled">Scheduled</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
        <option value="pending">Pending</option>
    </select>

    <button type="button" onclick="resetFilters()" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-2xl hover:bg-gray-100 hover:text-gray-900 transition-all border border-gray-100" title="Reset Filters">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl font-bold flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse" id="bookings-table">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">ID</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Session Details</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tutor</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Student</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Payment</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-blue-50/20 transition-colors booking-row" data-status="{{ strtolower($booking->status) }}">
                        <td class="px-8 py-6 text-sm font-bold text-gray-400">#{{ $booking->id }}</td>
                        <td class="px-8 py-6">
                            <div class="text-sm font-black text-gray-900">{{ $booking->start_time->format('M d, Y') }}</div>
                            <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase">{{ $booking->start_time->format('h:i A') }} - {{ $booking->end_time->format('h:i A') }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-black text-xs">
                                    {{ substr($booking->tutor->name ?? 'T', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 tutor-name">{{ $booking->tutor->name ?? 'Unknown' }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 truncate w-32">{{ $booking->tutor->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs">
                                    {{ substr($booking->student->name ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 student-name">{{ $booking->student->name ?? 'Guest' }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 truncate w-32">{{ $booking->student->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusClasses = [
                                    'scheduled' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'completed' => 'bg-green-50 text-green-600 border-green-100',
                                    'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                    'pending'   => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                    'confirmed' => 'bg-green-50 text-green-600 border-green-100',
                                ];
                                $class = $statusClasses[strtolower($booking->status)] ?? $statusClasses['pending'];
                            @endphp
                            <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-tight border {{ $class }} status-val">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            @if($booking->is_trial)
                                <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest italic">Trial</span>
                            @else
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-tight {{ $booking->payment_status == 'paid' ? 'text-green-600' : 'text-amber-600' }}">
                                        {{ $booking->payment_status ?: 'Unpaid' }}
                                    </span>
                                    @if($booking->transaction_id)
                                        <span class="text-[8px] font-bold text-gray-400 mt-1 italic">Ref: {{ $booking->transaction_id }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this session booking?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-300 hover:text-red-500 hover:bg-white rounded-xl transition-all shadow-sm" title="Delete Session">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center text-gray-300 mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 mb-1">No sessions yet</h3>
                                <p class="text-sm font-medium text-gray-400">Scheduled sessions will appear here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function filterBookings() {
    const search = document.getElementById('booking-search').value.toLowerCase();
    const status = document.getElementById('status-filter').value.toLowerCase();
    const rows = document.querySelectorAll('.booking-row');

    rows.forEach(row => {
        const rowTutor = row.querySelector('.tutor-name').textContent.toLowerCase();
        const rowStudent = row.querySelector('.student-name').textContent.toLowerCase();
        const rowStatus = row.getAttribute('data-status');

        const matchesSearch = rowTutor.includes(search) || rowStudent.includes(search);
        const matchesStatus = status === "" || rowStatus === status;

        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
    });
}

function resetFilters() {
    document.getElementById('booking-search').value = '';
    document.getElementById('status-filter').value = '';
    filterBookings();
}
</script>
@endpush
@endsection
