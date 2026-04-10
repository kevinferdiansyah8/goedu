<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EDUGO - Keuangan</title>
<meta name="description" content="EDUGO finance dashboard for managing student payments and PPDB finances.">
<link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style type="text/tailwindcss">
  @theme inline {
    --color-primary: var(--primary);
    --color-primary-hover: var(--primary-hover);
    --color-foreground: var(--foreground);
    --color-secondary: var(--secondary);
    --color-muted: var(--muted);
    --color-border: var(--border);
    --color-card-grey: var(--card-grey);
    --color-card-message: var(--card-message);
    --color-accent-blue: var(--accent-blue);
    --color-accent-teal: var(--accent-teal);
    --color-accent-sky: var(--accent-sky);
    --color-success: var(--success);
    --color-success-light: var(--success-light);
    --color-success-dark: var(--success-dark);
    --color-error: var(--error);
    --color-error-light: var(--error-light);
    --color-error-lighter: var(--error-lighter);
    --color-error-dark: var(--error-dark);
    --color-warning: var(--warning);
    --color-warning-light: var(--warning-light);
    --color-warning-dark: var(--warning-dark);
    --color-info: var(--info);
    --color-info-light: var(--info-light);
    --color-info-dark: var(--info-dark);
    --color-alert: var(--alert);
    --color-alert-light: var(--alert-light);
    --color-alert-dark: var(--alert-dark);
    --color-gray-50: var(--gray-50);
    --color-gray-100: var(--gray-100);
    --color-gray-200: var(--gray-200);
    --color-gray-500: var(--gray-500);
    --color-gray-600: var(--gray-600);
    --color-gray-700: var(--gray-700);
    --font-sans: var(--font-sans);
    --radius-card: 24px;
    --radius-button: 50px;
    --radius-icon: 12px;
    --radius-xl: 16px;
    --radius-2xl: 20px;
    --radius-3xl: 24px;
  }
  :root {
    --primary: #165DFF;
    --primary-hover: #0E4BD9;
    --foreground: #080C1A;
    --secondary: #6A7686;
    --muted: #EFF2F7;
    --border: #F3F4F3;
    --card-grey: #F1F3F6;
    --card-message: #C9E6FC;
    --accent-blue: #C9E6FC;
    --accent-teal: #82D9D7;
    --accent-sky: #DBEAFE;
    --success: #30B22D;
    --success-light: #DCFCE7;
    --success-dark: #166534;
    --error: #ED6B60;
    --error-light: #FEE2E2;
    --error-lighter: #FEF2F2;
    --error-dark: #991B1B;
    --warning: #FED71F;
    --warning-light: #FEF9C3;
    --warning-dark: #854D0E;
    --info: #165DFF;
    --info-light: #DBEAFE;
    --info-dark: #1E40AF;
    --alert: #F97316;
    --alert-light: #FFEDD5;
    --alert-dark: #9A3412;
    --gray-50: #F9FAFB;
    --gray-100: #F1F3F6;
    --gray-200: #E5E7EB;
    --gray-500: #6A7686;
    --gray-600: #4B5563;
    --gray-700: #374151;
    --font-sans: 'Lexend Deca', sans-serif;
  }
  select {
    @apply appearance-none bg-no-repeat cursor-pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-position: right 10px center;
    padding-right: 40px;
  }
  .scrollbar-hide::-webkit-scrollbar { display: none; }
  .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</head>
<body class="font-sans bg-white min-h-screen overflow-x-hidden">

<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/80 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

