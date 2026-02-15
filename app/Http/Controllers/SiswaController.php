<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        // Data Dummy untuk Dashboard Siswa

        // 1. Ringkasan Aktivitas
        // Jadwal Hari Ini
        $jadwal_hari_ini = [
            ['jam' => '07:00 - 08:30', 'mapel' => 'Matematika', 'guru' => 'Budi Santoso'],
            ['jam' => '08:30 - 10:00', 'mapel' => 'Bahasa Indonesia', 'guru' => 'Siti Aminah'],
            ['jam' => '10:15 - 11:45', 'mapel' => 'Fisika', 'guru' => 'Agus Dermawan'],
        ];

        // Kehadiran (Semester Ini)
        $kehadiran = [
            'hadir' => 95, // Persentase
            'sakit' => 2,  // Jumlah hari
            'izin'  => 1,  // Jumlah hari
            'alpha' => 0,  // Jumlah hari
        ];

        // Tugas Aktif (Belum dikerjakan / Deadline dekat)
        $tugas_aktif = [
            ['mapel' => 'Matematika', 'judul' => 'Latihan Soal Aljabar', 'deadline' => '2023-10-25', 'status' => 'Belum'],
            ['mapel' => 'Fisika', 'judul' => 'Laporan Praktikum', 'deadline' => '2023-10-27', 'status' => 'Proses'],
            ['mapel' => 'Bahasa Inggris', 'judul' => 'Essay Writing', 'deadline' => '2023-10-28', 'status' => 'Belum'],
        ];

        // Pengumuman Terbaru
        $pengumuman = [
            ['judul' => 'Libur Nasional Hari Pahlawan', 'tanggal' => '2023-10-20', 'isi' => 'Sekolah diliburkan pada tanggal 10 November unt...'],
            ['judul' => 'Jadwal Ujian Tengah Semester', 'tanggal' => '2023-10-15', 'isi' => 'Ujian Tengah Semester akan dilaksanakan mulai...'],
        ];

        return view('siswa.dashboard.index', compact('jadwal_hari_ini', 'kehadiran', 'tugas_aktif', 'pengumuman'));
    }
    public function akademikJadwal()
    {
        $jadwal = [
            'Senin' => [
                ['jam' => '07:00 - 08:30', 'mapel' => 'Matematika', 'guru' => 'Budi Santoso'],
                ['jam' => '08:30 - 10:00', 'mapel' => 'Bahasa Indonesia', 'guru' => 'Siti Aminah'],
            ],
            'Selasa' => [
                ['jam' => '07:00 - 08:30', 'mapel' => 'Fisika', 'guru' => 'Agus Dermawan'],
                ['jam' => '08:30 - 10:00', 'mapel' => 'Kimia', 'guru' => 'Ratna Sari'],
            ],
            'Rabu' => [
                ['jam' => '07:00 - 08:30', 'mapel' => 'Biologi', 'guru' => 'Eko Prasetyo'],
                ['jam' => '08:30 - 10:00', 'mapel' => 'Sejarah', 'guru' => 'Dewi Lestari'],
            ],
            'Kamis' => [
                ['jam' => '07:00 - 08:30', 'mapel' => 'Bahasa Inggris', 'guru' => 'John Doe'],
                ['jam' => '08:30 - 10:00', 'mapel' => 'Seni Budaya', 'guru' => 'Rina Wati'],
            ],
            'Jumat' => [
                ['jam' => '07:00 - 08:30', 'mapel' => 'Penjaskes', 'guru' => 'Bambang Pamungkas'],
                ['jam' => '08:30 - 10:00', 'mapel' => 'Prakarya', 'guru' => 'Sri Wahyuni'],
            ],
        ];
        return view('siswa.akademik.jadwal', compact('jadwal'));
    }

    public function akademikTugas()
    {
        $tugas = [
            ['mapel' => 'Matematika', 'judul' => 'Latihan Soal Aljabar', 'deadline' => '2023-10-25', 'status' => 'Belum', 'deskripsi' => 'Kerjakan halaman 10-12 buku paket.'],
            ['mapel' => 'Fisika', 'judul' => 'Laporan Praktikum', 'deadline' => '2023-10-27', 'status' => 'Proses', 'deskripsi' => 'Buat laporan praktikum hukum newton.'],
            ['mapel' => 'Bahasa Inggris', 'judul' => 'Essay Writing', 'deadline' => '2023-10-28', 'status' => 'Selesai', 'deskripsi' => 'Write an essay about your holiday.'],
             ['mapel' => 'Biologi', 'judul' => 'Gambar Sel Hewan', 'deadline' => '2023-10-30', 'status' => 'Belum', 'deskripsi' => 'Gambar dan jelaskan bagian sel hewan di kertas A3.'],
        ];
        return view('siswa.akademik.tugas', compact('tugas'));
    }

    public function akademikNilai()
    {
        $nilai = [
            ['mapel' => 'Matematika', 'uh' => 85, 'uts' => 80, 'uas' => 88, 'akhir' => 85],
            ['mapel' => 'Bahasa Indonesia', 'uh' => 90, 'uts' => 88, 'uas' => 92, 'akhir' => 90],
            ['mapel' => 'Fisika', 'uh' => 78, 'uts' => 75, 'uas' => 80, 'akhir' => 78],
            ['mapel' => 'Kimia', 'uh' => 82, 'uts' => 80, 'uas' => 85, 'akhir' => 82],
            ['mapel' => 'Biologi', 'uh' => 88, 'uts' => 85, 'uas' => 90, 'akhir' => 88],
        ];
        return view('siswa.akademik.nilai', compact('nilai'));
    }

    public function kehadiranRiwayat()
    {
        $riwayat = [
            ['tanggal' => '2023-10-24', 'jam_masuk' => '06:55', 'jam_pulang' => '14:00', 'status' => 'Hadir', 'keterangan' => '-'],
            ['tanggal' => '2023-10-23', 'jam_masuk' => '06:58', 'jam_pulang' => '14:05', 'status' => 'Hadir', 'keterangan' => '-'],
            ['tanggal' => '2023-10-20', 'jam_masuk' => '-', 'jam_pulang' => '-', 'status' => 'Izin', 'keterangan' => 'Acara Keluarga'],
            ['tanggal' => '2023-10-19', 'jam_masuk' => '06:50', 'jam_pulang' => '14:00', 'status' => 'Hadir', 'keterangan' => '-'],
            ['tanggal' => '2023-10-18', 'jam_masuk' => '07:05', 'jam_pulang' => '14:10', 'status' => 'Terlambat', 'keterangan' => 'Ban bocor'],
        ];
        return view('siswa.kehadiran.riwayat', compact('riwayat'));
    }

    public function kehadiranIzin()
    {
        $riwayat_izin = [
            ['tanggal_mulai' => '2023-10-20', 'tanggal_selesai' => '2023-10-20', 'jenis' => 'Izin', 'keterangan' => 'Acara Keluarga', 'status' => 'Disetujui'],
            ['tanggal_mulai' => '2023-09-15', 'tanggal_selesai' => '2023-09-17', 'jenis' => 'Sakit', 'keterangan' => 'Demam Tinggi', 'status' => 'Disetujui'],
        ];
        return view('siswa.kehadiran.izin', compact('riwayat_izin'));
    }

    public function kehadiranRekap()
    {
        $rekap = [
            ['bulan' => 'Oktober', 'hadir' => 20, 'sakit' => 0, 'izin' => 1, 'alpha' => 0, 'terlambat' => 1],
            ['bulan' => 'September', 'hadir' => 22, 'sakit' => 2, 'izin' => 0, 'alpha' => 0, 'terlambat' => 0],
            ['bulan' => 'Agustus', 'hadir' => 23, 'sakit' => 0, 'izin' => 0, 'alpha' => 0, 'terlambat' => 2],
            ['bulan' => 'Juli', 'hadir' => 15, 'sakit' => 0, 'izin' => 0, 'alpha' => 0, 'terlambat' => 0],
        ];
        return view('siswa.kehadiran.rekap', compact('rekap'));
    }
    public function kegiatanEvent()
    {
        $events = [
            ['judul' => 'Pentas Seni Tahunan', 'tanggal' => '2023-11-15', 'lokasi' => 'Aula Utama', 'deskripsi' => 'Pertunjukan seni dari seluruh siswa.', 'gambar' => 'pensi.jpg'],
            ['judul' => 'Lomba 17 Agustus', 'tanggal' => '2023-08-17', 'lokasi' => 'Lapangan Sekolah', 'deskripsi' => 'Berbagai lomba tradisional memeriahkan kemerdekaan.', 'gambar' => 'lomba.jpg'],
            ['judul' => 'Seminar Pendidikan', 'tanggal' => '2023-10-05', 'lokasi' => 'Ruang Multimedia', 'deskripsi' => 'Seminar tentang pentingnya teknologi dalam pendidikan.', 'gambar' => 'seminar.jpg'],
        ];
        return view('siswa.kegiatan.event', compact('events'));
    }

    public function kegiatanAgenda()
    {
        $agenda = [
            ['tanggal' => '2023-10-25', 'kegiatan' => 'Upacara Sumpah Pemuda', 'waktu' => '07:00 - 08:00', 'tempat' => 'Lapangan Utama'],
            ['tanggal' => '2023-10-27', 'kegiatan' => 'Kerja Bakti Sekolah', 'waktu' => '08:00 - 10:00', 'tempat' => 'Lingkungan Sekolah'],
            ['tanggal' => '2023-11-01', 'kegiatan' => 'Ujian Tengah Semester', 'waktu' => '07:30 - 12:00', 'tempat' => 'Ruang Kelas'],
        ];
        return view('siswa.kegiatan.agenda', compact('agenda'));
    }

    public function kegiatanDokumentasi()
    {
        $dokumentasi = [
            ['judul' => 'Kunjungan Industri 2023', 'tanggal' => '2023-09-10', 'gambar' => 'kunjungan.jpg'],
            ['judul' => 'Class Meeting Semester Genap', 'tanggal' => '2023-06-15', 'gambar' => 'classmeet.jpg'],
            ['judul' => 'Perpisahan Kelas XII', 'tanggal' => '2023-05-20', 'gambar' => 'perpisahan.jpg'],
            ['judul' => 'Study Tour Bali', 'tanggal' => '2023-04-10', 'gambar' => 'bali.jpg'],
            ['judul' => 'Buka Bersama OSIS', 'tanggal' => '2023-03-25', 'gambar' => 'bukber.jpg'],
            ['judul' => 'Hari Guru Nasional', 'tanggal' => '2022-11-25', 'gambar' => 'hariguru.jpg'],
        ];
        return view('siswa.kegiatan.dokumentasi', compact('dokumentasi'));
    }

    public function pembelajaranMateri()
    {
        $materi = [
            ['mapel' => 'Matematika', 'judul' => 'Bab 3: Aljabar Linear', 'guru' => 'Budi Santoso', 'tanggal' => '2023-10-20', 'file' => 'aljabar-linear.pdf', 'ukuran' => '2.5 MB'],
            ['mapel' => 'Fisika', 'judul' => 'Hukum Newton II', 'guru' => 'Agus Dermawan', 'tanggal' => '2023-10-18', 'file' => 'hukum-newton.pptx', 'ukuran' => '5.1 MB'],
            ['mapel' => 'Bahasa Inggris', 'judul' => 'Tenses Cheat Sheet', 'guru' => 'John Doe', 'tanggal' => '2023-10-15', 'file' => 'tenses.pdf', 'ukuran' => '1.2 MB'],
            ['mapel' => 'Biologi', 'judul' => 'Struktur Sel', 'guru' => 'Eko Prasetyo', 'tanggal' => '2023-10-12', 'file' => 'sel.pdf', 'ukuran' => '3.0 MB'],
        ];
        return view('siswa.pembelajaran.materi', compact('materi'));
    }

    public function pembelajaranTugas()
    {
        // Tugas yang belum dikerjakan bisa diambil dari sini atau query DB
        $tugas_pending = [
            ['id' => 1, 'mapel' => 'Matematika', 'judul' => 'Latihan Soal Aljabar', 'deadline' => '2023-10-25', 'deskripsi' => 'Kerjakan di kertas folio, scan, dan upload.'],
            ['id' => 2, 'mapel' => 'Biologi', 'judul' => 'Gambar Sel Hewan', 'deadline' => '2023-10-30', 'deskripsi' => 'Gambar manual dan foto hasilnya.'],
        ];
        return view('siswa.pembelajaran.tugas', compact('tugas_pending'));
    }

    public function pembelajaranNilai()
    {
        $nilai_tugas = [
            ['mapel' => 'Bahasa Inggris', 'judul' => 'Essay Writing', 'tanggal_kumpul' => '2023-10-18', 'nilai' => 88, 'feedback' => 'Good grammar, but pay attention to structure.', 'status' => 'Dinilai'],
            ['mapel' => 'Fisika', 'judul' => 'Laporan Praktikum', 'tanggal_kumpul' => '2023-10-15', 'nilai' => 90, 'feedback' => 'Laporan sangat lengkap.', 'status' => 'Dinilai'],
            ['mapel' => 'Kimia', 'judul' => 'Tabel Periodik', 'tanggal_kumpul' => '2023-10-10', 'nilai' => null, 'feedback' => null, 'status' => 'Menunggu Penilaian'],
        ];
        return view('siswa.pembelajaran.nilai', compact('nilai_tugas'));
    }

    public function perpustakaanKatalog()
    {
        $buku = [
            ['judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'kategori' => 'Novel', 'stok' => 5, 'gambar' => 'laskar-pelangi.jpg'],
            ['judul' => 'Bumi', 'penulis' => 'Tere Liye', 'kategori' => 'Fiksi', 'stok' => 3, 'gambar' => 'bumi.jpg'],
            ['judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'kategori' => 'Self Improvement', 'stok' => 8, 'gambar' => 'filosofi-teras.jpg'],
            ['judul' => 'Atomic Habits', 'penulis' => 'James Clear', 'kategori' => 'Self Improvement', 'stok' => 2, 'gambar' => 'atomic-habits.jpg'],
            ['judul' => 'Sejarah Dunia yang Disembunyikan', 'penulis' => 'Jonathan Black', 'kategori' => 'Sejarah', 'stok' => 1, 'gambar' => 'sejarah.jpg'],
        ];
        return view('siswa.perpustakaan.katalog', compact('buku'));
    }

    public function perpustakaanPinjam()
    {
        // Data buku untuk dropdown
        $buku_list = [
            'Laskar Pelangi', 'Bumi', 'Filosofi Teras', 'Atomic Habits', 'Sejarah Dunia yang Disembunyikan'
        ];
        return view('siswa.perpustakaan.pinjam', compact('buku_list'));
    }

    public function perpustakaanRiwayat()
    {
        $riwayat_pinjam = [
            ['judul' => 'Bumi', 'tgl_pinjam' => '2023-10-01', 'tgl_kembali' => '2023-10-08', 'status' => 'Dikembalikan', 'denda' => 0],
            ['judul' => 'Laskar Pelangi', 'tgl_pinjam' => '2023-10-15', 'tgl_kembali' => '2023-10-22', 'status' => 'Dipinjam', 'denda' => 0],
            ['judul' => 'Atomic Habits', 'tgl_pinjam' => '2023-09-01', 'tgl_kembali' => '2023-09-08', 'status' => 'Terlambat', 'denda' => 5000],
        ];
        return view('siswa.perpustakaan.riwayat', compact('riwayat_pinjam'));
    }

    public function profilBiodata()
    {
        $siswa = [
            'nama' => 'Kevin Ferdiansyah',
            'nis' => '12345678',
            'nisn' => '0012345678',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2006-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta Selatan',
            'telepon' => '081234567890',
            'email' => 'siswa@gmail.com',
            'kelas' => 'XII IPA 1',
            'foto' => 'https://ui-avatars.com/api/?name=Kevin+Ferdiansyah&background=0D8ABC&color=fff',
        ];
        return view('siswa.profil.biodata', compact('siswa'));
    }

    public function profilOrangtua()
    {
        $orangtua = [
            'ayah' => [
                'nama' => 'Budi Santoso',
                'pekerjaan' => 'Wiraswasta',
                'telepon' => '081122334455',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Selatan'
            ],
            'ibu' => [
                'nama' => 'Siti Aminah',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'telepon' => '081122334466',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Selatan'
            ],
            'wali' => [
                'nama' => '-',
                'pekerjaan' => '-',
                'telepon' => '-',
                'alamat' => '-'
            ]
        ];
        return view('siswa.profil.orangtua', compact('orangtua'));
    }

    public function profilPassword()
    {
        return view('siswa.profil.password');
    }
}
