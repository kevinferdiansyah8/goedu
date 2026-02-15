@extends('layouts.admin')

@section('title', 'Ganti Password')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-md mx-auto">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Ganti Password</h1>
            <p class="text-gray-600">Amankan akun Anda dengan mengganti password secara berkala.</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
            <form action="#" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <div class="relative">
                            <input type="password" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 pr-10" placeholder="Masukkan password lama">
                            <i data-lucide="lock" class="w-5 h-5 text-gray-400 absolute right-3 top-2.5"></i>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4"></div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                         <div class="relative">
                            <input type="password" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 pr-10" placeholder="Minimal 8 karakter">
                            <i data-lucide="key" class="w-5 h-5 text-gray-400 absolute right-3 top-2.5"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                         <div class="relative">
                            <input type="password" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 pr-10" placeholder="Ulangi password baru">
                            <i data-lucide="check-circle" class="w-5 h-5 text-gray-400 absolute right-3 top-2.5"></i>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                            Simpan Password Baru
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
