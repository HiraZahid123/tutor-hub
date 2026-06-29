@extends('layouts.dashboard')
@section('title', 'Learning Requests - TutorHub')

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2">Learning Requests</h1>
        <p class="text-gray-500 font-medium">Track your custom requests to find a suitable tutor.</p>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
        <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-50">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Learning Requests</h3>
            <a href="{{ route('find-a-tutor') }}" class="text-[9px] font-black text-blue-600 hover:text-blue-700 transition-colors uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-plus"></i> New Request
            </a>
        </div>

        @if($requests->isEmpty())
            <p class="text-[10px] text-gray-300 font-bold text-center py-20 uppercase tracking-widest">No requests yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <th class="pb-6 px-4">Subject</th>
                            <th class="pb-6 px-4">Status</th>
                            <th class="pb-6 px-4 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($requests as $req)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-6 px-4">
                                    <p class="text-sm font-black text-gray-800">{{ is_array($req->subject) ? implode(', ', $req->subject) : $req->subject }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter">{{ $req->grade }} • {{ $req->city }}</p>
                                </td>
                                <td class="py-6 px-4">
                                    @if($req->status === 'matched' && $req->assignedTutor)
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-green-600 uppercase tracking-widest leading-none mb-1 text-nowrap select-none">Matched</span>
                                            <span class="text-[9px] font-bold text-gray-400 leading-none text-nowrap select-none">{{ $req->assignedTutor->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black text-yellow-600 uppercase tracking-widest">Reviewing</span>
                                    @endif
                                </td>
                                <td class="py-6 px-4 text-right">
                                    <p class="text-[10px] font-black text-gray-800">{{ $req->created_at->format('M d, Y') }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
