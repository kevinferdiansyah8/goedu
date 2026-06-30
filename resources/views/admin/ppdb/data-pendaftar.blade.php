@extends('layouts.admin')

@section('title', 'PPDB - Data Pendaftar')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">PPDB</h1>
            <p class="text-gray-500">Manajemen Penerimaan Peserta Didik Baru</p>
        </div>
        <div class="flex gap-3">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full font-semibold text-sm">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Periode Aktif {{ date('Y') }}/{{ date('Y')+1 }}
            </span>
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-full font-semibold text-sm hover:bg-blue-700 transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Pendaftar
            </button>
        </div>
    </div>

    {{-- SUMMARY CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <div class="flex items-center gap-4 bg-white border-2 border-gray-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-blue-50"><i data-lucide="users" class="w-7 h-7 text-blue-600"></i></div>
            <div>
                <div class="text-sm font-semibold text-gray-500">Total Pendaftar</div>
                <div class="text-3xl font-extrabold text-gray-900">{{ $summary['total'] }}</div>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-white border-2 border-gray-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-sky-50"><i data-lucide="check-circle-2" class="w-7 h-7 text-sky-600"></i></div>
            <div>
                <div class="text-sm font-semibold text-sky-600">Diverifikasi</div>
                <div class="text-3xl font-extrabold text-sky-700">{{ $summary['diverifikasi'] }}</div>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-white border-2 border-gray-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-green-50"><i data-lucide="award" class="w-7 h-7 text-green-600"></i></div>
            <div>
                <div class="text-sm font-semibold text-green-600">Lulus</div>
                <div class="text-3xl font-extrabold text-green-700">{{ $summary['lulus'] }}</div>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-white border-2 border-gray-200 rounded-2xl p-5 shadow-md hover:shadow-xl transition">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-red-50"><i data-lucide="x-octagon" class="w-7 h-7 text-red-600"></i></div>
            <div>
                <div class="text-sm font-semibold text-red-600">Tidak Lulus</div>
                <div class="text-3xl font-extrabold text-red-700">{{ $summary['tidak_lulus'] }}</div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <form class="bg-white border-2 border-gray-200 rounded-2xl shadow-md px-6 py-4 flex flex-wrap gap-4 items-center mb-8" method="GET">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / no daftar" class="px-5 py-2.5 rounded-full bg-gray-50 border border-gray-200 text-base w-72 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        <select name="jurusan" class="px-5 py-2.5 rounded-full bg-gray-50 border border-gray-200 text-base font-bold" onchange="this.form.submit()">
            <option value="">Semua Pilihan Kelas</option>
            @foreach($jurusanList as $j)
                <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
        <select name="status" class="px-5 py-2.5 rounded-full bg-gray-50 border border-gray-200 text-base font-bold" onchange="this.form.submit()">
            <option value="Semua Status">Semua Status</option>
            @foreach(['Menunggu','Diverifikasi','Lulus','Tidak Lulus'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-700 transition"><i data-lucide="search" class="w-4 h-4 inline"></i> Cari</button>
    </form>
 
    {{-- TABLE --}}
    <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-2xl overflow-x-auto">
        <table class="min-w-full text-base">
            <thead class="bg-slate-100 text-blue-900">
                <tr>
                    <th class="px-5 py-3 text-left font-bold">No Daftar</th>
                    <th class="px-5 py-3 text-left font-bold">Nama</th>
                    <th class="px-5 py-3 text-left font-bold">Pilihan Kelas</th>
                    <th class="px-5 py-3 text-left font-bold">Jalur</th>
                    <th class="px-5 py-3 text-center font-bold">Status</th>
                    <th class="px-5 py-3 text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftar as $p)
                <tr class="group even:bg-blue-50/40 hover:bg-blue-100/60 transition">
                    <td class="px-5 py-3 font-extrabold">{{ $p->no_daftar }}</td>
                    <td class="px-5 py-3">
                        <div>{{ $p->nama }}</div>
                        @if($p->asal_sekolah)<div class="text-xs text-gray-400">{{ $p->asal_sekolah }}</div>@endif
                    </td>
                    <td class="px-5 py-3">{{ $p->jurusan ?? '-' }}</td>
                    <td class="px-5 py-3">{{ $p->jalur ?? '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        @php
                        $badge = match($p->status) {
                            'Menunggu' => 'bg-gray-100 text-gray-700 border-gray-300',
                            'Diverifikasi' => 'bg-sky-50 text-sky-700 border-sky-200',
                            'Lulus' => 'bg-green-50 text-green-700 border-green-200',
                            'Tidak Lulus' => 'bg-red-50 text-red-700 border-red-200',
                            default => 'bg-gray-100 text-gray-600 border-gray-200',
                        };
                        @endphp
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold border {{ $badge }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            {{-- Detail --}}
                            <button onclick='openDetail(@json($p))' class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-700 text-sm font-semibold transition" title="Detail">
                                <i data-lucide="eye" class="w-4 h-4 inline"></i>
                            </button>
                            {{-- Verifikasi --}}
                            <form action="{{ route('admin.ppdb.update-status', $p->id) }}" method="POST" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Diverifikasi">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-200 text-sm font-semibold transition" title="Verifikasi">
                                    <i data-lucide="check" class="w-4 h-4 inline"></i>
                                </button>
                            </form>
                            {{-- Luluskan --}}
                            <form action="{{ route('admin.ppdb.update-status', $p->id) }}" method="POST" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Lulus">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-green-50 text-green-700 hover:bg-green-200 text-sm font-semibold transition" title="Luluskan">
                                    <i data-lucide="award" class="w-4 h-4 inline"></i>
                                </button>
                            </form>
                            {{-- Tidak Lulus --}}
                            <form action="{{ route('admin.ppdb.update-status', $p->id) }}" method="POST" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Tidak Lulus">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 hover:bg-red-200 text-sm font-semibold transition" title="Tidak Lulus">
                                    <i data-lucide="x" class="w-4 h-4 inline"></i>
                                </button>
                            </form>
                            {{-- Hapus --}}
                            <form action="{{ route('admin.ppdb.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-200 text-sm font-semibold transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-10 text-gray-400">Belum ada data pendaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $pendaftar->links() }}</div>

    {{-- DETAIL MODAL --}}
    <div id="modalDetail" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 relative">
            <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500"><i data-lucide="x" class="w-5 h-5"></i></button>
            <h3 class="text-xl font-bold mb-4 text-blue-700">Detail Pendaftar</h3>
            <div id="detailContent" class="space-y-2 text-base"></div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 relative">
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500"><i data-lucide="x" class="w-5 h-5"></i></button>
            <h3 class="text-xl font-bold mb-4 text-blue-700">Tambah Pendaftar Baru</h3>
            <form action="{{ route('admin.ppdb.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" class="w-full px-4 py-2 border rounded-xl" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">NISN</label>
                        <input type="text" name="nisn" class="w-full px-4 py-2 border rounded-xl" placeholder="Untuk login calon siswa">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="w-full px-4 py-2 border rounded-xl" placeholder="Untuk login calon siswa">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Pilihan Kelas <span class="text-red-500">*</span></label>
                        <select name="jurusan" class="w-full px-4 py-2 border rounded-xl" required>
                            <option value="Kelas 7">Kelas 7</option>
                            <option value="Kelas 8">Kelas 8</option>
                            <option value="Kelas 9">Kelas 9</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Jalur <span class="text-red-500">*</span></label>
                        <select name="jalur" class="w-full px-4 py-2 border rounded-xl" required>
                            <option value="Reguler">Reguler</option>
                            <option value="Prestasi">Prestasi</option>
                            <option value="Zonasi">Zonasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="w-full px-4 py-2 border rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-2 border rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Telepon</label>
                        <input type="text" name="telepon" class="w-full px-4 py-2 border rounded-xl">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openDetail(p) {
    document.getElementById('modalDetail').classList.remove('hidden');
    document.getElementById('detailContent').innerHTML = `
        <div><b>No Daftar:</b> ${p.no_daftar}</div>
        <div><b>Nama:</b> ${p.nama}</div>
        <div><b>NISN:</b> ${p.nisn || '-'}</div>
        <div><b>Tanggal Lahir:</b> ${p.tanggal_lahir || '-'}</div>
        <div><b>Jurusan:</b> ${p.jurusan || '-'}</div>
        <div><b>Jalur:</b> ${p.jalur || '-'}</div>
        <div><b>Asal Sekolah:</b> ${p.asal_sekolah || '-'}</div>
        <div><b>Email:</b> ${p.email || '-'}</div>
        <div><b>Telepon:</b> ${p.telepon || '-'}</div>
        <div><b>Status:</b> ${p.status}</div>
        <div><b>Berkas:</b> ${p.berkas_status}</div>
        <div><b>Catatan:</b> ${p.catatan || '-'}</div>
        <div><b>Tanggal Daftar:</b> ${p.tanggal || '-'}</div>
    `;
}
</script>
@endsection
