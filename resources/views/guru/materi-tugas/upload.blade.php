@extends('layouts.admin')

@section('title', 'Daftar Kelas & Siswa')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Upload Materi</h1>
    <p class="text-gray-600">Unggah materi pembelajaran untuk siswa Anda</p>
</div>

@if(session('success'))
<div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-4 rounded-xl mb-6 shadow-lg flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="max-w-2xl">
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-8 shadow-xl border border-gray-100">
        <div class="flex items-center mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Form Upload Materi</h2>
                <p class="text-gray-600">Lengkapi formulir di bawah ini</p>
            </div>
        </div>

        <form 
            action="{{ route('guru.materi.upload.store') }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="space-y-7">
            
            @csrf

            <!-- Kelas Input -->
            <div class="group">
                <div class="flex items-center mb-3">
                    <div class="w-2 h-5 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full mr-3"></div>
                    <label class="text-sm font-semibold text-gray-800">Kelas</label>
                </div>
                <div class="relative">
                    <select name="kelas" class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-300 appearance-none outline-none hover:border-gray-300">
                        <option value="" class="text-gray-400">-- Pilih Kelas --</option>
                        <option value="X IPA 1" class="py-2">X IPA 1</option>
                        <option value="X IPA 2" class="py-2">X IPA 2</option>
                        <option value="X IPA 3" class="py-2">X IPA 3</option>
                        <option value="XI IPA 1" class="py-2">XI IPA 1</option>
                        <option value="XI IPA 2" class="py-2">XI IPA 2</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Judul Materi Input -->
            <div class="group">
                <div class="flex items-center mb-3">
                    <div class="w-2 h-5 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full mr-3"></div>
                    <label class="text-sm font-semibold text-gray-800">Judul Materi</label>
                </div>
                <div class="relative">
                    <input name="judul" type="text" class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-300 placeholder-gray-400" placeholder="Masukkan judul materi">
                    <div class="absolute left-5 inset-y-0 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- File Upload -->
            <div class="group">
                <div class="flex items-center mb-3">
                    <div class="w-2 h-5 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full mr-3"></div>
                    <label class="text-sm font-semibold text-gray-800">File Materi</label>
                </div>
                
                <!-- Upload Area -->
                <div class="mt-2">
                    <div id="upload-area" class="border-3 border-dashed border-gray-300 rounded-2xl p-8 text-center transition-all duration-300 hover:border-blue-400 hover:bg-blue-50 bg-gray-50">
                        <div class="max-w-xs mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-gray-700 font-medium mb-2">Drop file di sini atau klik untuk upload</p>
                            <p class="text-sm text-gray-500 mb-4">PDF, DOC, PPT (Maks. 10MB)</p>
                            <input id="file-input" name="file" type="file" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            <button type="button" id="browse-button" class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg">
                                Pilih File
                            </button>
                        </div>
                    </div>
                    
                    <!-- File Preview -->
                    <div id="file-preview" class="mt-4 hidden">
                        <div class="flex items-center justify-between bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-200 shadow-sm">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p id="file-name" class="font-medium text-gray-900"></p>
                                    <p id="file-size" class="text-sm text-gray-500"></p>
                                </div>
                            </div>
                            <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Upload Materi
                </button>
                <p class="text-center text-gray-500 text-sm mt-4">
                    Pastikan semua data sudah benar sebelum mengunggah
                </p>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-5 rounded-xl border border-blue-100">
            <div class="flex items-center">
                <div class="bg-blue-100 p-2.5 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Format File</p>
                    <p class="text-sm text-gray-600">PDF, DOC, PPT</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-xl border border-green-100">
            <div class="flex items-center">
                <div class="bg-green-100 p-2.5 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Ukuran Maksimal</p>
                    <p class="text-sm text-gray-600">10 MB per file</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-violet-50 p-5 rounded-xl border border-purple-100">
            <div class="flex items-center">
                <div class="bg-purple-100 p-2.5 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Akses Aman</p>
                    <p class="text-sm text-gray-600">Hanya untuk siswa kelas</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk file upload -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('file-input');
    const browseButton = document.getElementById('browse-button');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFile = document.getElementById('remove-file');
    
    // Klik pada area upload atau tombol browse
    uploadArea.addEventListener('click', () => fileInput.click());
    browseButton.addEventListener('click', () => fileInput.click());
    
    // Drag & drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadArea.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    function unhighlight() {
        uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        handleFiles(files);
    }
    
    // Handle file input change
    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            handleFiles(this.files);
        }
    });
    
    // Handle files
    function handleFiles(files) {
        const file = files[0];
        
        // Validasi ukuran file (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran file maksimal 10MB');
            return;
        }
        
        // Validasi tipe file
        const validTypes = ['application/pdf', 
                           'application/msword', 
                           'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                           'application/vnd.ms-powerpoint',
                           'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
        
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan PDF, DOC, atau PPT');
            return;
        }
        
        // Tampilkan preview
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        filePreview.classList.remove('hidden');
        uploadArea.classList.add('hidden');
    }
    
    // Format ukuran file
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Hapus file
    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
        uploadArea.classList.remove('hidden');
    });
});
</script>

<style>
    /* Custom scrollbar untuk select */
    select::-webkit-scrollbar {
        width: 8px;
    }
    
    select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    select::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    select::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    /* Animasi halus */
    .group:hover .w-2 {
        transform: scaleY(1.2);
        transition: transform 0.3s ease;
    }
    
    /* Efek glow pada focus */
    input:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

@endsection