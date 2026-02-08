@extends('layouts.admin')

@section('title', 'Identitas & Profil Sekolah')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4 flex items-center gap-2 text-gray-400" aria-label="Breadcrumb">
        <a href="/admin" class="hover:text-blue-600 transition"><i data-lucide="home" class="inline w-4 h-4 mr-1"></i>Dashboard</a>
        <span>/</span>
        <a href="#" class="hover:text-blue-600 transition">Data Sekolah</a>
        <span>/</span>
        <span class="text-gray-500">Identitas</span>
    </nav>
    <!-- Header -->
    <div class="mb-8 flex items-center gap-3">
        <div class="flex items-center justify-center bg-blue-100 rounded-xl w-12 h-12 mr-2">
            <i data-lucide="school" class="w-7 h-7 text-blue-600"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Identitas & Profil Sekolah</h1>
            <p class="text-gray-500">Lengkapi data resmi dan profil sekolah Anda di bawah ini.</p>
        </div>
    </div>
    <!-- Card Container -->
    <form class="bg-white border border-gray-100 rounded-2xl shadow p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Informasi Sekolah -->
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <i data-lucide="info" class="w-5 h-5 text-blue-500"></i>
                    <h2 class="text-lg font-semibold text-gray-800">Informasi Sekolah</h2>
                </div>
                <p class="text-xs text-gray-400 mb-4">Data utama identitas sekolah.</p>
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Contoh: SDN 1 Harapan Bangsa">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NPSN</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Nomor Pokok Sekolah Nasional">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Sekolah</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">Pilih Status</option>
                            <option value="Negeri">Negeri</option>
                            <option value="Swasta">Swasta</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Sekolah</label>
                        <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Alamat lengkap sekolah"></textarea>
                    </div>
                </div>
            </div>
            <!-- Kontak & Profil -->
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <i data-lucide="user" class="w-5 h-5 text-blue-500"></i>
                    <h2 class="text-lg font-semibold text-gray-800">Kontak & Profil</h2>
                </div>
                <p class="text-xs text-gray-400 mb-4">Kontak resmi dan kepala sekolah.</p>
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Sekolah</label>
                        <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="contoh@emailsekolah.sch.id">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="08xxxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website Sekolah</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="https://namasekolah.sch.id">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kepala Sekolah</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Nama Kepala Sekolah">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-10">
            <button type="submit" class="flex items-center gap-2 px-7 py-2.5 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
