<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'PPDB') - EDUGO</title>
<meta name="description" content="Penerimaan Peserta Didik Baru (PPDB) FDUGO - Pendaftaran online untuk SD, SMP, SMA, dan SMK.">
<link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<style type="text/tailwindcss">
  :root {
    --primary: #165DFF;
    --primary-hover: #0E4BD9;
    --foreground: #080C1A;
    --secondary: #6A7686;
    --font-sans: 'Lexend Deca', sans-serif;
  }
  body { font-family: 'Lexend Deca', sans-serif; }
  @theme inline {
    --color-primary: #165DFF;
    --color-primary-hover: #0E4BD9;
  }
</style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-800">

  {{-- ============ NAVBAR ============ --}}
  <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
      {{-- Logo --}}
      <a href="{{ url('/ppdb') }}" class="flex items-center gap-2 shrink-0">
        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center">
          <span class="text-white font-extrabold text-base leading-none">EG</span>
        </div>
        <div class="leading-tight">
          <div class="text-blue-600 font-extrabold text-base">EDUGO</div>
          <div class="text-gray-400 text-[10px] font-medium tracking-wide">online</div>
        </div>
      </a>

      {{-- Search --}}
      <div class="flex-1 max-w-sm hidden md:block">
        <div class="relative">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
          <input type="text" placeholder="Cari nisn, nomor peserta..."
            class="w-full pl-9 pr-4 py-2 text-sm rounded-full border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
          <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-300 hidden lg:block">ctrl + k</span>
        </div>
      </div>


    </div>
  </header>

  {{-- ============ ANNOUNCEMENT BANNER ============ --}}
  <div class="bg-blue-600 text-white text-sm py-2 px-4 text-center font-medium flex items-center justify-center gap-2">
    <i data-lucide="bell" class="w-4 h-4 shrink-0"></i>
    <span><strong>Pengumuman:</strong> Pelaksanaan PPDB EDUGO tidak dipungut biaya <strong>(GRATIS)</strong></span>
  </div>

  {{-- ============ MAIN CONTENT ============ --}}
  <main class="flex-1">
    @yield('content')
  </main>

  {{-- ============ FOOTER ============ --}}
  <footer class="bg-gray-900 text-gray-300 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">

      {{-- Kolom 1: Brand --}}
      <div>
        <div class="flex items-center gap-2.5 mb-4">
          <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center">
            <span class="text-white font-extrabold text-sm">EG</span>
          </div>
          <div>
            <div class="text-white font-extrabold text-base">EDUGO</div>
            <div class="text-gray-500 text-[10px] font-medium tracking-wider uppercase">PPDB Online</div>
          </div>
        </div>
        <p class="text-xs text-gray-500 leading-relaxed mb-4">Sistem Penerimaan Peserta Didik Baru online untuk jenjang SD, SMP, SMA, dan SMK. Gratis tanpa dipungut biaya.</p>
        <div class="flex gap-2">
          <a href="#" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-blue-600 flex items-center justify-center transition-colors">
            <i data-lucide="facebook" class="w-3.5 h-3.5 text-gray-400 hover:text-white"></i>
          </a>
          <a href="#" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-sky-500 flex items-center justify-center transition-colors">
            <i data-lucide="twitter" class="w-3.5 h-3.5 text-gray-400 hover:text-white"></i>
          </a>
          <a href="#" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-pink-600 flex items-center justify-center transition-colors">
            <i data-lucide="instagram" class="w-3.5 h-3.5 text-gray-400 hover:text-white"></i>
          </a>
          <a href="#" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-red-600 flex items-center justify-center transition-colors">
            <i data-lucide="youtube" class="w-3.5 h-3.5 text-gray-400 hover:text-white"></i>
          </a>
        </div>
      </div>

      {{-- Kolom 2: Navigasi --}}
      <div>
        <h4 class="text-white font-bold text-xs mb-4 uppercase tracking-wider">Navigasi</h4>
        <ul class="space-y-2.5">
          <li><a href="{{ url('/ppdb') }}" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="home" class="w-3.5 h-3.5"></i> Beranda PPDB</a></li>
          <li><a href="{{ url('/ppdb/jenjang/sd') }}" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="school" class="w-3.5 h-3.5"></i> Jenjang & Jalur</a></li>
          <li><a href="{{ url('/ppdb/cek-status') }}" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="search" class="w-3.5 h-3.5"></i> Cek Status</a></li>
          <li><a href="{{ url('/ppdb/login') }}" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="log-in" class="w-3.5 h-3.5"></i> Login Peserta</a></li>
          <li><a href="{{ url('/ppdb#faq') }}" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i data-lucide="help-circle" class="w-3.5 h-3.5"></i> FAQ</a></li>
        </ul>
      </div>

      {{-- Kolom 3: Kontak --}}
      <div>
        <h4 class="text-white font-bold text-xs mb-4 uppercase tracking-wider">Hubungi Kami</h4>
        <div class="space-y-3">
          <div class="flex items-start gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-gray-800 flex items-center justify-center shrink-0 mt-0.5">
              <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-400"></i>
            </div>
            <p class="text-xs text-gray-400 leading-relaxed">Jl. Pendidikan No. 1, Kota Edugo, Provinsi Jawa Barat 16913</p>
          </div>
          <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-gray-800 flex items-center justify-center shrink-0">
              <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-400"></i>
            </div>
            <p class="text-xs text-gray-400">0812-3456-7890 (WhatsApp)</p>
          </div>
          <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-gray-800 flex items-center justify-center shrink-0">
              <i data-lucide="mail" class="w-3.5 h-3.5 text-amber-400"></i>
            </div>
            <p class="text-xs text-gray-400">ppdb@edugo.sch.id</p>
          </div>
          <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-gray-800 flex items-center justify-center shrink-0">
              <i data-lucide="clock" class="w-3.5 h-3.5 text-violet-400"></i>
            </div>
            <p class="text-xs text-gray-400">Senin–Jumat, 08.00–15.00 WIB</p>
          </div>
        </div>
      </div>

      {{-- Kolom 4: Aplikasi --}}
      <div>
        <h4 class="text-white font-bold text-xs mb-4 uppercase tracking-wider">Unduh Aplikasi</h4>
        <p class="text-xs text-gray-500 mb-3">Pantau info dan hasil PPDB langsung dari smartphone Anda.</p>
        <div class="flex flex-col gap-2">
          <a href="#" class="inline-flex items-center gap-2.5 bg-gray-800 hover:bg-gray-700 text-white text-xs px-4 py-2.5 rounded-xl border border-gray-700 transition w-fit">
            <i data-lucide="play" class="w-4 h-4 text-emerald-400"></i>
            <div class="leading-tight">
              <div class="text-[9px] text-gray-500 uppercase">Get it on</div>
              <div class="font-bold text-xs">Google Play</div>
            </div>
          </a>
          <a href="#" class="inline-flex items-center gap-2.5 bg-gray-800 hover:bg-gray-700 text-white text-xs px-4 py-2.5 rounded-xl border border-gray-700 transition w-fit">
            <i data-lucide="apple" class="w-4 h-4 text-gray-300"></i>
            <div class="leading-tight">
              <div class="text-[9px] text-gray-500 uppercase">Download on</div>
              <div class="font-bold text-xs">App Store</div>
            </div>
          </a>
        </div>
      </div>

    </div>
    <div class="border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row items-center justify-between gap-2">
        <p class="text-xs text-gray-600">&copy; {{ date('Y') }} EDUGO. All rights reserved.</p>
        <div class="flex items-center gap-4">
          <a href="#" class="text-xs text-gray-600 hover:text-gray-400 transition-colors">Kebijakan Privasi</a>
          <a href="#" class="text-xs text-gray-600 hover:text-gray-400 transition-colors">Syarat & Ketentuan</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>