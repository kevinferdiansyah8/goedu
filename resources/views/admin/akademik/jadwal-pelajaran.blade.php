@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-foreground text-2xl md:text-3xl font-bold flex items-center gap-2">
            <i data-lucide="calendar-range" class="w-7 h-7 text-primary"></i>
            Jadwal Mengajar Guru
        </h1>
        <p class="text-secondary text-sm md:text-base">
            Kelola jadwal mengajar untuk masing-masing guru
        </p>
    </div>
    
    @if($selectedTeacherId)
    <button onclick="openAddModal()" class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-xl transition-colors font-medium">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Tambah Jadwal
    </button>
    @endif
</div>

@if(session('success'))
<div class="mb-4 bg-success-light text-success-dark px-4 py-3 rounded-xl border border-success-light flex items-center gap-2">
    <i data-lucide="check-circle" class="w-5 h-5"></i>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-4 bg-danger-light text-danger-dark px-4 py-3 rounded-xl border border-danger-light">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Filter Guru -->
<div class="rounded-2xl border border-border p-6 bg-white shadow-sm mb-8">
    <form action="{{ route('admin.akademik.jadwal-pelajaran') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="w-full md:w-1/3">
            <label class="block text-sm font-semibold mb-2">Pilih Guru</label>
            <select name="teacher_id" class="w-full border border-border rounded-xl px-4 py-2 bg-muted focus:outline-none focus:ring-2 focus:ring-primary" onchange="this.form.submit()">
                <option value="">-- Pilih Guru --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $selectedTeacherId == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        @if($selectedTeacherId)
        <div>
            <a href="{{ route('admin.akademik.jadwal-pelajaran') }}" class="px-4 py-2 rounded-xl border border-border text-secondary hover:bg-muted transition-colors inline-block">
                Reset
            </a>
        </div>
        @endif
    </form>
</div>

