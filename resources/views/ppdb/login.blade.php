@extends('layouts.ppdb')
@section('title', 'Masuk Akun — PPDB EDUGO')
@section('content')

<section class="min-h-[calc(100vh-120px)] flex items-center justify-center py-10 px-4">
  <div class="w-full max-w-md">

    {{-- Logo & Header --}}
    <div class="text-center mb-8">
      <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
        <span class="text-white font-extrabold text-2xl">EG</span>
      </div>
      <h1 class="text-2xl font-extrabold text-gray-900">Masuk Akun PPDB</h1>
      <p class="text-gray-500 text-sm mt-1.5">Pantau status pendaftaran dan kelola data Anda.</p>
    </div>

    {{-- Login Card --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-100/80 border border-gray-100 overflow-hidden">

      {{-- Header Bar --}}
      <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
        <div class="flex items-center gap-2">
          <i data-lucide="shield-check" class="w-5 h-5 text-blue-200"></i>
          <span class="text-white text-sm font-bold uppercase tracking-wider">Login Peserta Didik</span>
        </div>
        <p class="text-blue-200/80 text-xs mt-1">Gunakan NISN dan tanggal lahir untuk masuk.</p>
      </div>

      {{-- Form --}}
      <form action="{{ url('/ppdb/dashboard') }}" method="get" class="px-6 py-6 space-y-5">

        {{-- NISN --}}
        <div class="group">
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            NISN <span class="text-red-400">*</span>
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <i data-lucide="hash" class="w-4 h-4 text-gray-400"></i>
            </div>
            <input type="text" name="nisn" placeholder="Masukkan 10 digit NISN" inputmode="numeric" maxlength="10" required
              class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all">
          </div>
          <p class="text-xs text-gray-400 mt-1.5 ml-1">NISN tertera pada ijazah atau rapor terakhir.</p>
        </div>

        {{-- Tanggal Lahir --}}
        <div class="group">
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Tanggal Lahir <span class="text-red-400">*</span>
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
            </div>
            <input type="date" name="tanggal_lahir" required
              class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 focus:bg-white transition-all">
          </div>
          <p class="text-xs text-gray-400 mt-1.5 ml-1">Sesuai data pada formulir pendaftaran.</p>
        </div>

        {{-- Login Button --}}
        <button type="submit"
          class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transition-all text-sm active:scale-[0.98]">
          <i data-lucide="log-in" class="w-4 h-4"></i>
          Masuk ke Dashboard
        </button>

        {{-- Divider --}}
        <div class="flex items-center gap-3">
          <div class="flex-1 border-t border-gray-100"></div>
          <span class="text-xs text-gray-400 font-medium">atau</span>
          <div class="flex-1 border-t border-gray-100"></div>
        </div>

        {{-- Cek Status Button --}}
        <a href="{{ url('/ppdb/cek-status') }}"
          class="w-full flex items-center justify-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold py-3.5 rounded-xl text-sm transition-all">
          <i data-lucide="search" class="w-4 h-4"></i>
          Cek Status Pendaftaran
        </a>

      </form>
    </div>

    {{-- Info Box --}}
    <div class="bg-blue-50 border border-blue-100 rounded-2xl px-5 py-4 mt-5 flex items-start gap-3">
      <i data-lucide="info" class="w-4 h-4 text-blue-500 shrink-0 mt-0.5"></i>
      <div class="text-xs text-blue-700 leading-relaxed space-y-1">
        <p><strong>Belum punya akun?</strong> Anda tidak perlu membuat akun terlebih dahulu.</p>
        <p>Cukup <a href="{{ url('/ppdb') }}" class="underline font-semibold hover:text-blue-800">daftar melalui PPDB</a>, lalu gunakan NISN dan tanggal lahir untuk masuk ke dashboard.</p>
      </div>
    </div>

    {{-- Back --}}
    <div class="text-center mt-5">
      <a href="{{ url('/ppdb') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-blue-600 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Halaman PPDB
      </a>
    </div>

  </div>
</section>

@endsection
