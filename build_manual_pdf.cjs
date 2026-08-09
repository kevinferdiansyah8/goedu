const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const OUT_DIR = path.join(__dirname, 'docs_screenshots');
const PDF_OUTPUT = path.join(__dirname, 'Manual_Book_GoEdu.pdf');

function getBase64Image(filename) {
    const filePath = path.join(OUT_DIR, filename);
    if (!fs.existsSync(filePath)) return '';
    const buffer = fs.readFileSync(filePath);
    return `data:image/png;base64,${buffer.toString('base64')}`;
}

const imgs = {
    landing: getBase64Image('01_landing_page.png'),
    ppdb_portal: getBase64Image('02_ppdb_portal.png'),
    ppdb_form: getBase64Image('03_ppdb_form.png'),
    ppdb_status: getBase64Image('03b_ppdb_status.png'),
    admin_dash: getBase64Image('04_admin_dashboard.png'),
    admin_users: getBase64Image('05_admin_users.png'),
    admin_guru: getBase64Image('05b_admin_data_guru.png'),
    admin_arsip: getBase64Image('05c_admin_arsip.png'),
    admin_mapel: getBase64Image('06_admin_mapel.png'),
    admin_kelas: getBase64Image('06b_admin_kelas.png'),
    admin_jadwal: getBase64Image('07_admin_jadwal.png'),
    admin_absensi: getBase64Image('08_admin_absensi.png'),
    admin_ppdb: getBase64Image('08b_admin_ppdb_pendaftar.png'),
    guru_dash: getBase64Image('09_guru_dashboard.png'),
    guru_elearning: getBase64Image('10_guru_elearning.png'),
    guru_kelas: getBase64Image('10b_guru_kelas_siswa.png'),
    guru_materi: getBase64Image('11_guru_materi.png'),
    guru_tugas: getBase64Image('11b_guru_tugas.png'),
    guru_absensi: getBase64Image('12_guru_absensi.png'),
    guru_absensi_pt: getBase64Image('12b_guru_absensi_pertemuan.png'),
    guru_nilai: getBase64Image('13_guru_nilai.png'),
    guru_input_nilai: getBase64Image('13b_guru_input_nilai.png'),
    siswa_dash: getBase64Image('14_siswa_dashboard.png'),
    siswa_elearning: getBase64Image('15_siswa_elearning.png'),
    siswa_materi: getBase64Image('15b_siswa_materi.png'),
    siswa_tugas: getBase64Image('15c_siswa_tugas.png'),
    siswa_nilai: getBase64Image('16_siswa_nilai.png'),
    siswa_absensi: getBase64Image('16b_siswa_absensi.png'),
    ortu_dash: getBase64Image('17_ortu_dashboard.png'),
    ortu_presensi: getBase64Image('18_ortu_presensi.png'),
    ortu_izin: getBase64Image('18b_ortu_form_izin.png'),
    ortu_nilai: getBase64Image('19_ortu_nilai.png'),
    ortu_spp: getBase64Image('19b_ortu_spp.png'),
    keuangan_dash: getBase64Image('20_keuangan_dashboard.png'),
    keuangan_tagihan: getBase64Image('21_keuangan_tagihan.png'),
    keuangan_riwayat: getBase64Image('21b_keuangan_riwayat.png'),
    keuangan_laporan: getBase64Image('21c_keuangan_laporan.png')
};

