<!-- Footer -->
<div class="bg-blue-50">
    <footer class="py-14">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                <!-- Brand & Address -->
                <div class="lg:col-span-1 pr-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-blue-600 mb-6">
                        <i class="fas fa-laptop text-3xl text-blue-600"></i>
                        <span class="text-2xl font-bold text-gray-900">Tutor Hub</span>
                    </a>
                    <p class="text-gray-600 text-sm leading-relaxed mb-8">
                        Tutor Hub connects students with trusted, subject-expert tutors for focused and personalized learning. We empower learners to succeed with clarity, confidence, and care.
                    </p>
                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-widest">Head Office Address</h4>
                        <p class="text-gray-600 text-sm leading-relaxed flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-blue-600 mt-1"></i>
                            2nd Floor, 81 Commercial, Umer Block, Bahria Town, Lahore
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-10 h-10 flex items-center justify-center bg-white border border-blue-100 rounded-full hover:bg-blue-600 hover:text-white transition-all text-[#FF0000] shadow-sm"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center bg-white border border-blue-100 rounded-full hover:bg-blue-600 hover:text-white transition-all text-[#1877F2] shadow-sm"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center bg-white border border-blue-100 rounded-full hover:bg-blue-600 hover:text-white transition-all text-[#E1306C] shadow-sm"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center bg-white border border-blue-100 rounded-full hover:bg-blue-600 hover:text-white transition-all text-black shadow-sm"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center bg-white border border-blue-100 rounded-full hover:bg-blue-600 hover:text-white transition-all text-[#0A66C2] shadow-sm"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Quick Links</h2>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> About Us</a></li>
                        <li><a href="{{ route('services') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Services</a></li>
                        <li><a href="{{ route('tutoring-process') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> How It Works</a></li>
                    </ul>
                </div>

                <!-- Help & Support -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Help & Support</h2>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Help Center</a></li>
                        <li><a href="#" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Frequently Asked Questions</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Contact Us</a></li>
                        <li><a href="#" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Discover more -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Discover more</h2>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Our Subjects</a></li>
                        <li><a href="{{ route('for-students') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Top tutor</a></li>
                        <li><a href="{{ route('register-tutor') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Apply as a Tutor</a></li>
                        <li><a href="{{ route('tutors.directory') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-300"></i> Find a Tutor</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div class="container">
        <div class="text-center pb-8 pt-4">
            <div class="w-full h-px bg-blue-200/50 block mb-6"></div>
            <span class="block text-sm text-gray-500 font-medium tracking-wide">
                &copy; {{ date('Y') }} <strong class="text-gray-900">Tutor Hub</strong>. All rights reserved.
            </span>
        </div>
    </div>
</div>
