@extends('layouts.admin')
@section('title', 'Tutor Hire Leads - Admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Tutor Hire Leads</h2>
            <p class="text-gray-500 font-medium">Monitor direct student-to-tutor engagement across the platform.</p>
        </div>
        <div class="px-6 py-3 bg-white rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Leads</p>
                <p class="text-xl font-black text-blue-600 tracking-tight">{{ $inquiries->total() }}</p>
            </div>
        </div>
    </div>

    @if($inquiries->isEmpty())
        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-20 text-center shadow-xl shadow-blue-500/5">
            <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-300">
                <i class="fas fa-handshake text-3xl"></i>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-2">No leads found</h3>
            <p class="text-gray-400 text-sm font-medium">When students start hiring tutors, they will appear here.</p>
        </div>
    @else
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Student Info</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Targeted Tutor</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Preferences</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Message</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Submitted</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($inquiries as $inquiry)
                            <tr class="hover:bg-gray-50/30 transition-all group {{ $inquiry->status === 'hired' ? 'bg-emerald-50/20' : '' }}">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-black text-xs border border-blue-100 italic">
                                            {{ substr($inquiry->student->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900">{{ $inquiry->student->name ?? 'Unknown Student' }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">{{ $inquiry->student->email ?? 'No Email' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xs border border-indigo-100 font-serif">
                                            {{ substr($inquiry->tutor->name ?? 'T', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900">{{ $inquiry->tutor->name ?? 'Tutor Deleted' }}</p>
                                            <a href="{{ $inquiry->tutor ? route('tutors.show', $inquiry->tutor->id) : '#' }}" class="text-[10px] text-blue-500 font-black uppercase tracking-tight hover:underline flex items-center gap-1">
                                                View Profile <i class="fas fa-external-link-alt text-[8px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-2">
                                        <div class="flex flex-wrap gap-1">
                                            @if(is_array($inquiry->subjects))
                                                @foreach($inquiry->subjects as $subject)
                                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[8px] font-black uppercase tracking-tight rounded border border-gray-200">
                                                        {{ $subject }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($inquiry->hiring_type === 'home')
                                                <span class="text-[8px] font-black text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-full uppercase tracking-widest">Home Tutoring</span>
                                            @else
                                                <span class="text-[8px] font-black text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full uppercase tracking-widest">Online Tutoring</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="max-w-[200px] overflow-hidden">
                                        <p class="text-xs text-gray-600 font-medium leading-relaxed line-clamp-2 italic" title="{{ $inquiry->message }}">
                                            "{{ $inquiry->message ?? 'No message provided.' }}"
                                        </p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-block px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                        {{ $inquiry->status === 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                                        {{ $inquiry->status === 'confirmed' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}
                                        {{ $inquiry->status === 'hired' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm' : '' }}
                                        {{ $inquiry->status === 'rejected' ? 'bg-gray-100 text-gray-400 border border-gray-200' : '' }}
                                    ">
                                        {{ $inquiry->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest">{{ $inquiry->created_at->format('M d, Y') }}</p>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tight">{{ $inquiry->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <form action="{{ route('admin.tutor-inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hire lead?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Delete Lead">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($inquiries->hasPages())
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    @endif

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
@endsection
