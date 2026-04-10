<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

// halaman login satu pintu
Route::get('/login', function () {
    return view('auth.login');
});

// proses login satu pintu
Route::post('/login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');
    $role = null;
    $redirect = null;

    if ($email === 'admin@gmail.com') {
        $role = 'admin';
        $redirect = '/admin/dashboard';
    } elseif ($email === 'guru@gmail.com') {
        $role = 'guru';
        $redirect = '/guru/dashboard';
    } elseif ($email === 'siswa@gmail.com') {
        if ($password === 'siswa123') {
            $role = 'siswa';
            $redirect = '/siswa/dashboard';
        }
    } elseif ($email === 'ortu@gmail.com') {
        $role = 'orangtua';
        $redirect = '/orangtua/dashboard';
    } elseif ($email === 'keuangan@gmail.com') {
        $role = 'keuangan';
        $redirect = '/keuangan/dashboard';
    }

    if ($role && $redirect) {
        session([
            'is_login' => true,
            'role' => $role
        ]);
        return redirect($redirect);
    } else {
        return redirect('/login')->with('error', 'Email atau Password salah!');
    }
});

/*
|--------------------------------------------------------------------------
| PPDB ROUTES (Frontend Only)
|--------------------------------------------------------------------------
*/

// Landing PPDB
Route::view('/ppdb', 'ppdb.index')->name('ppdb.index');

// ================= JENJANG =================
Route::view('/ppdb/sd', 'ppdb.jenjang.sd')->name('ppdb.sd');
Route::view('/ppdb/smp', 'ppdb.jenjang.smp')->name('ppdb.smp');
Route::view('/ppdb/sma', 'ppdb.jenjang.sma')->name('ppdb.sma');
Route::view('/ppdb/smk', 'ppdb.jenjang.smk')->name('ppdb.smk');

// Alias dengan prefix /jenjang/
Route::view('/ppdb/jenjang/sd', 'ppdb.jenjang.sd')->name('ppdb.jenjang.sd');
Route::view('/ppdb/jenjang/smp', 'ppdb.jenjang.smp')->name('ppdb.jenjang.smp');
Route::view('/ppdb/jenjang/sma', 'ppdb.jenjang.sma')->name('ppdb.jenjang.sma');
Route::view('/ppdb/jenjang/smk', 'ppdb.jenjang.smk')->name('ppdb.jenjang.smk');

// ================= REGISTER SD =================
Route::view('/ppdb/register/sd/step1', 'ppdb.sd.step1')->name('ppdb.register.sd.step1');
Route::view('/ppdb/register/sd/step2', 'ppdb.sd.step2')->name('ppdb.register.sd.step2');
Route::view('/ppdb/register/sd/step3', 'ppdb.sd.step3')->name('ppdb.register.sd.step3');
Route::view('/ppdb/register/sd/success', 'ppdb.sd.success')->name('ppdb.register.sd.success');

// ================= REGISTER SMP =================
Route::view('/ppdb/register/smp/step1', 'ppdb.smp.step1')->name('ppdb.register.smp.step1');
Route::view('/ppdb/register/smp/step2', 'ppdb.smp.step2')->name('ppdb.register.smp.step2');
Route::view('/ppdb/register/smp/step3', 'ppdb.smp.step3')->name('ppdb.register.smp.step3');
Route::view('/ppdb/register/smp/success', 'ppdb.smp.success')->name('ppdb.register.smp.success');

// ================= REGISTER SMA =================
Route::view('/ppdb/register/sma/step1', 'ppdb.sma.step1')->name('ppdb.register.sma.step1');
Route::view('/ppdb/register/sma/step2', 'ppdb.sma.step2')->name('ppdb.register.sma.step2');
Route::view('/ppdb/register/sma/step3', 'ppdb.sma.step3')->name('ppdb.register.sma.step3');
Route::view('/ppdb/register/sma/success', 'ppdb.sma.success')->name('ppdb.register.sma.success');

