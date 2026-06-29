<div class="schedule-container bg-white rounded-3xl p-6 border border-gray-100 shadow-sm max-w-3xl mx-auto overflow-hidden relative">
    <div id="schedule-loading" class="absolute inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="w-8 h-8 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div class="calendar-flex-container" style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start;">
        <!-- Calendar (Left Part) -->
        <div class="calendar-part" style="flex: 0 0 300px; width: 300px;">
            <div class="flex items-center justify-between mb-4">
                <h3 id="current-month" class="text-xs font-black text-gray-900 uppercase tracking-widest italic">March 2026</h3>
                <div class="flex gap-1">
                    <button onclick="changeMonth(-1)" class="p-1.5 hover:bg-gray-100 rounded-lg transition-all border border-gray-50">
                        <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button onclick="changeMonth(1)" class="p-1.5 hover:bg-gray-100 rounded-lg transition-all border border-gray-50">
                        <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-1 mb-1 text-center" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px;">
                @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                    <div class="text-[8px] font-black text-gray-300 uppercase py-1">{{ $day }}</div>
                @endforeach
            </div>

            <div id="calendar-days" class="grid grid-cols-7 gap-1 text-center" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px;">
                <!-- Days will be injected here -->
            </div>
        </div>

        <!-- Slots (Right Part) -->
        <div class="slots-part" style="flex: 1; min-width: 250px; border-left: 1px solid #F3F4F6; padding-left: 2rem;">
            <div class="mb-4">
                <h4 id="selected-date-display" class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1 italic">Pick a Date</h4>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Available Time</p>
            </div>

            <div id="slots-container" class="space-y-1.5 max-h-[80px] overflow-y-auto pr-2 custom-scrollbar mb-4">
                <div class="py-4 text-center border border-dashed border-gray-100 rounded-2xl">
                    <p class="text-[8px] text-gray-300 font-black uppercase tracking-widest">Select Date</p>
                </div>
            </div>

            <div id="booking-actions" class="hidden animate-in fade-in slide-in-from-bottom-2 duration-300">
                @auth
                    <div class="space-y-3 p-4 bg-gray-50/50 rounded-2xl border border-gray-100 mb-4">
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <label class="text-[8px] font-black uppercase text-gray-400 block mb-1">Start Time</label>
                                <input type="time" id="booking-start" onchange="calculatePrice()" class="w-full bg-white p-2 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-0 text-xs font-bold font-mono">
                            </div>
                            <div class="flex-1">
                                <label class="text-[8px] font-black uppercase text-gray-400 block mb-1">End Time</label>
                                <input type="time" id="booking-end" onchange="calculatePrice()" class="w-full bg-white p-2 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-0 text-xs font-bold font-mono">
                            </div>
                        </div>
                        <div class="text-right border-t border-gray-200 pt-2 mt-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Est. Amount: </span>
                            <span id="booking-price" class="text-lg font-black text-blue-600">0 PKR</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <textarea id="booking-notes" placeholder="Notes (Optional)..." rows="2"
                                  class="w-full bg-gray-50/50 p-2.5 rounded-xl border-gray-100 focus:border-blue-500 focus:ring-0 text-[10px] font-medium transition-all"></textarea>
                        <button onclick="confirmBooking()" 
                                class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-500/10 transition-all flex items-center justify-center gap-2">
                            Confirm Custom Time
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Tutor Weekly Reference (New) -->
    <div class="mt-8 pt-6 border-t border-gray-50">
        <h5 class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em] mb-4 text-center">Tutor Working Hours Reference</h5>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-2">
            @php
                $refDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                $tutorAvails = \App\Models\TutorAvailability::where('tutor_id', $tutorId)->get();
            @endphp
            @foreach($refDays as $day)
                @php
                    $dayAvail = $tutorAvails->where('day_of_week', $day)->first();
                @endphp
                <div class="p-2 rounded-xl border border-gray-50 bg-gray-50/30 text-center {{ !$dayAvail ? 'opacity-30' : '' }}">
                    <p class="text-[8px] font-black text-blue-600 uppercase mb-1">{{ substr($day, 0, 3) }}</p>
                    @if($dayAvail)
                        <p class="text-[9px] font-bold text-gray-700 whitespace-nowrap">{{ \Carbon\Carbon::parse($dayAvail->start_time)->format('g:ia') }} - {{ \Carbon\Carbon::parse($dayAvail->end_time)->format('g:ia') }}</p>
                    @else
                        <p class="text-[9px] font-bold text-gray-400">Off</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    </div>

    <!-- Success Overlay -->
    <div id="booking-success" class="absolute inset-0 bg-white/95 backdrop-blur-sm hidden flex flex-col items-center justify-center p-6 text-center animate-in zoom-in duration-300" style="z-index: 60;">
        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-1">Requested!</h3>
        <p class="text-gray-500 text-[10px] mb-6 font-medium">Check your dashboard for updates.</p>
        <button onclick="location.reload()" class="text-[9px] font-black text-blue-600 border-b border-blue-100 hover:border-blue-600 py-1 transition-all uppercase tracking-widest">Close</button>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #F3F4F6; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #E5E7EB; }
