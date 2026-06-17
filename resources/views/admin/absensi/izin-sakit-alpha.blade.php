@extends('layouts.admin')

@section('title', 'Izin / Sakit / Alpha')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

  <!-- Header -->
  <div class="mb-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Izin / Sakit / Alpha</h1>
      <p class="text-gray-500">Monitoring ketidakhadiran siswa berdasarkan data absensi</p>
    </div>
    <!-- Filter Bulan -->
    <form method="GET" action="{{ route('admin.absensi.izin-sakit-alpha') }}" class="flex gap-2 items-center">
      <label class="text-sm font-semibold text-gray-600">Bulan:</label>
      <input type="month" name="bulan" value="{{ $bulan }}"
             class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
        <i class="fa fa-filter mr-1"></i> Filter
      </button>
    </form>
  </div>

  <!-- Tabs -->
  <div class="flex gap-2 mb-6">
    <button class="tab-btn active" onclick="switchTab('siswa', this)">Siswa</button>
    <button class="tab-btn" onclick="switchTab('guru', this)">Guru</button>
  </div>

  <!-- ===================== -->
  <!-- TAB SISWA -->
  <!-- ===================== -->
  <div id="tab-siswa">
    <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
      <table class="w-full text-base">
        <thead class="bg-slate-100 text-blue-900">
          <tr>
            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
            <th class="px-5 py-3 text-left font-bold">Kelas</th>
            <th class="px-5 py-3 text-center font-bold">Jenis</th>
            <th class="px-5 py-3 text-center font-bold">Tanggal</th>
            <th class="px-5 py-3 text-left font-bold rounded-tr-xl">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($izinSiswa as $row)
          @php
            $jenis = $row['jenis'];
            $badge = $jenis === 'Izin' ? 'bg-yellow-100 text-yellow-700' : ($jenis === 'Sakit' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700');
            $icon  = $jenis === 'Izin' ? 'fa-clock' : ($jenis === 'Sakit' ? 'fa-user-md' : 'fa-times-circle');
          @endphp
          <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg hover:scale-[1.01] transition rounded-xl">
            <td class="px-5 py-3 flex items-center gap-3">
              <span class='w-10 h-10 rounded-full bg-gradient-to-br from-pink-200 to-pink-400 text-pink-800 font-bold flex items-center justify-center shadow'>
                {{ collect(explode(' ', $row['nama']))->map(fn($n)=>$n[0])->join('') }}
              </span>
              <span class="font-medium text-gray-800">{{ $row['nama'] }}</span>
            </td>
            <td class="px-5 py-3">{{ $row['kelas'] }}</td>
            <td class="px-5 py-3 text-center">
              <span class="px-3 py-1 rounded-full {{ $badge }} text-xs font-semibold flex items-center gap-1 justify-center">
                <i class='fa {{ $icon }}'></i> {{ $jenis }}
              </span>
            </td>
            <td class="px-5 py-3 text-center">{{ $row['tanggal'] }}</td>
            <td class="px-5 py-3 text-gray-600">{{ $row['alasan'] }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-5 py-12 text-center text-gray-400">
              <i class="fa fa-check-circle text-3xl text-green-400 mb-2"></i>
              <p class="font-semibold">Tidak ada ketidakhadiran siswa pada bulan <strong>{{ $bulan }}</strong></p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- ===================== -->
  <!-- TAB GURU -->
  <!-- ===================== -->
  <div id="tab-guru" class="hidden">
    <div class="bg-white/95 rounded-2xl shadow-2xl overflow-x-auto p-2">
      <table class="w-full text-base">
        <thead class="bg-slate-100 text-blue-900">
          <tr>
            <th class="px-5 py-3 text-left font-bold rounded-tl-xl">Nama</th>
            <th class="px-5 py-3 text-left font-bold">Mata Pelajaran</th>
            <th class="px-5 py-3 text-center font-bold">Jenis</th>
            <th class="px-5 py-3 text-center font-bold">Tanggal</th>
            <th class="px-5 py-3 text-left font-bold rounded-tr-xl">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($izinGuru as $row)
          <tr class="group bg-white even:bg-blue-50/40 hover:shadow-lg transition">
            <td class="px-5 py-3 flex items-center gap-3">
              <span class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-200 to-blue-400 text-blue-800 font-bold flex items-center justify-center shadow'>
                {{ collect(explode(' ', $row['nama']))->map(fn($n)=>$n[0])->join('') }}
              </span>
              <span class="font-medium text-gray-800">{{ $row['nama'] }}</span>
            </td>
            <td class="px-5 py-3">{{ $row['mapel'] ?? '-' }}</td>
            <td class="px-5 py-3 text-center">{{ $row['jenis'] }}</td>
            <td class="px-5 py-3 text-center">{{ $row['tanggal'] }}</td>
            <td class="px-5 py-3 text-gray-600">{{ $row['alasan'] }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-5 py-12 text-center text-gray-400">
              <i class="fa fa-info-circle text-3xl mb-2"></i>
              <p>Data absensi guru belum tersedia.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<style>
.tab-btn {
  padding: 0.5rem 1.25rem;
  border-radius: 0.75rem;
  border: 1px solid #e5e7eb;
  font-weight: 500;
  color: #6b7280;
}
.tab-btn.active {
  background: #2563eb;
  color: white;
  border-color: #2563eb;
}
</style>

<script>
function switchTab(tab, btn) {
  document.getElementById('tab-siswa').classList.add('hidden');
  document.getElementById('tab-guru').classList.add('hidden');
  document.getElementById('tab-' + tab).classList.remove('hidden');
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
</script>
@endsection