// ================= REGISTER SMK =================
Route::view('/ppdb/register/smk/step1', 'ppdb.smk.step1')->name('ppdb.register.smk.step1');
Route::view('/ppdb/register/smk/step2', 'ppdb.smk.step2')->name('ppdb.register.smk.step2');
Route::view('/ppdb/register/smk/step3', 'ppdb.smk.step3')->name('ppdb.register.smk.step3');
Route::view('/ppdb/register/smk/success', 'ppdb.smk.success')->name('ppdb.register.smk.success');





// ================= LOGIN PPDB =================
Route::view('/ppdb/login', 'ppdb.login')->name('ppdb.login');

// ================= CEK STATUS PPDB =================
Route::view('/ppdb/cek-status', 'ppdb.cek-status')->name('ppdb.cek-status');

// ================= CETAK BUKTI PPDB =================
Route::view('/ppdb/cetak-bukti', 'ppdb.cetak-bukti')->name('ppdb.cetak-bukti');

// ================= DASHBOARD PPDB =================
Route::view('/ppdb/dashboard', 'ppdb.dashboard')->name('ppdb.dashboard');
/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
                
            // ========================
            // KEPEGAWAIAN
            // ========================
            Route::prefix('kepegawaian')->group(function () {
                Route::get('/data-guru', [\App\Http\Controllers\Admin\TeacherController::class, 'index'])->name('admin.kepegawaian.data-guru');
                Route::post('/data-guru', [\App\Http\Controllers\Admin\TeacherController::class, 'store'])->name('admin.kepegawaian.data-guru.store');
                Route::put('/data-guru/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'update'])->name('admin.kepegawaian.data-guru.update');
                Route::delete('/data-guru/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'destroy'])->name('admin.kepegawaian.data-guru.destroy');

                Route::get('/jadwal-mengajar', function () {
                    return view('admin.kepegawaian.jadwal-mengajar');
                })->name('admin.kepegawaian.jadwal-mengajar');

                Route::get('/arsip-kepegawaian', function () {
                    return view('admin.kepegawaian.arsip-kepegawaian');
                })->name('admin.kepegawaian.arsip-kepegawaian');
            });
        // ========================
        // ABSENSI
        // ========================
        Route::prefix('absensi')->group(function () {
            Route::get('/siswa', function () {
                return view('admin.absensi.absensi-siswa');
            })->name('admin.absensi.siswa');

            Route::get('/guru', function () {
                return view('admin.absensi.absensi-guru');
            })->name('admin.absensi.guru');

            Route::get('/rekap', function () {
                return view('admin.absensi.rekap-absensi');
            })->name('admin.absensi.rekap');

            Route::get('/izin-sakit-alpha', function () {
                return view('admin.absensi.izin-sakit-alpha');
            })->name('admin.absensi.izin-sakit-alpha');
        });
    // ========================
    // AKADEMIK
    // ========================
    Route::prefix('akademik')->group(function () {
        Route::get('/jadwal-pelajaran', function () {
            return view('admin.akademik.jadwal-pelajaran');
        })->name('admin.akademik.jadwal-pelajaran');

        Route::get('/penilaian', function () {
            return view('admin.akademik.penilaian');
        })->name('admin.akademik.penilaian');

        Route::get('/rapor', function () {
            return view('admin.akademik.rapor');
        })->name('admin.akademik.rapor');

        Route::get('/kelas-wali-kelas', [\App\Http\Controllers\Admin\SchoolClassController::class, 'index'])->name('admin.akademik.kelas-wali-kelas');
        Route::post('/kelas-wali-kelas', [\App\Http\Controllers\Admin\SchoolClassController::class, 'store'])->name('admin.akademik.kelas-wali-kelas.store');
        Route::put('/kelas-wali-kelas/{id}', [\App\Http\Controllers\Admin\SchoolClassController::class, 'update'])->name('admin.akademik.kelas-wali-kelas.update');
        Route::delete('/kelas-wali-kelas/{id}', [\App\Http\Controllers\Admin\SchoolClassController::class, 'destroy'])->name('admin.akademik.kelas-wali-kelas.destroy');

        Route::get('/mata-pelajaran', [\App\Http\Controllers\Admin\SubjectController::class, 'index'])->name('admin.akademik.mata-pelajaran');
        Route::post('/mata-pelajaran', [\App\Http\Controllers\Admin\SubjectController::class, 'store'])->name('admin.akademik.mata-pelajaran.store');
        Route::put('/mata-pelajaran/{id}', [\App\Http\Controllers\Admin\SubjectController::class, 'update'])->name('admin.akademik.mata-pelajaran.update');
        Route::delete('/mata-pelajaran/{id}', [\App\Http\Controllers\Admin\SubjectController::class, 'destroy'])->name('admin.akademik.mata-pelajaran.destroy');
    });

    // ========================
    // DASHBOARD
    // ========================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // ========================
    // USERS 
    // ========================
Route::get('/users', [\App\Http\Controllers\Admin\StudentController::class, 'index'])->name('admin.users');
Route::post('/users', [\App\Http\Controllers\Admin\StudentController::class, 'store'])->name('admin.users.store');
Route::put('/users/{id}', [\App\Http\Controllers\Admin\StudentController::class, 'update'])->name('admin.users.update');
Route::delete('/users/{id}', [\App\Http\Controllers\Admin\StudentController::class, 'destroy'])->name('admin.users.destroy');


    // ========================
    // DATA SEKOLAH (SUB MENU)
    // ========================
    Route::prefix('data-sekolah')->group(function () {

        // Identitas & Profil Sekolah
        Route::get('/identitas', function () {
            return view('admin.data-sekolah.identitas');
        })->name('admin.data-sekolah.identitas');

        // Visi, Misi & Struktur Organisasi
        Route::get('/visi-misi', function () {
            return view('admin.data-sekolah.visi-misi');
        })->name('admin.data-sekolah.visi-misi');

        // Jurusan / Kelas / Ruang - redirect ke classes
        Route::get('/jurusan', function () {
             return view('admin.data-sekolah.jurusan');
        })->name('admin.data-sekolah.jurusan');
    });

    // ========================
    // KEGIATAN
    // ========================
    Route::prefix('kegiatan')->group(function () {
        // Event
        Route::get('/event', function () {
            return view('admin.kegiatan.event.index');
        })->name('admin.kegiatan.event.index');
        Route::get('/event/form', function () {
            return view('admin.kegiatan.event.form');
        })->name('admin.kegiatan.event.form');
        Route::get('/event/detail', function () {
            return view('admin.kegiatan.event.detail');
        })->name('admin.kegiatan.event.detail');
        // Agenda
        Route::get('/agenda', function () {
            return view('admin.kegiatan.agenda.index');
        })->name('admin.kegiatan.agenda.index');
        // Dokumentasi
        Route::get('/dokumentasi', function () {
            return view('admin.kegiatan.dokumentasi.index');
        })->name('admin.kegiatan.dokumentasi.index');
        // Pengumuman
        Route::get('/pengumuman', function () {
            return view('admin.kegiatan.pengumuman.index');
        })->name('admin.kegiatan.pengumuman.index');
    });
    // ========================
    // PPDB (ADMIN)
    // ========================
    Route::prefix('ppdb')->group(function () {
        Route::get('/data-pendaftar', function () {
            return view('admin.ppdb.data-pendaftar');
        })->name('admin.ppdb.data-pendaftar');
        Route::get('/verifikasi-berkas', function () {
            return view('admin.ppdb.verifikasi-berkas');
        })->name('admin.ppdb.verifikasi-berkas');
        Route::get('/seleksi', function () {
            return view('admin.ppdb.seleksi');
        })->name('admin.ppdb.seleksi');
        Route::get('/pembayaran', function () {
            return view('admin.ppdb.pembayaran');
        })->name('admin.ppdb.pembayaran');
    });
    // ========================
    // LAPORAN
    // ========================
    Route::prefix('laporan')->group(function () {
        Route::get('/', function () {
            return view('admin.laporan.index');
        })->name('admin.laporan.index');
        Route::get('/absensi', function () {
            return view('admin.laporan.absensi');
        })->name('admin.laporan.absensi');
        Route::get('/akademik', function () {
            return view('admin.laporan.akademik');
        })->name('admin.laporan.akademik');
        Route::get('/keuangan', function () {
            return view('admin.laporan.keuangan');
        })->name('admin.laporan.keuangan');
        Route::get('/ppdb', function () {
            return view('admin.laporan.ppdb');
        })->name('admin.laporan.ppdb');
        Route::get('/perpustakaan', function () {
            return view('admin.laporan.perpustakaan');
        })->name('admin.laporan.perpustakaan');
        Route::get('/kegiatan', function () {
            return view('admin.laporan.kegiatan');
        })->name('admin.laporan.kegiatan');
    });
});

