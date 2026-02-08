@extends('layouts.admin')

@section('title', 'Izin / Sakit / Alpha Siswa')

@section('content')
<div class="space-y-6">

  {{-- Header --}}
  <div>
    <h1 class="text-xl font-semibold text-foreground">
      Izin / Sakit / Alpha Siswa
    </h1>
    <p class="text-sm text-secondary">
      Kelola pengajuan izin dan sakit siswa.
    </p>
  </div>

  {{-- Filter --}}
  <div class="bg-white rounded-xl p-4 shadow-sm">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="text-sm font-medium">Kelas</label>
        <select class="form-control mt-1">
          <option>-- Semua Kelas --</option>
          <option>X RPL</option>
          <option>XI RPL</option>
        </select>
      </div>

      <div>
        <label class="text-sm font-medium">Tanggal</label>
        <input type="date" class="form-control mt-1">
      </div>
    </div>
  </div>

  {{-- Tabel Pengajuan --}}
  <div class="bg-white rounded-xl p-6 shadow-sm">
    <h2 class="text-base font-semibold mb-4">Daftar Pengajuan Siswa</h2>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="border-b text-secondary">
          <tr>
            <th class="py-2 text-left">Tanggal</th>
            <th class="text-left">Nama Siswa</th>
            <th class="text-left">Kelas</th>
            <th class="text-left">Jenis</th>
            <th class="text-left">Alasan</th>
            <th class="text-left">Bukti</th>
            <th class="text-left">Status</th>
            <th class="text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>

          {{-- Contoh Data --}}
          <tr class="border-b">
            <td class="py-2">10-02-2026</td>
            <td>Ahmad Fauzi</td>
            <td>X RPL</td>
            <td>Sakit</td>
            <td>Demam tinggi</td>
            <td>
              <a href="#" class="text-primary text-xs">Lihat</a>
            </td>
            <td>
              <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                Menunggu
              </span>
            </td>
            <td class="space-x-2">
              <button class="px-3 py-1 text-xs rounded-lg bg-green-500 text-white">
                Setujui
              </button>
              <button class="px-3 py-1 text-xs rounded-lg bg-red-500 text-white">
                Tolak
              </button>
            </td>
          </tr>

          <tr class="border-b">
            <td class="py-2">10-02-2026</td>
            <td>Budi Santoso</td>
            <td>X RPL</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>
              <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                Alpha
              </span>
            </td>
            <td>
              <button class="px-3 py-1 text-xs rounded-lg bg-gray-500 text-white">
                Tandai Alpha
              </button>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
