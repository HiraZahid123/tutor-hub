@extends('layouts.dashboard')
@section('title', 'Student Dashboard - TutorHub')

@section('dashboard-content')
<div class="max-w-5xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-1">My Learning Hub</h1>
        <p class="text-xs font-semibold text-slate-500">Manage your sessions and tutors in one place.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50/40 border border-emerald-100 text-emerald-700 p-4 rounded-xl mb-8 flex items-center gap-3 animate-in fade-in slide-in-from-top-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-xs font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Your Tutors -->
            @php
                $matchedTutors = $requests->where('status', 'matched')->map(fn($r) => $r->assignedTutor);
                $hiredInquiryTutors = $inquiries->map(fn($i) => $i->tutor);
                $assignedTutors = $matchedTutors->concat($hiredInquiryTutors)->filter()->unique('id');
                
                $completedTutorIds = $bookings->whereIn('status', ['confirmed', 'scheduled', 'completed'])
                    ->filter(fn($b) => $b->end_time < now())
                    ->pluck('tutor_id')->unique()->toArray();
            @endphp

            @if($assignedTutors->isNotEmpty())
            @php $isBlocked = \App\Models\Booking::hasUnpaidSessions(Auth::id()); @endphp
            <div id="tutors" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative scroll-mt-24">
                <div class="flex justify-between items-center mb-6 pb-3 border-b border-slate-100">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Your Tutors</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assignedTutors as $tutor)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/20 hover:border-blue-100 hover:bg-white transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border border-slate-100 shadow-sm group-hover:scale-105 transition-transform text-blue-600 font-bold text-lg italic">
                                    {{ substr($tutor->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 leading-none mb-1">{{ $tutor->name }}</h4>
                                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wide">{{ $tutor->title ?: 'Expert Tutor' }}</p>
                                </div>
                            </div>
                            @if($isBlocked)
                                <button type="button" disabled class="text-[8px] font-bold text-slate-400 bg-slate-100 border border-slate-200 px-3 py-1.5 rounded-lg uppercase tracking-wider cursor-not-allowed flex items-center gap-1.5">
                                    <i class="fas fa-lock text-[8px]"></i>
                                    Locked
                                </button>
                            @else
                                <div class="flex items-center gap-2">
                                    @if(in_array($tutor->id, $completedTutorIds))
                                        <button onclick="openRatingModal({{ $tutor->id }}, '{{ addslashes($tutor->name) }}')" class="text-[8px] font-bold text-amber-600 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-lg uppercase tracking-wider hover:bg-amber-600 hover:text-white transition-all shadow-sm">Rate</button>
                                    @endif
                                    <a href="{{ route('student.book', $tutor->id) }}" class="text-[8px] font-bold text-blue-600 bg-white border border-blue-100 px-3 py-1.5 rounded-lg uppercase tracking-wider hover:bg-blue-600 hover:text-white transition-all shadow-sm">Schedule</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Scheduled Sessions -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="flex justify-between items-center mb-6 pb-3 border-b border-slate-100">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Upcoming Sessions</h3>
                </div>

                @if($bookings->isEmpty())
                    <div class="py-12 text-center opacity-40">
                        <i class="far fa-calendar-times text-2xl text-slate-300 mb-3 block"></i>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Your calendar is clear</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($bookings as $booking)
                            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/20 hover:border-blue-100 hover:bg-white transition-all group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white rounded-lg flex flex-col items-center justify-center border border-slate-100 shadow-sm group-hover:scale-105 transition-transform shrink-0">
                                        <span class="text-[7px] font-bold text-blue-500 uppercase">{{ $booking->start_time->format('M') }}</span>
                                        <span class="text-xs font-bold text-slate-800 leading-none">{{ $booking->start_time->format('d') }}</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-xs font-bold text-slate-800">{{ $booking->tutor->name }}</h4>
                                            @if($booking->is_trial)
                                                <span class="bg-blue-50 text-blue-600 text-[7px] font-bold uppercase px-2 py-0.5 rounded-full border border-blue-100">Trial</span>
                                            @endif
                                        </div>
                                        <p class="text-[9px] font-semibold text-slate-400 mt-0.5">{{ $booking->start_time->format('g:i A') }} • {{ $booking->status }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($booking->is_trial)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[8px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">
                                            Free Demo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[8px] font-bold uppercase tracking-wider 
                                            {{ $booking->status == 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 
                                               ($booking->status == 'confirmed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100') }}">
                                            {{ $booking->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <div class="space-y-6">
            <!-- Pending Payments -->
            @php
                $unpaidBookings = $bookings->whereIn('status', ['confirmed', 'scheduled', 'completed'])
                    ->where('payment_status', 'unpaid')
                    ->where('is_trial', false);
                $blockedBookings = $unpaidBookings->filter(fn($b) => $b->end_time < now());
            @endphp

            @if($unpaidBookings->isNotEmpty())
            <div class="bg-slate-900 p-8 rounded-2xl text-white shadow-md relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6 pb-2 border-b border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center {{ $blockedBookings->isNotEmpty() ? 'animate-pulse' : '' }}">
                            <i class="fas fa-wallet text-xs"></i>
                        </div>
                        <h3 class="text-[10px] font-bold uppercase tracking-widest">Pending Payments</h3>
                    </div>

                    @if($blockedBookings->isNotEmpty())
                        <div class="mb-4 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl">
                            <p class="text-[9px] font-bold text-rose-400 uppercase tracking-wider mb-0.5">Action Required</p>
                            <p class="text-xs font-semibold text-slate-300">Your account is restricted. Settle dues to book new sessions.</p>
                        </div>
                    @endif

                    <div class="space-y-3 mb-6">
                        @foreach($unpaidBookings as $ub)
                        <div class="flex justify-between items-center bg-white/5 p-4 rounded-xl border border-white/5 hover:bg-white/10 transition-colors">
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">{{ $ub->tutor->name }}</p>
                                <p class="text-xs font-bold mt-0.5">{{ $ub->start_time->format('M d, h:i A') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-blue-400">PKR {{ number_format($ub->price_at_booking) }}</p>
                                <a href="{{ route('payment.jazzcash.checkout', $ub->id) }}" class="text-[8px] font-bold text-white bg-blue-600 px-2.5 py-1 rounded uppercase tracking-wider mt-1 inline-block hover:bg-blue-700 transition-colors">Pay</a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <p class="text-[9px] font-bold text-slate-500 italic leading-relaxed">
                        Please settle your dues via JazzCash to continue booking sessions with our elite tutors.
                    </p>
                </div>
                <!-- Decorative element -->
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all"></div>
            </div>
            @endif

            <!-- Welcome Info Card -->
            <div class="bg-blue-600 p-8 rounded-2xl text-white shadow-sm">
                <h3 class="text-[9px] font-bold uppercase tracking-wider mb-3 opacity-60">Study Tip</h3>
                <p class="text-xs font-semibold leading-relaxed">Consistency is key! Try to book at least 2 sessions per week to see maximum results in {{ $requests->first() ? (is_array($requests->first()->subject) ? implode(', ', $requests->first()->subject) : $requests->first()->subject) : 'your subjects' }}.</p>
            </div>
        </div>
    </div>
</div>

@push('modals')
<!-- Rating Modal -->
<div id="rating-modal" class="fixed inset-0 hidden flex items-center justify-center p-4" style="z-index: 99999;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeRatingModal()"></div>
    <div class="bg-white rounded-2xl w-full max-w-md relative z-10 shadow-2xl overflow-hidden border border-slate-100">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Rate Your Tutor</h3>
                <p id="rating-tutor-name" class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1"></p>
            </div>
            <button onclick="closeRatingModal()" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:text-red-500 transition-all flex items-center justify-center">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        
        <form action="{{ route('tutor-reviews.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="tutor_id" id="rating-tutor-id">
            
            <div class="mb-6">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 text-center">Your Rating</label>
                <div class="flex items-center justify-center gap-1.5">
                    @foreach(range(1, 5) as $star)
                        <button type="button" onclick="setRating({{ $star }})" class="star-btn text-2xl text-slate-200 hover:text-amber-400 transition-colors" data-rating="{{ $star }}">
                            <i class="fas fa-star"></i>
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="rating" id="rating-input" required>
            </div>

            <div class="mb-6">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Feedback (Optional)</label>
                <textarea name="comment" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-xl p-3 text-xs font-semibold text-slate-700 focus:ring-4 focus:ring-blue-500/5 focus:bg-white focus:border-blue-500/30 transition-all outline-none resize-none" placeholder="How was your learning experience?"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-3 font-bold text-[10px] uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all">Submit Review</button>
        </form>
    </div>
</div>
@endpush

<script>
    function openRatingModal(tutorId, tutorName) {
        document.getElementById('rating-tutor-id').value = tutorId;
        document.getElementById('rating-tutor-name').innerText = tutorName;
        document.getElementById('rating-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setRating(0); // Reset
    }

    function closeRatingModal() {
        document.getElementById('rating-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function setRating(rating) {
        document.getElementById('rating-input').value = rating > 0 ? rating : '';
        document.querySelectorAll('.star-btn').forEach(btn => {
            const btnRating = parseInt(btn.dataset.rating);
            if (btnRating <= rating) {
                btn.classList.remove('text-slate-200');
                btn.classList.add('text-amber-400');
            } else {
                btn.classList.add('text-slate-200');
                btn.classList.remove('text-amber-400');
            }
        });
    }
</script>
@endsection
