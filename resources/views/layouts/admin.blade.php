<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - TutorHub')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-Outfit">
    <div class="flex min-h-screen bg-white">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-100 hidden md:flex flex-col sticky top-0 h-screen">
            <div class="p-8 border-b border-gray-50 mb-6">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-1">Admin Portal</h2>
                <p class="text-sm font-black text-gray-900 truncate">Platform Overview</p>
            </div>

            <nav class="flex-1 px-4 space-y-2 overflow-y-auto custom-scrollbar">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <i class="fas fa-home text-sm"></i> Dashboard
                </a>

                <a href="{{ route('admin.students') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.students') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-graduation-cap text-sm"></i> Student Connects
                    </div>
                    @php $pendingStudents = $adminSidebarCounts['pendingStudents'] ?? 0; @endphp
                    <span id="badge-pending-students" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-blue-600 text-white text-[9px] font-black shadow-md border border-white {{ $pendingStudents == 0 ? 'hidden' : '' }}">
                        {{ $pendingStudents }}
                    </span>
                </a>
                
                <a href="{{ route('admin.tutors') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.tutors') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chalkboard-teacher text-sm"></i> Tutor Roster
                    </div>
                    @php $pendingTutors = $adminSidebarCounts['pendingTutors'] ?? 0; @endphp
                    <span id="badge-pending-tutors" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-amber-500 text-white text-[9px] font-black shadow-md border border-white {{ $pendingTutors == 0 ? 'hidden' : '' }}">
                        {{ $pendingTutors }}
                    </span>
                </a>
                
                <a href="{{ route('admin.interviews') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.interviews') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar-alt text-sm"></i> Upcoming Interviews
                    </div>
                    @php $upcomingInterviews = $adminSidebarCounts['upcomingInterviews'] ?? 0; @endphp
                    <span id="badge-upcoming-interviews" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-emerald-500 text-white text-[9px] font-black shadow-md border border-white {{ $upcomingInterviews == 0 ? 'hidden' : '' }}">
                        {{ $upcomingInterviews }}
                    </span>
                </a>
                
                <a href="{{ route('admin.subjects.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.subjects.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <i class="fas fa-book text-sm"></i> Manage Subjects
                </a>
                
                <a href="{{ route('admin.bookings') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.bookings') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <i class="fas fa-calendar-check text-sm"></i> All Sessions
                </a>

                <a href="{{ route('admin.payments') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.payments') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <i class="fas fa-chart-line text-sm"></i> Platform Revenue
                </a>
                
                <a href="{{ route('admin.inquiries') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.inquiries') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-sm"></i> Contact Inquiries
                    </div>
                </a>
                
                <a href="{{ route('admin.tutor-inquiries') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('admin.tutor-inquiries') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-handshake text-sm"></i> Tutor Hire Leads
                    </div>
                    @php $pendingHireLeads = $adminSidebarCounts['pendingHireLeads'] ?? 0; @endphp
                    <span id="badge-pending-hire-leads" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-blue-600 text-white text-[9px] font-black shadow-md border border-white {{ $pendingHireLeads == 0 ? 'hidden' : '' }}">
                        {{ $pendingHireLeads }}
                    </span>
                </a>
                
                <a href="{{ route('chat.index') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('chat.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-comments text-sm"></i> Messages
                    </div>
                    @php $unreadCount = Auth::user()->unreadMessagesCount(); @endphp
                    <span id="sidebar-unread-count" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-blue-600 text-white text-[9px] font-black shadow-md border border-white {{ $unreadCount == 0 ? 'hidden' : '' }}">
                        {{ $unreadCount }}
                    </span>
                </a>

                <div class="pt-8 mt-8 border-t border-gray-50">
                    <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black text-gray-400 uppercase tracking-widest hover:bg-gray-50 hover:text-blue-600 transition-all text-left mb-2">
                        <i class="fas fa-external-link-alt text-sm"></i> Visit Site
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[11px] font-black text-red-500 uppercase tracking-widest hover:bg-red-50 hover:text-red-600 transition-all text-left">
                            <i class="fas fa-sign-out-alt text-sm"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-h-screen bg-gradient-to-br from-gray-50 to-white overflow-y-auto">
            <div class="p-10 max-w-[1600px]">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Notification Sound -->
    <audio id="notification-sound" preload="auto">
        <source src="https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3" type="audio/mpeg">
    </audio>

    <!-- Modals (rendered outside main content to avoid stacking context issues from overflow-y-auto) -->
    @stack('modals')

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-8 right-8 flex flex-col gap-3 pointer-events-none" style="z-index: 99999;"></div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sound = document.getElementById('notification-sound');
            const toastContainer = document.getElementById('toast-container');

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
                setTimeout(() => toast.classList.remove('translate-y-20', 'opacity-0'), 100);

                if (sound) sound.play().catch(e => console.log('Audio play failed:', e));

                const closeBtn = toast.querySelector('button');
                const closeToast = () => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                };
                closeBtn.onclick = closeToast;
                setTimeout(closeToast, 6000);
                
                toast.onclick = () => window.location.href = "{{ route('chat.index') }}";
            };

            // Unread count polling
            let currentUnreadCount = {{ Auth::user()->unreadMessagesCount() }};
            
            function updateAdminCounts() {
                // 1. Fetch unread messages
                fetch("{{ route('chat.unread-count') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.count > currentUnreadCount) {
                        if (!window.location.pathname.includes('/messages')) {
                            window.showChatToast('New administrative message received.', 'System Alert');
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
                });

                // 2. Fetch Global Admin Counts
                fetch("{{ route('admin.api.counts') }}")
                .then(res => res.json())
                .then(data => {
                    const updateBadge = (id, count) => {
                        const el = document.getElementById(id);
                        if (!el) return;
                        el.innerText = count;
                        if (count > 0) el.classList.remove('hidden');
                        else el.classList.add('hidden');
                    };

                    updateBadge('badge-pending-students', data.pendingStudents);
                    updateBadge('badge-pending-tutors', data.pendingTutors);
                    updateBadge('badge-upcoming-interviews', data.upcomingInterviews);
                    updateBadge('badge-pending-hire-leads', data.pendingHireLeads);
                });
            }

            setInterval(updateAdminCounts, 10000);
        });
    </script>

    @stack('scripts')
</body>
</html>
