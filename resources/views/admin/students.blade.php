@extends('layouts.admin')
@section('title', 'Student Submissions - Admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Student Requests</h2>
        <p class="text-gray-500 font-medium">Manage and match new student tutor requests across the platform.</p>
    </div>
    
    <div class="flex items-center bg-white border border-gray-100 rounded-2xl px-4 py-2.5 shadow-sm focus-within:ring-4 focus-within:ring-blue-500/10 focus-within:border-blue-500 transition-all w-72 md:w-80">
        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input type="text" id="table-search" onkeyup="filterTable()" 
               class="w-full border-none focus:ring-0 p-0 ml-3 text-sm bg-transparent placeholder-gray-300 font-medium" 
               placeholder="Search students, subjects...">
    </div>
</div>

@if($students->isEmpty())
    <div class="bg-white rounded-[2.5rem] border border-gray-100 p-20 text-center shadow-xl shadow-blue-500/5">
        <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-300">
            <i class="fas fa-graduation-cap text-3xl"></i>
        </div>
        <h3 class="text-lg font-black text-gray-900 mb-2">No requests yet</h3>
        <p class="text-gray-400 text-sm font-medium">When students look for tutors, their leads will show up here.</p>
    </div>
@else
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="students-table">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Student</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Contact / City</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Grade / Subject</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Notes</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Match / Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 italic-rows">
                    @foreach($students as $req)
                        <tr class="hover:bg-blue-50/30 transition-colors student-row">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $req->student_name }}</div>
                                <div class="text-xs text-gray-400">{{ $req->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-700 font-bold uppercase tracking-tighter text-xs">{{ $req->contact_method }}</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tight flex items-center gap-1.5 mt-0.5">
                                    <span>{{ $req->city }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-blue-600">
                                        @if($req->tutoring_type === 'online') Online
                                        @elseif($req->tutoring_type === 'home') Home
                                        @else Both
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-700 font-bold text-xs uppercase tracking-tighter">{{ $req->grade }}</div>
                                <div class="text-primary font-black text-[10px] uppercase tracking-tighter mt-0.5">
                                    {{ is_array($req->subject) ? implode(', ', $req->subject) : $req->subject }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-500 max-w-[150px] truncate" title="{{ $req->notes }}">
                                    {{ $req->notes ?: '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <select onchange="updateStatus({{ $req->id }}, this.value)" 
                                        class="text-xs rounded-full px-3 py-1 border-gray-200 font-semibold focus:ring-0 focus:border-blue-400
                                               {{ $req->status === 'matched' ? 'bg-green-100 text-green-800' : 
                                                  ($req->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : 
                                                  ($req->status === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                    <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewing" {{ $req->status === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                    <option value="matched" {{ $req->status === 'matched' ? 'selected' : '' }}>Matched</option>
                                    <option value="closed" {{ $req->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                @if($req->status !== 'matched')
                                    @php
                                        $studentSubjects = is_array($req->subject) ? $req->subject : [];
                                        $requestedMode = $req->tutoring_type;

                                        $sortedTutors = $approvedTutors->map(function($tutor) use ($studentSubjects, $requestedMode) {
                                            $tutorSubjectNames = $tutor->subjects->pluck('name')->toArray();
                                            $subjectMatchCount = count(array_intersect($studentSubjects, $tutorSubjectNames));
                                            
                                            // Calculate Match Score
                                            // Base score = matching subjects
                                            $matchScore = $subjectMatchCount;
                                            
                                            // Mode Bonus: If tutor offers what student wants
                                            $modeMismatch = false;
                                            if ($requestedMode === 'online' && !$tutor->is_online) $modeMismatch = true;
                                            if ($requestedMode === 'home' && !$tutor->is_home) $modeMismatch = true;
                                            
                                            // If it's a perfect mode match, give a boost to show them at top
                                            if (!$modeMismatch && $subjectMatchCount > 0) {
                                                $matchScore += 10; 
                                            }

                                            $tutor->match_count = $subjectMatchCount;
                                            $tutor->match_score = $matchScore;
                                            $tutor->mode_mismatch = $modeMismatch;
                                            
                                            return $tutor;
                                        })->sortByDesc('match_score');
                                    @endphp
                                    <form action="{{ route('admin.students.assign', $req->id) }}" method="POST" class="flex items-center gap-1">
                                        @csrf
                                        <select name="tutor_id" class="text-xs border-gray-200 rounded-lg py-1 px-2 w-[180px]" required>
                                            <option value="">Choose Tutor</option>
                                            @foreach($sortedTutors as $tutor)
                                                <option value="{{ $tutor->id }}" class="{{ $tutor->match_count > 0 ? 'bg-green-50 font-bold' : '' }}">
                                                    {{ $tutor->name }} 
                                                    @if($tutor->mode_mismatch) [{{ $req->tutoring_type === 'online' ? 'Online only' : ($req->tutoring_type === 'home' ? 'Home only' : 'Mode mismatch') }}] @endif
                                                    @if($tutor->match_count > 0)
                                                        — [{{ $tutor->match_count }} {{ Str::plural('Match', $tutor->match_count) }}]
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-blue-600 text-white p-1.5 rounded-lg hover:bg-blue-700 shadow-sm transition-all" title="Assign Tutor">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs ring-2 ring-white">
                                            {{ substr($req->assignedTutor->name ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-semibold text-gray-700">{{ $req->assignedTutor->name ?? 'Deleted Tutor' }}</div>
                                            <div class="text-[10px] text-gray-400">Assigned</div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Global Delete Action --}}
                                <div class="mt-3 pt-3 border-t border-gray-50 flex justify-end">
                                    <form action="{{ route('admin.students.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this student request?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] font-black text-red-300 hover:text-red-600 uppercase tracking-widest transition-all flex items-center gap-1.5">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete Request</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@push('scripts')
<script>
function filterTable() {
    const input = document.getElementById('table-search');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('.student-row');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
}

function updateStatus(id, status) {
    if (!confirm(`Change status to ${status.toUpperCase()}?`)) {
        location.reload();
        return;
    }

    fetch(`/admin/students/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ status: status })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Flash color or something? For now reload or just visual change
            location.reload(); 
        }
    })
    .catch(err => {
        console.error(err);
        alert('Update failed');
        location.reload();
    });
}
</script>
@endpush
@endsection
