@extends('layouts.app')

@section('title', 'Pendaftaran PPDB')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f8fafc] p-4 font-['Outfit'] relative overflow-hidden">
    
    {{-- Background Ornaments --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>

    <div class="max-w-2xl w-full z-10 py-10">
        {{-- Logo & Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl shadow-xl shadow-indigo-100 mb-4 transform hover:rotate-12 transition-transform duration-300">
                <i data-lucide="user-plus" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Pendaftaran Peserta Didik Baru</h1>
            <p class="text-gray-500 mt-2 font-medium">Lengkapi data di bawah ini untuk mendaftar</p>
        </div>

        {{-- Register Card --}}
        <div class="bg-white rounded-[32px] shadow-2xl shadow-indigo-100/50 p-8 border border-gray-100 backdrop-blur-sm">
            
            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('ppdb.daftar') }}" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <i data-lucide="user" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Sesuai Ijazah/Akte"
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    {{-- NISN --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">NISN <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <i data-lucide="hash" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="10 Digit NISN" maxlength="10" inputmode="numeric"
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <i data-lucide="calendar" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Jurusan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Jurusan / Program <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <i data-lucide="book-open" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors pointer-events-none"></i>
                            <select name="jurusan" required class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                                <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih Jurusan</option>
                                <option value="SD" {{ old('jurusan') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('jurusan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA IPA" {{ old('jurusan') == 'SMA IPA' ? 'selected' : '' }}>SMA - IPA</option>
                                <option value="SMA IPS" {{ old('jurusan') == 'SMA IPS' ? 'selected' : '' }}>SMA - IPS</option>
                                <option value="SMK RPL" {{ old('jurusan') == 'SMK RPL' ? 'selected' : '' }}>SMK - RPL</option>
                                <option value="SMK TKJ" {{ old('jurusan') == 'SMK TKJ' ? 'selected' : '' }}>SMK - TKJ</option>
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-4 top-4 pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Jalur --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Jalur Pendaftaran <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <i data-lucide="map-pin" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors pointer-events-none"></i>
                            <select name="jalur" required class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                                <option value="" disabled {{ old('jalur') ? '' : 'selected' }}>Pilih Jalur</option>
                                <option value="Reguler" {{ old('jalur') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="Prestasi" {{ old('jalur') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                <option value="Zonasi" {{ old('jalur') == 'Zonasi' ? 'selected' : '' }}>Zonasi</option>
                                <option value="Afirmasi" {{ old('jalur') == 'Afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 absolute right-4 top-4 pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Asal Sekolah --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Asal Sekolah</label>
                        <div class="relative group">
                            <i data-lucide="building-2" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Contoh: SMPN 1 Jakarta"
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Aktif</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Nomor WA / HP</label>
                        <div class="relative group">
                            <i data-lucide="phone" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx"
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 mt-6">
                    <p class="text-xs text-gray-500 mb-4 text-center">Pastikan NISN dan Tanggal Lahir yang Anda masukkan benar. Data tersebut akan digunakan sebagai akses Login Anda ke dalam sistem.</p>
                    
                    <button type="submit" 
                        class="w-full py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3 group">
                        DAFTAR SEKARANG
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('ppdb.index') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition-colors inline-flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda PPDB
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) lucide.createIcons();
    });
</script>
@endsection
