@extends('layouts.dashboard')
@section('title', 'My Profile - TutorHub')

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 mb-2">My Profile Settings</h1>
        <p class="text-gray-500 font-medium">Manage your personal information and account security.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50/50 border border-green-100 text-green-700 p-5 rounded-3xl mb-8 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 p-5 rounded-3xl mb-8">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-bold">Please correct the following:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-medium opacity-80">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="max-w-3xl mx-auto space-y-8">
            <!-- Account Info -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Personal Info</h3>
                        <p class="text-xs font-bold text-gray-400">Update your account name and email.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" placeholder="e.g. john@example.com" required>
                    </div>
                </div>
            </div>

            <!-- Password Info -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-500/5 border border-gray-100">
                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                    <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Security</h3>
                        <p class="text-xs font-bold text-gray-400">Secure your account with a strong password.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">New Password</label>
                        <input type="password" name="password" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" placeholder="Leave blank to keep current">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" placeholder="Confirm your new password">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-12 py-5 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 leading-none">
                    Save Profile Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
