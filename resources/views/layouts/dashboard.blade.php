@extends('layouts.app')

@php
    $user = Auth::user();
    $isTutor = $user->role === 'tutor';
    $isStudent = $user->role === 'student';

    $pendingInquiriesCount = 0;
    $pendingAppointmentsCount = 0;
    if ($isTutor) {
        $registration = \App\Models\TutorRegistration::where('user_id', $user->id)->first();
        if ($registration) {
            $pendingInquiriesCount = \App\Models\TutorInquiry::where('tutor_id', $registration->id)
                ->where('status', 'pending')
                ->count();
            $pendingAppointmentsCount = \App\Models\Booking::where('tutor_id', $registration->id)
                ->where('status', 'pending')
                ->count();
        }
    }
@endphp

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 hidden md:flex flex-col sticky top-0 h-screen">
        <div class="p-8 border-b border-gray-50 mb-6">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-1">User Portal</h2>
            <p class="text-sm font-black text-gray-900 truncate">{{ $user->name }}</p>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <!-- Common Links -->
            <a href="{{ $isTutor ? route('tutor.dashboard') : route('student.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('*.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>

            <a href="{{ route('chat.index') }}" 
               class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('chat.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Messages
                </div>
                <span id="sidebar-unread-count" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-blue-600 text-white text-[9px] font-black shadow-md border border-white {{ $user->unreadMessagesCount() == 0 ? 'hidden' : '' }}">
                    {{ $user->unreadMessagesCount() }}
                </span>
            </a>

            @if($isTutor)
                <a href="{{ route('tutor.appointments') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('tutor.appointments') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Appointments
                    </div>
                    @if($pendingAppointmentsCount > 0)
                        <span class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[9px] font-black shadow-md border border-white">
                            {{ $pendingAppointmentsCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('tutor.payments') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('tutor.payments') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    My Earnings
                </a>
                <a href="{{ route('tutor.inquiries') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('tutor.inquiries') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4m8 4v6"></path></svg>
                        Hire Inquiries
                    </div>
                    @if($pendingInquiriesCount > 0)
                        <span id="pending-inquiries-badge" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[9px] font-black shadow-md border border-white">
                            {{ $pendingInquiriesCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('tutor.availability') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('tutor.availability') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    My Schedule
                </a>
                <a href="{{ route('tutor.profile') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('tutor.profile') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Edit Profile
                </a>
            @endif

            @if($isStudent)
                @php
                    $hasLearningRequests = \App\Models\StudentRequest::where('user_id', Auth::id())->exists();
                    $learningRequestsUrl = $hasLearningRequests ? route('student.learning-requests') : route('find-a-tutor');
                @endphp
                <a href="{{ route('student.sent-requests') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('student.sent-requests') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Sent Requests
                </a>
                <a href="{{ $learningRequestsUrl }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('student.learning-requests') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Learning Requests
                </a>
                <a href="{{ route('student.profile') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('student.profile') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Edit Profile
                </a>
            @endif

            <div class="pt-8 mt-8 border-t border-gray-50">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black text-gray-400 uppercase tracking-widest hover:text-blue-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to site
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black text-red-400 uppercase tracking-widest hover:bg-red-50 hover:text-red-600 transition-all text-left">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Content Area -->
    <main class="flex-1 min-h-screen overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-30 px-8 py-4 md:hidden">
            <div class="flex items-center justify-between">
                <span class="text-sm font-black uppercase tracking-widest text-blue-600">Dashboard</span>
                <!-- Mobile Menu Button could go here, but I'll skip for now or use the existing app navbar -->
            </div>
        </header>

        <div class="p-8">
            @yield('dashboard-content')
        </div>
    </main>
</div>

<style>
    /* Ensure the main app navbar and footer are hidden on dashboard pages if needed */
    nav#main-navbar, footer#main-footer { display: none !important; }
</style>

<!-- Notification Sound -->
<audio id="notification-sound" preload="auto">
    <source src="https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3" type="audio/mpeg">
</audio>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-8 right-8 flex flex-col gap-3 pointer-events-none" style="z-index: 99999;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sound = document.getElementById('notification-sound');
        const sound = document.getElementById('notification-sound');
        const badge = document.getElementById('sidebar-unread-count');
        const toastContainer = document.getElementById('toast-container');

        // Global function to show toast
        window.showChatToast = function(message = 'You have a new message!', title = 'New Message') {
            const toast = document.createElement('div');
            toast.className = 'bg-white border-l-4 border-blue-600 shadow-2xl rounded-2xl p-4 min-w-[300px] pointer-events-auto transform translate-y-20 opacity-0 transition-all duration-500 ease-out flex items-start gap-4';
            toast.innerHTML = `
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-[11px] font-black text-gray-900 uppercase tracking-widest">${title}</h4>
                    <p class="text-xs font-medium text-gray-500 mt-0.5 line-clamp-2">${message}</p>
                </div>
                <button class="text-gray-300 hover:text-gray-500 transition-colors">
                    <i class="fas fa-times text-[10px]"></i>
                </button>
            `;

            toastContainer.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-y-20', 'opacity-0');
            }, 100);

            // Play sound
            if (sound) {
                sound.play().catch(e => console.log('Audio play failed:', e));
            }

            // Close logic
            const closeBtn = toast.querySelector('button');
            const closeToast = () => {
                toast.classList.add('translate-y-20', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            };
            closeBtn.onclick = closeToast;
            setTimeout(closeToast, 6000); // Auto close after 6s
            
            toast.onclick = () => {
                 window.location.href = "{{ $isTutor ? route('tutor.inquiries') : route('student.sent-requests') }}";
            };
        };

        // Audio unlocking for autoplay policies
        const unlockAudio = () => {
            if (sound) {
                sound.play().then(() => {
                    sound.pause();
                    sound.currentTime = 0;
                    document.removeEventListener('click', unlockAudio);
                    document.removeEventListener('keydown', unlockAudio);
                }).catch(e => console.log('Audio unlock failed:', e));
            }
        };
        document.addEventListener('click', unlockAudio);
        document.addEventListener('keydown', unlockAudio);

        // Poll for pending inquiries count every 15 seconds (for tutors)
        @if($isTutor)
        let currentInquiryCount = {{ $pendingInquiriesCount }};
        setInterval(() => {
            fetch("{{ route('tutor.inquiries.count') }}")
            .then(res => res.json())
            .then(data => {
                if (data.count > currentInquiryCount) {
                    window.showChatToast('You have a new hire request!', 'New Hire Request');
                    
                    const badge = document.getElementById('pending-inquiries-badge');
                    if (badge) {
                        badge.innerText = data.count;
                        badge.classList.remove('hidden');
                    }
                }
                currentInquiryCount = data.count;
            })
            .catch(err => console.error('Error fetching inquiry count:', err));
        }, 15000);
        @endif

        // Poll for unread messages count every 10 seconds
        let currentUnreadCount = {{ $user->unreadMessagesCount() }};
        setInterval(() => {
            fetch("{{ route('chat.unread-count') }}")
            .then(res => res.json())
            .then(data => {
                if (data.count > currentUnreadCount) {
                    if (!window.location.pathname.includes('/messages')) {
                        window.showChatToast('You have a new message!', 'New Message');
                    }
                    
                    const sidebarBadge = document.getElementById('sidebar-unread-count');
                    if (sidebarBadge) {
                        sidebarBadge.innerText = data.count;
                        sidebarBadge.classList.remove('hidden');
                    }
                } else if (data.count == 0) {
                    const sidebarBadge = document.getElementById('sidebar-unread-count');
                    if (sidebarBadge) sidebarBadge.classList.add('hidden');
                }
                currentUnreadCount = data.count;
            })
            .catch(err => console.error('Error fetching unread count:', err));
        }, 10000);

        window.showInquiryToast = window.showChatToast;
    });
</script>
@endsection
