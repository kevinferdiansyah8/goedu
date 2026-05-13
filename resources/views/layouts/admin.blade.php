<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard') - GOEDU</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  @stack('styles')
</head>

<body class="antialiased bg-gray-100">

<div class="flex min-h-screen">

  {{-- SIDEBAR (ROLE BASED) --}}
  @auth
    @if(Auth::user()->role === 'admin')
      @include('layouts.sidebar-admin')
    @elseif(Auth::user()->role === 'guru')
      @include('layouts.sidebar-guru')
    @elseif(Auth::user()->role === 'orangtua')
      @include('layouts.sidebar-orangtua')
    @elseif(Auth::user()->role === 'siswa')
      @include('layouts.sidebar-siswa')
    @elseif(Auth::user()->role === 'keuangan')
      @include('layouts.sidebar-keuangan')
    @endif
  @endauth

  {{-- MAIN CONTENT --}}
  <div class="flex-1 flex flex-col">

    <main class="flex-1 p-6">
      @yield('content')
    </main>

  </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
<script>if(typeof lucide!=='undefined')lucide.createIcons();</script>
</body>
</html>
