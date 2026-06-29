@extends('layouts.dashboard')

@section('title', 'My Earnings - TutorHub')

@section('dashboard-content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2 uppercase tracking-tight">Financial Overview</h1>
        <p class="text-gray-500 font-medium italic">Track your earnings and pending settlements from JazzCash.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div class="bg-blue-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-500/20 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center">
                        <i class="fas fa-coins text-sm text-white"></i>
                    </div>
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] opacity-80">Total Revenue</h3>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black italic">PKR</span>
                    <span class="text-5xl font-black">{{ number_format($totalEarned) }}</span>
                </div>
                <p class="mt-6 text-xs font-bold text-blue-100 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> Successfully settled via JazzCash
                </p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>

        <div class="bg-gray-900 p-8 rounded-[2.5rem] text-white shadow-xl shadow-gray-500/10 border border-gray-800 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-white/5 flex items-center justify-center">
                        <i class="fas fa-clock text-sm text-amber-500"></i>
                    </div>
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Awaiting Settlement</h3>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black italic text-gray-500">PKR</span>
                    <span class="text-5xl font-black text-blue-500">{{ number_format($pendingPayments) }}</span>
                </div>
                <p class="mt-6 text-xs font-bold text-gray-500 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500"></i> Completed sessions pending student payment
                </p>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
        <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-50">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Recent Transactions</h3>
        </div>

        @if($bookings->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <i class="fas fa-file-invoice-dollar text-2xl"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">No transaction history yet</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="pb-6">Date</th>
                            <th class="pb-6">Student</th>
                            <th class="pb-6">Reference</th>
                            <th class="pb-6">Amount</th>
                            <th class="pb-6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-6">
                                    <p class="text-sm font-black text-gray-900">{{ $booking->updated_at->format('M d, Y') }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase">{{ $booking->updated_at->format('h:i A') }}</p>
                                </td>
                                <td class="py-6">
                                    <p class="text-sm font-bold text-gray-800">{{ $booking->student_name }}</p>
                                </td>
                                <td class="py-6">
                                    <p class="text-xs font-medium text-gray-500 font-mono tracking-tighter">{{ $booking->transaction_id ?: 'N/A' }}</p>
                                    <p class="text-[9px] font-black text-blue-500 uppercase tracking-widest">{{ $booking->payment_method ?: 'JazzCash' }}</p>
                                </td>
                                <td class="py-6">
                                    <p class="text-sm font-black text-gray-900">PKR {{ number_format($booking->price_at_booking) }}</p>
                                </td>
                                <td class="py-6 text-right">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest border
                                        {{ $booking->payment_status == 'paid' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                        {{ $booking->payment_status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="mt-8 pt-8 border-t border-gray-50">
                    {{ $bookings->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
