@props(['tutorId', 'currency' => 'PKR'])

<div class="schedule-container max-w-4xl mx-auto relative">
    <div id="schedule-loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center hidden rounded-3xl">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            <p class="text-xs font-semibold text-slate-500">Loading availability...</p>
        </div>
    </div>

    <div class="rounded-[2rem] p-5 md:p-8 shadow-xl shadow-sky-200/40 border border-sky-100" style="background-color: #e1f5fe;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            <!-- Left: Date -->
            <div class="calendar-part relative bg-white rounded-2xl p-5 shadow-sm border border-sky-50">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                        <i class="fas fa-calendar-day text-sm"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Step 1</p>
                        <h3 class="text-sm font-bold text-slate-800">Choose Date</h3>
                    </div>
                </div>

                <button type="button" id="date-picker-toggle" onclick="toggleCalendar()"
                    class="w-full p-4 rounded-xl border-2 border-sky-100 bg-sky-50/50 text-left hover:border-sky-300 hover:bg-sky-50 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all group">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-sky-600 block mb-1">Date</span>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-calendar text-sky-500 text-base"></i>
                            <span id="selected-date-formatted" class="text-base font-bold text-slate-800">—</span>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 text-xs group-hover:text-blue-500 transition-colors" id="calendar-chevron"></i>
                    </div>
                </button>

                <div id="calendar-dropdown" class="hidden mt-3 p-4 rounded-xl border border-sky-100 bg-white shadow-inner">
                    <div class="flex items-center justify-between mb-4">
                        <h3 id="current-month" class="text-sm font-bold text-slate-800">March 2026</h3>
                        <div class="flex gap-1">
                            <button type="button" onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center hover:bg-sky-50 rounded-lg transition-all text-slate-500 hover:text-blue-600">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                            <button type="button" onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center hover:bg-sky-50 rounded-lg transition-all text-slate-500 hover:text-blue-600">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 mb-2 text-center">
                        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $day)
                            <div class="text-[10px] font-bold text-slate-400 uppercase py-1">{{ $day }}</div>
                        @endforeach
                    </div>

                    <div id="calendar-days" class="grid grid-cols-7 gap-1 text-center"></div>
                </div>
            </div>

            <!-- Right: Time -->
            <div class="slots-part bg-white rounded-2xl p-5 shadow-sm border border-sky-50">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Step 2</p>
                        <h3 class="text-sm font-bold text-slate-800">Pick Your Time</h3>
                    </div>
                </div>

                <p class="text-[11px] font-semibold text-sky-600 uppercase tracking-wide mb-2">Available Slots</p>
                <div id="slots-container" class="space-y-2 max-h-28 overflow-y-auto pr-1 custom-scrollbar mb-5">
                    <div class="py-6 text-center rounded-xl border border-dashed border-sky-200 bg-sky-50/30">
                        <i class="fas fa-spinner fa-spin text-sky-300 mb-2"></i>
                        <p class="text-[10px] text-slate-400 font-semibold">Loading slots...</p>
                    </div>
                </div>

                <div id="booking-actions" class="hidden">
                    @auth
                        <div class="space-y-4 p-4 rounded-xl bg-slate-50/80 border border-slate-100">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 rounded-xl border border-white bg-white shadow-sm">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-2">Start Time</span>
                                    <div class="relative">
                                        <i class="fas fa-clock absolute left-0 top-1/2 -translate-y-1/2 text-sky-400 text-sm"></i>
                                        <select id="booking-start" onchange="onStartTimeChange()"
                                            class="time-select w-full pl-6 pr-6 py-1 bg-transparent border-0 text-sm font-bold text-slate-800 focus:ring-0 cursor-pointer appearance-none">
                                            <option value="">Select time</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-0 top-1/2 -translate-y-1/2 text-slate-300 text-[10px] pointer-events-none"></i>
                                    </div>
                                </div>
                                <div class="p-3 rounded-xl border border-white bg-white shadow-sm">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-2">End Time</span>
                                    <div class="relative">
                                        <i class="fas fa-clock absolute left-0 top-1/2 -translate-y-1/2 text-sky-400 text-sm"></i>
                                        <select id="booking-end" onchange="calculatePrice()"
                                            class="time-select w-full pl-6 pr-6 py-1 bg-transparent border-0 text-sm font-bold text-slate-800 focus:ring-0 cursor-pointer appearance-none">
                                            <option value="">Select time</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-0 top-1/2 -translate-y-1/2 text-slate-300 text-[10px] pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-200/80">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Estimated Amount</span>
                                <span id="booking-price" class="text-xl font-black text-blue-600">0 {{ $currency }}</span>
                            </div>
                        </div>

                        <div class="space-y-3 mt-4">
                            <textarea id="booking-notes" placeholder="Add notes for your tutor (optional)..." rows="3"
                                class="w-full bg-white p-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 text-sm text-slate-700 placeholder:text-slate-400 transition-all resize-none"></textarea>
                            <button onclick="confirmBooking()"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 active:scale-[0.98]">
                                <i class="fas fa-bolt text-amber-300"></i>
                                Confirm Session
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Working Hours -->
        <div class="mt-6 pt-6 border-t border-sky-200/60">
            <div class="flex items-center justify-center gap-2 mb-4">
                <i class="fas fa-business-time text-sky-500 text-sm"></i>
                <h5 class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em]">Tutor Weekly Schedule</h5>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2">
                @php
                    $refDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    $tutorAvails = \App\Models\TutorAvailability::where('tutor_id', $tutorId)->get();
                @endphp
                @foreach($refDays as $day)
                    @php $dayAvail = $tutorAvails->where('day_of_week', $day)->first(); @endphp
                    <div class="p-3 rounded-xl text-center transition-all {{ $dayAvail ? 'bg-white border border-sky-100 shadow-sm' : 'bg-white/40 border border-transparent opacity-50' }}">
                        <p class="text-[10px] font-black text-blue-600 uppercase mb-1">{{ substr($day, 0, 3) }}</p>
                        @if($dayAvail)
                            <p class="text-[10px] font-semibold text-slate-600 leading-tight">{{ \Carbon\Carbon::parse($dayAvail->start_time)->format('g:i A') }}<br><span class="text-slate-300">–</span><br>{{ \Carbon\Carbon::parse($dayAvail->end_time)->format('g:i A') }}</p>
                        @else
                            <p class="text-[10px] font-bold text-slate-400">Off</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Success Overlay -->
    <div id="booking-success" class="absolute inset-0 rounded-[2rem] bg-white/95 backdrop-blur-md hidden flex flex-col items-center justify-center p-8 text-center z-[60]">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-5 shadow-lg shadow-emerald-100">
            <i class="fas fa-check text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-2">Session Requested!</h3>
        <p class="text-sm text-slate-500 mb-8 max-w-xs">Your booking request has been sent. Check your dashboard for updates.</p>
        <button onclick="location.reload()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl transition-all shadow-md">
            Done
        </button>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #bae6fd; border-radius: 10px; }
    .time-select option { font-weight: 600; padding: 8px; }
