@extends('layouts.ppdb')
@section('title', 'Penerimaan Peserta Didik Baru (PPDB)')
@section('content')

{{-- ============ HERO SECTION ============ --}}
<section class="bg-white border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

    {{-- Kiri: Text --}}
    <div>
      <p class="text-blue-600 font-semibold text-sm mb-1">Selamat Datang di PPDB</p>
      <div class="flex items-center gap-3 mb-2">
        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
          <span class="text-blue-600 font-extrabold text-xl">EG</span>
        </div>
        <div>
          <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">EDUGO</h1>
          <p class="text-gray-500 font-medium text-base">Tahun Ajaran 2025 / 2026</p>
        </div>
      </div>
      <p class="text-gray-500 text-sm leading-relaxed mt-4 max-w-md">
        Situs ini merupakan laman resmi untuk Sistem Penerimaan Peserta Didik Baru (PPDB)
        Tahun Ajaran 2025/2026 untuk pelaksanaan PPDB online.
      </p>
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ url('/ppdb/login') }}"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-full text-sm transition-colors duration-200">
          <i data-lucide="log-in" class="w-4 h-4"></i>
          Masuk Akun
        </a>
        <a href="{{ url('/ppdb/register/step1') }}"
          class="inline-flex items-center gap-2 border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold px-6 py-2.5 rounded-full text-sm transition-colors duration-200">
          <i data-lucide="user-plus" class="w-4 h-4"></i>
          Daftar Sekarang
        </a>
      </div>
    </div>

    {{-- Kanan: Banner / Illustration --}}
    <div class="relative flex items-center justify-center">
      <div class="w-full max-w-md rounded-2xl overflow-hidden shadow-xl">
        <img src="{{ asset('images/ppdb-banner.png') }}" alt="PPDB 2025/2026 Banner"
          class="w-full h-56 object-cover" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
        {{-- Fallback gradient banner --}}
        <div class="hidden w-full h-56 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 items-center justify-center rounded-2xl">
          <div class="text-center text-white px-8">
            <div class="text-5xl font-extrabold mb-1">PPDB</div>
            <div class="text-lg font-semibold opacity-90">2025 / 2026</div>
            <div class="text-sm opacity-70 mt-2">Penerimaan Peserta Didik Baru</div>
          </div>
        </div>
      </div>
      {{-- Dot indicator --}}
      <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5">
        <span class="w-2 h-2 rounded-full bg-orange-400"></span>
        <span class="w-2 h-2 rounded-full bg-gray-300"></span>
        <span class="w-2 h-2 rounded-full bg-gray-300"></span>
      </div>
    </div>

  </div>
</section>


{{-- ============ TIMELINE JADWAL PPDB ============ --}}
<section class="py-12 bg-white border-b border-gray-100">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
        <i data-lucide="calendar-range" class="w-3.5 h-3.5"></i> Jadwal PPDB
      </div>
      <h2 class="text-2xl font-extrabold text-gray-900">Timeline Pendaftaran 2025/2026</h2>
      <p class="text-gray-500 text-sm mt-2 max-w-lg mx-auto">Pastikan Anda tidak melewatkan tahapan penting pendaftaran.</p>
    </div>

    <div class="relative">
      {{-- Vertical line --}}
      <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-400 via-emerald-400 via-amber-400 to-red-400 rounded-full hidden md:block"></div>

      <div class="space-y-6">

        {{-- Step 1: Pendaftaran Online --}}
        <div class="relative flex items-start gap-5">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shrink-0 shadow-lg shadow-blue-200 z-10">
            <i data-lucide="edit-3" class="w-5 h-5 text-white"></i>
          </div>
          <div class="flex-1 bg-gradient-to-r from-blue-50 to-white border border-blue-100 rounded-2xl px-5 py-4">
            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
              <h3 class="font-extrabold text-gray-900 text-sm">Pendaftaran Online</h3>
              <span class="text-[10px] bg-blue-600 text-white px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Sedang Berlangsung</span>
            </div>
            <p class="text-xs text-gray-500 mb-2">10 Juni — 25 Juni 2025</p>
            <p class="text-xs text-gray-600 leading-relaxed">Pengisian formulir pendaftaran, upload dokumen persyaratan, dan pemilihan sekolah tujuan melalui sistem PPDB online.</p>
          </div>
        </div>

        {{-- Step 2: Verifikasi Berkas --}}
        <div class="relative flex items-start gap-5">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shrink-0 shadow-lg shadow-emerald-200 z-10">
            <i data-lucide="file-check-2" class="w-5 h-5 text-white"></i>
          </div>
          <div class="flex-1 bg-gradient-to-r from-emerald-50 to-white border border-emerald-100 rounded-2xl px-5 py-4">
            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
              <h3 class="font-extrabold text-gray-900 text-sm">Verifikasi Berkas</h3>
              <span class="text-[10px] bg-gray-200 text-gray-600 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Segera</span>
            </div>
            <p class="text-xs text-gray-500 mb-2">26 Juni — 30 Juni 2025</p>
            <p class="text-xs text-gray-600 leading-relaxed">Panitia PPDB memverifikasi kelengkapan dan keabsahan dokumen yang telah di-upload. Calon siswa mungkin diminta melengkapi data.</p>
          </div>
        </div>

        {{-- Step 3: Pengumuman --}}
        <div class="relative flex items-start gap-5">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-700 flex items-center justify-center shrink-0 shadow-lg shadow-amber-200 z-10">
            <i data-lucide="megaphone" class="w-5 h-5 text-white"></i>
          </div>
          <div class="flex-1 bg-gradient-to-r from-amber-50 to-white border border-amber-100 rounded-2xl px-5 py-4">
            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
              <h3 class="font-extrabold text-gray-900 text-sm">Pengumuman Hasil Seleksi</h3>
              <span class="text-[10px] bg-gray-200 text-gray-600 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Belum Dimulai</span>
            </div>
            <p class="text-xs text-gray-500 mb-2">5 Juli 2025</p>
            <p class="text-xs text-gray-600 leading-relaxed">Hasil seleksi diumumkan secara online. Calon siswa dapat mengecek status melalui halaman Cek Status Pendaftaran.</p>
          </div>
        </div>

        {{-- Step 4: Daftar Ulang --}}
        <div class="relative flex items-start gap-5">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center shrink-0 shadow-lg shadow-red-200 z-10">
            <i data-lucide="clipboard-check" class="w-5 h-5 text-white"></i>
          </div>
          <div class="flex-1 bg-gradient-to-r from-red-50 to-white border border-red-100 rounded-2xl px-5 py-4">
            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
              <h3 class="font-extrabold text-gray-900 text-sm">Daftar Ulang</h3>
              <span class="text-[10px] bg-gray-200 text-gray-600 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Belum Dimulai</span>
            </div>
            <p class="text-xs text-gray-500 mb-2">7 — 10 Juli 2025</p>
            <p class="text-xs text-gray-600 leading-relaxed">Siswa yang diterima wajib melakukan daftar ulang di sekolah tujuan dengan membawa berkas asli. Batas akhir: <strong>10 Juli 2025</strong>.</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

