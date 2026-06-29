@extends('layouts.admin')

@section('title', 'Platform Revenue - TutorHub')

@section('content')
<div class="space-y-8">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Financial Oversight</h2>
            <p class="text-gray-500 font-medium">Monitor every JazzCash transaction and platform settlement across the portal.</p>
        </div>
        
        <div class="px-6 py-3 bg-white rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Revenue</p>
                <p class="text-xl font-black text-blue-600 tracking-tight">PKR {{ number_format($totalRevenue) }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-blue-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-500/20 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center text-white">
                        <i class="fas fa-university text-sm"></i>
                    </div>
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] opacity-80">Total Platform Revenue</h3>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black italic">PKR</span>
                    <span class="text-5xl font-black">{{ number_format($totalRevenue) }}</span>
                </div>
                <p class="mt-6 text-[10px] font-black uppercase tracking-widest text-blue-100 italic">
                    Successfully received from {{ $totalTransactions }} sessions
                </p>
            </div>
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-all"></div>
        </div>

        <div class="bg-gray-900 p-8 rounded-[2.5rem] text-white shadow-xl shadow-gray-500/10 border border-gray-800 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-white/5 flex items-center justify-center">
                        <i class="fas fa-hand-holding-usd text-sm text-amber-500"></i>
                    </div>
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Pending Settlements</h3>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black italic text-gray-500">PKR</span>
                    <span class="text-5xl font-black text-blue-500">{{ number_format($pendingSettlements) }}</span>
                </div>
                <p class="mt-6 text-[10px] font-black uppercase tracking-widest text-gray-500 italic">
                    Unpaid dues from confirmed sessions
                </p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 flex flex-col justify-center">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Platform Fee Structure</h3>
            <p class="text-sm font-bold text-gray-600 leading-relaxed mb-4">
                All JazzCash payments go straight to the platform account.
            </p>
            <div class="pt-4 border-t border-gray-50 flex items-center gap-2">
                <div class="px-2 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-black uppercase">Active Oversight</div>
                <div class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase">Audited Logs</div>
            </div>
        </div>
    </div>

    <!-- Transaction Log -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
        <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-50">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Comprehensive Transaction Log</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date / Time</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Student</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tutor</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">JazzCash Ref</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <p class="text-sm font-black text-gray-900">{{ $tx->updated_at->format('M d, Y') }}</p>
                                <p class="text-[9px] font-bold text-gray-400 uppercase">{{ $tx->updated_at->format('H:i A') }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-bold text-gray-800">{{ $tx->student->name }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-bold text-gray-800">{{ $tx->tutor->name }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs font-medium text-gray-500 font-mono tracking-tighter">{{ $tx->transaction_id ?: 'MANUAL/PENDING' }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-black text-gray-900">PKR {{ number_format($tx->price_at_booking) }}</p>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest border
                                    {{ $tx->payment_status == 'paid' ? 'bg-green-50 text-green-600 border-green-100' : 
                                       ($tx->payment_status == 'failed' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-amber-50 text-amber-600 border-amber-100') }}">
                                    {{ $tx->payment_status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <i class="fas fa-file-invoice-dollar text-4xl text-gray-100 mb-4 block"></i>
                                <span class="text-[10px] font-black uppercase text-gray-300 tracking-widest">No financial activities recorded yet</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="mt-8 pt-8 border-t border-gray-50">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