</style>

<script>
    let currentDate = new Date();
    let selectedDate = null;
    let calendarOpen = false;
    let hourlyRate = 0;
    let tutorCurrency = @json($currency);
    let availableBlocks = [];
    const tutorId = {{ $tutorId }};

    function formatPrice(amount) {
        return `${Math.round(amount).toLocaleString()} ${tutorCurrency}`;
    }

    function toggleCalendar() {
        const dropdown = document.getElementById('calendar-dropdown');
        const chevron = document.getElementById('calendar-chevron');
        calendarOpen = !calendarOpen;
        dropdown.classList.toggle('hidden', !calendarOpen);
        if (chevron) chevron.classList.toggle('rotate-180', calendarOpen);
    }

    function closeCalendar() {
        calendarOpen = false;
        document.getElementById('calendar-dropdown').classList.add('hidden');
        const chevron = document.getElementById('calendar-chevron');
        if (chevron) chevron.classList.remove('rotate-180');
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
        if (!start) { calculatePrice(); return; }

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
            el.className = 'py-2 text-xs font-medium text-slate-300';
            el.textContent = daysInPrevMonth - firstDay + i + 1;
            grid.appendChild(el);
        }

        const today = new Date(); today.setHours(0,0,0,0);
        for (let day = 1; day <= daysInMonth; day++) {
            const dateObj = new Date(year, month, day);
            const isPast = dateObj < today;
            const isSelected = selectedDate && dateObj.getTime() === selectedDate.getTime();
            const isToday = dateObj.getTime() === today.getTime();
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `py-2 text-xs font-bold rounded-full transition-all
                ${isPast ? 'text-slate-200 cursor-default' :
                (isSelected ? 'bg-blue-600 text-white shadow-md shadow-blue-300/50 scale-110' :
                (isToday ? 'bg-sky-100 text-blue-600 ring-2 ring-blue-200' : 'text-slate-700 hover:bg-sky-50 hover:text-blue-600'))}`;
            btn.textContent = day;
            if (!isPast) btn.onclick = () => selectDate(dateObj);
            grid.appendChild(btn);
        }

        const totalCells = firstDay + daysInMonth;
        const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
        for (let day = 1; day <= remaining; day++) {
            const el = document.createElement('div');
            el.className = 'py-2 text-xs font-medium text-slate-300';
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
        document.getElementById('booking-price').textContent = `0 ${tutorCurrency}`;
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
                if (data.currency) tutorCurrency = data.currency;
                availableBlocks = data.blocks;
                data.blocks.forEach(block => {
                    const el = document.createElement('div');
                    el.className = 'flex items-center gap-2 w-full px-4 py-2.5 rounded-xl bg-gradient-to-r from-sky-50 to-blue-50 border border-sky-100 text-blue-700 font-semibold text-sm';
                    el.innerHTML = `<i class="fas fa-clock text-sky-400 text-xs"></i> ${block.formatted}`;
                    container.appendChild(el);
                });
                populateStartTimeOptions();
                document.getElementById('booking-actions').classList.remove('hidden');
            } else {
                availableBlocks = [];
                container.innerHTML = `
                    <div class="py-8 text-center rounded-xl border border-dashed border-slate-200 bg-slate-50/50">
                        <i class="fas fa-calendar-times text-slate-300 text-xl mb-2"></i>
                        <p class="text-xs text-slate-400 font-semibold">No availability on this date</p>
                    </div>`;
                document.getElementById('booking-actions').classList.add('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            container.innerHTML = '<p class="text-center text-red-500 text-xs font-semibold py-4">Failed to load slots</p>';
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
            document.getElementById('booking-price').textContent = formatPrice(price);
        } else {
            document.getElementById('booking-price').textContent = `0 ${tutorCurrency}`;
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
