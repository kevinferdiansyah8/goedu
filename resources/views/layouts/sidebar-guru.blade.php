<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EDUGO - Dashboard Guru</title>
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
         <a href="{{ route('guru.dashboard') }}"
             class="group {{ request()->routeIs('guru.dashboard') ? 'active' : '' }} cursor-pointer">

            <div class="flex items-center rounded-xl p-4 gap-3 bg-white group-[.active]:bg-muted group-hover:bg-muted transition-all duration-300">
              <i data-lucide="layout-dashboard" class="size-6 text-secondary group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300"></i>
              <span class="font-medium text-secondary group-[.active]:font-semibold group-[.active]:text-foreground group-hover:text-foreground transition-all duration-300">Dashboard Guru</span>
            </div>
          </a>
          

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
            
            <a href="{{ route('guru.akademik.jadwal-mengajar') }}"
   class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
   {{ request()->routeIs('guru.akademik.jadwal-mengajar')
      ? 'bg-muted text-foreground font-semibold'
      : 'text-secondary hover:bg-muted hover:text-foreground' }}">

    <span class="menu-bullet flex-shrink-0">
        <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
        {{ request()->routeIs('guru.akademik.jadwal-mengajar')
            ? 'border-primary'
            : 'border-gray-300' }}
        flex items-center justify-center">

            <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
            {{ request()->routeIs('guru.akademik.jadwal-mengajar')
                ? 'bg-primary'
                : 'bg-transparent' }}">
            </span>
        </span>
    </span>

    <span class="flex-1">Jadwal Mengajar</span>
</a>

<a href="{{ route('guru.akademik.kelas') }}"
   class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
   {{ request()->routeIs('guru.akademik.kelas')
      ? 'bg-muted text-foreground font-semibold'
      : 'text-secondary hover:bg-muted hover:text-foreground' }}">

    <span class="menu-bullet flex-shrink-0">
        <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
        {{ request()->routeIs('guru.akademik.kelas')
            ? 'border-primary'
            : 'border-gray-300' }}
        flex items-center justify-center">
            <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
            {{ request()->routeIs('guru.akademik.kelas')
                ? 'bg-primary'
                : 'bg-transparent' }}"></span>
        </span>
    </span>

    <span class="flex-1">Daftar Kelas & Siswa</span>
