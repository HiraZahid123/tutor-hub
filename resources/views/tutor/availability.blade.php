@extends('layouts.dashboard')

@section('title', 'Manage Availability - Tutor Hub')

@section('dashboard-content')
<div class="max-w-5xl">
    <div class="bg-white rounded-3xl shadow-xl p-6 md:p-10 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-4">
                <div>
                    <h1 class="text-2xl font-black text-gray-900 mb-1 uppercase tracking-tight">Set Your Schedule</h1>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-widest">Define your weekly working hours</p>
                </div>
            </div>

            <style>
                .duration-radio:checked + .duration-label {
                    background-color: #2563eb !important;
                    color: white !important;
                    border-color: #2563eb !important;
                }
                .duration-radio:checked + .duration-label svg {
                    display: block !important;
                }
            </style>

            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-xs font-bold uppercase tracking-wide">{{ session('success') }}</p>
                </div>
            @endif

            @if($tutor)
                <form action="{{ route('tutor.availability.store') }}" method="POST">
                    @csrf
                    
                    <!-- Compact Slot Duration -->
                    <div class="mb-10 p-6 bg-blue-50/50 rounded-3xl border border-blue-100 flex flex-wrap items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest leading-none mb-1">Session Length</p>
                                <p class="text-xs font-bold text-gray-700">Set your default slot duration</p>
                            </div>
                        </div>
                        <div class="flex gap-2 bg-white p-1.5 rounded-2xl border border-blue-100 shadow-sm">
                            @foreach([30, 45, 60, 90] as $dur)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="slot_duration" value="{{ $dur }}" class="sr-only duration-radio" {{ old('slot_duration', $availabilities->first()->slot_duration ?? 60) == $dur ? 'checked' : '' }}>
                                    <div class="duration-label px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 transition-all duration-300 hover:bg-gray-50 flex items-center gap-2">
                                        <svg class="w-3 h-3 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        {{ $dur }}m
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2-Column Days Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-5" id="slots-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                        @foreach($days as $index => $day)
                            @php $isSunday = $loop->last; @endphp
                            <div class="day-row p-8 bg-white border border-gray-100 rounded-[2.5rem] hover:border-blue-400 transition-all duration-500 shadow-sm hover:shadow-2xl group/card" 
                                 style="{{ $isSunday ? 'grid-column: 1 / -1; margin-left: auto; margin-right: auto; max-width: 500px; width: 100%;' : '' }}">
                                @php $daySlots = $availabilities->where('day_of_week', $day); @endphp
                                <div class="flex items-center justify-between mb-8">
                                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-3">
                                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-sm shadow-blue-500/50 group-hover/card:scale-125 transition-transform"></span>
                                        {{ $day }}
                                    </h3>
                                    <button type="button" onclick="addSlot('{{ $day }}')" 
                                            class="text-[9px] font-black text-blue-600 bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-600 hover:text-white transition-all uppercase tracking-widest border border-blue-100/50 shadow-sm active:scale-95">
                                        + Add Slot
                                    </button>
                                </div>

                                <div id="slots-{{ $day }}" class="space-y-3">
                                    @forelse($daySlots as $index => $slot)
                                        <div class="flex items-center gap-3 bg-gray-50/50 p-2 rounded-2xl border border-dashed border-gray-200 group transition-all hover:bg-white hover:border-blue-100">
                                            <div class="flex items-center gap-2 flex-grow">
                                                <input type="time" name="slots[{{ $day }}_{{ $index }}][start]" value="{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}"
                                                       class="flex-1 p-2 text-xs rounded-xl border-none focus:ring-0 bg-transparent font-black text-gray-700">
                                                <span class="text-[9px] font-black text-gray-300">➜</span>
                                                <input type="time" name="slots[{{ $day }}_{{ $index }}][end]" value="{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}"
                                                       class="flex-1 p-2 text-xs rounded-xl border-none focus:ring-0 bg-transparent font-black text-gray-700">
                                            </div>
                                            <input type="hidden" name="slots[{{ $day }}_{{ $index }}][day]" value="{{ $day }}">
                                            <button type="button" onclick="this.parentElement.remove()" class="text-gray-300 hover:text-red-500 transition-colors p-1 pr-2">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @empty
                                        <div class="py-6 text-center border-2 border-dashed border-gray-50 rounded-2xl">
                                            <p class="text-[9px] text-gray-300 font-bold uppercase tracking-widest italic">Offline</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 flex justify-center">
                        <button type="submit" class="bg-blue-600 text-white px-12 py-5 rounded-full font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-2xl shadow-blue-600/30 transition-all flex items-center gap-3 transform hover:-translate-y-1 active:translate-y-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Save Master Schedule
                        </button>
                    </div>
                </form>
            @else
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 mb-4 uppercase tracking-tight">Schedule Not Available</h2>
                    <p class="text-gray-500 font-medium mb-10 max-w-sm mx-auto leading-relaxed">You must be an active tutor to set your availability. Apply now to start your journey with us!</p>
                    <a href="{{ route('register-tutor') }}" class="inline-block bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-500/30 hover:bg-blue-700 transition-all transform hover:-translate-y-1">Become a Tutor</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    let slotIndex = 1000;

    function addSlot(day) {
        const container = document.getElementById(`slots-${day}`);
        const emptyMsg = container.querySelector('div.py-6');
        if (emptyMsg) emptyMsg.remove();

        const id = `${day}_${++slotIndex}`;
        const html = `
            <div class="flex items-center gap-3 bg-blue-50/20 p-2 rounded-2xl border border-dashed border-blue-200 group transition-all hover:bg-white animate-in zoom-in-95 duration-200">
                <div class="flex items-center gap-2 flex-grow">
                    <input type="time" name="slots[${id}][start]" required
                           class="flex-1 p-2 text-xs rounded-xl border-none focus:ring-0 bg-transparent font-black text-blue-600">
                    <span class="text-[9px] font-black text-blue-200">➜</span>
                    <input type="time" name="slots[${id}][end]" required
                           class="flex-1 p-2 text-xs rounded-xl border-none focus:ring-0 bg-transparent font-black text-blue-600">
                </div>
                <input type="hidden" name="slots[${id}][day]" value="${day}">
                <button type="button" onclick="this.parentElement.remove()" class="text-blue-200 hover:text-red-500 transition-colors p-1 pr-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }
</script>
@endsection
