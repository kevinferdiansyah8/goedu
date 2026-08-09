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
@else
    @include('layouts.sidebar-admin')
@endauth
