@extends('layouts.admin')

@section('title', 'Admin Messages - TutorHub')

@push('styles')
<style>
    /* Viewport Lock: Industry-standard approach for fixed-height dashboard apps */
    body, html { height: 100vh !important; overflow: hidden !important; }
    .flex.min-h-screen { height: 100vh !important; min-height: 100vh !important; overflow: hidden !important; }
    main { height: calc(100vh - 80px) !important; overflow: hidden !important; display: flex !important; flex-direction: column !important; }
    main > div.p-10 { flex: 1 !important; display: flex !important; flex-direction: column !important; min-height: 0 !important; padding: 32px !important; overflow: hidden !important; max-width: 100% !important; }
</style>
@endpush

@section('content')
<div class="flex bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden relative h-full min-h-0 w-full">
    <!-- Conversation List Sidebar -->
    <div class="w-full md:w-80 border-r border-gray-100 flex flex-col relative z-10 shadow-[8px_0_30px_rgba(0,0,0,0.04)] {{ isset($conversation) ? 'hidden md:flex' : 'flex' }}">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-xl font-black text-gray-900 tracking-tight">Support Inbox</h2>
            <button onclick="document.getElementById('new-chat-modal').classList.remove('hidden')" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300">
                <i class="fas fa-plus text-sm"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar">
            @forelse($conversations as $conv)
                @php $otherUser = $conv->getOtherUser(Auth::id()); @endphp
                <a href="{{ route('chat.show', $conv->id) }}" 
                   class="block p-4 border-b border-gray-50 hover:bg-blue-50/30 transition-all {{ isset($conversation) && $conversation->id == $conv->id ? 'bg-blue-50/50 border-r-4 border-r-blue-600' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="relative flex-shrink-0">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 text-gray-400 font-bold flex items-center justify-center overflow-hidden border border-gray-100 uppercase">
                                @if($otherUser->profile_image)
                                    <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    {{ substr($otherUser->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full border-2 border-white bg-green-500 hidden transition-all duration-300 scale-0 origin-center" data-online-indicator="{{ $otherUser->id }}"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-0.5">
                                <h4 class="text-xs font-black text-gray-900 truncate">{{ $otherUser->name }}</h4>
                                <span class="bg-blue-50 text-blue-600 text-[8px] font-black px-1.5 py-0.5 rounded-md uppercase ml-2 flex-shrink-0">{{ $otherUser->role }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-[11px] text-gray-400 truncate {{ $conv->unreadCountFor(Auth::id()) > 0 ? 'font-bold text-gray-900' : '' }}">
                                    {{ $conv->latestMessage?->body ?? 'Start conversation...' }}
                                </p>
                                @if($conv->unreadCountFor(Auth::id()) > 0)
                                    <span class="bg-blue-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full ml-1">
                                        {{ $conv->unreadCountFor(Auth::id()) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <p class="text-sm font-bold text-gray-300">No conversations</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Active Chat Area -->
    <div class="flex-1 flex flex-col min-h-0 bg-[#f8fafc] overflow-hidden relative {{ !isset($conversation) ? 'hidden md:flex' : 'flex' }}">
        @if(isset($conversation))
            <!-- Chat Header -->
            <div class="p-6 bg-white border-b border-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 font-bold flex items-center justify-center border border-gray-100 uppercase overflow-hidden">
                            @if($otherUser->profile_image)
                                <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                {{ substr($otherUser->name, 0, 1) }}
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 leading-tight">{{ $otherUser->name }}</h3>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5 flex items-center" data-online-text-indicator="{{ $otherUser->id }}">
                            <span class="w-2 h-2 rounded-full bg-gray-300 inline-block mr-1.5 transition-colors duration-300 status-dot"></span>
                            <span class="status-text text-gray-400 mr-2">Offline</span>
                            &bull; Role: {{ $otherUser->role }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">User ID: #{{ $otherUser->id }}</span>
                </div>
            </div>

            <!-- Messages Area Wrapper -->
            <div class="flex-1 min-h-0 relative overflow-hidden bg-gray-50/20">
                <div id="messages-container" class="h-full overflow-y-auto p-6 space-y-4 custom-scrollbar flex flex-col">
                    @foreach($messages as $msg)
                        <div class="flex @if($msg->sender_id == Auth::id()) justify-end @else justify-start @endif">
                            <div class="max-w-[70%]">
                                <p class="text-[8px] font-black text-gray-400 mb-1 uppercase tracking-widest @if($msg->sender_id == Auth::id()) text-right @endif">
                                    {{ $msg->sender->name }}
                                </p>
                                <div class="p-4 rounded-3xl text-sm @if($msg->sender_id == Auth::id()) bg-blue-600 text-white rounded-tr-none shadow-lg shadow-blue-600/20 @else bg-white text-gray-800 rounded-tl-none border border-gray-100 shadow-sm @endif">
                                    {{ $msg->body }}
                                </div>
                                <p class="text-[8px] font-bold text-gray-300 mt-2 uppercase tracking-wide px-2 @if($msg->sender_id == Auth::id()) text-right @endif">
                                    {{ $msg->created_at->format('h:i A') }}
                                    @if($msg->sender_id == Auth::id())
                                        <span class="ml-1 inline-block">
                                            <i class="fas fa-check-double {{ $msg->is_read ? 'text-blue-500' : 'text-gray-300' }}"></i>
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Message Input Area -->
            <div class="p-4 bg-white border-t border-gray-50">
                <form id="chat-form" class="flex items-center gap-3 bg-white border border-gray-100 shadow-sm rounded-2xl p-1.5 focus-within:ring-2 focus-within:ring-blue-600/10 focus-within:border-blue-600/20 transition-all">
                    <input type="text" id="message-input" placeholder="Type administrative response..." 
                           class="flex-1 bg-transparent border-none py-2 px-4 text-sm font-medium text-gray-800 placeholder-gray-300 outline-none focus:ring-0">
                    <button type="submit" class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/30 group flex-shrink-0">
                        <i class="fas fa-paper-plane text-xs group-hover:scale-110 transition-transform"></i>
                    </button>
                </form>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                <div class="w-24 h-24 rounded-[2rem] bg-blue-50 text-blue-600 flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-4xl"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight mb-3">Admin Chat Center</h2>
                <p class="text-gray-400 max-w-xs font-medium text-xs leading-relaxed italic">
                    Respond to student inquiries or coordinate with tutors directly from the command center.
                </p>
            </div>
        @endif
    </div>
</div>

@push('modals')
<!-- New Chat Modal -->
<div id="new-chat-modal" class="hidden fixed inset-0 flex items-center justify-center p-4" style="z-index: 99999;">
    <div class="absolute inset-0 backdrop-blur-sm" style="background-color: rgba(17, 24, 39, 0.6);" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform transition-all">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-2xl font-black text-gray-900 tracking-tight">Initiate Communication</h3>
            <p class="text-sm font-medium text-gray-400">Search for any tutor or student to start a management thread.</p>
        </div>
        <div class="px-8 py-2 border-b border-gray-50 bg-gray-50/50 flex gap-4">
            <button onclick="switchAdminChatTab('tutor')" id="tab-btn-tutor" class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all bg-blue-600 text-white shadow-lg shadow-blue-500/20">
                Tutors ({{ $contacts->where('role', 'tutor')->count() }})
            </button>
            <button onclick="switchAdminChatTab('student')" id="tab-btn-student" class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-gray-400 hover:text-gray-900">
                Students ({{ $contacts->where('role', 'student')->count() }})
            </button>
        </div>
        <div class="max-h-96 overflow-y-auto custom-scrollbar p-4">
            <!-- Tutors List -->
            <div id="contact-list-tutor" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($contacts->where('role', 'tutor') as $contact)
                    <form action="{{ route('chat.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $contact->id }}">
                        <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-2xl hover:bg-gray-50 transition-all text-left group border border-transparent hover:border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 font-bold overflow-hidden border border-gray-100 flex-shrink-0 uppercase">
                                @if($contact->profile_image)
                                    <img src="{{ asset('storage/' . $contact->profile_image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    {{ substr($contact->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-[11px] font-black text-gray-900 leading-tight truncate group-hover:text-blue-600 transition-colors">{{ $contact->name }}</h4>
                                <span class="text-[7px] font-bold text-gray-400 uppercase tracking-wider">{{ $contact->email }}</span>
                            </div>
                        </button>
                    </form>
                @empty
                    <div class="md:col-span-2 p-12 text-center text-gray-300">
                        <p class="text-xs font-black uppercase tracking-widest">No available tutors</p>
                    </div>
                @endforelse
            </div>

            <!-- Students List -->
            <div id="contact-list-student" class="hidden grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($contacts->where('role', 'student') as $contact)
                    <form action="{{ route('chat.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $contact->id }}">
                        <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-2xl hover:bg-gray-50 transition-all text-left group border border-transparent hover:border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 font-bold overflow-hidden border border-gray-100 flex-shrink-0 uppercase">
                                @if($contact->profile_image)
                                    <img src="{{ asset('storage/' . $contact->profile_image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    {{ substr($contact->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-[11px] font-black text-gray-900 leading-tight truncate group-hover:text-blue-600 transition-colors">{{ $contact->name }}</h4>
                                <span class="text-[7px] font-bold text-gray-400 uppercase tracking-wider">{{ $contact->email }}</span>
                            </div>
                        </button>
                    </form>
                @empty
                    <div class="md:col-span-2 p-12 text-center text-gray-300">
                        <p class="text-xs font-black uppercase tracking-widest">No available students</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="p-6 bg-gray-50 flex justify-end">
            <button onclick="document.getElementById('new-chat-modal').classList.add('hidden')" class="px-7 py-3 rounded-2xl text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-all">Close Workspace</button>
        </div>
    </div>
</div>
@endpush

<script>
    function switchAdminChatTab(role) {
        // Toggle Lists
        document.getElementById('contact-list-tutor').classList.toggle('hidden', role !== 'tutor');
        document.getElementById('contact-list-student').classList.toggle('hidden', role !== 'student');

        // Toggle Buttons Styling
        const tutorBtn = document.getElementById('tab-btn-tutor');
        const studentBtn = document.getElementById('tab-btn-student');

        if (role === 'tutor') {
            tutorBtn.className = 'px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all bg-blue-600 text-white shadow-lg shadow-blue-500/20';
            studentBtn.className = 'px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-gray-400 hover:text-gray-900';
        } else {
            studentBtn.className = 'px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all bg-blue-600 text-white shadow-lg shadow-blue-500/20';
            tutorBtn.className = 'px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-gray-400 hover:text-gray-900';
        }
    }
</script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($conversation))
            const container = document.getElementById('messages-container');
            const form = document.getElementById('chat-form');
            const input = document.getElementById('message-input');
            const currentUserId = {{ Auth::id() }};
            const conversationId = {{ $conversation->id }};

            container.scrollTop = container.scrollHeight;

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const body = input.value.trim();
                if (!body) return;
                input.value = '';

                // Optimistic UI Append
                appendMessage({
                    sender_id: currentUserId,
                    sender_name: '{{ Auth::user()->name }}',
                    body: body,
                    created_at: new Date().toISOString()
                }, true);
                container.scrollTop = container.scrollHeight;
                
                axios.post(`{{ route('chat.send', $conversation->id) }}`, { body: body })
                    .catch(err => { input.value = body; });
            });

            // Presence Channel implementation
            if (window.Echo) {
                window.Echo.join('app')
                    .here((users) => {
                        users.forEach(user => setOnlineStatus(user.id, true));
                    })
                    .joining((user) => {
                        setOnlineStatus(user.id, true);
                    })
                    .leaving((user) => {
                        setOnlineStatus(user.id, false);
                    });
            }

            function setOnlineStatus(userId, isOnline) {
                // Sidebar avatars
                document.querySelectorAll(`[data-online-indicator="${userId}"]`).forEach(el => {
                    if (isOnline) {
                        el.classList.remove('hidden', 'scale-0');
                    } else {
                        el.classList.add('hidden', 'scale-0');
                    }
                });

                // Chat header text
                document.querySelectorAll(`[data-online-text-indicator="${userId}"]`).forEach(el => {
                    const dot = el.querySelector('.status-dot');
                    const text = el.querySelector('.status-text');
                    
                    if (isOnline) {
                        dot.classList.remove('bg-gray-300');
                        dot.classList.add('bg-green-500');
                        text.textContent = 'Online';
                        text.classList.remove('text-gray-400');
                        text.classList.add('text-green-600');
                    } else {
                        dot.classList.remove('bg-green-500');
                        dot.classList.add('bg-gray-300');
                        text.textContent = 'Offline';
                        text.classList.remove('text-green-600');
                        text.classList.add('text-gray-400');
                    }
                });
            }

            // Simple Notification Sound
            function playNotificationSound() {
                try {
                    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioCtx.createOscillator();
                    const gainNode = audioCtx.createGain();
                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(600, audioCtx.currentTime); 
                    oscillator.frequency.exponentialRampToValueAtTime(300, audioCtx.currentTime + 0.1); 
                    gainNode.gain.setValueAtTime(0.3, audioCtx.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
                    oscillator.connect(gainNode);
                    gainNode.connect(audioCtx.destination);
                    oscillator.start();
                    oscillator.stop(audioCtx.currentTime + 0.1);
                } catch(e) {}
            }

            if (window.Echo) {
                window.Echo.private(`chat.${conversationId}`)
                    .listen('.message.sent', (data) => {
                        if (data.sender_id != currentUserId) {
                            playNotificationSound();
                            appendMessage(data, false);
                            axios.post(`{{ route('chat.read', $conversation->id) }}`).catch(()=>{});
                        }
                    })
                    .listen('.messages.read', (data) => {
                        if (data.reader_id != currentUserId) {
                            document.querySelectorAll('.fa-check-double.text-gray-300').forEach(icon => {
                                icon.classList.remove('text-gray-300');
                                icon.classList.add('text-blue-500');
                            });
                        }
                    });
            }

            function appendMessage(data, isMe) {
                const div = document.createElement('div');
                div.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;
                const time = new Date(data.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                
                let readIcon = '';
                if (isMe) {
                    readIcon = `<span class="ml-1 inline-block"><i class="fas fa-check-double ${data.is_read ? 'text-blue-500' : 'text-gray-300'}"></i></span>`;
                }

                div.innerHTML = `
                    <div class="max-w-[70%]">
                        <p class="text-[8px] font-black text-gray-400 mb-1 uppercase tracking-widest ${isMe ? 'text-right' : ''}">
                            ${data.sender_name}
                        </p>
                        <div class="p-4 rounded-3xl text-sm ${isMe ? 'bg-blue-600 text-white rounded-tr-none shadow-lg shadow-blue-600/20' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100 shadow-sm'}">
                            ${data.body}
                        </div>
                        <p class="text-[8px] font-bold text-gray-300 mt-2 uppercase tracking-wide px-2 ${isMe ? 'text-right' : ''}">
                            ${time} ${readIcon}
                        </p>
                    </div>
                `;
                container.appendChild(div);
                container.scrollTop = container.scrollHeight;
            }
        @endif
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
@endpush
@endsection