// ========================
// GURU AREA
// ========================
Route::prefix('guru')->name('guru.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\GuruController::class, 'dashboard'])->name('dashboard');

    // Akademik
    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::get('/mata-pelajaran', [\App\Http\Controllers\GuruController::class, 'mataPelajaran'])->name('mata-pelajaran');
        Route::post('/mata-pelajaran', [\App\Http\Controllers\GuruController::class, 'storeMataPelajaran'])->name('mata-pelajaran.store');
        Route::put('/mata-pelajaran/{id}', [\App\Http\Controllers\GuruController::class, 'updateMataPelajaran'])->name('mata-pelajaran.update');
        Route::delete('/mata-pelajaran/{id}', [\App\Http\Controllers\GuruController::class, 'destroyMataPelajaran'])->name('mata-pelajaran.destroy');

        Route::get('/jadwal-mengajar', [\App\Http\Controllers\GuruController::class, 'jadwalMengajar'])->name('jadwal-mengajar');
        Route::get('/kelas-siswa', [\App\Http\Controllers\GuruController::class, 'kelasSiswa'])->name('kelas');
        
        // Student Management
        Route::post('/siswa', [\App\Http\Controllers\GuruController::class, 'storeStudent'])->name('siswa.store');
        Route::put('/siswa/{id}', [\App\Http\Controllers\GuruController::class, 'updateStudent'])->name('siswa.update');
        Route::delete('/siswa/{id}', [\App\Http\Controllers\GuruController::class, 'destroyStudent'])->name('siswa.destroy');
        Route::post('/siswa/update-catatan/{id}', [\App\Http\Controllers\GuruController::class, 'updateStudentNote'])->name('siswa.update-catatan');
        
        // Class Management
        Route::post('/kelas', [\App\Http\Controllers\GuruController::class, 'storeClass'])->name('kelas.store');
        Route::put('/kelas/{id}', [\App\Http\Controllers\GuruController::class, 'updateClass'])->name('kelas.update');
        Route::delete('/kelas/{id}', [\App\Http\Controllers\GuruController::class, 'destroyClass'])->name('kelas.destroy');
        
        Route::get('/rekap-nilai', [\App\Http\Controllers\GuruController::class, 'rekapNilai'])->name('rekap');
        Route::get('/nilai-tugas', [\App\Http\Controllers\GuruController::class, 'inputNilaiTugas'])->name('nilai.tugas');
        Route::post('/nilai-tugas', [\App\Http\Controllers\GuruController::class, 'storeNilaiTugas'])->name('nilai.tugas.store');
        Route::get('/nilai-rapor', [\App\Http\Controllers\GuruController::class, 'inputNilaiRapor'])->name('nilai.rapor');
        Route::post('/nilai-rapor', [\App\Http\Controllers\GuruController::class, 'storeNilaiRapor'])->name('nilai.rapor.store');
    });

    // Absensi
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', function () { return view('guru.absensi.index'); })->name('index');
        Route::get('/absensi-pertemuan', [\App\Http\Controllers\GuruController::class, 'absensiPertemuan'])->name('pertemuan');
        Route::get('/izin-sakit-alpha', function () { return view('guru.absensi.izin-sakit-alpha'); })->name('izin');
        Route::get('/rekap-absensi', function () { return view('guru.absensi.rekap-absensi'); })->name('rekap');
        
        // Reports CRUD
        Route::get('/reports', [\App\Http\Controllers\GuruController::class, 'reportsIndex'])->name('reports.index');
        Route::post('/reports', [\App\Http\Controllers\GuruController::class, 'storeReport'])->name('reports.store');
        Route::put('/reports/{id}', [\App\Http\Controllers\GuruController::class, 'updateReport'])->name('reports.update');
        Route::delete('/reports/{id}', [\App\Http\Controllers\GuruController::class, 'destroyReport'])->name('reports.destroy');
    });

    // Materi & Tugas (CRUD)
    Route::prefix('materi')->group(function () {
        Route::get('/materi', [\App\Http\Controllers\GuruController::class, 'materiIndex'])->name('materi.index');
        Route::get('/upload', [\App\Http\Controllers\GuruController::class, 'uploadForm'])->name('materi.upload');
        Route::post('/upload', [\App\Http\Controllers\GuruController::class, 'storeMateri'])->name('materi.store');
        Route::put('/materi/{id}', [\App\Http\Controllers\GuruController::class, 'updateMateri'])->name('materi.update');
        Route::delete('/materi/{id}', [\App\Http\Controllers\GuruController::class, 'destroyMateri'])->name('materi.destroy');
        
        Route::get('/tugas', [\App\Http\Controllers\GuruController::class, 'tugasIndex'])->name('tugas.index');
        Route::post('/tugas', [\App\Http\Controllers\GuruController::class, 'storeTugas'])->name('tugas.store');
        Route::put('/tugas/{id}', [\App\Http\Controllers\GuruController::class, 'updateTugas'])->name('tugas.update');
        Route::delete('/tugas/{id}', [\App\Http\Controllers\GuruController::class, 'destroyTugas'])->name('tugas.destroy');
        
        Route::get('/penilaian', [\App\Http\Controllers\GuruController::class, 'penilaianIndex'])->name('tugas.penilaian');
        Route::put('/penilaian/{id}', [\App\Http\Controllers\GuruController::class, 'updateNilai'])->name('tugas.penilaian.update');
        Route::get('/feedback', function () { return view('guru.materi-tugas.komentar-feedback'); })->name('tugas.feedback');
    });

    // Kegiatan (masih statis)
    Route::prefix('kegiatan')->group(function () {
        Route::get('/agenda', function () { return view('guru.kegiatan.agenda'); });
        Route::get('/event', function () { return view('guru.kegiatan.event'); });
        Route::get('/pengumuman', function () { return view('guru.kegiatan.pengumuman'); });
    });

    // Profil (masih statis)
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/biodata', function () { return view('guru.profil.biodata'); })->name('biodata');
        Route::get('/riwayat-mengajar', function () { return view('guru.profil.riwayat-mengajar'); })->name('riwayat');
        Route::get('/arsip-dokumen', function () { return view('guru.profil.arsip-dokumen'); })->name('arsip');
        Route::get('/ganti-password', function () { return view('guru.profil.ganti-password'); })->name('password');
    });
});

    // ========================
    // ORANG TUA AREA
    // ========================
    Route::prefix('orangtua')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'orangtua'])->name('orangtua.dashboard');

        // Monitoring Anak
        Route::prefix('monitoring')->group(function () {
            Route::get('/presensi', [\App\Http\Controllers\OrangtuaController::class, 'monitoringPresensi'])->name('orangtua.monitoring.presensi');
            Route::get('/nilai', [\App\Http\Controllers\OrangtuaController::class, 'monitoringNilai'])->name('orangtua.monitoring.nilai');
            Route::get('/spp', [\App\Http\Controllers\OrangtuaController::class, 'monitoringSpp'])->name('orangtua.monitoring.spp');
        });

        // Monitoring Akademik
        Route::prefix('akademik')->group(function () {
            Route::get('/tugas', [\App\Http\Controllers\OrangtuaController::class, 'akademikTugas'])->name('orangtua.akademik.tugas');
            Route::get('/rapor', [\App\Http\Controllers\OrangtuaController::class, 'akademikRapor'])->name('orangtua.akademik.rapor');
            Route::get('/jadwal', [\App\Http\Controllers\OrangtuaController::class, 'akademikJadwal'])->name('orangtua.akademik.jadwal');
        });

        // Absensi Anak
        Route::prefix('absensi')->group(function () {
            Route::get('/riwayat', [\App\Http\Controllers\OrangtuaController::class, 'absensiRiwayat'])->name('orangtua.absensi.riwayat');
            Route::get('/izin', [\App\Http\Controllers\OrangtuaController::class, 'absensiIzin'])->name('orangtua.absensi.izin');
            Route::get('/rekap', [\App\Http\Controllers\OrangtuaController::class, 'absensiRekap'])->name('orangtua.absensi.rekap');
        });

        // Keuangan
        Route::prefix('keuangan')->group(function () {
            Route::get('/tagihan', [\App\Http\Controllers\OrangtuaController::class, 'keuanganTagihan'])->name('orangtua.keuangan.tagihan');
            Route::get('/riwayat', [\App\Http\Controllers\OrangtuaController::class, 'keuanganRiwayat'])->name('orangtua.keuangan.riwayat');
            Route::get('/bukti', [\App\Http\Controllers\OrangtuaController::class, 'keuanganBukti'])->name('orangtua.keuangan.bukti');
        });

        // Kegiatan & Info
        Route::prefix('kegiatan')->group(function () {
            Route::get('/agenda', [\App\Http\Controllers\OrangtuaController::class, 'kegiatanAgenda'])->name('orangtua.kegiatan.agenda');
            Route::get('/event', [\App\Http\Controllers\OrangtuaController::class, 'kegiatanEvent'])->name('orangtua.kegiatan.event');
            Route::get('/pengumuman', [\App\Http\Controllers\OrangtuaController::class, 'kegiatanPengumuman'])->name('orangtua.kegiatan.pengumuman');
        });

        // Profil Orang Tua
        Route::prefix('profil')->group(function () {
            Route::get('/data-diri', [\App\Http\Controllers\OrangtuaController::class, 'profilDataDiri'])->name('orangtua.profil.datadiri');
            Route::get('/data-anak', [\App\Http\Controllers\OrangtuaController::class, 'profilDataAnak'])->name('orangtua.profil.dataanak');
            Route::get('/password', [\App\Http\Controllers\OrangtuaController::class, 'profilPassword'])->name('orangtua.profil.password');
        });
    });

    // ========================
    // SISWA AREA
    // ========================
    Route::prefix('siswa')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswa.dashboard');
        
        // Akademik
        Route::prefix('akademik')->group(function () {
            Route::get('/jadwal', [\App\Http\Controllers\SiswaController::class, 'akademikJadwal'])->name('siswa.akademik.jadwal');
            Route::get('/tugas', [\App\Http\Controllers\SiswaController::class, 'akademikTugas'])->name('siswa.akademik.tugas');
            Route::get('/nilai', [\App\Http\Controllers\SiswaController::class, 'akademikNilai'])->name('siswa.akademik.nilai');
        });

        // Kehadiran
        Route::prefix('kehadiran')->group(function () {
            Route::get('/riwayat', [\App\Http\Controllers\SiswaController::class, 'kehadiranRiwayat'])->name('siswa.kehadiran.riwayat');
            Route::get('/izin', [\App\Http\Controllers\SiswaController::class, 'kehadiranIzin'])->name('siswa.kehadiran.izin');
            Route::get('/rekap', [\App\Http\Controllers\SiswaController::class, 'kehadiranRekap'])->name('siswa.kehadiran.rekap');
        });

        // Kegiatan
        Route::prefix('kegiatan')->group(function () {
            Route::get('/event', [\App\Http\Controllers\SiswaController::class, 'kegiatanEvent'])->name('siswa.kegiatan.event');
            Route::get('/agenda', [\App\Http\Controllers\SiswaController::class, 'kegiatanAgenda'])->name('siswa.kegiatan.agenda');
            Route::get('/dokumentasi', [\App\Http\Controllers\SiswaController::class, 'kegiatanDokumentasi'])->name('siswa.kegiatan.dokumentasi');
        });

        // Pembelajaran (Materi & Tugas)
        Route::prefix('pembelajaran')->group(function () {
            Route::get('/materi', [\App\Http\Controllers\SiswaController::class, 'pembelajaranMateri'])->name('siswa.pembelajaran.materi');
            Route::get('/tugas', [\App\Http\Controllers\SiswaController::class, 'pembelajaranTugas'])->name('siswa.pembelajaran.tugas');
            Route::post('/tugas/submit/{id}', [\App\Http\Controllers\SiswaController::class, 'submitTugas'])->name('siswa.pembelajaran.tugas.submit');
            Route::get('/nilai', [\App\Http\Controllers\SiswaController::class, 'pembelajaranNilai'])->name('siswa.pembelajaran.nilai');
        });

        // Perpustakaan
        Route::prefix('perpustakaan')->group(function () {
            Route::get('/katalog', [\App\Http\Controllers\SiswaController::class, 'perpustakaanKatalog'])->name('siswa.perpustakaan.katalog');
            Route::get('/pinjam', [\App\Http\Controllers\SiswaController::class, 'perpustakaanPinjam'])->name('siswa.perpustakaan.pinjam');
            Route::get('/riwayat', [\App\Http\Controllers\SiswaController::class, 'perpustakaanRiwayat'])->name('siswa.perpustakaan.riwayat');
        });

        // Profil
        Route::prefix('profil')->group(function () {
            Route::get('/biodata', [\App\Http\Controllers\SiswaController::class, 'profilBiodata'])->name('siswa.profil.biodata');
            Route::get('/orangtua', [\App\Http\Controllers\SiswaController::class, 'profilOrangtua'])->name('siswa.profil.orangtua');
            Route::get('/password', [\App\Http\Controllers\SiswaController::class, 'profilPassword'])->name('siswa.profil.password');
        });
    });



