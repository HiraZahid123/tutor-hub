<!-- Footer -->
<div class="text-white" style="background: linear-gradient(160deg, #1e3a8a 0%, #1d4ed8 60%, #2563eb 100%);">
    <footer class="py-14">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                <!-- Brand & Address -->
                <div class="lg:col-span-1 pr-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-white mb-6">
                        <i class="fas fa-laptop text-3xl text-orange-400"></i>
                        <span class="text-2xl font-bold text-white">Tutor Hub</span>
                    </a>
                    <p class="text-blue-200 text-sm leading-relaxed mb-8">
                        Tutor Hub connects students with trusted, subject-expert tutors for focused and personalized learning. We empower learners to succeed with clarity, confidence, and care.
                    </p>
                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-white mb-3 uppercase tracking-widest">Head Office Address</h4>
                        <p class="text-blue-200 text-sm leading-relaxed flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-orange-400 mt-1"></i>
                            2nd Floor, 81 Commercial, Umer Block, Bahria Town, Lahore
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="https://www.youtube.com/@AHomeTuitionServices" target="_blank" class="w-10 h-10 flex items-center justify-center bg-blue-800/60 border border-blue-600/50 rounded-full hover:bg-orange-500 hover:border-orange-500 transition-all text-[#FF0000] hover:text-white shadow-sm" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.facebook.com/ahometuitionservices" target="_blank" class="w-10 h-10 flex items-center justify-center bg-blue-800/60 border border-blue-600/50 rounded-full hover:bg-orange-500 hover:border-orange-500 transition-all text-blue-200 hover:text-white shadow-sm" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/aftabalam7984" target="_blank" class="w-10 h-10 flex items-center justify-center bg-blue-800/60 border border-blue-600/50 rounded-full hover:bg-orange-500 hover:border-orange-500 transition-all text-pink-300 hover:text-white shadow-sm" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.threads.net/@aftabalam7984" target="_blank" class="w-10 h-10 flex items-center justify-center bg-blue-800/60 border border-blue-600/50 rounded-full hover:bg-orange-500 hover:border-orange-500 transition-all text-white shadow-sm" title="Threads"><i class="fab fa-threads"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h2 class="text-lg font-bold text-white mb-6">Quick Links</h2>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> About Us</a></li>
                        <li><a href="{{ route('services') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Services</a></li>
                        <li><a href="{{ route('tutoring-process') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> How It Works</a></li>
                    </ul>
                </div>

                <!-- Help & Support -->
                <div>
                    <h2 class="text-lg font-bold text-white mb-6">Help &amp; Support</h2>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Help Center</a></li>
                        <li><a href="#" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Frequently Asked Questions</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Contact Us</a></li>
                        <li><a href="#" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Discover more -->
                <div>
                    <h2 class="text-lg font-bold text-white mb-6">Discover more</h2>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Our Subjects</a></li>
                        <li><a href="{{ route('for-students') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Top tutor</a></li>
                        <li><a href="{{ route('register-tutor') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Apply as a Tutor</a></li>
                        <li><a href="{{ route('tutors.directory') }}" class="text-sm font-medium text-blue-200 hover:text-orange-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-orange-400"></i> Find a Tutor</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div class="container">
        <div class="text-center pb-8 pt-4">
            <div class="w-full h-px bg-blue-700/60 block mb-6"></div>
            <span class="block text-sm text-blue-200 font-medium tracking-wide">
                &copy; {{ date('Y') }} <strong class="text-white">Tutor Hub</strong>. All rights reserved.
            </span>
        </div>
    </div>
</div>
