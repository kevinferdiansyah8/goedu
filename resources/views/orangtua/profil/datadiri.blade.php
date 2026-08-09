@extends('layouts.admin')

@section('title', 'Data Diri Orang Tua')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Diri Orang Tua</h1>
        <p class="text-gray-600">Informasi profil akun dan data orang tua siswa <span class="font-bold text-primary">{{ $student->nama ?? 'Siswa' }}</span>.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-rose-700 shadow-sm">
        <div class="flex items-center gap-3 mb-1">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
            <span class="font-bold text-sm">Gagal memperbarui data:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-1 ml-8">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-4xl">
        <form action="{{ route('orangtua.profil.datadiri.update') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Header Profil -->
                <div class="md:col-span-2 flex flex-col items-center justify-center pb-6 border-b border-gray-100">
                    <div class="w-20 h-20 rounded-full bg-primary/10 text-primary font-bold text-2xl flex items-center justify-center mb-3 border-2 border-primary/20">
                        {{ strtoupper(substr($user->name ?? 'W', 0, 2)) }}
                    </div>
                    <h3 class="font-extrabold text-gray-800 text-lg">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-400 font-medium">Orang Tua dari: <span class="text-primary font-bold">{{ $student->nama ?? '-' }}</span></p>
                </div>

                <!-- Form Fields -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Akun Orang Tua</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email Akun</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $profil->nama_ayah ?? '') }}" placeholder="Nama Ayah Kandung/Wali" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $profil->pekerjaan_ayah ?? '') }}" placeholder="Misal: Pegawai Swasta / PNS / Wiraswasta" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">No. HP / WA Ayah</label>
                    <input type="text" name="telepon_ayah" value="{{ old('telepon_ayah', $profil->telepon_ayah ?? '') }}" placeholder="08xxxxxxxxxx" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $profil->nama_ibu ?? '') }}" placeholder="Nama Ibu Kandung" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $profil->pekerjaan_ibu ?? '') }}" placeholder="Misal: Ibu Rumah Tangga / PNS / Wiraswasta" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">No. HP / WA Ibu</label>
                    <input type="text" name="telepon_ibu" value="{{ old('telepon_ibu', $profil->telepon_ibu ?? '') }}" placeholder="08xxxxxxxxxx" class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" placeholder="Alamat Domisili Orang Tua..." class="w-full border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary p-3 border font-medium">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                </div>
            </div>
            
            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-primary hover:bg-primary-hover text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md shadow-blue-200 cursor-pointer">
                    Simpan Perubahan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
