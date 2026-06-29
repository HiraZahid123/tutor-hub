@extends('layouts.dashboard')

@section('title', 'Messages - TutorHub')

@push('styles')
<style>
    /* Clean Slate Layout: Standard scrolling with a stable fixed-size chat box */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endpush

@section('dashboard-content')
<div class="max-w-6xl mx-auto flex bg-white rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100 overflow-hidden relative w-full" style="height: 600px !important; max-height: 600px !important; flex-shrink: 0 !important;">
    <!-- Conversation List Sidebar -->
    <div class="w-full md:w-80 border-r border-gray-100 flex flex-col relative z-10 shadow-[8px_0_30px_rgba(0,0,0,0.04)] {{ isset($conversation) ? 'hidden md:flex' : 'flex' }}">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-xl font-black text-gray-900 tracking-tight">Messages</h2>
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
                            <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 font-bold overflow-hidden shadow-sm">
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
                                <h4 class="text-sm font-black text-gray-900 truncate">{{ $otherUser->name }}</h4>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">{{ $conv->latestMessage?->created_at->diffForHumans(null, true) ?? '' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500 truncate {{ $conv->unreadCountFor(Auth::id()) > 0 ? 'font-bold text-gray-900' : '' }}">
                                    @if($conv->latestMessage?->sender_id == Auth::id())
                                        <span class="text-blue-500 mr-1"><i class="fas fa-check-double"></i></span>
                                    @endif
                                    {{ $conv->latestMessage?->body ?? 'No messages yet' }}
                                </p>
                                @if($conv->unreadCountFor(Auth::id()) > 0)
                                    <span class="bg-blue-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full">
                                        {{ $conv->unreadCountFor(Auth::id()) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-3xl bg-gray-50 text-gray-300 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-2xl"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-400">No conversations</p>
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
                    <a href="{{ route('chat.index') }}" class="md:hidden text-gray-400 hover:text-gray-600 mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400 font-bold overflow-hidden">
                        @if($otherUser->profile_image)
                            <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="" class="w-full h-full object-cover">
                        @else
                            {{ substr($otherUser->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 leading-tight">{{ $otherUser->name }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5 flex items-center" data-online-text-indicator="{{ $otherUser->id }}">
                            <span class="w-2 h-2 rounded-full bg-gray-300 inline-block mr-1.5 transition-colors duration-300 status-dot"></span>
                            <span class="status-text text-gray-400">Offline</span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Buttons removed -->
                </div>
            </div>

            <!-- Messages Area Wrapper -->
            <div class="flex-1 min-h-0 relative overflow-hidden bg-gray-50/20">
                <div id="messages-container" class="h-full overflow-y-auto p-6 space-y-4 custom-scrollbar flex flex-col">
                    @foreach($messages as $msg)
                        <div class="flex @if($msg->sender_id == Auth::id()) justify-end @else justify-start @endif">
                            <div class="max-w-[70%]">
                                <div class="p-4 rounded-3xl text-sm @if($msg->sender_id == Auth::id()) bg-blue-600 text-white rounded-tr-none shadow-lg shadow-blue-600/20 @else bg-white text-gray-800 rounded-tl-none border border-gray-100 shadow-sm @endif">
                                    {{ $msg->body }}
                                </div>
                                <p class="text-[9px] font-bold text-gray-400 mt-2 uppercase tracking-wide px-2 @if($msg->sender_id == Auth::id()) text-right @endif">
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
            <div class="p-4 bg-white border-t border-gray-100">
                <form id="chat-form" class="flex items-center gap-3 bg-white border border-gray-100 shadow-sm rounded-2xl p-1.5 focus-within:ring-2 focus-within:ring-blue-600/10 focus-within:border-blue-600/20 transition-all">
                    <input type="text" id="message-input" placeholder="Type your message..." 
                           class="flex-1 bg-transparent border-none py-2 px-4 text-sm font-medium text-gray-800 placeholder-gray-300 outline-none focus:ring-0">
                    <button type="submit" class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/30 group flex-shrink-0">
                        <i class="fas fa-paper-plane text-xs group-hover:scale-110 transition-transform"></i>
                    </button>
                </form>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                <div class="w-32 h-32 rounded-[3rem] bg-white shadow-2xl shadow-blue-500/10 flex items-center justify-center mb-8 relative">
                    <i class="fas fa-comments text-5xl text-blue-600"></i>
                    <div class="absolute -top-2 -right-2 w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg transform rotate-12">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight mb-4">Your Inbox</h2>
                <p class="text-gray-500 max-w-sm font-medium leading-relaxed italic">
                    Select a conversation from the sidebar to start chatting with your tutors or students in real-time.
                </p>
            </div>
        @endif
    </div>
</div>

@push('modals')
<!-- New Chat Modal -->
<div id="new-chat-modal" class="hidden fixed inset-0 flex items-center justify-center p-4" style="z-index: 99999;">
    <div class="absolute inset-0 backdrop-blur-sm" style="background-color: rgba(17, 24, 39, 0.6);" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-2xl font-black text-gray-900 tracking-tight">Start New Chat</h3>
            <p class="text-sm font-medium text-gray-400 mt-1">Select a contact to begin a conversation.</p>
        </div>
        <div class="max-h-80 overflow-y-auto custom-scrollbar p-4">
            @forelse($contacts as $contact)
                <form action="{{ route('chat.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $contact->id }}">
                    <button type="submit" class="w-full flex items-center gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-all text-left">
                        <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 font-bold overflow-hidden shadow-sm">
                            @if($contact->profile_image)
                                <img src="{{ asset('storage/' . $contact->profile_image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                {{ substr($contact->name, 0, 1) }}
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-gray-900 leading-tight">{{ $contact->name }}</h4>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ ucfirst($contact->role) }}</p>
                        </div>
                        <i class="fas fa-chevron-right ml-auto text-gray-200"></i>
                    </button>
                </form>
            @empty
                <div class="p-12 text-center text-gray-400">
                    <p class="text-sm font-bold">No new contacts available.</p>
                </div>
            @endforelse
        </div>
        <div class="p-6 bg-gray-50 flex justify-end">
            <button onclick="document.getElementById('new-chat-modal').classList.add('hidden')" class="px-7 py-3 rounded-2xl text-[11px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-all">Cancel</button>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($conversation))
            const container = document.getElementById('messages-container');
            const form = document.getElementById('chat-form');
            const input = document.getElementById('message-input');
            const currentUserId = {{ Auth::id() }};
            const conversationId = {{ $conversation->id }};

            // Scroll to bottom immediately
            container.scrollTop = container.scrollHeight;

            // Handle Form Submit
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
                    .catch(err => {
                        console.error('Error sending message:', err);
                        input.value = body; // Put it back on error
                    });
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

            // Listen for Real-time messages
            if (window.Echo) {
                window.Echo.private(`chat.${conversationId}`)
                    .listen('.message.sent', (data) => {
                        console.log('New message received:', data);
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
                        <div class="p-4 rounded-3xl text-sm ${isMe ? 'bg-blue-600 text-white rounded-tr-none shadow-lg shadow-blue-600/20' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100 shadow-sm'}">
                            ${data.body}
                        </div>
                        <p class="text-[9px] font-bold text-gray-400 mt-2 uppercase tracking-wide px-2 ${isMe ? 'text-right' : ''}">
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
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endpush
@endsection
