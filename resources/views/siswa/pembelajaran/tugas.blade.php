@extends('layouts.admin')

@section('title', 'Upload Tugas')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Upload Tugas</h1>
        <p class="text-gray-600">Kirim tugas yang diberikan oleh guru.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- List Tugas -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($tugas_pending as $tugas)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                <div>
                     <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600 mb-2">{{ $tugas['mapel'] }}</span>
                    <h3 class="text-lg font-bold text-gray-800 max-w-md">{{ $tugas['judul'] }}</h3>
                    <p class="text-gray-500 text-sm mt-1">{{ $tugas['deskripsi'] }}</p>
                    <div class="flex items-center gap-2 mt-3 text-sm text-gray-500">
                        <i data-lucide="calendar-clock" class="w-4 h-4 text-red-500"></i>
                        <span>Deadline: <span class="font-semibold text-red-500">{{ \Carbon\Carbon::parse($tugas['deadline'])->format('d M Y') }}</span></span>
                    </div>
                </div>
                <button onclick="selectTugas('{{ $tugas['judul'] }}', '{{ $tugas['mapel'] }}')" class="w-full md:w-auto px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all shadow-md shadow-blue-200">
                    Upload
                </button>
            </div>
            @endforeach
        </div>

        <!-- Form Upload -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 sticky top-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4 pb-2 border-b">Form Pengumpulan</h3>
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
                            <input type="text" id="selectedTugas" class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed px-3 py-2 text-sm" placeholder="Pilih tugas di samping..." readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Tugas</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer relative">
                                <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                <p class="text-sm text-gray-500">Klik atau drag file ke sini</p>
                                <p class="text-xs text-gray-400 mt-1">PDF, DOCX, JPG (Max 5MB)</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                            <textarea rows="3" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan catatan untuk guru..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition-colors shadow-md shadow-green-200 flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i> Kirim Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function selectTugas(judul, mapel) {
        document.getElementById('selectedTugas').value = judul + ' - ' + mapel;
    }
</script>
@endsection
