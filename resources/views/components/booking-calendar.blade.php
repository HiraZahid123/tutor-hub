<div class="schedule-container bg-white rounded-3xl p-6 border border-gray-100 shadow-sm max-w-3xl mx-auto relative">
    <div id="schedule-loading" class="absolute inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="w-8 h-8 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div class="calendar-flex-container" style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start;">
        <!-- Calendar (Left Part) -->
        <div class="calendar-part relative" style="flex: 0 0 300px; width: 300px;">
            <!-- Clickable date display -->
            <button type="button" id="date-picker-toggle" onclick="toggleCalendar()" class="w-full p-3 rounded-xl border border-gray-200 bg-white text-left hover:border-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                <span class="text-[8px] font-black uppercase text-gray-400 block mb-1">Date</span>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar text-gray-400 text-xs"></i>
                    <span id="selected-date-formatted" class="text-sm font-bold text-gray-800">—</span>
                </div>
            </button>

            <!-- Calendar dropdown (hidden until date clicked) -->
            <div id="calendar-dropdown" class="hidden absolute top-full left-0 right-0 mt-2 z-40 border border-gray-100 rounded-2xl p-4 bg-white shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="current-month" class="text-xs font-black text-gray-900 uppercase tracking-widest italic">March 2026</h3>
                    <div class="flex gap-1">
                        <button type="button" onclick="changeMonth(-1)" class="p-1.5 hover:bg-gray-100 rounded-lg transition-all border border-gray-50">
                            <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button type="button" onclick="changeMonth(1)" class="p-1.5 hover:bg-gray-100 rounded-lg transition-all border border-gray-50">
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
        </div>

        <!-- Slots (Right Part) -->
        <div class="slots-part" style="flex: 1; min-width: 250px; border-left: 1px solid #F3F4F6; padding-left: 2rem;">
            <div class="mb-4">
                <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1 italic">Available Time</h4>
            </div>

            <div id="slots-container" class="space-y-1.5 max-h-[80px] overflow-y-auto pr-2 custom-scrollbar mb-4">
                <div class="py-4 text-center border border-dashed border-gray-100 rounded-2xl">
                    <p class="text-[8px] text-gray-300 font-black uppercase tracking-widest">Select Date</p>
                </div>
            </div>

            <div id="booking-actions" class="hidden animate-in fade-in slide-in-from-bottom-2 duration-300">
                @auth
                    <div class="space-y-4 p-4 bg-gray-50/50 rounded-2xl border border-gray-100 mb-4">
                        <!-- Start / End time dropdowns (5-min intervals, 12h format) -->
                        <div class="flex gap-3">
                            <div class="flex-1 p-3 rounded-xl border border-gray-200 bg-white">
                                <span class="text-[8px] font-black uppercase text-gray-400 block mb-1">Start Time</span>
                                <div class="relative">
                                    <i class="fas fa-clock absolute left-0 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <select id="booking-start" onchange="onStartTimeChange()" class="w-full pl-5 bg-transparent border-0 p-0 text-sm font-bold text-gray-800 focus:ring-0 cursor-pointer appearance-none">
                                        <option value="">Select time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex-1 p-3 rounded-xl border border-gray-200 bg-white">
                                <span class="text-[8px] font-black uppercase text-gray-400 block mb-1">End Time</span>
                                <div class="relative">
                                    <i class="fas fa-clock absolute left-0 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <select id="booking-end" onchange="calculatePrice()" class="w-full pl-5 bg-transparent border-0 p-0 text-sm font-bold text-gray-800 focus:ring-0 cursor-pointer appearance-none">
                                        <option value="">Select time</option>
                                    </select>
                                </div>
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
    let calendarOpen = false;
    let hourlyRate = 0;
    let availableBlocks = [];
    const tutorId = {{ $tutorId }};

    function toggleCalendar() {
        const dropdown = document.getElementById('calendar-dropdown');
        calendarOpen = !calendarOpen;
        dropdown.classList.toggle('hidden', !calendarOpen);
    }

    function closeCalendar() {
        calendarOpen = false;
        document.getElementById('calendar-dropdown').classList.add('hidden');
    }

    function updateDateDisplay(date) {
        const formattedEl = document.getElementById('selected-date-formatted');
        if (formattedEl) formattedEl.textContent = formatDateDisplay(date);
    }

    function timeToMinutes(t) {
        const [h, m] = t.split(':').map(Number);
        return h * 60 + m;
    }

    function minutesToTime24(m) {
        const h = Math.floor(m / 60);
        const min = m % 60;
        return `${String(h).padStart(2, '0')}:${String(min).padStart(2, '0')}`;
    }

    function formatTime12h(t24) {
        const [h, m] = t24.split(':').map(Number);
        const ampm = h >= 12 ? 'PM' : 'AM';
        const h12 = h % 12 || 12;
        return `${h12}:${String(m).padStart(2, '0')} ${ampm}`;
    }

    function formatDateDisplay(date) {
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function generateFiveMinSlots(start24, end24) {
        const slots = [];
        let cur = timeToMinutes(start24);
        const end = timeToMinutes(end24);
        while (cur <= end) {
            const value = minutesToTime24(cur);
            slots.push({ value, label: formatTime12h(value) });
            cur += 5;
        }
        return slots;
    }

    function populateStartTimeOptions() {
        const startSelect = document.getElementById('booking-start');
        startSelect.innerHTML = '<option value="">Select time</option>';

        const seen = new Set();
        availableBlocks.forEach(block => {
            generateFiveMinSlots(block.start, block.end).forEach(slot => {
                if (seen.has(slot.value)) return;
                seen.add(slot.value);
                const opt = document.createElement('option');
                opt.value = slot.value;
                opt.textContent = slot.label;
                startSelect.appendChild(opt);
            });
        });
    }

    function onStartTimeChange() {
        const start = document.getElementById('booking-start').value;
        const endSelect = document.getElementById('booking-end');
        endSelect.innerHTML = '<option value="">Select time</option>';

        if (!start) {
            calculatePrice();
            return;
        }

        const startMins = timeToMinutes(start);
        const seen = new Set();

        availableBlocks.forEach(block => {
            const blockStart = timeToMinutes(block.start);
            const blockEnd = timeToMinutes(block.end);
            if (startMins < blockStart || startMins > blockEnd) return;

            generateFiveMinSlots(minutesToTime24(startMins + 5), block.end).forEach(slot => {
                if (seen.has(slot.value)) return;
                seen.add(slot.value);
                const opt = document.createElement('option');
                opt.value = slot.value;
                opt.textContent = slot.label;
                endSelect.appendChild(opt);
            });
        });

        calculatePrice();
    }

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;
        const grid = document.getElementById('calendar-days');
        grid.innerHTML = '';

        for (let i = 0; i < firstDay; i++) {
            const el = document.createElement('div');
            el.className = 'p-2 text-[10px] font-bold text-gray-200';
            el.textContent = daysInPrevMonth - firstDay + i + 1;
            grid.appendChild(el);
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

        const totalCells = firstDay + daysInMonth;
        const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
        for (let day = 1; day <= remaining; day++) {
            const el = document.createElement('div');
            el.className = 'p-2 text-[10px] font-bold text-gray-200';
            el.textContent = day;
            grid.appendChild(el);
        }
    }

    function changeMonth(delta) {
        currentDate.setMonth(currentDate.getMonth() + delta);
        renderCalendar();
    }

    async function selectDate(date) {
        selectedDate = date;
        currentDate = new Date(date.getFullYear(), date.getMonth(), 1);
        updateDateDisplay(date);
        renderCalendar();
        closeCalendar();
        document.getElementById('booking-actions').classList.add('hidden');
        document.getElementById('booking-start').innerHTML = '<option value="">Select time</option>';
        document.getElementById('booking-end').innerHTML = '<option value="">Select time</option>';
        document.getElementById('booking-price').textContent = '0 PKR';
        availableBlocks = [];
        fetchSlots(date);
    }

    function initBookingCalendar() {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        selectedDate = today;
        currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
        updateDateDisplay(today);
        renderCalendar();
        fetchSlots(today);

        document.addEventListener('click', function (e) {
            const calendarPart = document.querySelector('.calendar-part');
            if (calendarOpen && calendarPart && !calendarPart.contains(e.target)) {
                closeCalendar();
            }
        });
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
                availableBlocks = data.blocks;
                data.blocks.forEach(block => {
                    const el = document.createElement('div');
                    el.className = 'w-full p-2.5 rounded-xl border border-blue-100 bg-blue-50 text-blue-700 text-center mb-1 font-bold text-xs';
                    el.textContent = block.formatted;
                    container.appendChild(el);
                });
                populateStartTimeOptions();
                document.getElementById('booking-actions').classList.remove('hidden');
            } else {
                availableBlocks = [];
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
    document.addEventListener('DOMContentLoaded', initBookingCalendar);
</script>