const htmlContent = `
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manual Book Lengkap GoEdu</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        
        @page {
            size: A4;
            margin: 18mm 15mm 18mm 15mm;
        }
        
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-size: 10pt;
        }

        .cover-page {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-after: always;
            padding: 50px 30px;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 80%, #4338ca 100%);
            color: #ffffff;
            border-radius: 16px;
        }

        .cover-title {
            margin-top: 80px;
        }

        .cover-title h1 {
            font-size: 36pt;
            font-weight: 800;
            letter-spacing: -1.5px;
            margin: 0 0 12px 0;
            color: #818cf8;
            text-transform: uppercase;
        }

        .cover-title h2 {
            font-size: 20pt;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 24px 0;
            line-height: 1.3;
        }

        .cover-title p {
            font-size: 11pt;
            color: #c7d2fe;
            max-width: 650px;
            line-height: 1.8;
        }

        .cover-footer {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 9.5pt;
            color: #a5b4fc;
            font-weight: 500;
        }

        .page-break {
            page-break-after: always;
        }

        h2.section-header {
            font-size: 16pt;
            font-weight: 800;
            color: #1e1b4b;
            border-bottom: 3px solid #6366f1;
            padding-bottom: 6px;
            margin-top: 25px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h3.subsection-header {
            font-size: 12.5pt;
            font-weight: 700;
            color: #334155;
            margin-top: 20px;
            margin-bottom: 10px;
            border-left: 4px solid #4f46e5;
            padding-left: 10px;
        }

        p {
            margin-bottom: 10px;
            color: #334155;
            text-align: justify;
        }

        ul, ol {
            margin-top: 4px;
            margin-bottom: 12px;
            padding-left: 20px;
        }

        li {
            margin-bottom: 4px;
            color: #334155;
        }

        .img-container {
            margin: 16px 0;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }

        .img-container img {
            width: 100%;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            border: 1px solid #cbd5e1;
        }

        .img-caption {
            font-size: 8.5pt;
            font-weight: 600;
            color: #64748b;
            margin-top: 8px;
            font-style: italic;
        }

        .toc-list {
            list-style: none;
            padding: 0;
        }

        .toc-list li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-weight: 600;
            font-size: 10pt;
        }

        .toc-list span.title {
            color: #1e1b4b;
        }

        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 10px 14px;
            border-radius: 0 8px 8px 0;
            margin: 12px 0;
            font-size: 9.5pt;
        }

        .info-box.tip {
            background: #f0fdf4;
            border-left-color: #22c55e;
        }

        .info-box.important {
            background: #fef2f2;
            border-left-color: #ef4444;
        }

        .workflow-step {
            background: #faf5ff;
            border: 1px solid #e9d5ff;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 10px;
        }
        .workflow-step strong {
            color: #7e22ce;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            margin-right: 6px;
        }
        .badge-admin { background: #fee2e2; color: #991b1b; }
        .badge-guru { background: #fef3c7; color: #92400e; }
        .badge-siswa { background: #dbeafe; color: #1e40af; }
        .badge-ortu { background: #dcfce7; color: #166534; }
        .badge-keuangan { background: #f3e8ff; color: #6b21a8; }
        .badge-ppdb { background: #e0e7ff; color: #3730a3; }
    </style>
</head>
<body>

    <!-- COVER PAGE -->
    <div class="cover-page">
        <div class="cover-title">
            <h1>GoEdu</h1>
            <h2>MANUAL BOOK OPERASIONAL SISTEM INFORMASI MANAJEMEN SEKOLAH TERPADU</h2>
            <p>Buku Panduan Penggunaan Resmi Lengkap dengan Deskripsi Prosedur, Diagram Alur Kerja, serta Tangkapan Layar (Screenshot) Antarmuka Fisik untuk Hak Akses: Super Admin, Guru, Siswa, Orang Tua/Wali, Staf Keuangan, dan Pendaftar PPDB.</p>
        </div>
        <div class="cover-footer">
            <div>GoEdu Smart Digital Campus</div>
            <div>Dokumen Resmi Panduan Operasional Sistem © 2026</div>
        </div>
    </div>

    <!-- DAFTAR ISI -->
    <h2 class="section-header">DAFTAR ISI LENGKAP</h2>
    <ul class="toc-list">
        <li><span class="title">BAB 1. PENDAHULUAN & ARSITEKTUR KONTROL PENGGUNA</span> <span>Halaman 2</span></li>
        <li><span class="title">BAB 2. MODUL PPDB (PENERIMAAN PESERTA DIDIK BARU)</span> <span>Halaman 3</span></li>
        <li><span class="title">BAB 3. MODUL SUPER ADMINISTRATOR (ADMIN SECOMA)</span> <span>Halaman 5</span></li>
        <li><span class="title">BAB 4. MODUL TENAGA PENDIDIK & WALI KELAS (GURU)</span> <span>Halaman 9</span></li>
        <li><span class="title">BAB 5. MODUL PESERTA DIDIK (SISWA)</span> <span>Halaman 13</span></li>
        <li><span class="title">BAB 6. MODUL PEMANTAUAN ORANG TUA / WALI MURID</span> <span>Halaman 16</span></li>
        <li><span class="title">BAB 7. MODUL KEUANGAN & MANAJEMEN BILLING SPP</span> <span>Halaman 18</span></li>
        <li><span class="title">BAB 8. PANDUAN PENANGANAN MASALAH (TROUBLESHOOTING)</span> <span>Halaman 20</span></li>
    </ul>

    <div class="info-box tip">
        <strong>Revisi & Pembaharuan Sistem:</strong> Panduan ini memuat seluruh fitur mutakhir aplikasi GoEdu termasuk otomatisasi presensi E-Learning, perbaikan penyaringan tingkat kelas 10, 11, 12 pada User Management, pengajuan izin digital orang tua, serta modul keuangan terintegrasi real-time.
    </div>

    <div class="page-break"></div>

    <!-- BAB 1: PENDAHULUAN -->
    <h2 class="section-header">BAB 1. Pendahuluan & Arsitektur Kontrol Pengguna</h2>
    <p>GoEdu merupakan Platform Sistem Informasi Manajemen Sekolah (SIMS) berbasis ekosistem digital terpadu yang menghubungkan seluruh pemangku kepentingan di lingkungan pendidikan secara real-time.</p>
    
    <h3 class="subsection-header">1.1 Matriks Peran & Hak Akses Pengguna</h3>
    <p>Aplikasi menggunakan proteksi <em>Role-Based Access Control (RBAC)</em> ketat untuk menjamin keamanan data dan kerahasiaan informasi per akun:</p>

    <ul>
        <li><span class="badge badge-admin">Admin</span> <strong>Super Admin:</strong> Mengelola konfigurasi utama, master data guru & siswa, jadwal KBM, mata pelajaran, serta persetujuan final seluruh aktivitas sekolah.</li>
        <li><span class="badge badge-guru">Guru</span> <strong>Tenaga Pengajar:</strong> Mengelola sesi pembelajaran E-Learning, mengunggah materi/tugas, memasukkan nilai tugas/rapor, dan mencatat presensi pertemuan.</li>
        <li><span class="badge badge-siswa">Siswa</span> <strong>Peserta Didik:</strong> Mengakses ruang kelas digital, mengerjakan tugas/kuis E-Learning, melihat jadwal harian, dan memantau prestasi nilai.</li>
        <li><span class="badge badge-ortu">Ortu</span> <strong>Orang Tua / Wali:</strong> Memantau kehadiran anak secara langsung, mengajukan izin/sakit digital, serta melihat perkembangan nilai dan status tagihan SPP.</li>
        <li><span class="badge badge-keuangan">Keuangan</span> <strong>Staf Keuangan:</strong> Menyiapkan penagihan SPP bulanan, memverifikasi bukti pembayaran transfer, serta menyusun laporan arus kas.</li>
        <li><span class="badge badge-ppdb">PPDB</span> <strong>Calon Siswa & Public:</strong> Mengisi formulir pendaftaran calon siswa baru (SD/SMP/SMA/SMK) dan mengecek status seleksi pendaftaran.</li>
    </ul>

    <div class="page-break"></div>

    <!-- BAB 2: PPDB -->
    <h2 class="section-header">BAB 2. Modul PPDB (Penerimaan Peserta Didik Baru)</h2>
    <p>Modul PPDB dirancang untuk memfasilitasi calon peserta didik baru dan wali murid dalam melakukan pendaftaran transparan dari mana saja tanpa harus datang langsung ke sekolah.</p>

    <h3 class="subsection-header">2.1 Halaman Depan & Portal Informasi PPDB</h3>
    <p>Portal PPDB memuat informasi lengkap jenjang pendidikan yang dibuka (SD, SMP, SMA, SMK), alur pendaftaran, tanggal penting, serta persyaratan dokumen pendaftaran.</p>

    <div class="img-container">
        <img src="${imgs.ppdb_portal}" alt="Portal PPDB">
        <div class="img-caption">Gambar 2.1: Halaman Landing Portal PPDB Sekolah</div>
    </div>

    <h3 class="subsection-header">2.2 Formulir Pendaftaran Online (Multi-Step Form)</h3>
    <p>Pendaftaran dilakukan melalui 3 tahapan utama:</p>
    <div class="workflow-step">
        <strong>Langkah 1:</strong> Pengisian Data Diri Calon Siswa (NISN, Nama Lengkap, Tempat Tanggal Lahir, Alamat).<br>
        <strong>Langkah 2:</strong> Pengisian Data Orang Tua/Wali (Nama Ayah/Ibu, Pekerjaan, No. WhatsApp).<br>
        <strong>Langkah 3:</strong> Pengunggahan Berkas Persyaratan (Kartu Keluarga, Ijazah/SKL, Pas Foto, Bukti Prestasi jika ada).
    </div>

    <div class="img-container">
        <img src="${imgs.ppdb_form}" alt="Formulir Pendaftaran PPDB">
        <div class="img-caption">Gambar 2.2: Formulir Pendaftaran Bertahap PPDB Jenjang SMA</div>
    </div>

    <h3 class="subsection-header">2.3 Fitur Cek Status Pendaftaran</h3>
    <p>Calon siswa dapat memeriksa status kelulusan berkas dan hasil seleksi secara mandiri dengan memasukkan nomor pendaftaran atau NISN pada halaman Cek Status.</p>

    <div class="img-container">
        <img src="${imgs.ppdb_status}" alt="Cek Status PPDB">
        <div class="img-caption">Gambar 2.3: Antarmuka Pencarian Status Kelulusan Pendaftaran PPDB</div>
    </div>

    <div class="page-break"></div>

    <!-- BAB 3: ADMIN -->
    <h2 class="section-header">BAB 3. Modul Super Administrator (Admin)</h2>
    <p>Administrator bertindak sebagai pemegang kendali utama operasional SIMS GoEdu. Modul ini menyediakan beragam pusat kendali real-time.</p>

    <h3 class="subsection-header">3.1 Dashboard Administrator Real-Time</h3>
    <p>Dashboard utama menyajikan widget statistik jumlah total siswa, guru, pendaftar PPDB, widget <em>Laporan Hari Ini</em> dengan indikator dinamis (Hadir, Menunggu, Verifikasi), serta <em>Aktivitas Sekolah</em>.</p>

    <div class="img-container">
        <img src="${imgs.admin_dash}" alt="Dashboard Admin">
        <div class="img-caption">Gambar 3.1: Dashboard Administrator Real-Time</div>
    </div>

    <h3 class="subsection-header">3.2 User Management & Penyaringan Tingkat Kelas</h3>
    <p>Pada menu User Management, Admin dapat mengelola seluruh akun pengguna. Opsi penyaringan (filter) kelas telah ditingkatkan agar Admin dapat memfilter siswa tepat berdasarkan tingkat kelas (10, 11, atau 12) tanpa tercampur format ganda.</p>

    <div class="img-container">
        <img src="${imgs.admin_users}" alt="User Management Admin">
        <div class="img-caption">Gambar 3.2: Antarmuka User Management & Filter Kelas 10, 11, 12</div>
    </div>

    <h3 class="subsection-header">3.3 Manajemen Data Kepegawaian & Arsip Dokumen Guru</h3>
    <p>Admin dapat menambah data guru baru, mengedit NUPTK, jabatan, golongan, serta memverifikasi lampiran arsip kepegawaian (SK Mengajar, Sertifikat Pendidik, Ijazah).</p>

    <div class="img-container">
        <img src="${imgs.admin_guru}" alt="Data Guru Admin">
        <div class="img-caption">Gambar 3.3: Daftar Kepegawaian & Data Guru Sekolah</div>
    </div>

    <div class="img-container">
        <img src="${imgs.admin_arsip}" alt="Arsip Kepegawaian Admin">
        <div class="img-caption">Gambar 3.4: Pengelolaan Arsip & Dokumen Kepegawaian Guru</div>
    </div>

    <h3 class="subsection-header">3.4 Pengelolaan Mata Pelajaran & Jadwal Mengajar</h3>
    <p>Admin mengatur kurikulum melalui penataan master Mata Pelajaran per tingkat/jurusan serta menyusun Jadwal Pelajaran mingguan yang terhubung langsung ke dashboard guru dan siswa.</p>

    <div class="img-container">
        <img src="${imgs.admin_mapel}" alt="Master Mapel">
        <div class="img-caption">Gambar 3.5: Master Data Mata Pelajaran Sekolah</div>
    </div>

    <div class="img-container">
        <img src="${imgs.admin_kelas}" alt="Kelas dan Wali Kelas">
        <div class="img-caption">Gambar 3.6: Pengaturan Kelas & Penunjukan Wali Kelas</div>
    </div>

    <div class="img-container">
        <img src="${imgs.admin_jadwal}" alt="Jadwal Pelajaran Admin">
        <div class="img-caption">Gambar 3.7: Penyusunan Tabel Jadwal Pelajaran Mingguan</div>
    </div>

    <h3 class="subsection-header">3.5 Rekapitulasi Presensi & Pengelolaan PPDB Admin</h3>
    <p>Admin memantau presensi seluruh siswa & guru serta mengesahkan pendaftar PPDB yang lulus verifikasi berkas.</p>

    <div class="img-container">
        <img src="${imgs.admin_absensi}" alt="Absensi Siswa Admin">
        <div class="img-caption">Gambar 3.8: Pemantauan Absensi Siswa Seluruh Sekolah</div>
    </div>

    <div class="img-container">
        <img src="${imgs.admin_ppdb}" alt="Data Pendaftar PPDB Admin">
        <div class="img-caption">Gambar 3.9: Manajemen & Verifikasi Data Pendaftar PPDB</div>
    </div>

    <div class="page-break"></div>

    <!-- BAB 4: GURU -->
    <h2 class="section-header">BAB 4. Modul Tenaga Pendidik & Wali Kelas (Guru)</h2>
    <p>Modul Guru memfasilitasi kelancaran Proses Belajar Mengajar (PBM) baik secara luring di kelas maupun digital melalui E-Learning.</p>

    <h3 class="subsection-header">4.1 Dashboard Guru & Jadwal Mengajar Hari Ini</h3>
    <p>Guru mendapatkan informasi langsung mengenai jadwal mengajar pada hari berjalan, jumlah kelas yang diampu, dan notifikasi pengumpulan tugas siswa.</p>

    <div class="img-container">
        <img src="${imgs.guru_dash}" alt="Dashboard Guru">
        <div class="img-caption">Gambar 4.1: Dashboard Guru & Informasi KBM Hari Ini</div>
    </div>

    <h3 class="subsection-header">4.2 Manajemen E-Learning & Kuis Evaluasi</h3>
    <p>Guru membuat sesi E-Learning per bab/pertemuan, menyusun soal pretest/posttest multi-pilihan, membagikan link video/materi, dan memantau kehadiran siswa secara otomatis.</p>

    <div class="img-container">
        <img src="${imgs.guru_elearning}" alt="E-Learning Guru">
        <div class="img-caption">Gambar 4.2: Daftar Sesi E-Learning & Kelas Online Guru</div>
    </div>

    <div class="img-container">
        <img src="${imgs.guru_kelas}" alt="Daftar Kelas Siswa Guru">
        <div class="img-caption">Gambar 4.3: Halaman Manajemen Siswa per Kelas Ampuhan</div>
    </div>

    <h3 class="subsection-header">4.3 Pembagian Materi & Penugasan Terstruktur</h3>
    <p>Fasilitas untuk mengunggah bahan ajar berbentuk dokumen PDF/PPT, membuat tugas mandiri/kelompok lengkap dengan batas waktu pengumpulan (*deadline*).</p>

    <div class="img-container">
        <img src="${imgs.guru_materi}" alt="Pengelolaan Materi Guru">
        <div class="img-caption">Gambar 4.4: Pengelolaan Materi Pembelajaran Digital</div>
    </div>

    <div class="img-container">
        <img src="${imgs.guru_tugas}" alt="Pengelolaan Tugas Guru">
        <div class="img-caption">Gambar 4.5: Penugasan Siswa & Pengaturan Deadline</div>
    </div>

    <h3 class="subsection-header">4.4 Absensi Pertemuan & Rekap Kehadiran</h3>
    <p>Guru mencatat status kehadiran siswa per jam tatap muka (Hadir, Izin, Sakit, Alpha) dan mengecek statistik rekapitulasi presensi bulanan.</p>

    <div class="img-container">
        <img src="${imgs.guru_absensi}" alt="Absensi Kelas Guru">
        <div class="img-caption">Gambar 4.6: Halaman Rekapitulasi Absensi Mata Pelajaran</div>
    </div>

    <div class="img-container">
        <img src="${imgs.guru_absensi_pt}" alt="Absensi Pertemuan Guru">
        <div class="img-caption">Gambar 4.7: Pencatatan Presensi Pertemuan Tatap Muka</div>
    </div>

    <h3 class="subsection-header">4.5 Input Nilai Tugas & Rapor Akademik</h3>
    <p>Pendidik menginput nilai hasil koreksi tugas dan nilai akhir semester untuk penulisan buku Rapor siswa.</p>

    <div class="img-container">
        <img src="${imgs.guru_nilai}" alt="Rekap Nilai Guru">
        <div class="img-caption">Gambar 4.8: Rekapitulasi Nilai Akademik Siswa per Kelas</div>
    </div>

    <div class="img-container">
        <img src="${imgs.guru_input_nilai}" alt="Input Nilai Tugas Guru">
        <div class="img-caption">Gambar 4.9: Form Penginputan Nilai Tugas & Rapor Siswa</div>
    </div>

    <div class="page-break"></div>

    <!-- BAB 5: SISWA -->
    <h2 class="section-header">BAB 5. Modul Peserta Didik (Siswa)</h2>
    <p>Modul Siswa didesain modern dan intuitif agar siswa dapat fokus pada aktivitas pembelajaran mandiri dan pemantauan prestasi secara pribadi.</p>

    <h3 class="subsection-header">5.1 Dashboard Siswa</h3>
    <p>Halaman utama siswa menampilkan persentase kehadiran harian, jumlah tugas aktif yang belum dikumpulkan, jadwal kelas hari ini, dan pengumuman sekolah.</p>

    <div class="img-container">
        <img src="${imgs.siswa_dash}" alt="Dashboard Siswa">
        <div class="img-caption">Gambar 5.1: Dashboard Akses Siswa</div>
    </div>

    <h3 class="subsection-header">5.2 Ruang Pembelajaran Digital & E-Learning Siswa</h3>
    <p>Siswa memasuki sesi E-Learning, menyimak materi guru, mengerjakan soal pretest & posttest, serta berdiskusi aktif di kolom komentar.</p>

    <div class="img-container">
        <img src="${imgs.siswa_elearning}" alt="E-Learning Siswa">
        <div class="img-caption">Gambar 5.2: Daftar Sesi E-Learning yang Harus Diikuti Siswa</div>
    </div>

    <div class="img-container">
        <img src="${imgs.siswa_materi}" alt="Modul Materi Siswa">
        <div class="img-caption">Gambar 5.3: Halaman Pengunduhan Materi Pembelajaran</div>
    </div>

    <h3 class="subsection-header">5.3 Pengumpulan Tugas Online & Transkrip Nilai</h3>
    <p>Siswa mengunggah file tugas sekolah (PDF/ZIP/Gambar), melihat catatan feedback guru, dan memantau rekapitulasi nilai akhir mata pelajaran.</p>

    <div class="img-container">
        <img src="${imgs.siswa_tugas}" alt="Modul Tugas Siswa">
        <div class="img-caption">Gambar 5.4: Pengumpulan Tugas Online & Batas Waktu</div>
    </div>

    <div class="img-container">
        <img src="${imgs.siswa_nilai}" alt="Transkrip Nilai Siswa">
        <div class="img-caption">Gambar 5.5: Halaman Transkrip & Grafik Perkembangan Nilai Akademik</div>
    </div>

    <div class="img-container">
        <img src="${imgs.siswa_absensi}" alt="Riwayat Absensi Siswa">
        <div class="img-caption">Gambar 5.6: Riwayat Presensi Kehadiran Siswa di Sekolah</div>
    </div>

    <div class="page-break"></div>

    <!-- BAB 6: ORANG TUA -->
    <h2 class="section-header">BAB 6. Modul Pemantauan Orang Tua / Wali Murid</h2>
    <p>Modul Orang Tua diciptakan guna memberikan keterbukaan informasi bagi wali murid terhadap kedisiplinan dan perkembangan akademik putra-putrinya.</p>

    <h3 class="subsection-header">6.1 Dashboard Pemantauan Orang Tua</h3>
    <p>Menampilkan secara langsung status kehadiran anak hari ini di sekolah (Hadir, Izin, Sakit, atau Alpha), serta pengumuman penting sekolah.</p>

    <div class="img-container">
        <img src="${imgs.ortu_dash}" alt="Dashboard Orang Tua">
        <div class="img-caption">Gambar 6.1: Dashboard Monitoring Orang Tua / Wali Siswa</div>
    </div>

    <h3 class="subsection-header">6.2 Pemantauan Presensi Real-Time & Pengajuan Izin Digital</h3>
    <p>Orang tua dapat memantau riwayat kedisiplinan anak dan mengirimkan Surat Izin/Sakit digital lengkap dengan foto surat dokter dari aplikasi tanpa harus bersurat fisik.</p>

    <div class="img-container">
        <img src="${imgs.ortu_presensi}" alt="Presensi Anak Ortu">
        <div class="img-caption">Gambar 6.2: Halaman Pemantauan Kehadiran Anak</div>
    </div>

    <div class="img-container">
        <img src="${imgs.ortu_izin}" alt="Form Izin Digital Ortu">
        <div class="img-caption">Gambar 6.3: Formulir Pengajuan Surat Izin / Sakit Anak Online</div>
    </div>

    <h3 class="subsection-header">6.3 Pemantauan Nilai & Tagihan SPP Anak</h3>
    <p>Orang tua dapat melihat rekap Rapor berkala anak serta mengecek rincian tagihan bulanan SPP yang perlu diselesaikan.</p>

    <div class="img-container">
        <img src="${imgs.ortu_nilai}" alt="Monitoring Nilai Ortu">
        <div class="img-caption">Gambar 6.4: Halaman Evaluasi Nilai Rapor & Hasil Belajar Anak</div>
    </div>

    <div class="img-container">
        <img src="${imgs.ortu_spp}" alt="Monitoring SPP Ortu">
        <div class="img-caption">Gambar 6.5: Pemantauan Tagihan SPP & Upload Bukti Bayar</div>
    </div>

    <div class="page-break"></div>

    <!-- BAB 7: KEUANGAN -->
    <h2 class="section-header">BAB 7. Modul Keuangan & Manajemen Billing SPP</h2>
    <p>Staf Keuangan mengelola seluruh aspek administrasi penerimaan dana SPP, uang gedung, dan verifikasi transfer dari wali murid.</p>

    <h3 class="subsection-header">7.1 Dashboard Keuangan Sekolah</h3>
    <p>Pusat statistik arus kas yang menampilkan total penerimaan bulanan, persentase tunggakan siswa, serta grafik riwayat pembayaran.</p>

    <div class="img-container">
        <img src="${imgs.keuangan_dash}" alt="Dashboard Keuangan">
        <div class="img-caption">Gambar 7.1: Dashboard Pengawasan Keuangan & Penerimaan Kas</div>
    </div>

    <h3 class="subsection-header">7.2 Manajemen Tagihan SPP & Verifikasi Transfer</h3>
    <p>Staf Keuangan menerbitkan lembar tagihan bulanan per kelas dan mengonfirmasi bukti transfer pembayaran yang diunggah oleh siswa/orang tua.</p>

    <div class="img-container">
        <img src="${imgs.keuangan_tagihan}" alt="Daftar Tagihan Keuangan">
        <div class="img-caption">Gambar 7.2: Manajemen Tagihan Pembayaran SPP Siswa</div>
    </div>

    <div class="img-container">
        <img src="${imgs.keuangan_riwayat}" alt="Riwayat Pembayaran Keuangan">
        <div class="img-caption">Gambar 7.3: Halaman Rekapitulasi Riwayat Pembayaran SPP Siswa</div>
    </div>

    <h3 class="subsection-header">7.3 Penyusunan Laporan Pemasukan Sekolah</h3>
    <p>Modul laporan transaksi keuangan memudahkan pengunduhan rekapitulasi kas masuk untuk keperluan audit rutin sekolah.</p>

    <div class="img-container">
        <img src="${imgs.keuangan_laporan}" alt="Laporan Keuangan">
        <div class="img-caption">Gambar 7.4: Modul Laporan Pemasukan & Keuangan Sekolah</div>
    </div>

    <div class="page-break"></div>

    <!-- BAB 8: TROUBLESHOOTING -->
    <h2 class="section-header">BAB 8. Panduan Penanganan Masalah (Troubleshooting)</h2>
    <p>Berikut adalah solusi cepat untuk beberapa kendala operasional yang mungkin ditemui pengguna saat mengoperasikan aplikasi GoEdu:</p>

    <div class="workflow-step">
        <strong>1. Lupa Password Akun Login:</strong><br>
        Klik tautan <em>"Lupa Password?"</em> pada halaman login, masukkan email terdaftar, atau hubungi Super Admin sekolah untuk melakukan reset kata sandi dari menu User Management.
    </div>

    <div class="workflow-step">
        <strong>2. Hasil Filter Kelas Tidak Ditemukan:</strong><br>
        Pastikan Anda memilih opsi filter kelas tingkat (Kelas 10, Kelas 11, atau Kelas 12) yang sesuai. Data kelas di SIMS GoEdu telah disinkronkan sehingga pencarian tingkat kelas berjalan presisi.
    </div>

    <div class="workflow-step">
        <strong>3. Presensi E-Learning Tidak Otomatis Terdeteksi:</strong><br>
        Pastikan siswa telah menyelesaikan seluruh tahapan modul E-Learning (Pretest, menyimak materi, dan menjawab Posttest) hingga selesai.
    </div>

    <div class="workflow-step">
        <strong>4. Bukti Transfer Pembayaran SPP Belum Terverifikasi:</strong><br>
        Pastikan file resi pembayaran dalam format gambar/PDF jelas dan terbaca. Verifikasi akan diproses oleh Staf Keuangan dalam 1x24 jam kerja.
    </div>

    <div style="margin-top: 40px; text-align: center; font-size: 9pt; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 16px;">
        <p><strong>Panduan Penggunaan Resmi SIMS GoEdu Digital Ecosystem</strong></p>
        <p>Hak Cipta Dilindungi Undang-Undang © 2026. Apabila membutuhkan bantuan lebih lanjut, silakan hubungi tim IT Helpdesk Sekolah.</p>
    </div>

</body>
</html>
`;

async function buildPdf() {
    console.log('Generating comprehensive PDF manual book with all 29 screenshots...');
    const browser = await puppeteer.launch({
        executablePath: CHROME_PATH,
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const page = await browser.newPage();
    await page.setContent(htmlContent, { waitUntil: 'domcontentloaded', timeout: 120000 });
    await new Promise(r => setTimeout(r, 2000)); // allow images to render

    await page.pdf({
        path: PDF_OUTPUT,
        format: 'A4',
        printBackground: true,
        margin: {
            top: '12mm',
            bottom: '12mm',
            left: '12mm',
            right: '12mm'
        }
    });

    await browser.close();
    console.log(`PDF successfully generated at: ${PDF_OUTPUT}`);
}

buildPdf();
