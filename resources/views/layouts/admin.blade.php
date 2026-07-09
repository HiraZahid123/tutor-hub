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
    <div class="flex min-h-screen bg-slate-50/50">
        <!-- Sidebar -->
        <aside class="w-68 bg-slate-900 hidden md:flex flex-col sticky top-0 h-screen text-slate-300 shadow-xl shadow-slate-900/10">
            <div class="p-6 border-b border-slate-800/60 mb-4 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                    <i class="fas fa-shield-halved text-sm"></i>
                </div>
                <div>
                    <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">TutorHub</h2>
                    <p class="text-sm font-bold text-white tracking-tight">Admin Console</p>
                </div>
            </div>

            <nav class="flex-1 px-3 space-y-1.5 overflow-y-auto custom-scrollbar pb-6">
                <div class="px-3 mb-2">
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Core Portal</span>
                </div>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-home text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Dashboard
                </a>

                <a href="{{ route('admin.students') }}"
                   class="group flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.students') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-graduation-cap text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Student Connects
                    </div>
                    @php $pendingStudents = $adminSidebarCounts['pendingStudents'] ?? 0; @endphp
                    <span id="badge-pending-students" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-blue-500 text-white text-[9px] font-black border border-blue-400 {{ $pendingStudents == 0 ? 'hidden' : '' }}">
                        {{ $pendingStudents }}
                    </span>
                </a>
                
                <a href="{{ route('admin.tutors') }}"
                   class="group flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.tutors') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chalkboard-teacher text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Tutor Roster
                    </div>
                    @php $pendingTutors = $adminSidebarCounts['pendingTutors'] ?? 0; @endphp
                    <span id="badge-pending-tutors" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-amber-500 text-white text-[9px] font-black border border-amber-400 {{ $pendingTutors == 0 ? 'hidden' : '' }}">
                        {{ $pendingTutors }}
                    </span>
                </a>
                
                <a href="{{ route('admin.interviews') }}"
                   class="group flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.interviews') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar-alt text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Interviews
                    </div>
                    @php $upcomingInterviews = $adminSidebarCounts['upcomingInterviews'] ?? 0; @endphp
                    <span id="badge-upcoming-interviews" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-emerald-500 text-white text-[9px] font-black border border-emerald-400 {{ $upcomingInterviews == 0 ? 'hidden' : '' }}">
                        {{ $upcomingInterviews }}
                    </span>
                </a>

                <div class="px-3 pt-4 pb-2">
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Management</span>
                </div>
                
                <a href="{{ route('admin.subjects.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.subjects.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-book text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Subjects
                </a>
                
                <a href="{{ route('admin.bookings') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.bookings') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-calendar-check text-sm opacity-80 group-hover:scale-110 transition-transform"></i> All Sessions
                </a>
 
                <a href="{{ route('admin.payments') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.payments') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-chart-line text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Revenue
                </a>
                
                <div class="px-3 pt-4 pb-2">
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Support</span>
                </div>

                <a href="{{ route('admin.inquiries') }}"
                   class="group flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.inquiries') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-sm opacity-80 group-hover:scale-110 transition-transform"></i> General Inquiries
                    </div>
                </a>
                
                <a href="{{ route('admin.tutor-inquiries') }}"
                   class="group flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.tutor-inquiries') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-handshake text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Hire Leads
                    </div>
                    @php $pendingHireLeads = $adminSidebarCounts['pendingHireLeads'] ?? 0; @endphp
                    <span id="badge-pending-hire-leads" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-blue-500 text-white text-[9px] font-black border border-blue-400 {{ $pendingHireLeads == 0 ? 'hidden' : '' }}">
                        {{ $pendingHireLeads }}
                    </span>
                </a>
                
                <a href="{{ route('chat.index') }}"
                   class="group flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('chat.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-comments text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Messages
                    </div>
                    @php $unreadCount = Auth::user()->unreadMessagesCount(); @endphp
                    <span id="sidebar-unread-count" class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[9px] font-black border border-red-400 {{ $unreadCount == 0 ? 'hidden' : '' }}">
                        {{ $unreadCount }}
                    </span>
                </a>

                <div class="pt-6 mt-6 border-t border-slate-800/80">
                    <a href="{{ route('home') }}" class="group w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                        <i class="fas fa-external-link-alt text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Visit Website
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-950/20 hover:text-rose-300 transition-all text-left">
                            <i class="fas fa-sign-out-alt text-sm opacity-80 group-hover:scale-110 transition-transform"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-h-screen bg-slate-50/50 overflow-y-auto">
            <!-- Top Dashboard Header -->
            <header class="bg-white border-b border-slate-100 py-4 px-10 flex justify-between items-center sticky top-0 z-30">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400">Portal</span>
                    <span class="text-xs text-slate-300">/</span>
                    <span class="text-xs font-bold text-slate-800 capitalize">{{ str_replace('admin.', '', request()->route()->getName()) }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-xs font-bold text-slate-700">{{ Auth::user()->name }}</span>
                </div>
            </header>

            <div class="p-8 max-w-[1600px]">
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
