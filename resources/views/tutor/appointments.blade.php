@extends('layouts.dashboard')
@section('title', 'Your Appointments - TutorHub')

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Appointment History</h1>
        <p class="text-gray-500 font-medium">Manage and view all your student sessions</p>
    </div>

    @if($registration)
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Student</th>
                            <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Session Time</th>
                            <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                            <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Payment</th>
                            <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="p-6">
                                    <p class="text-sm font-black text-gray-900 group-hover:text-blue-600 transition-colors">{{ $booking->student_name }}</p>
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">Student</p>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-xl flex flex-col items-center justify-center font-black leading-none">
                                            <span class="text-[8px] uppercase">{{ $booking->start_time->format('M') }}</span>
                                            <span class="text-[14px]">{{ $booking->start_time->format('d') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $booking->start_time->format('h:i A') }}</p>
                                            <p class="text-[9px] text-gray-400 font-medium">{{ $booking->start_time->format('l') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-2">
                                        <span id="status-{{ $booking->id }}" class="inline-flex items-center px-2.5 py-1 rounded-full text-[8px] font-black uppercase tracking-widest 
                                            {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                               ($booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                            {{ $booking->status }}
                                        </span>
                                        @if($booking->status == 'pending')
                                            <div class="flex gap-1 action-group-{{ $booking->id }}">
                                                <button onclick="openConfirmModal({{ $booking->id }}, '{{ $booking->start_time->format('H:i') }}', '{{ $booking->end_time->format('H:i') }}', '{{ addslashes($booking->student_name) }}')" class="p-1.5 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-all shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                                <button onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-6">
                                    @if($booking->is_trial)
                                        <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest italic">Trial Session</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[8px] font-black uppercase tracking-widest 
                                            {{ $booking->payment_status == 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $booking->payment_status ?: 'Unpaid' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6">
                                    <p class="text-xs text-gray-500 leading-relaxed italic max-w-xs">{{ $booking->notes ?: 'No notes provided.' }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center">
                                    <div class="mb-4 text-gray-200 flex justify-center">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-xs font-black text-gray-300 uppercase tracking-widest italic">No appointment history found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($bookings->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="bg-white p-12 rounded-[3rem] shadow-xl border border-gray-100 text-center">
            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-4 uppercase tracking-tight">Access Restricted</h2>
            <p class="text-gray-500 font-medium mb-10 max-w-sm mx-auto leading-relaxed">You haven't applied as a tutor yet. Please complete your application to view and manage appointments.</p>
            <a href="{{ route('register-tutor') }}" class="inline-block bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-500/30 hover:bg-blue-700 transition-all transform hover:-translate-y-1">Start My Application</a>
        </div>
    @endif
</div>

@push('modals')
<!-- Adjust Session Modal -->
<div id="confirmModal" class="hidden fixed inset-0 backdrop-blur-sm flex items-center justify-center p-4" style="z-index: 99999; background-color: rgba(0, 0, 0, 0.5);">
    <div class="bg-white rounded-[2rem] p-8 max-w-md w-full shadow-2xl">
        <h3 class="text-xl font-black text-gray-900 mb-2">Confirm Session</h3>
        <p class="text-xs text-gray-500 font-medium mb-6">Review the session details for <span id="modal-student" class="font-bold text-gray-800"></span></p>
        
        <div class="space-y-4 mb-8">
            <div>
                <label class="text-[9px] font-black uppercase text-gray-400 block mb-1">Start Time (Fixed)</label>
                <input type="time" id="modal-start" readonly class="w-full bg-gray-50 p-3 rounded-xl border-gray-100 text-sm font-bold text-gray-500 cursor-not-allowed">
            </div>
            <div>
                <label class="text-[9px] font-black uppercase text-gray-400 block mb-1">End Time</label>
                <input type="time" id="modal-end" class="w-full bg-white p-3 rounded-xl border-gray-200 focus:border-blue-500 text-sm font-bold shadow-sm">
                <p class="text-[9px] text-gray-400 mt-2 italic font-medium leading-relaxed">Adjust the end time if you cannot tutor for the fully requested duration.</p>
            </div>
        </div>

        <div class="flex gap-3">
            <button onclick="closeConfirmModal()" class="flex-1 px-4 py-3 bg-gray-50 text-gray-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-100 transition-colors">Cancel</button>
            <button onclick="submitConfirmation()" class="flex-1 px-4 py-3 bg-green-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-green-600 transition-colors shadow-lg shadow-green-500/20">Finalize</button>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    let currentConfirmId = null;

    function openConfirmModal(id, start, end, studentName) {
        currentConfirmId = id;
        document.getElementById('modal-student').textContent = studentName;
        document.getElementById('modal-start').value = start;
        document.getElementById('modal-end').value = end;
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        currentConfirmId = null;
    }

    async function submitConfirmation() {
        if (!currentConfirmId) return;
        
        const bookingId = currentConfirmId;
        let endTime = document.getElementById('modal-end').value;
        const startTime = document.getElementById('modal-start').value;
        
        if (endTime <= startTime) {
            alert('End time must be after start time.');
            return;
        }

        // Standardize to H:i structure without seconds
        if (endTime.length === 8) endTime = endTime.substring(0, 5);

        closeConfirmModal();
        await updateBookingStatus(bookingId, 'confirmed', endTime);
    }

    async function updateBookingStatus(id, status, endTime = null) {
        if (status === 'cancelled' && !confirm(`Are you sure you want to cancel this booking?`)) return;
        
        try {
            const body = { status };
            if (endTime) body.end = endTime;

            const response = await fetch(`/api/bookings/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(body)
            });
            
            const data = await response.json();
            if (data.success) {
                // Update Badge
                const badge = document.getElementById(`status-${id}`);
                badge.textContent = status;
                badge.className = `inline-flex items-center px-2.5 py-1 rounded-full text-[8px] font-black uppercase tracking-widest ${status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;
                
                // Hide Buttons
                const actions = document.querySelector(`.action-group-${id}`);
                if (actions) actions.style.display = 'none';
            } else {
                if(data.errors && data.errors.end) {
                    alert(data.errors.end[0]);
                } else {
                    alert(data.message || 'Operation failed');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Something went wrong during confirmation.');
        }
    }
</script>
@endpush
@endsection