// ========================
// KEUANGAN AREA
// ========================
Route::prefix('keuangan')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\KeuanganController::class, 'index'])->name('keuangan.dashboard');

    // Pembayaran Siswa
    Route::prefix('pembayaran-siswa')->group(function () {
        Route::get('/tagihan', [\App\Http\Controllers\KeuanganController::class, 'tagihanSpp'])->name('keuangan.pembayaran.tagihan');
        Route::get('/riwayat', [\App\Http\Controllers\KeuanganController::class, 'riwayatPembayaran'])->name('keuangan.pembayaran.riwayat');
        Route::get('/verifikasi', [\App\Http\Controllers\KeuanganController::class, 'verifikasiPembayaran'])->name('keuangan.pembayaran.verifikasi');
    });

    // PPDB Keuangan
    Route::prefix('ppdb')->group(function () {
        Route::get('/biaya-pendaftaran', [\App\Http\Controllers\KeuanganController::class, 'biayaPPDB'])->name('keuangan.ppdb.biaya');
        Route::get('/pembayaran', [\App\Http\Controllers\KeuanganController::class, 'pembayaranPPDB'])->name('keuangan.ppdb.pembayaran');
        Route::get('/rekap', [\App\Http\Controllers\KeuanganController::class, 'rekapPPDB'])->name('keuangan.ppdb.rekap');
    });

    // Laporan Keuangan
    Route::get('/laporan', [\App\Http\Controllers\KeuanganController::class, 'laporan'])->name('keuangan.laporan');
    Route::post('/laporan/transaksi', [\App\Http\Controllers\KeuanganController::class, 'storeTransaksi'])->name('keuangan.laporan.store');

    Route::put('/pembayaran-siswa/verifikasi/{id}', [\App\Http\Controllers\KeuanganController::class, 'updateVerifikasi'])->name('keuangan.pembayaran.verifikasi.update');
});

// ========================
// NOTIFICATIONS
// ========================
Route::middleware(['web'])->group(function () {
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

