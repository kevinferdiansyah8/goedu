@extends('layouts.admin')

@section('title', 'Ganti Password')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Ganti Password</h1>
        <p class="text-gray-600">Amankan akun Anda dengan mengganti password secara berkala.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 max-w-xl p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 max-w-xl p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-rose-700 shadow-sm">
        <div class="flex items-center gap-3 mb-1">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
            <span class="font-bold text-sm">Gagal memperbarui password:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-1 ml-8">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-xl">
        <form action="{{ route('orangtua.profil.password.update') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Password Saat Ini</label>
                <input type="password" name="current_password" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium" placeholder="Masukkan password lama" required>
            </div>
            <hr class="border-gray-100">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Password Baru</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium" placeholder="Minimal 6 karakter" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium" placeholder="Ulangi password baru" required>
            </div>

            <div class="bg-amber-50 p-4 rounded-xl border border-amber-100">
                <div class="flex gap-3">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 flex-shrink-0"></i>
                    <div class="text-xs text-amber-900 space-y-1">
                        <p class="font-bold">Ketentuan Password:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            <li>Minimal 6 karakter.</li>
                            <li>Gunakan kombinasi huruf dan angka untuk keamanan maksimal.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-primary hover:bg-primary-hover text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md shadow-blue-200 w-full sm:w-auto cursor-pointer">
                    Update Password Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
