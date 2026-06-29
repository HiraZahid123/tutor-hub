@extends('layouts.app')
@section('title', 'Contact Us - TutorHub')

@section('content')
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
                <div class="flex items-center space-x-4 bg-white p-4 rounded-2xl shadow-md">
                    <i class="fas fa-phone text-xl text-blue-500"></i>
                    <div>
                        <h4 class="text-sm font-bold text-blue-500 uppercase tracking-wider mb-0.5">Phone / WhatsApp</h4>
                        <a href="https://wa.me/923414133395" target="_blank" class="text-[#2f2f2f] text-sm hover:text-emerald-600 transition-colors font-medium">+923414133395</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4 bg-white p-4 rounded-2xl shadow-md">
                    <i class="fas fa-envelope text-xl text-blue-500"></i>
                    <div>
                        <h4 class="text-sm font-bold text-blue-500 uppercase tracking-wider mb-0.5">Email</h4>
                        <p class="text-[#2f2f2f] text-sm font-medium">support@tutorhub.com</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 bg-white p-4 rounded-2xl shadow-md">
                    <i class="fas fa-clock text-xl text-blue-500"></i>
                    <div>
                        <h4 class="text-sm font-bold text-blue-500 uppercase tracking-wider mb-0.5">Working Hours</h4>
                        <p class="text-[#2f2f2f] text-sm font-medium">Mon – Sat: 9:00 AM – 7:00 PM</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('contact.store') }}" method="POST"
                  class="bg-white p-10 rounded-3xl shadow-2xl space-y-6" data-aos="fade-left">
                @csrf

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <label class="block text-blue-600 font-semibold mb-2">Full Name</label>
                    <input type="text" name="name" placeholder="Ali Sultan" required
                           class="w-full p-3 border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('name') }}">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-blue-600 font-semibold mb-2">Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com" required
                           class="w-full p-3 border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('email') }}">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-blue-600 font-semibold mb-2">Your Message</label>
                    <textarea name="message" placeholder="How can we help you?" rows="5" required
                              class="w-full p-3 border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('message') }}</textarea>
                    @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