{{-- ============ CEK STATUS & HELPDESK ============ --}}
<section class="py-12">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 gap-5">

      {{-- Cek Status Card --}}
      <a href="{{ url('/ppdb/cek-status') }}" class="group relative block bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl overflow-hidden p-6 shadow-xl shadow-blue-200/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="relative">
          <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
            <i data-lucide="search" class="w-6 h-6 text-white"></i>
          </div>
          <h3 class="text-white font-extrabold text-lg mb-1">Cek Status Pendaftaran</h3>
          <p class="text-blue-200 text-xs mb-4">Masukkan NISN atau Nomor Peserta untuk melihat progres pendaftaran Anda secara real-time.</p>
          <div class="flex items-center gap-1.5 text-white text-sm font-semibold">
            Cek Sekarang <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>

      {{-- Helpdesk Card --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-md">
        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mb-4">
          <i data-lucide="headphones" class="w-6 h-6 text-emerald-600"></i>
        </div>
        <h3 class="font-extrabold text-gray-900 text-lg mb-1">Helpdesk PPDB</h3>
        <p class="text-gray-500 text-xs mb-4">Ada kendala atau pertanyaan? Hubungi kami di jam operasional.</p>
        <div class="space-y-2">
          <div class="flex items-center gap-2.5 text-xs text-gray-600">
            <span class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
              <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-600"></i>
            </span>
            <span><strong>0812-3456-7890</strong> (WhatsApp)</span>
          </div>
          <div class="flex items-center gap-2.5 text-xs text-gray-600">
            <span class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
              <i data-lucide="mail" class="w-3.5 h-3.5 text-emerald-600"></i>
            </span>
            <span>ppdb@edugo.sch.id</span>
          </div>
          <div class="flex items-center gap-2.5 text-xs text-gray-600">
            <span class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
              <i data-lucide="clock" class="w-3.5 h-3.5 text-emerald-600"></i>
            </span>
            <span>Senin–Jumat, <strong>08.00–15.00 WIB</strong></span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ============ FAQ ============ --}}
