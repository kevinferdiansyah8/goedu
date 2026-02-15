<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard') - GOEDU</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @stack('styles')
</head>

<body class="antialiased bg-gray-100">

<div class="flex min-h-screen">

  {{-- SIDEBAR (ROLE BASED) --}}
  @if(session('role') === 'admin')
    @include('layouts.sidebar-admin')
  @elseif(session('role') === 'guru')
    @include('layouts.sidebar-guru')
  @elseif(session('role') === 'orangtua')
    @include('layouts.sidebar-orangtua')
  @elseif(session('role') === 'siswa')
    @include('layouts.sidebar-siswa')
  @endif

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
</body>
</html>
