@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f8fafc] p-4 font-['Lexend_Deca']">
    <div class="max-w-md w-full">
        {{-- Logo & Header --}}
        <div class="text-center mb-10 flex flex-col items-center justify-center">
            <img src="{{ asset('images/goedu_logo.png') }}" alt="GoEdu Logo" class="h-28 w-auto object-contain mb-4">
            <p class="text-gray-500 mt-2 font-medium">Sistem Informasi Akademik Terintegrasi</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white rounded-[32px] shadow-2xl shadow-blue-100/50 p-8 border border-gray-100 backdrop-blur-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Selamat Datang Kembali</h2>

            @if(session('status'))
                <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="email" name="email" required autofocus placeholder="nama@sekolah.sch.id"
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-blue-600 transition-colors"></i>
                        <input id="password-input" type="password" name="password" required placeholder="••••••••"
                            class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 outline-none transition-all">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-4 top-3.5 text-gray-400 hover:text-blue-600 focus:outline-none transition-colors cursor-pointer" aria-label="Toggle Password Visibility">
                            <i id="toggle-password-icon" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Cloudflare Turnstile Widget -->
                <div class="py-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Verifikasi Keamanan</label>
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.key') }}" data-theme="light"></div>
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                </div>

                <div class="flex items-center justify-between py-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-bold text-gray-500 group-hover:text-gray-700 transition-colors">Ingat Saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">Lupa Password?</a>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3 group cursor-pointer">
                    MASUK KE DASHBOARD
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>

        {{-- Footer Info --}}
        <p class="text-center text-gray-400 text-xs mt-10 font-medium uppercase tracking-widest">
            &copy; 2026 GOEDU Ecosystem &bull; Versi 2.1
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) lucide.createIcons();
    });

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password-input');
        const toggleIcon = document.getElementById('toggle-password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            passwordInput.type = 'password';
            toggleIcon.setAttribute('data-lucide', 'eye');
        }
        if (window.lucide) {
            lucide.createIcons();
        }
    }
</script>
@endsection
