@extends('layouts.app')
@section('title', 'Register - TutorHub')

@section('content')
<div class="flex items-center justify-center bg-gray-50 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 md:p-10 rounded-3xl shadow-xl shadow-blue-500/5 border border-blue-50/50">
        <div>
            <h2 class="text-center text-3xl font-black text-gray-900 tracking-tight leading-tight">Create an account</h2>
            <p class="mt-2.5 text-center text-sm text-gray-500 font-medium">
                Already have an account? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-500">Log in</a>
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 p-4 rounded-xl">
                <ul class="list-disc list-inside text-xs font-semibold text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="space-y-6" action="{{ route('register.submit') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Full Name</label>
                    <input id="name" name="name" type="text" required 
                           class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" 
                           placeholder="John Doe" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="email" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Email address</label>
                    <input id="email" name="email" type="email" required 
                           class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" 
                           placeholder="Email address" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="password" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" 
                           placeholder="Password">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400/80 placeholder:font-normal focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/5 transition-all outline-none" 
                           placeholder="Confirm Password">
                </div>
                <div>
                    <label for="role" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">I am a...</label>
                    <div class="relative">
                        <select id="role" name="role" required 
                                class="w-full px-5 py-3.5 bg-gray-50/60 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="student" {{ (old('role', $role ?? '') == 'student') ? 'selected' : '' }}>Student / Parent</option>
                            <option value="tutor" {{ (old('role', $role ?? '') == 'tutor') ? 'selected' : '' }}>Tutor</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-bold text-sm uppercase tracking-wider transition-all shadow-lg shadow-blue-500/10 active:scale-95 flex items-center justify-center">
                    Register
                </button>
            </div>
        </form>

        {{-- Separator --}}
        <div class="relative flex items-center justify-center my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-100"></div>
            </div>
            <span class="relative px-4 text-[10px] font-bold text-gray-400 bg-white uppercase tracking-widest">
                OR
            </span>
        </div>

        {{-- Social Logins --}}
        <div class="space-y-3">
            {{-- Google Button --}}
            <a href="{{ route('login.social', ['provider' => 'google']) }}" 
               class="w-full flex items-center justify-center gap-3 py-3.5 px-4 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 active:scale-[0.98] transition-all hover:border-gray-300">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                    <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.48c0,-0.62 -0.06,-1.21 -0.16,-1.78z" fill="#4285F4" />
                    <path d="M12,20.6c2.6,0 4.78,-0.86 6.38,-2.33l-3.3,-2.58c-0.91,0.61 -2.08,0.98 -3.08,0.98c-2.37,0 -4.38,-1.6 -5.1,-3.75H3.5v2.66c1.6,3.18 4.9,5.02 8.5,5.02z" fill="#34A853" />
                    <path d="M6.9,12.93c-0.18,-0.54 -0.28,-1.11 -0.28,-1.7c0,-0.59 0.1,-1.16 0.28,-1.7V6.87H3.5c-0.6,1.2 -0.95,2.56 -0.95,4c0,1.44 0.35,2.8 0.95,4l2.6,-2.03c-0.18,-0.54 -0.28,-1.11 -0.28,-1.7z" fill="#FBBC05" />
                    <path d="M12,5.22c1.41,0 2.68,0.49 3.68,1.44l2.76,-2.76C16.78,2.4 14.6,1.4 12,1.4C8.4,1.4 5.1,3.24 3.5,6.42l3.4,2.66c0.72,-2.15 2.73,-3.75 5.1,-3.75z" fill="#EA4335" />
                </svg>
                <span>Continue with Google</span>
            </a>

            {{-- Apple Button --}}
            <a href="{{ route('login.social', ['provider' => 'apple']) }}" 
               class="w-full flex items-center justify-center gap-3 py-3.5 px-4 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 active:scale-[0.98] transition-all hover:border-gray-300">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.06-1 .04-2.2.67-2.92 1.5-.63.72-1.18 1.86-1.03 2.97 1.12.09 2.27-.58 2.96-1.41z"/>
                </svg>
                <span>Continue with Apple</span>
            </a>
        </div>
    </div>
</div>
@endsection