@if($selectedTeacherId)
    @php
        $jamList = ['07.00','08.00','09.00','10.00','11.00','12.00','13.00','14.00','15.00'];
        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        
        // Buat matriks kosong
        $jadwalMatrix = [];
        foreach($jamList as $jam) {
            foreach($hariList as $hari) {
                $jadwalMatrix[$jam][$hari] = null;
            }
        }
        
        // Isi matriks dari database
        foreach($schedules as $s) {
            $jamStart = \Carbon\Carbon::parse($s->jam_mulai)->format('H.i');
            // Untuk penempatan di tabel, kita cocokkan jam_mulai (mendekati)
            // Ini penyederhanaan. Idealnya cek range jam.
            $closestJam = null;
            foreach($jamList as $j) {
                if (substr($jamStart, 0, 2) == substr($j, 0, 2)) {
                    $closestJam = $j;
                    break;
                }
            }
            if ($closestJam && isset($jadwalMatrix[$closestJam][$s->hari])) {
                $jadwalMatrix[$closestJam][$s->hari] = $s;
            }
        }
    @endphp

    <div class="flex items-center gap-1 rounded-xl p-1 bg-muted w-fit mb-4">
        <button type="button" class="tab-btn active" data-tab="mingguan" onclick="showTab('mingguan', this)">Jadwal Mingguan</button>
        <button type="button" class="tab-btn" data-tab="daftar" onclick="showTab('daftar', this)">Daftar Jadwal</button>
    </div>

    <div id="content-mingguan">
        <div class="rounded-2xl border border-border p-6 bg-white shadow-sm mb-8 overflow-x-auto">
            <table class="min-w-[900px] w-full text-sm">
                <thead>
                    <tr class="bg-muted">
                        <th class="p-2 border-b border-border text-center">Jam</th>
                        @foreach($hariList as $hari)
                            <th class="p-2 border-b border-border text-center">{{ $hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($jamList as $jam)
                        <tr>
                            <td class="p-2 font-semibold text-center border-b border-border {{ $jam=='10.00' ? 'bg-warning-light text-warning-dark' : '' }}">
                                {{ $jam }}
                            </td>

                            @if($jam == '10.00')
                                @foreach($hariList as $hari)
                                    <td class="p-2 text-center bg-warning-light border-b border-border text-warning-dark font-bold">
                                        Istirahat
                                    </td>
                                @endforeach
                            @else
                                @foreach($hariList as $hari)
                                    <td class="p-2 border-b border-border relative align-top">
                                        @if(isset($jadwalMatrix[$jam][$hari]) && $jadwalMatrix[$jam][$hari])
                                            @php $sc = $jadwalMatrix[$jam][$hari]; @endphp
                                            <div class="rounded-xl bg-accent-blue/10 border border-accent-blue/20 p-2 shadow-sm relative group">
                                                <div class="font-bold text-accent-blue">{{ $sc->subject->nama }}</div>
                                                <div class="text-xs font-semibold">{{ $sc->kelas }}</div>
                                                <div class="text-xs text-secondary mt-1 flex items-center gap-1">
                                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                                    {{ \Carbon\Carbon::parse($sc->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sc->jam_selesai)->format('H:i') }}
                                                </div>
                                                
                                                <!-- Action overlay -->
                                                <div class="absolute inset-0 bg-black/5 rounded-xl opacity-0 group-hover:opacity-100 flex items-center justify-center gap-2 transition-opacity">
                                                    <button onclick='openEditModal(@json($sc))' class="w-8 h-8 rounded-full bg-white text-info flex items-center justify-center shadow hover:bg-info hover:text-white transition-colors">
                                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                                    </button>
                                                    <form action="{{ route('admin.akademik.jadwal-pelajaran.destroy', $sc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="w-8 h-8 rounded-full bg-white text-danger flex items-center justify-center shadow hover:bg-danger hover:text-white transition-colors">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <div class="h-16 border-2 border-dashed border-gray-100 rounded-xl flex items-center justify-center text-gray-300 text-xs">
                                                Kosong
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="content-daftar" class="hidden">
        <div class="rounded-2xl border border-border bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-muted text-secondary">
                        <tr>
                            <th class="p-4 font-semibold">Mata Pelajaran</th>
                            <th class="p-4 font-semibold">Kelas</th>
                            <th class="p-4 font-semibold">Hari</th>
                            <th class="p-4 font-semibold">Waktu</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($schedules as $s)
                        <tr class="hover:bg-muted/50 transition-colors">
                            <td class="p-4 font-semibold text-foreground">{{ $s->subject->nama }}</td>
                            <td class="p-4">{{ $s->kelas }}</td>
                            <td class="p-4">{{ $s->hari }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }}</td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <button onclick='openEditModal(@json($s))' class="p-2 text-info hover:bg-info-light rounded-lg transition-colors">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.akademik.jadwal-pelajaran.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-danger hover:bg-danger-light rounded-lg transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-secondary">Belum ada jadwal.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="rounded-2xl border border-border p-12 bg-white shadow-sm flex flex-col items-center justify-center text-center">
        <div class="w-16 h-16 bg-muted rounded-full flex items-center justify-center text-secondary mb-4">
            <i data-lucide="users" class="w-8 h-8"></i>
        </div>
        <h3 class="font-bold text-lg mb-1">Pilih Guru Terlebih Dahulu</h3>
        <p class="text-secondary text-sm max-w-md">
            Silakan pilih guru dari dropdown di atas untuk melihat dan mengelola jadwal mengajar mereka.
        </p>
    </div>
@endif

<!-- Modal Tambah/Edit Jadwal -->
<div id="jadwalModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4">
    <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden shadow-xl transform transition-all">
        <div class="p-6 border-b border-border flex justify-between items-center bg-muted/30">
            <h3 id="modalTitle" class="font-bold text-lg text-foreground flex items-center gap-2">
                <i data-lucide="calendar-plus" class="w-5 h-5 text-primary"></i>
                Tambah Jadwal
            </h3>
            <button type="button" onclick="closeModal()" class="text-secondary hover:text-danger transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <form id="jadwalForm" method="POST" action="{{ route('admin.akademik.jadwal-pelajaran.store') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div>
                <label class="block text-sm font-semibold mb-2">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="subject_id" id="subject_id" required class="w-full border border-border rounded-xl px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($subjects as $subject)
                        @if($subject->teacher_id == $selectedTeacherId)
                            <option value="{{ $subject->id }}">{{ $subject->nama }} ({{ $subject->kode }})</option>
                        @endif
                    @endforeach
                </select>
                <p class="text-xs text-secondary mt-1">Hanya menampilkan mapel yang diampu guru ini.</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-2">Kelas <span class="text-danger">*</span></label>
                <select name="school_class_id" id="school_class_id" required class="w-full border border-border rounded-xl px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->tingkat }} {{ $class->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-2">Hari <span class="text-danger">*</span></label>
                <select name="hari" id="hari" required class="w-full border border-border rounded-xl px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">-- Pilih Hari --</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Jam Mulai <span class="text-danger">*</span></label>
                    <input type="time" name="jam_mulai" id="jam_mulai" required class="w-full border border-border rounded-xl px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Jam Selesai <span class="text-danger">*</span></label>
                    <input type="time" name="jam_selesai" id="jam_selesai" required class="w-full border border-border rounded-xl px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2 rounded-xl text-secondary hover:bg-muted font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-5 py-2 rounded-xl font-medium transition-colors shadow-sm">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.tab-btn {
  padding: 0.6rem 1.2rem;
  border-radius: 0.75rem;
  color: #6A7686;
  font-weight: 500;
  transition: all 0.2s;
}
.tab-btn.active {
  background: white;
  color: #080C1A;
  font-weight: 600;
  border: 1px solid #E5E7EB;
  box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});

function showTab(tab, btn) {
    document.getElementById('content-mingguan').classList.add('hidden');
    document.getElementById('content-daftar').classList.add('hidden');
    document.getElementById('content-' + tab).classList.remove('hidden');
    
    document.querySelectorAll('.tab-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    if(btn) btn.classList.add('active');
}

function openAddModal() {
    document.getElementById('modalTitle').innerHTML = '<i data-lucide="calendar-plus" class="w-5 h-5 text-primary"></i> Tambah Jadwal';
    document.getElementById('jadwalForm').action = "{{ route('admin.akademik.jadwal-pelajaran.store') }}";
    document.getElementById('formMethod').value = "POST";
    
    document.getElementById('subject_id').value = "";
    document.getElementById('school_class_id').value = "";
    document.getElementById('hari').value = "";
    document.getElementById('jam_mulai').value = "";
    document.getElementById('jam_selesai').value = "";
    
    document.getElementById('jadwalModal').classList.remove('hidden');
    document.getElementById('jadwalModal').classList.add('flex');
    lucide.createIcons();
}

function openEditModal(schedule) {
    document.getElementById('modalTitle').innerHTML = '<i data-lucide="edit" class="w-5 h-5 text-info"></i> Edit Jadwal';
    document.getElementById('jadwalForm').action = `/admin/akademik/jadwal-pelajaran/${schedule.id}`;
    document.getElementById('formMethod').value = "PUT";
    
    document.getElementById('subject_id').value = schedule.subject_id;
    document.getElementById('school_class_id').value = schedule.school_class_id;
    document.getElementById('hari').value = schedule.hari;
    
    // Formatting time to HH:MM for time input
    const tStart = schedule.jam_mulai.substring(0, 5);
    const tEnd = schedule.jam_selesai.substring(0, 5);
    
    document.getElementById('jam_mulai').value = tStart;
    document.getElementById('jam_selesai').value = tEnd;
    
    document.getElementById('jadwalModal').classList.remove('hidden');
    document.getElementById('jadwalModal').classList.add('flex');
    lucide.createIcons();
}

function closeModal() {
    document.getElementById('jadwalModal').classList.add('hidden');
    document.getElementById('jadwalModal').classList.remove('flex');
}
</script>
@endsection