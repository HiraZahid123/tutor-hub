@extends('layouts.admin')
@section('title', 'Inquiries - Admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Contact Inquiries</h2>
        <p class="text-gray-500 font-medium">Manage generic messages submitted via the contact form.</p>
    </div>
    <div class="px-6 py-3 bg-white rounded-3xl border border-gray-100 shadow-sm">
        <div class="text-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Messages</p>
            <p class="text-xl font-black text-blue-600 tracking-tight">{{ $inquiries->count() }}</p>
        </div>
    </div>
</div>

@if($inquiries->isEmpty())
    <div class="bg-white rounded-[2.5rem] border border-gray-100 p-20 text-center shadow-xl shadow-blue-500/5">
        <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-300">
            <i class="fas fa-envelope-open text-3xl"></i>
        </div>
        <h3 class="text-lg font-black text-gray-900 mb-2">Inbox is empty</h3>
        <p class="text-gray-400 text-sm font-medium">When users submit the contact form, they will appear here.</p>
    </div>
@else
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Sender</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Email Address</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Message Snippet</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Submitted</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50/30 transition-all group">
                            <td class="px-8 py-6">
                                <p class="text-sm font-black text-gray-900">{{ $inquiry->name }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <a href="mailto:{{ $inquiry->email }}" class="text-xs font-bold text-blue-500 hover:underline flex items-center gap-2">
                                    {{ $inquiry->email }} <i class="fas fa-external-link-alt text-[8px]"></i>
                                </a>
                            </td>
                            <td class="px-8 py-6">
                                <div class="max-w-xs">
                                    <p class="text-xs text-gray-600 leading-relaxed font-medium" title="{{ $inquiry->message }}">
                                        {{ Str::limit($inquiry->message, 80) }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest">{{ $inquiry->created_at->format('M d, Y') }}</p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tight">{{ $inquiry->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-gray-50 text-gray-300 hover:bg-red-50 hover:text-red-600 transition-all flex items-center justify-center">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
