<!-- Navbar Title Bar -->
<style>
@keyframes navbar-blink {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.35; }
}
.navbar-blink-text { animation: navbar-blink 1.4s ease-in-out infinite; }
</style>
<div class="bg-blue-600 py-2 shadow-md" data-aos="fade-right" data-aos-duration="1000">
    <p class="navbar-blink-text text-center text-sm lg:text-lg font-medium text-white">
        Are you a university or school student looking for an online tutoring partnership?
        <a href="{{ route('contact') }}" class="ml-3 font-semibold inline-block hover:bg-white hover:text-blue-900 hover:shadow-lg hover:rounded-lg hover:px-3 hover:py-1 transition-all duration-200">
            Talk to us
        </a>
    </p>
</div>
