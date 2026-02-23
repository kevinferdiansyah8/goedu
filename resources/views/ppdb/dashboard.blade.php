@extends('layouts.ppdb')
@section('title', 'Dashboard Pendaftaran — PPDB EDUGO')
@section('content')

<section class="py-8">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-4 mb-8">
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200">
          <span class="text-white font-extrabold text-xl">AR</span>
        </div>
        <div>
          <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Selamat Datang,</p>
          <h1 class="text-xl font-extrabold text-gray-900">Ahmad Rizky Pratama</h1>
          <p class="text-xs text-gray-500">No. Peserta: <span class="font-bold text-blue-600">PPDB-2025-00123</span></p>
        </div>
      </div>
      <a href="{{ url('/ppdb') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-red-500 transition-colors">
        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
      </a>
    </div>

    {{-- Status Banner --}}
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl p-5 mb-6 shadow-lg shadow-amber-200/50 relative overflow-hidden">
      <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 18px 18px;"></div>
      <div class="relative flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
          <i data-lucide="clock" class="w-6 h-6 text-white"></i>
        </div>
        <div>
          <p class="text-white/80 text-xs font-semibold uppercase tracking-wider">Status Pendaftaran</p>
          <p class="text-white text-lg font-extrabold">Dalam Proses Verifikasi</p>
          <p class="text-white/70 text-xs mt-0.5">Estimasi: berkas Anda akan diverifikasi dalam 3 hari kerja.</p>
        </div>
      </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
      <a href="{{ url('/ppdb/cek-status') }}" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-100 transition-colors">
          <i data-lucide="search" class="w-5 h-5 text-blue-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Cek Status</p>
      </a>
      <a href="{{ url('/ppdb/cetak-bukti') }}" target="_blank" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-emerald-100 transition-colors">
          <i data-lucide="printer" class="w-5 h-5 text-emerald-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Cetak Bukti</p>
      </a>
      <a href="{{ url('/ppdb') }}" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-violet-100 transition-colors">
          <i data-lucide="file-edit" class="w-5 h-5 text-violet-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Edit Data</p>
      </a>
      <a href="{{ url('/ppdb') }}" class="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mx-auto mb-2 group-hover:bg-amber-100 transition-colors">
          <i data-lucide="headphones" class="w-5 h-5 text-amber-600"></i>
        </div>
        <p class="text-xs font-bold text-gray-700">Helpdesk</p>
      </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

      {{-- Left: Data Ringkasan --}}
      <div class="md:col-span-2 space-y-5">

        {{-- Data Diri --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
            <span class="text-sm font-bold text-gray-800">Data Diri</span>
          </div>
          <div class="px-5 py-4 space-y-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Nama Lengkap</span>
              <span class="text-xs font-semibold text-gray-800">Ahmad Rizky Pratama</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">NISN</span>
              <span class="text-xs font-semibold text-gray-800">0012345678</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">NIK</span>
              <span class="text-xs font-semibold text-gray-800">3201••••••••0001</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Tanggal Lahir</span>
              <span class="text-xs font-semibold text-gray-800">15 Maret 2012</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Jenis Kelamin</span>
              <span class="text-xs font-semibold text-gray-800">Laki-laki</span>
            </div>
          </div>
        </div>

        {{-- Info Pendaftaran --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="clipboard-list" class="w-4 h-4 text-emerald-500"></i>
            <span class="text-sm font-bold text-gray-800">Info Pendaftaran</span>
          </div>
          <div class="px-5 py-4 space-y-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Jenjang</span>
              <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full">SMP</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Jalur</span>
              <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full">
                <i data-lucide="map-pin" class="w-3 h-3"></i> Zonasi
              </span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Sekolah Asal</span>
              <span class="text-xs font-semibold text-gray-800">SD Negeri 01 Cibinong</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Tanggal Daftar</span>
              <span class="text-xs font-semibold text-gray-800">15 Juni 2025</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Rata-rata Rapor</span>
              <span class="text-xs font-semibold text-gray-800">82.5</span>
            </div>
          </div>
        </div>

        {{-- Dokumen Upload --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="paperclip" class="w-4 h-4 text-violet-500"></i>
            <span class="text-sm font-bold text-gray-800">Dokumen yang Di-upload</span>
          </div>
          <div class="px-5 py-4 space-y-2.5">
            @php
              $docs = [
                ['name' => 'Kartu Keluarga (KK)', 'status' => 'verified'],
                ['name' => 'Akta Kelahiran', 'status' => 'verified'],
                ['name' => 'Rapor Kelas 4-6', 'status' => 'verified'],
                ['name' => 'Pas Foto 3×4', 'status' => 'pending'],
                ['name' => 'Ijazah / SKL SD', 'status' => 'pending'],
              ];
            @endphp
            @foreach($docs as $doc)
            <div class="flex items-center justify-between px-3 py-2.5 bg-gray-50 rounded-xl">
              <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg {{ $doc['status'] === 'verified' ? 'bg-green-100' : 'bg-amber-100' }} flex items-center justify-center">
                  <i data-lucide="{{ $doc['status'] === 'verified' ? 'check-circle-2' : 'clock' }}" class="w-3.5 h-3.5 {{ $doc['status'] === 'verified' ? 'text-green-600' : 'text-amber-500' }}"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">{{ $doc['name'] }}</span>
              </div>
              <span class="text-[10px] font-bold uppercase tracking-wider {{ $doc['status'] === 'verified' ? 'text-green-600' : 'text-amber-500' }}">
                {{ $doc['status'] === 'verified' ? 'Terverifikasi' : 'Menunggu' }}
              </span>
            </div>
            @endforeach
          </div>
        </div>

      </div>

      {{-- Right: Timeline & Notifications --}}
      <div class="space-y-5">

        {{-- Progres --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
            <i data-lucide="git-branch" class="w-4 h-4 text-amber-500"></i>
            <span class="text-sm font-bold text-gray-800">Progres</span>
          </div>
          <div class="px-5 py-4 space-y-4">
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-800">Formulir Dikirim</p>
                <p class="text-[10px] text-gray-400">15 Jun, 10:30</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                <i data-lucide="check" class="w-3.5 h-3.5 text-white"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-800">Dokumen Di-upload</p>
                <p class="text-[10px] text-gray-400">15 Jun, 10:32</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full bg-amber-400 flex items-center justify-center shrink-0 animate-pulse">
                <i data-lucide="loader-2" class="w-3.5 h-3.5 text-white"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-amber-700">Verifikasi Data</p>
                <p class="text-[10px] text-gray-400">~3 hari kerja</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center shrink-0">
                <i data-lucide="circle" class="w-3.5 h-3.5 text-gray-400"></i>
              </div>
              <div>
                <p class="text-xs font-medium text-gray-400">Pengumuman</p>
                <p class="text-[10px] text-gray-400">5 Juli 2025</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Notifikasi --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <i data-lucide="bell" class="w-4 h-4 text-red-500"></i>
              <span class="text-sm font-bold text-gray-800">Notifikasi</span>
            </div>
            <span class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full font-bold">2 Baru</span>
          </div>
          <div class="px-5 py-4 space-y-3">
            <div class="flex items-start gap-2.5 p-3 bg-red-50 border border-red-100 rounded-xl">
              <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-red-500"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-red-800">Pas Foto belum terverifikasi</p>
                <p class="text-[10px] text-red-600/70">Pastikan foto berformat 3×4, latar merah, kualitas jelas.</p>
              </div>
            </div>
            <div class="flex items-start gap-2.5 p-3 bg-blue-50 border border-blue-100 rounded-xl">
              <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="info" class="w-3.5 h-3.5 text-blue-500"></i>
              </div>
              <div>
                <p class="text-xs font-bold text-blue-800">Jadwal verifikasi offline</p>
                <p class="text-[10px] text-blue-600/70">Bawa dokumen asli ke sekolah pada 28 Juni 2025, 09:00 WIB.</p>
              </div>
            </div>
            <div class="flex items-start gap-2.5 p-3 bg-gray-50 rounded-xl">
              <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-green-500"></i>
              </div>
              <div>
                <p class="text-xs font-semibold text-gray-700">Pendaftaran berhasil dikirim</p>
                <p class="text-[10px] text-gray-400">15 Juni 2025, 10:30 WIB</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

@endsection
