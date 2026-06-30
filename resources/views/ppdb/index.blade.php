<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal PPDB 2026 - GOEDU</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-gray-800 min-h-screen flex flex-col relative overflow-hidden">
    
    {{-- Background Ornaments --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>

    {{-- Navbar --}}
    <nav class="w-full py-6 px-6 relative z-10">
        <div class="max-w-6xl mx-auto flex justify-between items-center bg-white/70 backdrop-blur-md rounded-3xl px-6 py-4 shadow-sm border border-white">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/goedu_logo.png') }}" alt="GoEdu Logo" class="h-10 w-auto object-contain">
            </div>
            <div>
                <a href="{{ url('/') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition-colors">Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow flex items-center justify-center p-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-full font-bold text-sm mb-6 border border-blue-100">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span> Pendaftaran Gelombang 1 Dibuka
            </div>

            <h1 class="text-5xl md:text-7xl font-black text-gray-900 tracking-tight leading-tight mb-6">
                Penerimaan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Peserta Didik Baru</span> 2026
            </h1>
            
            <p class="text-lg text-gray-500 font-medium max-w-2xl mx-auto mb-12">
                Bergabunglah bersama kami di GOEDU. Dapatkan pendidikan terbaik dengan fasilitas modern dan kurikulum terpadu untuk masa depan yang gemilang.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('ppdb.daftar') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 group">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    Mendaftar Sebagai Siswa Baru
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="{{ route('ppdb.login') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-indigo-600 font-bold rounded-2xl shadow-lg shadow-gray-100 border border-indigo-100 hover:bg-indigo-50 hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                    <i data-lucide="search" class="w-5 h-5"></i>
                    Cek Status Pendaftaran
                </a>
            </div>

            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 text-center border-t border-gray-200/60 pt-10">
                <div>
                    <h3 class="text-3xl font-black text-gray-900 mb-1">4</h3>
                    <p class="text-sm font-semibold text-gray-500">Pilihan Jenjang</p>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-gray-900 mb-1">8</h3>
                    <p class="text-sm font-semibold text-gray-500">Program Keahlian</p>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-gray-900 mb-1">100%</h3>
                    <p class="text-sm font-semibold text-gray-500">Pendaftaran Online</p>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-gray-900 mb-1">24/7</h3>
                    <p class="text-sm font-semibold text-gray-500">Dukungan Helpdesk</p>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-8 text-center relative z-10">
        <p class="text-sm font-medium text-gray-400">&copy; 2026 GOEDU Ecosystem. Hak cipta dilindungi.</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
