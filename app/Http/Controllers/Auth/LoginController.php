<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            if ($role === 'tutor') {
                return redirect()->intended('/tutor/dashboard');
            }
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function socialRedirect($provider)
    {
        if (!in_array($provider, ['google', 'apple'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function socialCallback($provider)
    {
        if (!in_array($provider, ['google', 'apple'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Social login failed. Please try again.',
            ]);
        }

        // Check if user already exists in DB by email or by provider ID
        $user = \App\Models\User::where('email', $socialUser->getEmail())
            ->orWhere($provider . '_id', $socialUser->getId())
            ->first();

        if ($user) {
            // Update provider ID if not set
            if (!$user->{$provider . '_id'}) {
                $user->{$provider . '_id'} = $socialUser->getId();
                $user->save();
            }
        } else {
            // Create a new user account
            $user = new \App\Models\User();
            $user->name = $socialUser->getName() ?? $socialUser->getNickname() ?? explode('@', $socialUser->getEmail())[0];
            $user->email = $socialUser->getEmail();
            $user->{$provider . '_id'} = $socialUser->getId();
            $user->password = \Illuminate\Support\Facades\Hash::make(Str::random(24));
            $user->role = 'student'; // Default role is student
            $user->save();
        }

        Auth::login($user);
        session()->regenerate();

        return redirect()->intended('/student/dashboard')->with('success', 'Logged in successfully via ' . ucfirst($provider) . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
