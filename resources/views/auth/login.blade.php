@extends('layouts.app')
@section('title', 'Login - TutorHub')

@section('content')
<div class="flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 my-5">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-primary">Log in to your account</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">create a new account</a>
            </p>
        </div>
        
        @if ($errors->any())
            <div class="mb-4 bg-red-50 p-4 rounded-md">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Email address" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Password">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Sign in
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
