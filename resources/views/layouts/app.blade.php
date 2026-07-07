<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="TutorHub - Find your perfect tutor for 1-on-1 lessons. Expert tutors, affordable prices, interactive learning.">
    <title>@yield('title', 'TutorHub - Find Your Perfect Tutor')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS (Animate on Scroll) -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Slick Carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        let token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-Outfit overflow-x-hidden">

    @include('partials.navbar')
    @include('partials.navbar-title')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.chatbot')

    @stack('modals')

    <!-- jQuery (for Slick) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- Slick Carousel JS -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>

    <!-- CountUp JS -->
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-in-out',
        });

        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const closeBtn = document.getElementById('close-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('mobile-overlay');

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
            });
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', closeMobileMenu);
        }
        if (overlay) {
            overlay.addEventListener('click', closeMobileMenu);
        }

        function closeMobileMenu() {
            mobileMenu.classList.add('translate-x-full');
            overlay.classList.add('hidden');
        }

        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
    </script>

    @stack('scripts')
</body>
</html>
