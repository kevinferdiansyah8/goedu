@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f8fafc] p-4 font-['Lexend_Deca']">
    <div class="max-w-md w-full">
        {{-- Logo & Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl shadow-xl shadow-indigo-100 mb-4 transform hover:rotate-12 transition-transform duration-300">
                <i data-lucide="graduation-cap" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">GOEDU</h1>
            <p class="text-gray-500 mt-2 font-medium">Sistem Informasi Akademik Terintegrasi</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white rounded-[32px] shadow-2xl shadow-indigo-100/50 p-8 border border-gray-100 backdrop-blur-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Selamat Datang Kembali</h2>

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
                        <i data-lucide="mail" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                        <input type="email" name="email" required autofocus placeholder="nama@sekolah.sch.id"
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-between py-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-bold text-gray-500 group-hover:text-gray-700 transition-colors">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Lupa Password?</a>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3 group">
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
</script>
@endsection
