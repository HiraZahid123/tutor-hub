@extends('layouts.app')
@section('title', 'Contact Us - TutorHub')

@section('content')
<style>
.hover-lift-card {
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), border-color 0.4s ease;
}
.hover-lift-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.15);
    border-color: rgba(59, 130, 246, 0.2);
}
.hover-lift-text {
    display: inline-block;
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), color 0.4s ease;
}
.hover-lift-card:hover .hover-lift-text {
    transform: translateY(-3px);
}
.input-group-lift {
    transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), border-color 0.3s ease, background-color 0.3s ease;
    border: 1px solid transparent;
}
.input-group-lift:hover {
    transform: translateY(-5px) scale(1.01);
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.06);
    border-color: rgba(59, 130, 246, 0.15);
    background-color: rgba(239, 246, 255, 0.25);
}
.input-group-lift:hover .hover-lift-text {
    transform: translateY(-2px);
}
</style>

<section class="bg-white py-20 px-6 text-[#2f2f2f] font-sans">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16" data-aos="zoom-in">
            <h2 class="text-5xl font-extrabold text-blue-600 mb-4">Get in Touch</h2>
            <p class="text-lg text-[#5e5e5e] max-w-2xl mx-auto">
                We value every query and message. Feel free to drop a line, and our team will get back to you swiftly!
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-14 items-start">
            <div class="space-y-8" data-aos="fade-right">
                <div class="hover-lift-card flex items-center space-x-4 bg-white p-6 rounded-2xl shadow-md border border-transparent">
                    <i class="fas fa-phone text-xl text-blue-500 hover-lift-text"></i>
                    <div>
                        <h4 class="hover-lift-text text-sm font-bold text-blue-500 uppercase tracking-wider mb-0.5 block">Phone / WhatsApp</h4>
                        <a href="https://wa.me/923414133395" target="_blank" class="hover-lift-text text-[#2f2f2f] text-sm hover:text-emerald-600 transition-colors font-medium block mt-1">+923414133395</a>
                    </div>
                </div>
                <div class="hover-lift-card flex items-center space-x-4 bg-white p-6 rounded-2xl shadow-md border border-transparent">
                    <i class="fas fa-envelope text-xl text-blue-500 hover-lift-text"></i>
                    <div>
                        <h4 class="hover-lift-text text-sm font-bold text-blue-500 uppercase tracking-wider mb-0.5 block">Email</h4>
                        <p class="hover-lift-text text-[#2f2f2f] text-sm font-medium block mt-1">support@tutorhub.com</p>
                    </div>
                </div>
                <div class="hover-lift-card flex items-center space-x-4 bg-white p-6 rounded-2xl shadow-md border border-transparent">
                    <i class="fas fa-clock text-xl text-blue-500 hover-lift-text"></i>
                    <div>
                        <h4 class="hover-lift-text text-sm font-bold text-blue-500 uppercase tracking-wider mb-0.5 block">Working Hours</h4>
                        <p class="hover-lift-text text-[#2f2f2f] text-sm font-medium block mt-1">24/7</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('contact.store') }}" method="POST"
                  class="hover-lift-card bg-white p-10 rounded-3xl shadow-2xl space-y-6 border border-transparent" data-aos="fade-left">
                @csrf

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="input-group-lift p-4 rounded-2xl">
                    <label class="hover-lift-text block text-blue-600 font-semibold mb-2">Full Name</label>
                    <input type="text" name="name" placeholder="Ali Sultan" required
                           class="w-full p-3 border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('name') }}">
                    @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="input-group-lift p-4 rounded-2xl">
                    <label class="hover-lift-text block text-blue-600 font-semibold mb-2">Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com" required
                           class="w-full p-3 border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('email') }}">
                    @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="input-group-lift p-4 rounded-2xl">
                    <label class="hover-lift-text block text-blue-600 font-semibold mb-2">Your Message</label>
                    <textarea name="message" placeholder="How can we help you?" rows="5" required
                              class="w-full p-3 border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('message') }}</textarea>
                    @error('message') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-md transition transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-paper-plane text-lg"></i> Send Message
                </button>
            </form>
        </div>

        <div class="mt-20 text-center" data-aos="fade-up">
            <p class="text-[#888] italic">
                We typically respond within 24 hours. Thank you for choosing our tutoring services.
            </p>
        </div>
    </div>
</section>
@endsection
