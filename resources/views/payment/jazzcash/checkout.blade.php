@extends('layouts.dashboard')

@section('title', 'Payment Checkout - JazzCash')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Secure Checkout</h1>
        <p class="text-gray-500 font-medium italic">Complete your payment via JazzCash to finalize your session.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Order Summary -->
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-6">Session Summary</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-4 border-b border-gray-50">
                        <span class="text-sm font-bold text-gray-500">Tutor</span>
                        <span class="text-sm font-black text-gray-900">{{ $booking->tutor->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-gray-50">
                        <span class="text-sm font-bold text-gray-500">Date</span>
                        <span class="text-sm font-black text-gray-900">{{ $booking->start_time->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-gray-50">
                        <span class="text-sm font-bold text-gray-500">Time</span>
                        <span class="text-sm font-black text-gray-900">{{ $booking->start_time->format('h:i A') }} - {{ $booking->end_time->format('h:i A') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-6">
                        <span class="text-lg font-black text-gray-900">Total Amount</span>
                        <span class="text-2xl font-black text-blue-600">PKR {{ number_format($booking->price_at_booking, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-blue-50 rounded-3xl border border-blue-100 flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-sm"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-blue-900 uppercase tracking-widest mb-1">Encrypted Payment</p>
                    <p class="text-[11px] font-bold text-blue-700 leading-relaxed">Your transaction is processed securely through JazzCash gateway. No card details are stored on our servers.</p>
                </div>
            </div>
        </div>

        <!-- Payment Action -->
        <div class="flex flex-col justify-center">
            <div class="bg-gray-900 p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 text-center">
                    <div class="mb-8 flex justify-center">
                        <!-- JazzCash Logo Placeholder Style -->
                        <div class="px-6 py-3 bg-white rounded-2xl">
                            <span class="text-xl font-black italic tracking-tighter text-red-600">Jazz</span><span class="text-xl font-black italic tracking-tighter text-gray-900">Cash</span>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-black tracking-tight mb-4">Pay with Wallet</h2>
                    <p class="text-sm font-medium text-gray-400 mb-10 leading-relaxed">
                        Click the button below to be redirected to JazzCash secure payment gateway.
                    </p>

                    <!-- Hidden Form for JazzCash Redirect -->
                    <form action="{{ $apiUrl }}" method="POST" id="jazzcash-form">
                        @foreach($paymentData as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <button type="submit" class="w-full py-5 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-[1.02] shadow-xl shadow-red-600/20 flex items-center justify-center gap-3">
                            <i class="fas fa-credit-card"></i> Redirect to JazzCash
                        </button>
                    </form>

                    <!-- Mock Helper -->
                    @if(config('services.jazzcash.mock', true))
                    <div class="mt-8 pt-8 border-t border-white/10">
                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-4">Developer Tools (Mock Mode)</p>
                        <a href="{{ route('payment.jazzcash.mock-success', $booking->id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600/20 hover:bg-emerald-600/40 text-emerald-400 rounded-xl font-black text-[11px] uppercase tracking-widest transition-all">
                             Simulate Successful Payment
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Decorative elements -->
                <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-red-600/20 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-600/10 rounded-full blur-2xl"></div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('student.dashboard') }}" class="text-[11px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel and return to dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
