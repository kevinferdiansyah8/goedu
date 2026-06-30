@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f8fafc] p-4 font-['Lexend_Deca']">
    <div class="max-w-md w-full">
        {{-- Logo & Header --}}
        <div class="text-center mb-10 flex flex-col items-center justify-center">
            <img src="{{ asset('images/goedu_logo.png') }}" alt="GoEdu Logo" class="h-28 w-auto object-contain mb-4">
            <p class="text-gray-500 mt-2 font-medium">Sistem Informasi Akademik Terintegrasi</p>
        </div>

        {{-- Forgot Password Card --}}
        <div class="bg-white rounded-[32px] shadow-2xl shadow-blue-100/50 p-8 border border-gray-100 backdrop-blur-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Lupa Password?</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-6">Masukkan email Anda untuk melakukan verifikasi akun.</p>

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Email Terdaftar</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="email" name="email" required autofocus placeholder="nama@sekolah.sch.id" value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3 group cursor-pointer">
                    LANJUT VERIFIKASI
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali ke Halaman Login
                    </a>
                </div>
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
</script>
@endsection