<section class="py-12 bg-white border-t border-gray-100">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <div class="inline-flex items-center gap-2 bg-amber-50 text-amber-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
        <i data-lucide="help-circle" class="w-3.5 h-3.5"></i> FAQ
      </div>
      <h2 class="text-2xl font-extrabold text-gray-900">Pertanyaan yang Sering Diajukan</h2>
      <p class="text-gray-500 text-sm mt-2">Temukan jawaban atas pertanyaan umum seputar PPDB 2025/2026.</p>
    </div>

    <div class="space-y-3" x-data="{ open: null }">

      {{-- Q1 --}}
      <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm" :class="open === 1 ? 'ring-2 ring-blue-100 border-blue-200' : ''">
        <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
              <i data-lucide="file-question" class="w-4 h-4 text-blue-500"></i>
            </div>
            <span class="text-sm font-bold text-gray-800">Apa saja dokumen yang harus disiapkan untuk pendaftaran?</span>
          </div>
          <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 1 ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open === 1" x-collapse>
          <div class="px-5 pb-4 pl-16">
            <p class="text-xs text-gray-600 leading-relaxed">Dokumen yang diperlukan meliputi: <strong>Kartu Keluarga (KK)</strong>, <strong>Akta Kelahiran</strong>, <strong>Ijazah/SKL</strong> dari sekolah asal, <strong>Rapor</strong> terakhir, <strong>Pas Foto</strong> terbaru (3x4), dan dokumen tambahan sesuai jalur yang dipilih (seperti KIP, sertifikat prestasi, atau SK Pindah Tugas).</p>
          </div>
        </div>
      </div>

      {{-- Q2 --}}
      <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm" :class="open === 2 ? 'ring-2 ring-blue-100 border-blue-200' : ''">
        <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
              <i data-lucide="wallet" class="w-4 h-4 text-emerald-500"></i>
            </div>
            <span class="text-sm font-bold text-gray-800">Apakah ada biaya pendaftaran PPDB?</span>
          </div>
          <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 2 ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open === 2" x-collapse>
          <div class="px-5 pb-4 pl-16">
            <p class="text-xs text-gray-600 leading-relaxed"><strong>Tidak ada biaya apapun</strong> untuk pendaftaran PPDB. Seluruh proses pendaftaran bersifat gratis. Jika ada pihak yang meminta biaya, harap laporkan ke Helpdesk PPDB.</p>
          </div>
        </div>
      </div>

      {{-- Q3 --}}
      <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm" :class="open === 3 ? 'ring-2 ring-blue-100 border-blue-200' : ''">
        <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-violet-50 flex items-center justify-center shrink-0">
              <i data-lucide="school" class="w-4 h-4 text-violet-500"></i>
            </div>
            <span class="text-sm font-bold text-gray-800">Bolehkah mendaftar ke lebih dari satu sekolah?</span>
          </div>
          <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 3 ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open === 3" x-collapse>
          <div class="px-5 pb-4 pl-16">
            <p class="text-xs text-gray-600 leading-relaxed">Calon peserta didik hanya diperbolehkan mendaftar di <strong>satu sekolah</strong> pada satu jalur pendaftaran. Namun jika tidak diterima, Anda dapat mendaftar kembali di jalur lain (jika masih dalam periode pendaftaran).</p>
          </div>
        </div>
      </div>

      {{-- Q4 --}}
      <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm" :class="open === 4 ? 'ring-2 ring-blue-100 border-blue-200' : ''">
        <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
              <i data-lucide="map-pin" class="w-4 h-4 text-amber-500"></i>
            </div>
            <span class="text-sm font-bold text-gray-800">Bagaimana jika alamat KK berbeda dengan domisili saat ini?</span>
          </div>
          <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 4 ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open === 4" x-collapse>
          <div class="px-5 pb-4 pl-16">
            <p class="text-xs text-gray-600 leading-relaxed">Untuk jalur Zonasi, yang digunakan adalah alamat sesuai <strong>Kartu Keluarga (KK)</strong>, bukan domisili saat ini. KK juga harus diterbitkan <strong>minimal 1 tahun</strong> sebelum tanggal pendaftaran. Jika berbeda, disarankan untuk mendaftar melalui jalur lain seperti Afirmasi atau Perpindahan.</p>
          </div>
        </div>
      </div>

      {{-- Q5 --}}
      <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm" :class="open === 5 ? 'ring-2 ring-blue-100 border-blue-200' : ''">
        <button @click="open = open === 5 ? null : 5" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
              <i data-lucide="calendar-x" class="w-4 h-4 text-red-500"></i>
            </div>
            <span class="text-sm font-bold text-gray-800">Apa yang terjadi jika melewati batas daftar ulang?</span>
          </div>
          <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 5 ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open === 5" x-collapse>
          <div class="px-5 pb-4 pl-16">
            <p class="text-xs text-gray-600 leading-relaxed">Jika melewati batas waktu daftar ulang (10 Juli 2025), maka siswa dianggap <strong>mengundurkan diri</strong> dan kuota akan dialihkan ke calon siswa cadangan. Pastikan untuk segera melakukan daftar ulang setelah pengumuman.</p>
          </div>
        </div>
      </div>

      {{-- Q6 --}}
      <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm" :class="open === 6 ? 'ring-2 ring-blue-100 border-blue-200' : ''">
        <button @click="open = open === 6 ? null : 6" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
              <i data-lucide="phone" class="w-4 h-4 text-orange-500"></i>
            </div>
            <span class="text-sm font-bold text-gray-800">Bagaimana cara menghubungi panitia jika ada kendala?</span>
          </div>
          <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 6 ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open === 6" x-collapse>
          <div class="px-5 pb-4 pl-16">
            <p class="text-xs text-gray-600 leading-relaxed">Hubungi Helpdesk PPDB melalui <strong>WhatsApp: 0812-3456-7890</strong> atau email <strong>ppdb@edugo.sch.id</strong> pada hari kerja (Senin–Jumat, 08.00–15.00 WIB). Anda juga bisa datang langsung ke sekolah yang dituju untuk mendapatkan bantuan.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
