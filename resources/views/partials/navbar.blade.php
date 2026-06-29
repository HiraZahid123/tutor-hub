@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $navLinks = [
        ['route' => 'home', 'label' => 'Home'],
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'contact', 'label' => 'Contact'],
        ['route' => 'for-students', 'label' => 'Best Tutors'],
    ];
@endphp

<!-- Main Navbar -->
<header class="relative bg-white shadow-md z-50" data-aos="fade-in" data-aos-duration="1000">
    <nav class="container flex items-center justify-between py-5">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <i class="fas fa-laptop text-3xl text-blue-600"></i>
            <span class="text-2xl font-bold text-blue-600">Tutor Hub</span>
        </a>

        <!-- Desktop Nav Links -->
        <ul class="hidden lg:flex items-center gap-8">
            @foreach($navLinks as $link)
                <li>
                    <a href="{{ route($link['route']) }}"
                       class="text-lg font-medium transition-all {{ $currentRoute === $link['route'] ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' }}">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach

            <!-- Become a Tutor Dropdown -->
            <li class="relative" id="bat-wrapper">
                <span onclick="toggleBatDropdown(event)"
                      class="text-lg font-medium cursor-pointer text-gray-700 hover:text-blue-600 select-none flex items-center gap-1">
                    Become a Tutor
                    <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" id="bat-chevron"></i>
                </span>
                <ul id="bat-dropdown"
                    class="hidden absolute top-10 left-0 w-60 bg-white border border-gray-200 shadow-xl rounded-md z-50"
                    style="animation:batFadeIn 0.18s ease;">
                    <li>
                        <a href="{{ route('tutor-policy') }}" class="block px-5 py-3 hover:bg-gray-100 text-gray-700 hover:text-blue-600">
                            Tutor Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tutoring-process') }}" class="block px-5 py-3 hover:bg-gray-100 text-gray-700 hover:text-blue-600">
                            Tutoring Flow
                        </a>
                    </li>
                    <li class="px-5 py-3">
                        <a href="{{ route('register', ['role' => 'tutor']) }}" class="block text-center w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-all">
                            Register
                        </a>
                    </li>
                </ul>
            </li>
            <style>
                @keyframes batFadeIn {
                    from { opacity:0; transform:translateY(-6px); }
                    to   { opacity:1; transform:translateY(0); }
                }
            </style>
            <script>
                function toggleBatDropdown(e) {
                    e.stopPropagation();
                    const dd      = document.getElementById('bat-dropdown');
                    const chevron = document.getElementById('bat-chevron');
                    const isOpen  = !dd.classList.contains('hidden');
                    dd.classList.toggle('hidden', isOpen);
                    chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
                }
                document.addEventListener('click', function(e) {
                    const wrapper = document.getElementById('bat-wrapper');
                    if (wrapper && !wrapper.contains(e.target)) {
                        document.getElementById('bat-dropdown').classList.add('hidden');
                        document.getElementById('bat-chevron').style.transform = '';
                    }
                });
            </script>
        </ul>

        <!-- Desktop Buttons -->
        <div class="hidden lg:flex items-center gap-4">
            @auth
                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::user()->isTutor() ? route('tutor.dashboard') : route('student.dashboard')) }}">
                    <button class="text-lg font-medium bg-blue-600 text-white px-7 py-2 rounded-md ml-4 hover:bg-blue-700 hover:shadow-lg transition-all duration-300 hover:scale-105">
                        Dashboard
                    </button>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <button style="width:160px;height:44px;font-size:15px;font-weight:600;border-radius:6px;border:2px solid #2563EB;background:#fff;color:#2563EB;box-sizing:border-box;cursor:pointer;transition:all 0.3s;">
                        Login
                    </button>
                </a>
                <a href="{{ route('find-a-tutor') }}">
                    <button style="width:160px;height:44px;font-size:15px;font-weight:600;border-radius:6px;border:2px solid #2563EB;background:#2563EB;color:#fff;box-sizing:border-box;cursor:pointer;transition:all 0.3s;">
                        Request Tutor
                    </button>
                </a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <div class="lg:hidden">
            <button id="menu-btn" class="text-3xl cursor-pointer">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
</header>

<!-- Mobile Overlay -->
<div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<!-- Mobile Menu -->
<ul id="mobile-menu" class="fixed inset-0 bg-white z-50 flex flex-col gap-4 p-6 lg:hidden transform translate-x-full transition-transform duration-500">
    <li class="flex items-center justify-between border-b pb-4 mb-4">
        <div class="flex items-center gap-2">
            <i class="fas fa-laptop text-4xl text-blue-600"></i>
            <span class="text-2xl font-bold text-blue-600">Tutor Hub</span>
        </div>
        <button id="close-btn" class="text-3xl cursor-pointer">
            <i class="fas fa-xmark"></i>
        </button>
    </li>

    <li class="px-4 py-2">
        <input type="text" placeholder="Search..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600">
    </li>

    @foreach($navLinks as $link)
        <li>
            <a href="{{ route($link['route']) }}"
               class="block text-lg font-medium px-4 py-2 {{ $currentRoute === $link['route'] ? 'text-blue-600 font-semibold shadow-lg' : 'text-gray-700 hover:text-blue-600' }}">
                {{ $link['label'] }}
            </a>
        </li>
    @endforeach

    <li>
        <a href="{{ route('tutor-policy') }}" class="block text-lg font-medium px-4 py-2 text-gray-700 hover:text-blue-600">
            Become a Tutor
        </a>
    </li>

    <li>
        <a href="{{ route('register') }}">
            <button class="block w-full text-lg font-medium bg-blue-600 text-white px-4 py-2 rounded-md mt-2 hover:shadow-lg hover:bg-blue-700 transition-all">
                Sign Up
            </button>
        </a>
    </li>

    @auth
        <li>
            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::user()->isTutor() ? route('tutor.dashboard') : route('student.dashboard')) }}">
                <button class="block w-full text-lg font-medium bg-white text-blue-600 px-4 py-2 rounded-md mt-2 hover:shadow-lg transition-all border border-blue-600">
                    Dashboard
                </button>
            </a>
        </li>
    @else
        <li>
            <a href="{{ route('login') }}">
                <button class="block w-full text-lg font-medium bg-white text-blue-600 px-4 py-2 rounded-md mt-2 hover:shadow-lg transition-all border border-blue-600">
                    Sign In
                </button>
            </a>
        </li>
    @endauth
</ul>
