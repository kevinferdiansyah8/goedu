@extends('layouts.admin')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="min-h-screen bg-gray-50/50 pb-10" x-data="jadwalPage()">
    
    @if(request('subject_id'))
        <x-academic-flow-nav :active-step="2" :subject-id="request('subject_id')" />
    @endif

    {{-- HEADER SECTION --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Jadwal Mengajar</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola hari, jam, dan kelas kegiatan belajar mengajar Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="openModal()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4 text-white"></i> Tambah Jadwal
            </button>
            <div class="text-right hidden xl:block border-l border-gray-200 pl-4 ml-2">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Hari Ini</div>
                <div class="text-lg font-bold text-indigo-600 leading-none">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
            </div>
        </div>
    </div>

    {{-- ANALYTICS SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i data-lucide="clock" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Sesi Hari Ini</div>
                <div class="text-2xl font-bold text-gray-900" x-text="schedules.filter(s => s.hari === currentDay).length"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center"><i data-lucide="book-open" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Total Mapel</div>
                <div class="text-2xl font-bold text-gray-900" x-text="[...new Set(schedules.map(s => s.subject))].length"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i data-lucide="users" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Total Kelas</div>
                <div class="text-2xl font-bold text-gray-900" x-text="[...new Set(schedules.map(s => s.class))].length"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center"><i data-lucide="calendar" class="w-6 h-6"></i></div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Sesi Mingguan</div>
                <div class="text-2xl font-bold text-gray-900" x-text="schedules.length"></div>
            </div>
        </div>
    </div>

    {{-- CONTROLS --}}
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4 mb-6 bg-white p-2 rounded-2xl shadow-sm border border-gray-200">
        <div class="flex bg-gray-100 p-1 rounded-xl w-full lg:w-auto">
            <button @click="viewMode = 'card'" :class="viewMode === 'card' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500'" class="flex-1 lg:flex-none px-6 py-2 text-sm font-bold rounded-lg transition-all flex items-center gap-2 justify-center">
                <i data-lucide="layout-grid" class="w-4 h-4"></i> Cards
            </button>
            <button @click="viewMode = 'timeline'" :class="viewMode === 'timeline' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500'" class="flex-1 lg:flex-none px-6 py-2 text-sm font-bold rounded-lg transition-all flex items-center gap-2 justify-center">
                <i data-lucide="list" class="w-4 h-4"></i> Timeline
            </button>
        </div>

        <div class="flex flex-wrap gap-2 items-center w-full lg:w-auto">
            <select x-model="selectedDay" class="text-sm border-gray-100 bg-gray-50 rounded-xl px-4 py-2.5 font-bold text-gray-600 focus:ring-2 focus:ring-indigo-100 transition-all outline-none">
                <option value="all">Semua Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
            </select>
            <div class="relative flex-grow lg:flex-grow-0 ml-2">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
                <input type="text" x-model="search" placeholder="Cari Mapel/Kelas..." class="w-full lg:w-48 text-sm border-gray-100 bg-gray-50 rounded-xl pl-10 pr-4 py-2.5 font-medium outline-none focus:ring-2 focus:ring-indigo-100 transition-all">
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div x-show="viewMode === 'card'" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" x-cloak>
        <template x-for="s in filteredSchedules" :key="s.id">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full" :class="s.hari === currentDay ? 'bg-indigo-600' : 'bg-gray-100'"></div>
                
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-gray-50 text-gray-900 font-bold px-3 py-1.5 rounded-lg text-xs border border-gray-200">
                           <span x-text="s.timeStart"></span> - <span x-text="s.timeEnd"></span>
                        </div>
                        <span x-show="s.hari === currentDay" class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg uppercase tracking-widest" :class="s.hari === currentDay ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500'" x-text="s.hari"></span>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-1" x-text="s.subject"></h3>
                <div class="flex items-center text-xs text-gray-400 font-medium mb-6 gap-4">
                    <div class="flex items-center gap-1"><i data-lucide="users" class="w-3.5 h-3.5"></i> <span x-text="s.kelas"></span></div>
                    <div class="flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> <span x-text="s.room"></span></div>
                </div>

                <div class="flex justify-between items-center mt-auto">
                    <div class="flex gap-2">
                        <button @click="openModal(s)" class="p-2 bg-gray-50 text-gray-500 rounded-lg hover:bg-gray-100 transition-colors" title="Edit Jadwal">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        </button>
                        <form :action="'{{ route('guru.akademik.jadwal-mengajar.destroy', ['id' => 'ID_PLACEHOLDER']) }}'.replace('ID_PLACEHOLDER', s.id)" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-100 transition-colors" title="Hapus Jadwal">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                    <a :href="'{{ route('guru.absensi.pertemuan') }}?subject_id=' + s.subject_id + '&class_id=' + s.class_id" class="px-3 py-2 bg-indigo-100 text-indigo-700 text-[10px] font-bold rounded-lg text-center hover:bg-indigo-600 hover:text-white transition-colors">ABSENSI</a>
                    <a :href="'{{ route('guru.akademik.kelas') }}?subject_id=' + s.subject_id + '&class_id=' + s.class_id" class="px-3 py-2 bg-gray-900 text-white text-[10px] font-bold rounded-lg text-center hover:bg-black transition-colors">LANJUT</a>
                </div>
            </div>
        </template>
        
        <div x-show="filteredSchedules.length === 0" class="col-span-full py-20 text-center text-gray-400 bg-white rounded-3xl border border-dashed border-gray-200">
            <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-3 opacity-20"></i>
            <p class="font-bold">Tidak ada jadwal ditemukan.</p>
        </div>
    </div>

    <div x-show="viewMode === 'timeline'" class="max-w-2xl mx-auto space-y-4" x-cloak>
        <template x-for="s in filteredSchedules" :key="s.id">
            <div class="flex gap-4 group">
                <div class="flex flex-col items-center">
                    <div class="w-3 h-3 rounded-full border-2 border-indigo-600 group-hover:scale-125 transition-transform" :class="s.hari === currentDay ? 'bg-indigo-600' : 'bg-white'"></div>
                    <div class="w-0.5 h-full bg-gray-100 group-last:hidden"></div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex-1 mb-4 group-hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" x-text="s.hari + ', ' + s.timeStart + ' - ' + s.timeEnd"></span>
                        <span x-show="s.hari === currentDay" class="text-[8px] font-black bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded uppercase">Now</span>
                    </div>
                    <h4 class="font-bold text-gray-900" x-text="s.subject"></h4>
                    <p class="text-xs text-gray-500" x-text="s.class + ' • ' + s.room"></p>
                </div>
            </div>
        </template>
    </div>

    {{-- MODAL FORM --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-cloak x-transition>
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden" @click.away="closeModal()">
            <div class="bg-indigo-600 p-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold" x-text="isEdit ? 'Ubah Jadwal' : 'Tambah Jadwal Baru'"></h3>
                    <p class="text-xs opacity-70 mt-1">Lengkapi data jadwal mengajar Anda di bawah ini.</p>
                </div>
                <button @click="closeModal()" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            
            <form :action="isEdit ? '{{ route('guru.akademik.jadwal-mengajar.update', ['id' => 'ID_PLACEHOLDER']) }}'.replace('ID_PLACEHOLDER', formData.id) : '{{ route('guru.akademik.jadwal-mengajar.store') }}'" method="POST" class="p-8 space-y-6">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Mata Pelajaran</label>
                        <select name="subject_id" x-model="formData.subject_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 appearance-none">
                            <option value="">Pilih Mata Pelajaran...</option>
                            @foreach($subjects as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pilih Kelas</label>
                        <select name="kelas" x-model="formData.kelas" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 appearance-none">
                            <option value="">Pilih Kelas...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->tingkat }}-{{ $c->nama_kelas }}">{{ $c->tingkat }} - {{ $c->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pilih Hari</label>
                        <select name="hari" x-model="formData.hari" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 appearance-none">
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" x-model="formData.jam_mulai" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" x-model="formData.jam_selesai" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400">
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="closeModal()" class="flex-1 px-6 py-3.5 bg-gray-50 text-gray-500 font-bold rounded-2xl hover:bg-gray-100 transition-all text-sm">Batal</button>
                    <button type="submit" class="flex-2 px-6 py-3.5 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all text-sm">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('jadwalPage', () => ({
        viewMode: 'card',
        selectedDay: 'all',
        search: '',
        currentDay: '{{ \Carbon\Carbon::now()->translatedFormat('l') }}',
        showModal: false,
        isEdit: false,
        formData: { id: '', subject_id: '{{ request('subject_id') }}', kelas: '', hari: 'Senin', jam_mulai: '', jam_selesai: '' },
        
        schedules: @json($schedules),

        openModal(schedule = null) {
            if (schedule) {
                this.isEdit = true;
                this.formData = { ...schedule };
            } else {
                this.isEdit = false;
                this.formData = { id: '', subject_id: '{{ request('subject_id') }}', kelas: '', hari: 'Senin', jam_mulai: '', jam_selesai: '' };
            }
            this.showModal = true;
            setTimeout(() => { if (window.lucide) lucide.createIcons(); }, 100);
        },

        closeModal() {
            this.showModal = false;
        },

        get filteredSchedules() {
            return this.schedules.filter(s => {
                const dayMatch = this.selectedDay === 'all' || s.hari === this.selectedDay;
                const searchMatch = s.subject.toLowerCase().includes(this.search.toLowerCase()) || 
                                   s.class.toLowerCase().includes(this.search.toLowerCase());
                return dayMatch && searchMatch;
            });
        }
    }));

    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