</a>

 {{-- Input Nilai Tugas --}}
    <a href="{{ route('guru.akademik.nilai.tugas') }}"
       class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
       {{ request()->routeIs('guru.akademik.nilai.tugas') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
        <span class="menu-bullet flex-shrink-0">
        <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
        {{ request()->routeIs('guru.akademik.nilai.tugas')
            ? 'border-primary'
            : 'border-gray-300' }}
        flex items-center justify-center">
            <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
            {{ request()->routeIs('guru.akademik.nilai.tugas')
                ? 'bg-primary'
                : 'bg-transparent' }}"></span>
        </span>
    </span>
        Input Nilai Tugas / Ulangan
    </a>


    {{-- Input Nilai Rapor --}}
    <a href="{{ route('guru.akademik.nilai.rapor') }}"
       class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
       {{ request()->routeIs('guru.akademik.nilai.rapor') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
        <span class="menu-bullet flex-shrink-0">
        <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
        {{ request()->routeIs('guru.akademik.nilai.rapor')
            ? 'border-primary'
            : 'border-gray-300' }}
        flex items-center justify-center">
            <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
            {{ request()->routeIs('guru.akademik.nilai.rapor')
                ? 'bg-primary'
                : 'bg-transparent' }}"></span>
        </span>
    </span>
        Input Nilai Rapor
    </a>

    {{-- Rekap Nilai --}}
    <a href="{{ route('guru.akademik.rekap') }}"
       class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
       {{ request()->routeIs('guru.akademik.rekap') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
        <span class="menu-bullet flex-shrink-0">
        <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
        {{ request()->routeIs('guru.akademik.rekap')
            ? 'border-primary'
            : 'border-gray-300' }}
        flex items-center justify-center">
            <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
            {{ request()->routeIs('guru.akademik.rekap')
                ? 'bg-primary'
                : 'bg-transparent' }}"></span>
        </span>
    </span>
        Rekap Nilai
    </a>
    </div>
    {{-- Text --}}
   
      
                    <!-- Absensi Dropdown -->
            <div class="group cursor-pointer">
              <button
                onclick="const m=document.getElementById('menuAbsensiGuru');const a=document.getElementById('arrowAbsensiGuru');m.classList.toggle('hidden');a.classList.toggle('rotate-180');"
                aria-expanded="false"
                aria-controls="menuAbsensiGuru"
                class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">

                <div class="flex items-center gap-3">
                  <i data-lucide="clipboard-list"
                    class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
                  <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">
                    Absensi
                  </span>
                </div>

                <i id="arrowAbsensiGuru"
                  data-lucide="chevron-down"
                  class="w-4 h-4 text-secondary transition-transform duration-300
                  {{ request()->is('guru/absensi*') ? 'rotate-180' : '' }}">
                </i>
              </button>

              <div id="menuAbsensiGuru"
                  class="ml-4 mt-2 space-y-2
                  {{ request()->is('guru/absensi*') ? '' : 'hidden' }}">

                {{-- Absensi Guru --}}
                <a href="{{ url('/guru/absensi/absensi-pertemuan') }}"
                  class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
                  {{ request()->is('guru/absensi/absensi-pertemuan') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">

                  <span class="menu-bullet flex-shrink-0">
                    <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
                    {{ request()->is('guru/absensi/absensi-pertemuan') ? 'border-primary' : 'border-gray-300' }}
                    flex items-center justify-center">
                      <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
                      {{ request()->is('guru/absensi/absensi-pertemuan') ? 'bg-primary' : 'bg-transparent' }}"></span>
                    </span>
                  </span>

                  <span class="flex-1">Absensi Siswa</span>
                </a>

                      {{-- Rekap Absensi --}}
        <a href="{{ url('/guru/absensi/rekap-absensi') }}"
          class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
          {{ request()->is('guru/absensi/rekap-absensi') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">

          <span class="menu-bullet flex-shrink-0">
            <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
            {{ request()->is('guru/absensi/rekap-absensi') ? 'border-primary' : 'border-gray-300' }}
            flex items-center justify-center">
              <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
              {{ request()->is('guru/absensi/rekap-absensi') ? 'bg-primary' : 'bg-transparent' }}"></span>
            </span>
          </span>

          <span class="flex-1">Rekap Absensi</span>
        </a>


         {{-- Izin / Sakit / Alpha --}}
    <a href="{{ url('/guru/absensi/izin-sakit-alpha') }}"
       class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
       {{ request()->is('guru/absensi/izin-sakit-alpha') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">

      <span class="menu-bullet flex-shrink-0">
        <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
        {{ request()->is('guru/absensi/izin-sakit-alpha') ? 'border-primary' : 'border-gray-300' }}
        flex items-center justify-center">
          <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
          {{ request()->is('guru/absensi/izin-sakit-alpha') ? 'bg-primary' : 'bg-transparent' }}"></span>
        </span>
      </span>

      <span class="flex-1">Izin / Sakit / Alpha</span>
    </a>

</div>

                    
               <!-- Kegiatan Dropdown -->
<div class="group cursor-pointer">
  <button
    onclick="const m=document.getElementById('menuKegiatanGuru');const a=document.getElementById('arrowKegiatanGuru');m.classList.toggle('hidden');a.classList.toggle('rotate-180');"
    aria-expanded="false"
    aria-controls="menuKegiatanGuru"
    class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white group-hover:bg-muted transition-all duration-300">

    <div class="flex items-center gap-3">
      <i data-lucide="calendar"
         class="size-6 text-secondary group-hover:text-foreground transition-all duration-300"></i>
      <span class="font-medium text-secondary group-hover:text-foreground transition-all duration-300">
        Kegiatan
      </span>
    </div>

    <i id="arrowKegiatanGuru"
       data-lucide="chevron-down"
       class="w-4 h-4 text-secondary transition-transform duration-300
       {{ request()->is('guru/kegiatan*') ? 'rotate-180' : '' }}">
    </i>
  </button>

  <div id="menuKegiatanGuru"
       class="ml-4 mt-2 space-y-2
       {{ request()->is('guru/kegiatan*') ? '' : 'hidden' }}">

                      {{-- Agenda --}}
            <a href="{{ url('/guru/kegiatan/agenda') }}"
              class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
              {{ request()->is('guru/kegiatan/agenda') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">

              <span class="menu-bullet flex-shrink-0">
                <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
                {{ request()->is('guru/kegiatan/agenda') ? 'border-primary' : 'border-gray-300' }}
                flex items-center justify-center">
                  <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
                  {{ request()->is('guru/kegiatan/agenda') ? 'bg-primary' : 'bg-transparent' }}"></span>
                </span>
              </span>

              <span class="flex-1">Agenda</span>
            </a>


                          {{-- Event --}}
                <a href="{{ url('/guru/kegiatan/event') }}"
                  class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
                  {{ request()->is('guru/kegiatan/event') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">

                  <span class="menu-bullet flex-shrink-0">
                    <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
                    {{ request()->is('guru/kegiatan/event') ? 'border-primary' : 'border-gray-300' }}
                    flex items-center justify-center">
                      <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
                      {{ request()->is('guru/kegiatan/event') ? 'bg-primary' : 'bg-transparent' }}"></span>
                    </span>
                  </span>

                  <span class="flex-1">Event</span>
                </a>


                          {{-- Pengumuman --}}
                <a href="{{ url('/guru/kegiatan/pengumuman') }}"
                  class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
                  {{ request()->is('guru/kegiatan/pengumuman') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">

                  <span class="menu-bullet flex-shrink-0">
                    <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
                    {{ request()->is('guru/kegiatan/pengumuman') ? 'border-primary' : 'border-gray-300' }}
                    flex items-center justify-center">
                      <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
                      {{ request()->is('guru/kegiatan/pengumuman') ? 'bg-primary' : 'bg-transparent' }}"></span>
                    </span>
                  </span>

                  <span class="flex-1">Pengumuman</span>
                </a>


         
          <!-- Materi & Tugas -->
    <div class="group cursor-pointer">
      <button onclick="toggleMateri()"
              class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white hover:bg-muted transition-all duration-300">

        <div class="flex items-center gap-3">
          <i data-lucide="book-open" class="size-6 text-secondary"></i>
          <span class="font-medium text-secondary">Materi & Tugas</span>
        </div>

        <i id="arrowMateri"
          data-lucide="chevron-down"
          class="w-4 h-4 text-secondary transition-transform duration-300"></i>
      </button>

      <div id="menuMateri"
     class="ml-4 mt-2 space-y-2 {{ request()->is('guru/materi*') || request()->is('guru/tugas*') ? '' : 'hidden' }}">

  {{-- Upload Materi --}}
  <a href="{{ route('guru.materi.upload') }}"
     class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
     {{ request()->routeIs('guru.materi.upload') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
    <span class="menu-bullet flex-shrink-0">
      <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
      {{ request()->routeIs('guru.materi.upload') ? 'border-primary' : 'border-gray-300' }}
      flex items-center justify-center">
        <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
        {{ request()->routeIs('guru.materi.upload') ? 'bg-primary' : 'bg-transparent' }}"></span>
      </span>
    </span>
    <span class="flex-1">Upload Materi</span>
  </a>

  {{-- Tugas --}}
  <a href="{{ route('guru.tugas.index') }}"
     class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
     {{ request()->routeIs('guru.tugas.index') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
    <span class="menu-bullet flex-shrink-0">
      <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
      {{ request()->routeIs('guru.tugas.index') ? 'border-primary' : 'border-gray-300' }}
      flex items-center justify-center">
        <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
        {{ request()->routeIs('guru.tugas.index') ? 'bg-primary' : 'bg-transparent' }}"></span>
      </span>
    </span>
    <span class="flex-1">Tugas</span>
  </a>

  {{-- Penilaian Tugas --}}
  <a href="{{ route('guru.tugas.penilaian') }}"
     class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
     {{ request()->routeIs('guru.tugas.penilaian') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
    <span class="menu-bullet flex-shrink-0">
      <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
      {{ request()->routeIs('guru.tugas.penilaian') ? 'border-primary' : 'border-gray-300' }}
      flex items-center justify-center">
        <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
        {{ request()->routeIs('guru.tugas.penilaian') ? 'bg-primary' : 'bg-transparent' }}"></span>
      </span>
    </span>
    <span class="flex-1">Penilaian Tugas</span>
  </a>

  {{-- Feedback --}}
  <a href="{{ route('guru.tugas.feedback') }}"
     class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm
     {{ request()->routeIs('guru.tugas.feedback') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
    <span class="menu-bullet flex-shrink-0">
      <span class="menu-bullet-outer w-5 h-5 rounded-full border-2
      {{ request()->routeIs('guru.tugas.feedback') ? 'border-primary' : 'border-gray-300' }}
      flex items-center justify-center">
        <span class="menu-bullet-inner w-2.5 h-2.5 rounded-full
        {{ request()->routeIs('guru.tugas.feedback') ? 'bg-primary' : 'bg-transparent' }}"></span>
      </span>
    </span>
    <span class="flex-1">Feedback</span>
  </a>

</div>

              

      </div>
    </div>


          <!-- Profil Guru -->
      <div class="group cursor-pointer">
        <button onclick="toggleProfil()"
                class="flex items-center justify-between w-full rounded-xl p-4 gap-3 bg-white hover:bg-muted transition-all duration-300">

          <div class="flex items-center gap-3">
            <i data-lucide="user" class="size-6 text-secondary"></i>
            <span class="font-medium text-secondary">Profil Guru</span>
          </div>

          <i id="arrowProfil"
            data-lucide="chevron-down"
            class="w-4 h-4 text-secondary transition-transform duration-300"></i>
        </button>

        <div id="menuProfil" class="ml-4 mt-2 space-y-2 {{ request()->is('guru/profil*') ? '' : 'hidden' }}">
              <a href="{{ route('guru.profil.biodata') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('guru.profil.biodata') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('guru.profil.biodata') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('guru.profil.biodata') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Biodata</span>
              </a>
               <a href="{{ route('guru.profil.riwayat') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('guru.profil.riwayat') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('guru.profil.riwayat') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('guru.profil.riwayat') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Riwayat</span>
              </a>
               <a href="{{ route('guru.profil.arsip') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('guru.profil.arsip') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('guru.profil.arsip') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('guru.profil.arsip') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Arsip</span>
              </a>
                <a href="{{ route('guru.profil.password') }}" class="submenu-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ request()->routeIs('guru.profil.password') ? 'bg-muted text-foreground font-semibold' : 'text-secondary hover:bg-muted hover:text-foreground' }}">
                <span class="menu-bullet flex-shrink-0"><span class="menu-bullet-outer w-5 h-5 rounded-full border-2 {{ request()->routeIs('guru.profil.password') ? 'border-primary' : 'border-gray-300' }} flex items-center justify-center"><span class="menu-bullet-inner w-2.5 h-2.5 rounded-full {{ request()->routeIs('guru.profil.password') ? 'bg-primary' : 'bg-transparent' }}"></span></span></span>
                <span class="flex-1">Password</span>
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
      <h2 class="hidden lg:block font-bold text-2xl text-foreground">Dashboard Guru</h2>
      <!-- Right actions -->
      <div class="flex items-center gap-3 ml-auto">
        <button class="size-11 flex items-center justify-center rounded-xl ring-1 ring-border hover:ring-primary transition-all duration-300 cursor-pointer relative" aria-label="Notifications">
          <i data-lucide="bell" class="size-6 text-secondary"></i>
          <span class="absolute -top-1 -right-1 h-5 px-1.5 rounded-full bg-error text-white text-xs font-medium flex items-center justify-center">3</span>
        </button>
        <div class="hidden md:flex items-center gap-3 pl-3 border-l border-border">
          <div class="text-right">
            <p class="font-semibold text-foreground text-sm">Pak Bambang</p>
            <p class="text-secondary text-xs">Guru Matematika</p>
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

<script>
function toggleMateri() {
  const menu = document.getElementById('menuMateri');
  const arrow = document.getElementById('arrowMateri');
  menu.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}
</script>

<script>
function toggleProfil() {
  const menu = document.getElementById('menuProfil');
  const arrow = document.getElementById('arrowProfil');
  menu.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}
</script>

</body>
</html>
