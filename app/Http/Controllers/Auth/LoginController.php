<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        // 1. Rate Limiting Check
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        // 2. Validate standard fields and Turnstile CAPTCHA
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'cf-turnstile-response' => ['required', 'string'],
        ]);

        // Validate Turnstile CAPTCHA token with Cloudflare
        try {
            $response = Http::withoutVerifying()->asForm()->timeout(5)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]);

            $success = $response->json('success');
        } catch (\Exception $e) {
            \Log::error('Cloudflare Turnstile verification error: ' . $e->getMessage());
            // Fallback to true in local/development environment to prevent blockages
            $success = app()->environment('local');
        }

        if (!$success) {
            RateLimiter::hit($throttleKey, 60); // lock/throttle counter increment
            return back()->withErrors([
                'captcha' => 'Verifikasi keamanan (CAPTCHA) gagal.',
            ])->onlyInput('email');
        }

        // 3. Attempt Login
        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Clear rate limit on success
            RateLimiter::clear($throttleKey);

            // Set role in session for legacy sidebar logic if needed
            session(['role' => Auth::user()->role]);

            return $this->redirectBasedOnRole(Auth::user());
        }

        // Increment rate limit on authentication failure
        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            case 'orangtua':
                return redirect()->route('orangtua.dashboard');
            case 'keuangan':
                return redirect()->route('keuangan.dashboard');
            default:
                return redirect('/');
        }
    }
}
