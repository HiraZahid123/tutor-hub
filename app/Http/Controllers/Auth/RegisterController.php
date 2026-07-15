<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        $role = $request->get('role', 'student');
        return view('auth.register', compact('role'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,tutor'],
            'g-recaptcha-response' => ['required', function ($attribute, $value, $fail) {
                $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);

                if (!$response->json('success')) {
                    $fail('The Google reCAPTCHA verification failed. Please try again.');
                }
            }],
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);
        
        if ($user->role === 'tutor') {
            return redirect()->route('register-tutor');
        }
        return redirect('/student/dashboard');
    }
}
