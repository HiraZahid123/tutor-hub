@extends('layouts.dashboard')
@section('title', 'Student Dashboard - TutorHub')

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2">My Learning Hub</h1>
        <p class="text-gray-500 font-medium">Manage your sessions and tutors in one place.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50/50 border border-green-100 text-green-700 p-5 rounded-3xl mb-8 flex items-center gap-3 animate-in fade-in slide-in-from-top-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Your Tutors -->
            @php
                $matchedTutors = $requests->where('status', 'matched')->map(fn($r) => $r->assignedTutor);
                $hiredInquiryTutors = $inquiries->map(fn($i) => $i->tutor);
                $assignedTutors = $matchedTutors->concat($hiredInquiryTutors)->filter()->unique('id');
                
                // A session is naturally considered completed if it was confirmed/scheduled and its end time has passed
                $completedTutorIds = $bookings->whereIn('status', ['confirmed', 'scheduled', 'completed'])
                    ->filter(fn($b) => $b->end_time < now())
                    ->pluck('tutor_id')->unique()->toArray();
            @endphp

            @if($assignedTutors->isNotEmpty())
            @php $isBlocked = \App\Models\Booking::hasUnpaidSessions(Auth::id()); @endphp
            <div id="tutors" class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden relative scroll-mt-24">
                <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-50">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Your Tutors</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assignedTutors as $tutor)
                        <div class="flex items-center justify-between p-5 rounded-3xl border border-gray-50 bg-gray-50/30 hover:border-blue-100 transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center border border-gray-100 shadow-sm group-hover:shadow-md transition-all text-blue-600 font-black text-xl italic">
                                    {{ substr($tutor->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-gray-900 leading-none mb-1">{{ $tutor->name }}</h4>
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $tutor->title ?: 'Expert Tutor' }}</p>
                                </div>
                            </div>
                            @if($isBlocked)
                                <button type="button" disabled class="text-[9px] font-black text-gray-400 bg-gray-100 border border-gray-200 px-4 py-2 rounded-xl uppercase tracking-widest cursor-not-allowed flex items-center gap-2">
                                    <i class="fas fa-lock text-[8px]"></i>
                                    Locked
                                </button>
                            @else
                                <div class="flex items-center gap-2">
                                    @if(in_array($tutor->id, $completedTutorIds))
                                        <button onclick="openRatingModal({{ $tutor->id }}, '{{ addslashes($tutor->name) }}')" class="text-[9px] font-black text-amber-600 bg-amber-50 border border-amber-100 px-4 py-2 rounded-xl uppercase tracking-widest hover:bg-amber-600 hover:text-white transition-all shadow-sm">Rate</button>
                                    @endif
                                    <a href="{{ route('student.book', $tutor->id) }}" class="text-[9px] font-black text-blue-600 bg-white border border-blue-100 px-4 py-2 rounded-xl uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all shadow-sm">Schedule</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Scheduled Sessions -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden relative">
                <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-50">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Upcoming Sessions</h3>
                </div>

                @if($bookings->isEmpty())
                    <div class="py-16 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Your calendar is clear</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="flex items-center justify-between p-5 rounded-3xl border border-gray-50 bg-gray-50/30 hover:border-blue-100 transition-all group">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex flex-col items-center justify-center border border-gray-100 shadow-sm group-hover:shadow-md transition-all">
                                        <span class="text-[8px] font-black text-blue-500 uppercase">{{ $booking->start_time->format('M') }}</span>
                                        <span class="text-sm font-black text-gray-900 leading-none">{{ $booking->start_time->format('d') }}</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-black text-gray-900">{{ $booking->tutor->name }}</h4>
                                            @if($booking->is_trial)
                                                <span class="bg-blue-100 text-blue-600 text-[7px] font-black uppercase px-2 py-0.5 rounded-full border border-blue-200">Trial</span>
                                            @endif
                                        </div>
                                        <p class="text-[10px] font-bold text-gray-400 mt-0.5">{{ $booking->start_time->format('g:i A') }} • {{ $booking->status }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($booking->is_trial)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-2xl text-[8px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100">
                                            Free Demo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-2xl text-[8px] font-black uppercase tracking-widest 
                                            {{ $booking->status == 'pending' ? 'bg-yellow-50 text-yellow-600 border border-yellow-100' : 
                                               ($booking->status == 'confirmed' ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-red-50 text-red-600 border border-red-100') }}">
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

        <div class="space-y-8">
            <!-- Pending Payments -->
            @php
                $unpaidBookings = $bookings->whereIn('status', ['confirmed', 'scheduled', 'completed'])
                    ->where('payment_status', 'unpaid')
                    ->where('is_trial', false); // <--- HIDE TRIALS FROM SIDEBAR
                // A session is blocked if it matches the refined hasUnpaidSessions criteria
                $blockedBookings = $unpaidBookings->filter(fn($b) => $b->end_time < now());
            @endphp

            @if($unpaidBookings->isNotEmpty())
            <div class="bg-gray-900 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-500/10 border border-gray-800 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-red-500 text-white flex items-center justify-center {{ $blockedBookings->isNotEmpty() ? 'animate-pulse' : '' }}">
                            <i class="fas fa-wallet text-xs"></i>
                        </div>
                        <h3 class="text-xs font-black uppercase tracking-[0.2em]">Pending Payments</h3>
                    </div>

                    @if($blockedBookings->isNotEmpty())
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
                            <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1 font-italic">Action Required</p>
                            <p class="text-xs font-bold text-gray-200">Your account is restricted. Settle dues to book new sessions.</p>
                        </div>
                    @endif

                    <div class="space-y-4 mb-8">
                        @foreach($unpaidBookings as $ub)
                        <div class="flex justify-between items-center bg-white/5 p-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-colors">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $ub->tutor->name }}</p>
                                <p class="text-xs font-bold">{{ $ub->start_time->format('M d, h:i A') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-blue-400">PKR {{ number_format($ub->price_at_booking) }}</p>
                                <a href="{{ route('payment.jazzcash.checkout', $ub->id) }}" class="text-[9px] font-black text-white bg-blue-600 px-3 py-1.5 rounded-lg uppercase tracking-widest mt-1 inline-block hover:bg-blue-700 transition-colors">Pay Now</a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <p class="text-[10px] font-bold text-gray-500 italic leading-relaxed">
                        Please settle your dues via JazzCash to continue booking sessions with our elite tutors.
                    </p>
                </div>
                <!-- Decorative element -->
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl group-hover:bg-blue-600/20 transition-all"></div>
            </div>
            @endif

            <!-- Welcome Info Card -->
            <div class="bg-blue-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-500/20">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] mb-4 opacity-60">Study Tip</h3>
                <p class="text-sm font-bold leading-relaxed">Consistency is key! Try to book at least 2 sessions per week to see maximum results in {{ $requests->first() ? (is_array($requests->first()->subject) ? implode(', ', $requests->first()->subject) : $requests->first()->subject) : 'your subjects' }}.</p>
            </div>
        </div>
    </div>
</div>

@push('modals')
<!-- Rating Modal -->
<div id="rating-modal" class="fixed inset-0 hidden flex items-center justify-center p-4" style="z-index: 99999;">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeRatingModal()"></div>
    <div class="bg-white rounded-[2.5rem] w-full max-w-md relative z-10 shadow-2xl overflow-hidden border border-gray-100">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Rate Your Tutor</h3>
                <p id="rating-tutor-name" class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1"></p>
            </div>
            <button onclick="closeRatingModal()" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:text-red-500 transition-all flex items-center justify-center">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        
        <form action="{{ route('tutor-reviews.store') }}" method="POST" class="p-8">
            @csrf
            <input type="hidden" name="tutor_id" id="rating-tutor-id">
            
            <div class="mb-8">
                <label class="block text-[10px] font-black text-gray-900 uppercase tracking-widest mb-4 text-center">Your Rating</label>
                <div class="flex items-center justify-center gap-2">
                    @foreach(range(1, 5) as $star)
                        <button type="button" onclick="setRating({{ $star }})" class="star-btn text-3xl text-gray-200 hover:text-amber-400 transition-colors" data-rating="{{ $star }}">
                            <i class="fas fa-star"></i>
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="rating" id="rating-input" required>
            </div>

            <div class="mb-8">
                <label class="block text-[10px] font-black text-gray-900 uppercase tracking-widest mb-3">Feedback (Optional)</label>
                <textarea name="comment" rows="4" class="w-full bg-gray-50/50 border border-gray-100 rounded-2xl p-4 text-xs font-medium text-gray-800 focus:ring-4 focus:ring-blue-500/5 focus:bg-white focus:border-blue-500/30 transition-all outline-none resize-none" placeholder="How was your learning experience?"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white rounded-2xl py-4 font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-blue-500/20 hover:bg-blue-700 hover:-translate-y-1 transition-all">Submit Review</button>
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
                btn.classList.remove('text-gray-200');
                btn.classList.add('text-amber-400');
            } else {
                btn.classList.add('text-gray-200');
                btn.classList.remove('text-amber-400');
            }
        });
    }
</script>
@endsection
