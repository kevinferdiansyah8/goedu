@extends('layouts.admin')

@section('title', 'Ganti Password')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Ganti Password</h1>
        <p class="text-gray-600">Amankan akun Anda dengan mengganti password secara berkala.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-xl">
        <form action="#" method="POST" class="space-y-6">
             <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                <input type="password" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border" placeholder="Masukkan password lama">
            </div>
            <hr class="border-gray-100">
             <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border" placeholder="Minimal 8 karakter">
            </div>
             <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border" placeholder="Ulangi password baru">
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                <div class="flex gap-3">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 flex-shrink-0"></i>
                    <div class="text-xs text-yellow-800 space-y-1">
                        <p class="font-bold">Ketentuan Password:</p>
                        <ul class="list-disc list-inside">
                            <li>Minimal 8 karakter.</li>
                            <li>Gunakan kombinasi huruf besar dan kecil.</li>
                            <li>Disarankan menggunakan angka atau simbol.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-md shadow-blue-600/20 w-full sm:w-auto">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
