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
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
                // ========================
                // PPDB
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
            // KEPEGAWAIAN
            // ========================
            Route::prefix('kepegawaian')->group(function () {
                Route::get('/data-guru', function () {
                    return view('admin.kepegawaian.data-guru');
                })->name('admin.kepegawaian.data-guru');

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

        Route::get('/kelas-wali-kelas', function () {
            return view('admin.akademik.kelas-wali-kelas');
        })->name('admin.akademik.kelas-wali-kelas');

        Route::get('/mata-pelajaran', function () {
            return view('admin.akademik.mata-pelajaran');
        })->name('admin.akademik.mata-pelajaran');
    });

    // ========================
    // DASHBOARD
    // ========================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // ========================
    // USERS 
    // ========================
Route::get('/users', function () {
    $users = [
        ['name'=>'Budi','status'=>'Active'],
        ['name'=>'Siti','status'=>'Active'],
        ['name'=>'Agus','status'=>'Pending'],
    ];

    return view('admin.users', compact('users'));
})->name('admin.users');


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
Route::prefix('guru')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('guru.dashboard.index');
    });

    Route::get('/dashboard/index', function () {
        return view('guru.dashboard.index');
    })->name('guru.dashboard');

    // Akademik
   Route::prefix('guru')->name('guru.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('guru.dashboard.index');
    })->name('dashboard');

    // =====================
    // AKADEMIK GURU
    // =====================
    Route::prefix('akademik')->name('akademik.')->group(function () {

        Route::get('/jadwal-mengajar', function () {
            return view('guru.akademik.jadwal-mengajar');
        })->name('jadwal-mengajar');

        Route::get('/kelas-siswa', function () {
            return view('guru.akademik.kelas-siswa');
        })->name('kelas');

        Route::get('/input-nilai-tugas', function () {
            return view('guru.akademik.input-nilai-tugas');
        })->name('nilai.tugas');

        Route::get('/input-nilai-rapor', function () {
            return view('guru.akademik.input-nilai-rapor');
        })->name('nilai.rapor');

        Route::get('/rekap-nilai', function () {
            return view('guru.akademik.rekap-nilai');
        })->name('rekap');

    });

});



    // Absensi
    Route::get('/absensi', function () {
        return view('guru.absensi.index');
    });

    Route::get('/absensi/absensi-pertemuan', function () {
        return view('guru.absensi.absensi-pertemuan');
    });

    Route::get('/absensi/izin-sakit-alpha', function () {
        return view('guru.absensi.izin-sakit-alpha');
    });

    Route::get('/absensi/rekap-absensi', function () {
        return view('guru.absensi.rekap-absensi');
    });



    /*
    |--------------------------------------------------------------------------
    | Materi & Tugas
    |--------------------------------------------------------------------------
    */
    Route::prefix('materi')->group(function () {

        Route::get('/upload', function () {
            return view('guru.materi-tugas.upload');
        })->name('guru.materi.upload');

        Route::get('/materi', function () {
            return view('guru.materi-tugas.materi');
        })->name('guru.materi.index');

        Route::get('/tugas', function () {
            return view('guru.materi-tugas.tugas');
        })->name('guru.tugas.index');

        Route::get('/penilaian', function () {
            return view('guru.materi-tugas.penilaian-tugas');
        })->name('guru.tugas.penilaian');

        Route::get('/feedback', function () {
            return view('guru.materi-tugas.komentar-feedback');
        })->name('guru.tugas.feedback');

    });

});


    // Kegiatan
    
    Route::prefix('guru')->group(function () {

    Route::get('/kegiatan/agenda', function () {
        return view('guru.kegiatan.agenda');
    });

    Route::get('/kegiatan/event', function () {
        return view('guru.kegiatan.event');
    });

    Route::get('/kegiatan/pengumuman', function () {
        return view('guru.kegiatan.pengumuman');
    });

});


    // Profil
  

    /*
    |--------------------------------------------------------------------------
    | Profil Guru
    |--------------------------------------------------------------------------
    */
    Route::prefix('profil')->group(function () {

        Route::get('/biodata', function () {
            return view('guru.profil.biodata');
        })->name('guru.profil.biodata');

        Route::get('/riwayat-mengajar', function () {
            return view('guru.profil.riwayat-mengajar');
        })->name('guru.profil.riwayat');

        Route::get('/arsip-dokumen', function () {
            return view('guru.profil.arsip-dokumen');
        })->name('guru.profil.arsip');

        Route::get('/ganti-password', function () {
            return view('guru.profil.ganti-password');
        })->name('guru.profil.password');

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

    Route::prefix('guru/materi')->name('guru.materi.')->group(function () {

    // tampil form
    Route::get('/upload', function () {
        return view('guru.materi-tugas.upload');
    })->name('upload');

    // simpan upload
    Route::post('/upload', function (\Illuminate\Http\Request $request) {

        $request->validate([
            'kelas' => 'required',
            'judul' => 'required',
            'file'  => 'required|file'
        ]);

        $fileName = time().'_'.$request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('materi', $fileName, 'public');

        return back()->with('success', 'Materi berhasil diupload');
    })->name('upload.store');

});





