@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f8fafc] p-4 font-['Lexend_Deca']">
    <div class="max-w-md w-full">
        {{-- Logo & Header --}}
        <div class="text-center mb-10 flex flex-col items-center justify-center">
            <img src="{{ asset('images/goedu_logo.png') }}" alt="GoEdu Logo" class="h-28 w-auto object-contain mb-4">
            <p class="text-gray-500 mt-2 font-medium">Sistem Informasi Akademik Terintegrasi</p>
        </div>

        {{-- Reset Password Card --}}
        <div class="bg-white rounded-[32px] shadow-2xl shadow-blue-100/50 p-8 border border-gray-100 backdrop-blur-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Reset Password</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-6">Mengatur ulang kata sandi untuk akun <span class="text-blue-600 lowercase">{{ $email }}</span></p>

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update', ['email' => $email]) }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password Baru</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-blue-600 transition-colors"></i>
                        <input id="password-new" type="password" name="password" required autofocus placeholder="Minimal 6 karakter"
                            class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 outline-none transition-all">
                        <button type="button" onclick="togglePassword('password-new', 'icon-new')" class="absolute right-4 top-3.5 text-gray-400 hover:text-blue-600 focus:outline-none transition-colors cursor-pointer" aria-label="Toggle Password Visibility">
                            <i id="icon-new" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Password Baru</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-blue-600 transition-colors"></i>
                        <input id="password-confirm" type="password" name="password_confirmation" required placeholder="Ulangi password baru"
                            class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 outline-none transition-all">
                        <button type="button" onclick="togglePassword('password-confirm', 'icon-confirm')" class="absolute right-4 top-3.5 text-gray-400 hover:text-blue-600 focus:outline-none transition-colors cursor-pointer" aria-label="Toggle Password Visibility">
                            <i id="icon-confirm" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3 group cursor-pointer">
                    PERBARUI PASSWORD
                    <i data-lucide="check" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
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

    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
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