</style>

<script>
    let currentDate = new Date();
    let selectedDate = null;
    let hourlyRate = 0; // Dynamic rate loaded when dates are picked
    const tutorId = {{ $tutorId }};

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;
        const grid = document.getElementById('calendar-days');
        grid.innerHTML = '';
        for (let i = 0; i < firstDay; i++) {
            grid.appendChild(document.createElement('div'));
        }
        const today = new Date(); today.setHours(0,0,0,0);
        for (let day = 1; day <= daysInMonth; day++) {
            const dateObj = new Date(year, month, day);
            const isPast = dateObj < today;
            const isSelected = selectedDate && dateObj.getTime() === selectedDate.getTime();
            const btn = document.createElement('button');
            btn.className = `p-2 text-[10px] font-black rounded-lg transition-all border
                ${isPast ? 'text-gray-100 border-transparent cursor-default' : 
                (isSelected ? 'border-blue-600 bg-blue-600 text-white shadow-sm' : 'border-transparent text-gray-700 hover:bg-blue-50 hover:text-blue-600')}`;
            btn.textContent = day;
            if (!isPast) btn.onclick = () => selectDate(dateObj);
            grid.appendChild(btn);
        }
    }

    function changeMonth(delta) {
        currentDate.setMonth(currentDate.getMonth() + delta);
        renderCalendar();
    }

    async function selectDate(date) {
        selectedDate = date;
        renderCalendar();
        document.getElementById('selected-date-display').textContent = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        document.getElementById('booking-actions').classList.add('hidden');
        document.getElementById('booking-start').value = '';
        document.getElementById('booking-end').value = '';
        document.getElementById('booking-price').textContent = '0 PKR';
        fetchSlots(date);
    }

    async function fetchSlots(date) {
        const dateStr = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        const container = document.getElementById('slots-container');
        const loader = document.getElementById('schedule-loading');
        loader.classList.remove('hidden');
        try {
            const response = await fetch(`/api/tutors/${tutorId}/slots?date=${dateStr}`);
            const data = await response.json();
            container.innerHTML = '';
            
            if (data.blocks && data.blocks.length > 0) {
                hourlyRate = data.hourly_rate || 0;
                data.blocks.forEach(block => {
                    const el = document.createElement('div');
                    el.className = 'w-full p-2.5 rounded-xl border border-blue-100 bg-blue-50 text-blue-700 text-center mb-1 font-bold text-xs uppercase tracking-widest';
                    el.textContent = block.formatted;
                    container.appendChild(el);
                });
                document.getElementById('booking-actions').classList.remove('hidden');
            } else {
                container.innerHTML = '<p class="py-10 text-[8px] text-gray-300 font-black uppercase text-center italic tracking-widest">No availability</p>';
                document.getElementById('booking-actions').classList.add('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            container.innerHTML = '<p class="text-center text-red-500 text-[8px] font-black">ERROR LOADING</p>';
        } finally { loader.classList.add('hidden'); }
    }

    function calculatePrice() {
        const start = document.getElementById('booking-start').value;
        const end = document.getElementById('booking-end').value;
        if(start && end && start < end) {
            const startD = new Date(`1970-01-01T${start}`);
            const endD = new Date(`1970-01-01T${end}`);
            const mins = (endD - startD) / 60000;
            const price = (mins / 60) * hourlyRate;
            document.getElementById('booking-price').textContent = `${Math.round(price)} PKR`;
        } else {
            document.getElementById('booking-price').textContent = `0 PKR`;
        }
    }

    async function confirmBooking() {
        const start = document.getElementById('booking-start').value;
        const end = document.getElementById('booking-end').value;

        if (!start || !end || !selectedDate) {
            alert('Please select valid start and end times.');
            return;
        }
        if (start >= end) {
            alert('End time must be after start time.');
            return;
        }

        const dateStr = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth() + 1).padStart(2, '0')}-${String(selectedDate.getDate()).padStart(2, '0')}`;
        const loader = document.getElementById('schedule-loading');
        loader.classList.remove('hidden');
        try {
            const response = await fetch('/api/bookings', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ tutor_id: tutorId, date: dateStr, start: start, end: end, student_name: "{{ Auth::user()->name ?? 'Guest' }}", notes: document.getElementById('booking-notes').value })
            });
            const data = await response.json();
            if (data.success) {
                document.getElementById('booking-success').classList.remove('hidden');
            } else { alert(data.message || 'Booking failed'); }
        } catch (error) { console.error('Error:', error); alert('Something went wrong'); } finally { loader.classList.add('hidden'); }
    }
    document.addEventListener('DOMContentLoaded', renderCalendar);
</script>
