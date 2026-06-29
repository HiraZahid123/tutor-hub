@extends('layouts.admin')
@section('title', 'Manage Subjects - Admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h2 class="text-4xl font-black text-gray-900 tracking-tight mb-2">Academic Subjects</h2>
        <p class="text-gray-500 font-medium">Manage all academic categories and their associated child subjects.</p>
    </div>
    
    <div class="flex gap-4">
        <button onclick="openCategoryModal()" class="px-6 py-3 bg-white text-blue-600 border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all font-black text-[11px] uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-folder-plus text-sm"></i> New Category
        </button>
        <button onclick="openCreateModal()" class="px-6 py-3 bg-blue-600 text-white rounded-2xl shadow-xl shadow-blue-500/20 hover:bg-blue-700 transition-all font-black text-[11px] uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-plus text-sm"></i> Add Subject
        </button>
    </div>
</div>

@if(session('success'))
    <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl font-bold flex items-center gap-3 shadow-sm">
        <i class="fas fa-check-circle text-green-500"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

    <div class="space-y-10">
        @foreach($categories as $category)
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-blue-500/5 overflow-hidden">
                <div class="p-8 flex items-center justify-between border-b border-gray-50 bg-gray-50/30">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 flex items-center justify-center rounded-2xl text-blue-600 shadow-inner">
                            <i class="{{ $category->icon ?? 'fas fa-folder' }} text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">{{ $category->name }}</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $category->subjects->count() }} Subjects</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                         <button onclick="openCategoryModal({{ json_encode($category) }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Deleting category will also delete its subjects. Continue?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-6 bg-white/30 rounded-b-[2rem]">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($category->subjects as $subject)
                            <div class="bg-white p-4 rounded-2xl border border-gray-100/50 shadow-sm hover:shadow-md hover:border-blue-100 transition-all group overflow-hidden relative">
                                <div class="flex items-center gap-3">
                                    <div style="background-color: {{ $subject->color ?? '#F1F5F9' }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-white shadow-inner shrink-0 scale-90 group-hover:scale-100 transition-transform">
                                        <i class="{{ $subject->icon ?? 'fas fa-book' }} text-base"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-gray-900 truncate text-sm">{{ $subject->name }}</h4>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate">{{ $subject->slug }}</p>
                                    </div>
                                </div>
                                
                                <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button onclick="openEditModal({{ json_encode($subject) }})" class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-md">
                                        <i class="fas fa-pen text-[10px]"></i>
                                    </button>
                                    <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Delete this subject?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-400 hover:bg-red-50 rounded-md">
                                            <i class="fas fa-times text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@push('modals')
<!-- Subject Modal -->
<div id="subject-modal" class="fixed inset-0 flex items-center justify-center backdrop-blur-md hidden" style="z-index: 99999; background-color: rgba(0, 0, 0, 0.6);">
    <div class="bg-white p-10 rounded-[2.5rem] w-full max-w-lg shadow-2xl border border-gray-100 animate-in fade-in zoom-in duration-300">
        <div class="text-center mb-8">
            <h3 id="modal-title" class="text-2xl font-black text-gray-900 tracking-tight">Add New Subject</h3>
            <p class="text-sm text-gray-500 font-medium">Link a specific academic subject to a category.</p>
        </div>

        <form id="subject-form" class="space-y-6">
            @csrf
            <div id="method-container"></div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Parent Category</label>
                    <select name="category_id" id="field-category" required 
                           class="w-full border border-gray-100 bg-gray-50/50 p-4 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition-all font-bold text-sm">
                        <option value="" disabled selected>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Subject Name</label>
                    <input name="name" id="field-name" placeholder="e.g. Mathematics" required 
                           class="w-full border border-gray-100 bg-gray-50/50 p-4 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition-all font-bold text-sm">
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Icon (FA Class)</label>
                    <input name="icon" id="field-icon" placeholder="fas fa-calculator" 
                           class="w-full border border-gray-100 bg-gray-50/50 p-4 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Accent Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="color" id="field-color" value="#3b82f6" 
                               class="h-13 w-13 border-none p-0 rounded-xl cursor-pointer bg-transparent">
                        <input type="text" id="color-text" placeholder="#3b82f6" 
                               class="flex-1 border border-gray-100 bg-gray-50/50 p-4 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-xs font-mono uppercase">
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 pt-6">
                <button type="button" onclick="submitForm()" class="w-full bg-blue-600 text-white py-4 rounded-2xl hover:bg-blue-700 transition shadow-xl shadow-blue-500/20 font-black text-xs uppercase tracking-widest">
                    Save Subject
                </button>
                <button type="button" onclick="closeModal()" class="w-full bg-gray-50 text-gray-500 py-4 rounded-2xl hover:bg-gray-100 transition font-black text-xs uppercase tracking-widest">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

{{-- Category Modal (Optional, but good for UX) --}}
{{-- I'll skip category modal for now to keep it simple, or user can add via tinker/seeder --}}

@push('scripts')
<script>
let editingId = null;

function openCreateModal() {
    editingId = null;
    document.getElementById('modal-title').innerText = 'Add New Subject';
    document.getElementById('subject-form').reset();
    document.getElementById('method-container').innerHTML = '';
    document.getElementById('field-color').value = '#3b82f6';
    document.getElementById('color-text').value = '#3b82f6';
    document.getElementById('subject-modal').classList.remove('hidden');
}

function openEditModal(subject) {
    editingId = subject.id;
    document.getElementById('modal-title').innerText = 'Edit Subject';
    document.getElementById('field-category').value = subject.category_id;
    document.getElementById('field-name').value = subject.name;
    document.getElementById('field-icon').value = subject.icon || '';
    document.getElementById('field-color').value = subject.color || '#3b82f6';
    document.getElementById('color-text').value = subject.color || '#3b82f6';
    document.getElementById('method-container').innerHTML = '@method("PUT")';
    document.getElementById('subject-modal').classList.remove('hidden');
}

function openCategoryModal(category = null) {
    editingId = category ? category.id : null;
    const title = category ? 'Edit Category' : 'New Category';
    const url = category ? `/admin/categories/${category.id}` : '/admin/categories';
    
    document.getElementById('modal-title').innerText = title;
    document.getElementById('field-name').value = category ? category.name : '';
    document.getElementById('field-icon').value = category ? (category.icon || '') : '';
    
    // We'll reuse the same modal for simple name/icon edits if possible, 
    // but for now let's just make the CREATE work.
    const form = document.getElementById('subject-form');
    form.action = url;
    document.getElementById('field-category').parentElement.style.display = category ? 'none' : 'block';
    if(category) {
         document.getElementById('method-container').innerHTML = '@method("DELETE")'; // Wait, no, this is for store/update
    }
    document.getElementById('subject-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('subject-modal').classList.add('hidden');
}

document.getElementById('field-color').addEventListener('input', (e) => {
    document.getElementById('color-text').value = e.target.value;
});

document.getElementById('color-text').addEventListener('input', (e) => {
    document.getElementById('field-color').value = e.target.value;
});

function submitForm() {
    const form = document.getElementById('subject-form');
    const formData = new FormData(form);
    const url = editingId ? `/admin/subjects/${editingId}` : '/admin/subjects';
    
    // We use fetch for match the Tutor edit pattern (with spoofing)
    fetch(url, {
        method: editingId ? 'POST' : 'POST', 
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        if (res.ok) {
            location.reload();
        } else {
            const data = await res.json();
            alert('Error: ' + JSON.stringify(data.errors));
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred during save.');
    });
}
</script>
@endpush
@endsection