<div class="flex h-screen max-h-screen flex-1 bg-muted overflow-hidden">
  <!-- SIDEBAR -->
  <aside id="sidebar" class="flex flex-col w-[280px] shrink-0 h-screen fixed inset-y-0 left-0 z-50 bg-white border-r border-border transform -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-hidden">
    <!-- Top Bar with logo and title -->
    <div class="flex items-center justify-between border-b border-border h-[90px] px-5 gap-3">
      <div class="flex items-center gap-3">
        <div class="w-11 h-9 bg-primary rounded-xl flex items-center justify-center">
          <i data-lucide="graduation-cap" class="w-5 h-5 text-white"></i>
        </div>
        <h1 class="font-semibold text-xl">EduGo</h1>
      </div>
      <div class="flex gap-2">
        <button class="size-11 flex shrink-0 bg-white rounded-xl p-[10px] items-center justify-center ring-1 ring-border hover:ring-primary transition-all duration-300 cursor-pointer" aria-label="Search">
          <i data-lucide="search" class="size-6 text-secondary"></i>
        </button>
        <button onclick="toggleSidebar()" aria-label="Close sidebar" class="lg:hidden size-11 flex shrink-0 bg-white rounded-xl p-[10px] items-center justify-center ring-1 ring-border hover:ring-primary transition-all duration-300 cursor-pointer">
          <i data-lucide="x" class="size-6 text-secondary"></i>
        </button>
      </div>
    </div>

    <!-- Navigation Menu -->
    <div class="flex flex-col p-5 pb-28 gap-6 overflow-y-auto flex-1">
      <!-- Main Menu Section -->
      <div class="flex flex-col gap-4">
        <h3 class="font-medium text-sm text-secondary">Menu Keuangan</h3>
        <div class="flex flex-col gap-1">
          <!-- Dashboard -->
          <a href="{{ route('keuangan.dashboard') }}" class="group {{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }} cursor-pointer">
            <div class="flex items-center rounded-xl p-4 gap-3 bg-white group-[.active]:bg-muted group-hover:bg-muted transition-all duration-300">
              <i data-lucide="layout-dashboard" class="size-6 text-secondary group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300"></i>
              <span class="font-medium text-secondary group-[.active]:font-semibold group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300">Dashboard</span>
            </div>
          </a>

          <!-- Pembayaran Siswa Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="toggleMenu('Pembayaran')" aria-expanded="false" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="wallet" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Pembayaran Siswa</span>
              </div>
              <i id="arrowPembayaran" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('keuangan/pembayaran-siswa/*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuPembayaran" class="ml-4 mt-2 space-y-2 {{ request()->is('keuangan/pembayaran-siswa/*') ? '' : 'hidden' }}">
              <a href="{{ route('keuangan.pembayaran.tagihan') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('keuangan.pembayaran.tagihan') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('keuangan.pembayaran.tagihan') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('keuangan.pembayaran.tagihan') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Tagihan SPP</span>
              </a>
              <a href="{{ route('keuangan.pembayaran.riwayat') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('keuangan.pembayaran.riwayat') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('keuangan.pembayaran.riwayat') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('keuangan.pembayaran.riwayat') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Riwayat Pembayaran</span>
              </a>
              <a href="{{ route('keuangan.pembayaran.verifikasi') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('keuangan.pembayaran.verifikasi') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('keuangan.pembayaran.verifikasi') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('keuangan.pembayaran.verifikasi') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Verifikasi Pembayaran</span>
              </a>
            </div>
          </div>

          <!-- PPDB Keuangan Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="toggleMenu('PPDB')" aria-expanded="false" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Keuangan PPDB</span>
              </div>
              <i id="arrowPPDB" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('keuangan/ppdb/*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuPPDB" class="ml-4 mt-2 space-y-2 {{ request()->is('keuangan/ppdb/*') ? '' : 'hidden' }}">
              <a href="{{ route('keuangan.ppdb.biaya') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('keuangan.ppdb.biaya') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('keuangan.ppdb.biaya') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('keuangan.ppdb.biaya') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Biaya Pendaftaran</span>
              </a>
              <a href="{{ route('keuangan.ppdb.pembayaran') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('keuangan.ppdb.pembayaran') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('keuangan.ppdb.pembayaran') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('keuangan.ppdb.pembayaran') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Pembayaran Masuk</span>
              </a>
              <a href="{{ route('keuangan.ppdb.rekap') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('keuangan.ppdb.rekap') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('keuangan.ppdb.rekap') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('keuangan.ppdb.rekap') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Rekap PPDB</span>
              </a>
            </div>
          </div>

          <!-- Laporan Keuangan -->
          <a href="{{ route('keuangan.laporan') }}" class="group {{ request()->routeIs('keuangan.laporan') ? 'active' : '' }} cursor-pointer">
            <div class="flex items-center rounded-xl p-4 gap-3 bg-white group-[.active]:bg-muted group-hover:bg-muted transition-all duration-300">
              <i data-lucide="bar-chart-2" class="size-6 text-secondary group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300"></i>
              <span class="font-medium text-secondary group-[.active]:font-semibold group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300">Laporan Keuangan</span>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Bottom Help Card -->
    <div class="absolute bottom-0 left-0 w-[280px]">
      <div class="flex items-center justify-between border-t bg-white border-border p-5 gap-3">
        <div class="min-w-0">
          <p class="font-semibold text-foreground">Staff Keuangan</p>
          <a href="/login" class="cursor-pointer"><span class="text-sm text-secondary hover:text-primary hover:underline transition-all duration-300">Logout</span></a>
        </div>
        <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
          <i data-lucide="log-out" class="size-6 text-primary"></i>
        </div>
      </div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 lg:ml-[280px] flex flex-col bg-white min-h-screen overflow-x-hidden">
    <!-- Top Header Bar -->
    <div class="flex items-center justify-between w-full h-[90px] shrink-0 border-b border-border bg-white px-5 md:px-8">
      <!-- Mobile hamburger -->
      <button onclick="toggleSidebar()" aria-label="Open menu" class="lg:hidden size-11 flex items-center justify-center rounded-xl ring-1 ring-border hover:ring-primary transition-all duration-300 cursor-pointer">
        <i data-lucide="menu" class="size-6 text-foreground"></i>
      </button>
      <!-- Page title (shown on desktop) -->
      <h2 class="hidden lg:block font-bold text-2xl text-foreground">Keuangan</h2>
      <!-- Right actions -->
      <div class="flex items-center gap-3 ml-auto">
        @include('components.notification-dropdown')
        <div class="hidden md:flex items-center gap-3 pl-3 border-l border-border">
          <div class="text-right">
            <p class="font-semibold text-foreground text-sm">Staff Keuangan</p>
            <p class="text-secondary text-xs">Bendahara</p>
          </div>
          <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="Profile" class="size-11 rounded-full object-cover ring-2 ring-border">
        </div>
      </div>
    </div>

    <!-- Page Content -->
    <div class="flex-1 overflow-y-auto p-6 md:p-8 bg-muted">
      @yield('content')
    </div>
  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  lucide.createIcons();
});

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');
  sidebar.classList.toggle('-translate-x-full');
  overlay.classList.toggle('hidden');
  document.body.classList.toggle('overflow-hidden');
}

function toggleMenu(name) {
  const menu = document.getElementById('menu' + name);
  const arrow = document.getElementById('arrow' + name);
  if (!menu || !arrow) return;
  menu.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}
</script>
@stack('scripts')
<script>if(typeof lucide!=='undefined')lucide.createIcons();</script>
</body>
</html>

