<!-- Footer -->
<div style="background-color: #e1f5fe;">
    <footer class="py-14">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                <!-- Brand & Address -->
                <div class="lg:col-span-1 pr-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-slate-800 mb-6">
                        <i class="fas fa-laptop text-3xl text-blue-600"></i>
                        <span class="text-2xl font-bold text-slate-800">Tutor Hub</span>
                    </a>
                    <p class="text-slate-600 text-sm leading-relaxed mb-8">
                        Tutor Hub connects students with trusted, subject-expert tutors for focused and personalized learning. We empower learners to succeed with clarity, confidence, and care.
                    </p>
                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-widest">Head Office Address</h4>
                        <p class="text-slate-600 text-sm leading-relaxed flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-blue-600 mt-1"></i>
                            2nd Floor, 81 Commercial, Umer Block, Bahria Town, Lahore
                        </p>
                    </div>
                    <div class="footer-social-icons flex items-center gap-3 flex-nowrap">
                        <a href="https://www.youtube.com/@AHomeTuitionServices" target="_blank" rel="noopener noreferrer"
                           class="footer-social-link shrink-0 w-11 h-11 flex items-center justify-center bg-white rounded-xl border border-sky-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"
                           title="YouTube">
                            <i class="fab fa-youtube text-xl" style="color: #FF0000;"></i>
                        </a>
                        <a href="https://www.facebook.com/ahometuitionservices" target="_blank" rel="noopener noreferrer"
                           class="footer-social-link shrink-0 w-11 h-11 flex items-center justify-center bg-white rounded-xl border border-sky-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"
                           title="Facebook">
                            <i class="fab fa-facebook-f text-xl" style="color: #1877F2;"></i>
                        </a>
                        <a href="https://www.instagram.com/aftabalam7984" target="_blank" rel="noopener noreferrer"
                           class="footer-social-link shrink-0 w-11 h-11 flex items-center justify-center bg-white rounded-xl border border-sky-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"
                           title="Instagram">
                            <i class="fab fa-instagram text-xl" style="color: #E4405F;"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/hafiz-aftab-alam-b7b676411" target="_blank" rel="noopener noreferrer"
                           class="footer-social-link shrink-0 w-11 h-11 flex items-center justify-center bg-white rounded-xl border border-sky-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"
                           title="LinkedIn">
                            <i class="fab fa-linkedin-in text-xl" style="color: #0A66C2;"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h2 class="text-lg font-bold text-slate-800 mb-6">Quick Links</h2>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> About Us</a></li>
                        <li><a href="{{ route('services') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Services</a></li>
                        <li><a href="{{ route('tutoring-process') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> How It Works</a></li>
                    </ul>
                </div>

                <!-- Help & Support -->
                <div>
                    <h2 class="text-lg font-bold text-slate-800 mb-6">Help &amp; Support</h2>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Help Center</a></li>
                        <li><a href="#" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Frequently Asked Questions</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Contact Us</a></li>
                        <li><a href="#" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Discover more -->
                <div>
                    <h2 class="text-lg font-bold text-slate-800 mb-6">Discover more</h2>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Our Subjects</a></li>
                        <li><a href="{{ route('for-students') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Top tutor</a></li>
                        <li><a href="{{ route('register-tutor') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Apply as a Tutor</a></li>
                        <li><a href="{{ route('tutors.directory') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-blue-600"></i> Find a Tutor</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div class="container">
        <div class="text-center pb-8 pt-4">
            <hr class="border-0 h-px bg-sky-300/70 mb-6">
            <span class="block text-sm text-slate-600 font-medium tracking-wide">
                &copy; {{ date('Y') }} <strong class="text-slate-800">Tutor Hub</strong>. All rights reserved.
            </span>
        </div>
    </div>
</div>

<style>
    .footer-social-icons .footer-social-link i {
        line-height: 1;
    }
    .footer-social-icons .footer-social-link:hover i {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
</style>
