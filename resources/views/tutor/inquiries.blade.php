@extends('layouts.dashboard')
@section('title', 'Hire Inquiries - TutorHub')

@section('dashboard-content')
<div class="max-w-5xl">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2">Hire Inquiries</h1>
        <p class="text-gray-500 font-medium">Manage direct tutoring requests from potential students.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-50">
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Student</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Subjects</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Format</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Message</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Received</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50/30 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-black text-xs border border-blue-100 italic">
                                        {{ substr($inquiry->student->name ?? 'S', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-900">{{ $inquiry->student->name ?? 'Guest/Unknown' }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">{{ $inquiry->student->email ?? 'no-email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                    @if(is_array($inquiry->subjects))
                                        @foreach($inquiry->subjects as $subject)
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[8px] font-black uppercase tracking-tight rounded-lg border border-gray-200">
                                                {{ $subject }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    @if($inquiry->hiring_type === 'home')
                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <i class="fas fa-home text-[10px]"></i>
                                        </div>
                                        <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">Home</span>
                                    @else
                                        <div class="w-6 h-6 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                            <i class="fas fa-globe text-[10px]"></i>
                                        </div>
                                        <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest">Online</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="max-w-[200px]">
                                    @if($inquiry->message)
                                        <p class="text-xs text-gray-600 line-clamp-1 leading-relaxed font-medium italic mb-1">
                                            "{{ $inquiry->message }}"
                                        </p>
                                        <button onclick="showMessageModal('{{ addslashes($inquiry->student->name ?? 'Student') }}', `{{ addslashes($inquiry->message) }}`)" 
                                                class="text-[8px] font-black text-blue-500 uppercase tracking-widest hover:text-blue-700 transition-all">
                                            View Full Message →
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-300 italic">No message</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest">{{ $inquiry->created_at->format('M d, Y') }}</p>
                                <p class="text-[9px] text-gray-300 font-bold uppercase tracking-tight">{{ $inquiry->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($inquiry->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('tutor.inquiries.update', $inquiry->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 border border-green-100 hover:bg-green-500 hover:text-white hover:border-green-500 transition-all flex items-center justify-center" title="Accept Request">
                                                <i class="fas fa-check text-[10px]"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('tutor.inquiries.update', $inquiry->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all flex items-center justify-center" title="Decline Request">
                                                <i class="fas fa-times text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                        @if($inquiry->status === 'hired')
                                            <span class="inline-block px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100">
                                                Accepted & Matches
                                            </span>
                                        @elseif($inquiry->status === 'rejected')
                                            <span class="inline-block px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest bg-gray-50 text-gray-400 border border-gray-100">
                                                Declined
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="max-w-xs mx-auto opacity-30">
                                    <div class="w-16 h-16 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4 text-gray-400">
                                        <i class="fas fa-inbox text-2xl"></i>
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">No inquiries yet</p>
                                    <p class="text-xs text-gray-400 mt-2 font-medium">Your profile is live! Keep it updated to attract more students.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($inquiries->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</div>

@push('modals')
<!-- View Full Message Modal -->
<div id="msg-modal" class="fixed inset-0 hidden flex items-center justify-center p-4" style="z-index: 99999;">
    <div class="fixed inset-0 backdrop-blur-sm" style="background-color: rgba(17, 24, 39, 0.6);" onclick="closeMessageModal()"></div>
    <div class="bg-white rounded-[2.5rem] w-full max-w-md relative z-10 shadow-2xl border border-gray-100 overflow-hidden">
        <div class="pt-6 px-8 pb-4 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fas fa-envelope-open-text text-blue-600"></i>
                <span id="msg-modal-title">Student Message</span>
            </h3>
            <button onclick="closeMessageModal()" class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 text-gray-400 hover:text-red-500 hover:border-red-100 transition-all flex items-center justify-center">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div class="p-8">
            <p id="msg-modal-body" class="text-sm text-gray-700 leading-relaxed font-medium italic"></p>
        </div>
    </div>
</div>
@endpush

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

<script>
    function showMessageModal(studentName, message) {
        document.getElementById('msg-modal-title').textContent = 'Message from ' + studentName;
        document.getElementById('msg-modal-body').textContent = '"' + message + '"';
        document.getElementById('msg-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeMessageModal() {
        document.getElementById('msg-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMessageModal();
    });
</script>
@endsection

