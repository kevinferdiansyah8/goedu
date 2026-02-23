<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukti Pendaftaran PPDB — EDUGO</title>
  <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    body { font-family: 'Lexend Deca', sans-serif; }
    @media print {
      .no-print { display: none !important; }
      body { background: white !important; }
      .print-card { box-shadow: none !important; border: 2px solid #e5e7eb !important; }
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

  {{-- Print Button --}}
  <div class="fixed top-6 right-6 no-print flex gap-2">
    <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-blue-200 text-sm transition-all active:scale-95">
      <i data-lucide="printer" class="w-4 h-4"></i> Cetak / Simpan PDF
    </button>
    <a href="{{ url('/ppdb/dashboard') }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold px-5 py-2.5 rounded-xl text-sm transition-all">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
  </div>

  <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl print-card overflow-hidden">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6 text-white relative overflow-hidden">
      <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 18px 18px;"></div>
      <div class="relative flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
            <span class="font-extrabold text-xl">EG</span>
          </div>
          <div>
            <h1 class="font-extrabold text-lg">EDUGO — PPDB 2025/2026</h1>
            <p class="text-blue-200 text-xs">Bukti Pendaftaran Peserta Didik Baru</p>
          </div>
        </div>
        <div class="text-right">
          <p class="text-blue-200 text-[10px] uppercase tracking-widest font-bold">Dokumen Resmi</p>
          <p class="text-white text-xs font-bold mt-0.5">No. {{ date('Ymd') }}-{{ rand(1000,9999) }}</p>
        </div>
      </div>
    </div>

    {{-- Nomor Pendaftaran --}}
    <div class="px-8 py-5 bg-green-50 border-b border-green-100">
      <p class="text-[10px] text-green-600 font-bold uppercase tracking-widest mb-1">Nomor Pendaftaran</p>
      <p class="text-2xl font-extrabold text-green-700 tracking-widest">SMP-ZNS-{{ date('Ymd') }}-{{ rand(1000,9999) }}</p>
      <p class="text-[10px] text-green-500 mt-1">Simpan nomor ini untuk keperluan pengecekan status dan daftar ulang.</p>
    </div>

    {{-- Data Diri --}}
    <div class="px-8 py-5 border-b border-gray-100">
      <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
        <i data-lucide="user" class="w-3.5 h-3.5 text-blue-500"></i> Data Peserta Didik
      </h2>
      <div class="grid grid-cols-2 gap-x-8 gap-y-2.5">
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Nama Lengkap</p>
          <p class="text-sm font-semibold text-gray-800">Ahmad Rizky Pratama</p>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">NISN</p>
          <p class="text-sm font-semibold text-gray-800">0012345678</p>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">NIK</p>
          <p class="text-sm font-semibold text-gray-800">3201234567890001</p>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Tanggal Lahir</p>
          <p class="text-sm font-semibold text-gray-800">15 Maret 2012</p>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jenis Kelamin</p>
          <p class="text-sm font-semibold text-gray-800">Laki-laki</p>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Asal Sekolah</p>
          <p class="text-sm font-semibold text-gray-800">SD Negeri 01 Cibinong</p>
        </div>
      </div>
    </div>

    {{-- Info Pendaftaran --}}
    <div class="px-8 py-5 border-b border-gray-100">
      <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
        <i data-lucide="clipboard-list" class="w-3.5 h-3.5 text-emerald-500"></i> Informasi Pendaftaran
      </h2>
      <div class="grid grid-cols-2 gap-x-8 gap-y-2.5">
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jenjang</p>
          <p class="text-sm font-semibold text-gray-800">Sekolah Menengah Pertama (SMP)</p>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jalur Pendaftaran</p>
          <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full mt-0.5">
            <i data-lucide="map-pin" class="w-3 h-3"></i> Zonasi
          </span>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Tanggal Pendaftaran</p>
          <p class="text-sm font-semibold text-gray-800">{{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-wider">Status</p>
          <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-0.5 rounded-full mt-0.5">
            <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Menunggu Verifikasi
          </span>
        </div>
      </div>
    </div>

    {{-- Catatan --}}
    <div class="px-8 py-5 border-b border-gray-100">
      <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
        <i data-lucide="info" class="w-3.5 h-3.5 text-amber-500"></i> Catatan Penting
      </h2>
      <ul class="text-xs text-gray-600 space-y-1.5 list-disc list-inside">
        <li>Bukti pendaftaran ini <strong>bukan</strong> tanda diterima di sekolah.</li>
        <li>Wajib bawa dokumen <strong>asli</strong> saat verifikasi offline sesuai jadwal.</li>
        <li>Cek status pendaftaran secara berkala di <strong>edugo.sch.id/ppdb/cek-status</strong></li>
        <li>Hubungi Helpdesk PPDB: <strong>0812-3456-7890</strong> jika ada kendala.</li>
      </ul>
    </div>

    {{-- Footer --}}
    <div class="px-8 py-4 bg-gray-50 flex items-center justify-between">
      <div>
        <p class="text-[10px] text-gray-400">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i:s') }} WIB</p>
        <p class="text-[10px] text-gray-400">Dokumen ini di-generate oleh sistem PPDB EDUGO secara otomatis.</p>
      </div>
      <div class="text-right">
        <p class="text-[10px] text-gray-400">Panitia PPDB</p>
        <p class="text-xs font-bold text-gray-600">EDUGO 2025/2026</p>
      </div>
    </div>

  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
