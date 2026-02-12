<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EDUGO - Dashboard</title>
<meta name="description" content="EDUGO dashboard for managing and monitoring your campus data.">
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
<script>
function toggleAkademik() {
  var menu = document.getElementById('menuAkademik');
  var arrow = document.getElementById('arrowAkademik');
  if (menu.classList.contains('hidden')) {
    menu.classList.remove('hidden');
    arrow.classList.add('rotate-180');
  } else {
    menu.classList.add('hidden');
    arrow.classList.remove('rotate-180');
  }
}
</script>
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
        <h3 class="font-medium text-sm text-secondary">Main Menu</h3>
        <div class="flex flex-col gap-1">
          <!-- Dashboard -->
          <a href="{{ route('admin.dashboard') }}" class="group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} cursor-pointer">
            <div class="flex items-center rounded-xl p-4 gap-3 bg-white group-[.active]:bg-muted group-hover:bg-muted transition-all duration-300">
              <i data-lucide="layout-dashboard" class="size-6 text-secondary group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300"></i>
              <span class="font-medium text-secondary group-[.active]:font-semibold group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300">Dashboard</span>
            </div>
          </a>
          
          <!-- User Management -->
          <a href="{{ route('admin.users') }}" class="group {{ request()->routeIs('admin.users') ? 'active' : '' }} cursor-pointer">
            <div class="flex items-center rounded-xl p-4 gap-3 bg-white group-[.active]:bg-muted group-hover:bg-muted transition-all duration-300">
              <i data-lucide="users" class="size-6 text-secondary group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300"></i>
              <span class="font-medium text-secondary group-[.active]:font-semibold group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300">User Management</span>
            </div>
          </a>

          <!-- DATA SEKOLAH DROPDOWN -->
          <div class="group cursor-pointer">
            <button onclick="toggleSekolah()" aria-expanded="false" aria-controls="menuSekolah" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="school" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Data Sekolah</span>
              </div>
              <i id="arrowSekolah" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('admin/data-sekolah/*') ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="menuSekolah" class="ml-4 mt-2 space-y-2 {{ request()->is('admin/data-sekolah/*') ? '' : 'hidden' }}">
              <a href="{{ route('admin.data-sekolah.identitas') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.data-sekolah.identitas') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.data-sekolah.identitas') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.data-sekolah.identitas') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Identitas & Profil Sekolah</span>
              </a>

              <a href="{{ route('admin.data-sekolah.visi-misi') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.data-sekolah.visi-misi') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.data-sekolah.visi-misi') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.data-sekolah.visi-misi') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Visi, Misi & Struktur Organisasi</span>
              </a>

              <a href="{{ route('admin.data-sekolah.jurusan') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.data-sekolah.jurusan') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.data-sekolah.jurusan') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.data-sekolah.jurusan') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Jurusan / Kelas / Ruang</span>
              </a>
            </div>
          </div>

          <!-- Akademik -->
          <!-- Akademik Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="toggleAkademik()" aria-expanded="false" aria-controls="menuAkademik" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="book" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Akademik</span>
              </div>
              <i id="arrowAkademik" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('admin/akademik*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuAkademik" class="ml-4 mt-2 space-y-2 {{ request()->is('admin/akademik*') ? '' : 'hidden' }}">
              <a href="{{ route('admin.akademik.jadwal-pelajaran') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.akademik.jadwal-pelajaran') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.akademik.jadwal-pelajaran') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.akademik.jadwal-pelajaran') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Jadwal Pelajaran</span>
              </a>
              <a href="{{ route('admin.akademik.mata-pelajaran') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.akademik.mata-pelajaran') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.akademik.mata-pelajaran') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.akademik.mata-pelajaran') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Mata Pelajaran</span>
              </a>
              <a href="{{ route('admin.akademik.kelas-wali-kelas') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.akademik.kelas-wali-kelas') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.akademik.kelas-wali-kelas') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.akademik.kelas-wali-kelas') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Kelas & Wali Kelas</span>
              </a>
              <a href="{{ route('admin.akademik.penilaian') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.akademik.penilaian') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.akademik.penilaian') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.akademik.penilaian') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Penilaian</span>
              </a>
              <a href="{{ route('admin.akademik.rapor') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.akademik.rapor') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.akademik.rapor') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.akademik.rapor') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Rapor Siswa</span>
              </a>
            </div>
          </div>

          <!-- Absensi Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="const m=document.getElementById('menuAbsensi');const a=document.getElementById('arrowAbsensi');m.classList.toggle('hidden');a.classList.toggle('rotate-180');" aria-expanded="false" aria-controls="menuAbsensi" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="clipboard-list" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Absensi</span>
              </div>
              <i id="arrowAbsensi" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('admin/absensi*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuAbsensi" class="ml-4 mt-2 space-y-2 {{ request()->is('admin/absensi*') ? '' : 'hidden' }}">
              <a href="{{ route('admin.absensi.siswa') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.absensi.siswa') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.absensi.siswa') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.absensi.siswa') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Absensi Siswa</span>
              </a>
              <a href="{{ route('admin.absensi.guru') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.absensi.guru') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.absensi.guru') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.absensi.guru') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Absensi Guru</span>
              </a>
              <a href="{{ route('admin.absensi.rekap') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.absensi.rekap') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.absensi.rekap') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.absensi.rekap') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Rekap Absensi</span>
              </a>
              <a href="{{ route('admin.absensi.izin-sakit-alpha') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.absensi.izin-sakit-alpha') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.absensi.izin-sakit-alpha') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.absensi.izin-sakit-alpha') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Izin / Sakit / Alpha</span>
              </a>
            </div>
          </div>

          <!-- Kepegawaian Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="const m=document.getElementById('menuKepegawaian');const a=document.getElementById('arrowKepegawaian');m.classList.toggle('hidden');a.classList.toggle('rotate-180');" aria-expanded="false" aria-controls="menuKepegawaian" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="users" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Kepegawaian</span>
              </div>
              <i id="arrowKepegawaian" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('admin/kepegawaian*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuKepegawaian" class="ml-4 mt-2 space-y-2 {{ request()->is('admin/kepegawaian*') ? '' : 'hidden' }}">
              <a href="{{ route('admin.kepegawaian.data-guru') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.kepegawaian.data-guru') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.kepegawaian.data-guru') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.kepegawaian.data-guru') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Data Guru</span>
              </a>
              <a href="{{ route('admin.kepegawaian.jadwal-mengajar') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.kepegawaian.jadwal-mengajar') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.kepegawaian.jadwal-mengajar') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.kepegawaian.jadwal-mengajar') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Jadwal Mengajar</span>
              </a>
              <a href="{{ route('admin.kepegawaian.arsip-kepegawaian') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.kepegawaian.arsip-kepegawaian') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.kepegawaian.arsip-kepegawaian') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.kepegawaian.arsip-kepegawaian') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Arsip Kepegawaian</span>
              </a>
            </div>
          </div>

                    <!-- PPDB Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="const m=document.getElementById('menuPPDB');const a=document.getElementById('arrowPPDB');m.classList.toggle('hidden');a.classList.toggle('rotate-180');" aria-expanded="false" aria-controls="menuPPDB" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">PPDB</span>
              </div>
              <i id="arrowPPDB" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('admin/ppdb*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuPPDB" class="ml-4 mt-2 space-y-2 {{ request()->is('admin/ppdb*') ? '' : 'hidden' }}">
              <a href="{{ route('admin.ppdb.data-pendaftar') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.ppdb.data-pendaftar') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.ppdb.data-pendaftar') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.ppdb.data-pendaftar') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Data Pendaftar</span>
              </a>
              <a href="{{ route('admin.ppdb.verifikasi-berkas') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.ppdb.verifikasi-berkas') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.ppdb.verifikasi-berkas') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.ppdb.verifikasi-berkas') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Verifikasi Berkas</span>
              </a>
              <a href="{{ route('admin.ppdb.seleksi') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.ppdb.seleksi') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.ppdb.seleksi') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.ppdb.seleksi') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Seleksi</span>
              </a>
              <a href="{{ route('admin.ppdb.pembayaran') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.ppdb.pembayaran') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0">
                  <span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.ppdb.pembayaran') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center">
                    <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.ppdb.pembayaran') ? 'bg-primary' : 'bg-transparent' }}"></span>
                  </span>
                </span>
                <span class="flex-1">Pembayaran</span>
              </a>
            </div>
          </div>
          <!-- Kegiatan Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="const m=document.getElementById('menuKegiatan');const a=document.getElementById('arrowKegiatan');m.classList.toggle('hidden');a.classList.toggle('rotate-180');" aria-expanded="false" aria-controls="menuKegiatan" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="calendar-days" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Kegiatan</span>
              </div>
              <i id="arrowKegiatan" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('admin/kegiatan*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuKegiatan" class="ml-4 mt-2 space-y-2 {{ request()->is('admin/kegiatan*') ? '' : 'hidden' }}">
              <a href="{{ route('admin.kegiatan.event.index') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.kegiatan.event.index') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.kegiatan.event.index') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.kegiatan.event.index') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Event</span>
              </a>
              <a href="{{ route('admin.kegiatan.agenda.index') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.kegiatan.agenda.index') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.kegiatan.agenda.index') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.kegiatan.agenda.index') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Agenda</span>
              </a>
              <a href="{{ route('admin.kegiatan.dokumentasi.index') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.kegiatan.dokumentasi.index') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.kegiatan.dokumentasi.index') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.kegiatan.dokumentasi.index') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Dokumentasi</span>
              </a>
              <a href="{{ route('admin.kegiatan.pengumuman.index') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.kegiatan.pengumuman.index') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.kegiatan.pengumuman.index') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.kegiatan.pengumuman.index') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Pengumuman</span>
              </a>
            </div>
          </div>

          <!-- Laporan Sekolah Dropdown -->
          <div class="group cursor-pointer">
            <button onclick="const m=document.getElementById('menuLaporan');const a=document.getElementById('arrowLaporan');m.classList.toggle('hidden');a.classList.toggle('rotate-180');" aria-expanded="false" aria-controls="menuLaporan" class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">
              <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">Laporan Sekolah</span>
              </div>
              <i id="arrowLaporan" data-lucide="chevron-down" class="w-4 h-4 text-secondary transition-transform duration-300 {{ request()->is('admin/laporan*') ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="menuLaporan" class="ml-4 mt-2 space-y-2 {{ request()->is('admin/laporan*') ? '' : 'hidden' }}">
              <a href="{{ route('admin.laporan.index') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.laporan.index') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.laporan.index') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.laporan.index') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Semua Laporan</span>
              </a>
              <a href="{{ route('admin.laporan.absensi') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.laporan.absensi') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.laporan.absensi') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.laporan.absensi') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Laporan Absensi</span>
              </a>
              <a href="{{ route('admin.laporan.akademik') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.laporan.akademik') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.laporan.akademik') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.laporan.akademik') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Laporan Akademik</span>
              </a>
              <a href="{{ route('admin.laporan.keuangan') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.laporan.keuangan') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.laporan.keuangan') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.laporan.keuangan') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Laporan Keuangan</span>
              </a>
              <a href="{{ route('admin.laporan.ppdb') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.laporan.ppdb') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.laporan.ppdb') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.laporan.ppdb') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Laporan PPDB</span>
              </a>
              <a href="{{ route('admin.laporan.perpustakaan') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.laporan.perpustakaan') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.laporan.perpustakaan') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.laporan.perpustakaan') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Laporan Perpustakaan</span>
              </a>
              <a href="{{ route('admin.laporan.kegiatan') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('admin.laporan.kegiatan') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('admin.laporan.kegiatan') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('admin.laporan.kegiatan') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Laporan Kegiatan</span>
              </a>
            </div>
          </div>
    <!-- Bottom Help Card -->
    <div class="absolute bottom-0 left-0 w-[280px]">
      <div class="flex items-center justify-between border-t bg-white border-border p-5 gap-3">
        <div class="min-w-0">
          <p class="font-semibold text-foreground">Need help?</p>
          <a href="#" class="cursor-pointer"><span class="text-sm text-secondary hover:text-primary hover:underline transition-all duration-300">Contact support</span></a>
        </div>
        <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
          <i data-lucide="message-circle-question" class="size-6 text-primary"></i>
        </div>
      </div>
    </div>
    a
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
      <h2 class="hidden lg:block font-bold text-2xl text-foreground">Dashboard Admin</h2>
      <!-- Right actions -->
      <div class="flex items-center gap-3 ml-auto">
        <button class="size-11 flex items-center justify-center rounded-xl ring-1 ring-border hover:ring-primary transition-all duration-300 cursor-pointer relative" aria-label="Notifications">
          <i data-lucide="bell" class="size-6 text-secondary"></i>
          <span class="absolute -top-1 -right-1 h-5 px-1.5 rounded-full bg-error text-white text-xs font-medium flex items-center justify-center">3</span>
        </button>
        <div class="hidden md:flex items-center gap-3 pl-3 border-l border-border">
          <div class="text-right">
            <p class="font-semibold text-foreground text-sm">Admin User</p>
            <p class="text-secondary text-xs">Administrator</p>
          </div>
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" alt="Profile" class="size-11 rounded-full object-cover ring-2 ring-border">
        </div>
      </div>
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

function toggleSekolah() {
  const menu = document.getElementById('menuSekolah');
  const arrow = document.getElementById('arrowSekolah');

  if (!menu || !arrow) return;

  menu.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}
</script>

<script>
function toggleAkademik() {
  var menu = document.getElementById('menuAkademik');
  var arrow = document.getElementById('arrowAkademik');
  if (menu.classList.contains('hidden')) {
    menu.classList.remove('hidden');
    arrow.classList.add('rotate-180');
  } else {
    menu.classList.add('hidden');
    arrow.classList.remove('rotate-180');
  }
}
</script>
</body>
</html>
