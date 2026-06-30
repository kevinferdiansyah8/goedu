<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'checkEmail'])->name('password.email');
Route::get('/reset-password/{email}', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password/{email}', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])->name('password.update');

Route::get('/', function () {
    return redirect('/login');
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





// ================= PORTAL PPDB (LANDING PAGE) =================
Route::get('/ppdb', [\App\Http\Controllers\PpdbFrontendController::class, 'index'])->name('ppdb.index');

// ================= DAFTAR PPDB =================
Route::get('/ppdb/daftar', [\App\Http\Controllers\PpdbFrontendController::class, 'showRegisterForm'])->name('ppdb.daftar');
Route::post('/ppdb/daftar', [\App\Http\Controllers\PpdbFrontendController::class, 'register']);

// ================= LOGIN PPDB =================
Route::get('/ppdb/login', [\App\Http\Controllers\PpdbFrontendController::class, 'showLoginForm'])->name('ppdb.login');
Route::post('/ppdb/login', [\App\Http\Controllers\PpdbFrontendController::class, 'login']);
Route::post('/ppdb/logout', [\App\Http\Controllers\PpdbFrontendController::class, 'logout'])->name('ppdb.logout');

// ================= CEK STATUS PPDB =================
Route::get('/ppdb/cek-status', [\App\Http\Controllers\PpdbFrontendController::class, 'showCekStatus'])->name('ppdb.cek-status');
Route::post('/ppdb/cek-status', [\App\Http\Controllers\PpdbFrontendController::class, 'searchStatus'])->name('ppdb.cek-status.search');

// ================= CETAK BUKTI PPDB =================
Route::get('/ppdb/cetak-bukti', [\App\Http\Controllers\PpdbFrontendController::class, 'cetakBukti'])->name('ppdb.cetak-bukti');

// ================= DASHBOARD PPDB =================
Route::get('/ppdb/dashboard', [\App\Http\Controllers\PpdbFrontendController::class, 'dashboard'])->name('ppdb.dashboard');
Route::post('/ppdb/upload-document', [\App\Http\Controllers\PpdbFrontendController::class, 'uploadDocument'])->name('ppdb.upload-document');
Route::post('/ppdb/upload-payment', [\App\Http\Controllers\PpdbFrontendController::class, 'uploadPayment'])->name('ppdb.upload-payment');
Route::get('/ppdb/api/status', [\App\Http\Controllers\PpdbFrontendController::class, 'getStatusApi'])->name('ppdb.api.status');
/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
                
            // ========================
            // KEPEGAWAIAN
            // ========================
            Route::prefix('kepegawaian')->group(function () {
                Route::get('/data-guru', [\App\Http\Controllers\Admin\TeacherController::class, 'index'])->name('admin.kepegawaian.data-guru');
                Route::post('/data-guru', [\App\Http\Controllers\Admin\TeacherController::class, 'store'])->name('admin.kepegawaian.data-guru.store');
                Route::put('/data-guru/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'update'])->name('admin.kepegawaian.data-guru.update');
                Route::delete('/data-guru/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'destroy'])->name('admin.kepegawaian.data-guru.destroy');

                Route::get('/jadwal-mengajar', [\App\Http\Controllers\Admin\TeacherController::class, 'jadwalMengajar'])->name('admin.kepegawaian.jadwal-mengajar');

                // Arsip Kepegawaian
            Route::get('/arsip-kepegawaian', [\App\Http\Controllers\Admin\ArchiveController::class, 'index'])->name('admin.kepegawaian.arsip-kepegawaian');
            Route::put('/arsip/{id}/profil', [\App\Http\Controllers\Admin\ArchiveController::class, 'updateProfile'])->name('admin.kepegawaian.arsip.profil');
            Route::post('/arsip/{id}/dokumen', [\App\Http\Controllers\Admin\ArchiveController::class, 'storeDocument'])->name('admin.kepegawaian.arsip.dokumen');
            Route::delete('/arsip/dokumen/{id}', [\App\Http\Controllers\Admin\ArchiveController::class, 'destroyDocument'])->name('admin.kepegawaian.arsip.dokumen.destroy');
            Route::post('/arsip/{id}/riwayat', [\App\Http\Controllers\Admin\ArchiveController::class, 'storeHistory'])->name('admin.kepegawaian.arsip.riwayat');
            Route::delete('/arsip/riwayat/{id}', [\App\Http\Controllers\Admin\ArchiveController::class, 'destroyHistory'])->name('admin.kepegawaian.arsip.riwayat.destroy');
            Route::post('/arsip/{id}/sertifikasi', [\App\Http\Controllers\Admin\ArchiveController::class, 'storeCertification'])->name('admin.kepegawaian.arsip.sertifikasi');
            Route::delete('/arsip/sertifikasi/{id}', [\App\Http\Controllers\Admin\ArchiveController::class, 'destroyCertification'])->name('admin.kepegawaian.arsip.sertifikasi.destroy');
            });
        // ========================
        // ABSENSI
        // ========================
        Route::prefix('absensi')->group(function () {
            Route::get('/siswa', [\App\Http\Controllers\Admin\AdminAbsensiController::class, 'absensiSiswa'])->name('admin.absensi.siswa');
            Route::get('/guru', [\App\Http\Controllers\Admin\AdminAbsensiController::class, 'absensiGuru'])->name('admin.absensi.guru');
            Route::get('/rekap', [\App\Http\Controllers\Admin\AdminAbsensiController::class, 'rekapAbsensi'])->name('admin.absensi.rekap');
            Route::get('/izin-sakit-alpha', [\App\Http\Controllers\Admin\AdminAbsensiController::class, 'izinSakitAlpha'])->name('admin.absensi.izin-sakit-alpha');
        });
    // ========================
    // AKADEMIK
    // ========================
    Route::prefix('akademik')->group(function () {
        Route::get('/jadwal-pelajaran', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('admin.akademik.jadwal-pelajaran');
        Route::post('/jadwal-pelajaran', [\App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('admin.akademik.jadwal-pelajaran.store');
        Route::put('/jadwal-pelajaran/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('admin.akademik.jadwal-pelajaran.update');
        Route::delete('/jadwal-pelajaran/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('admin.akademik.jadwal-pelajaran.destroy');

        Route::get('/penilaian', [\App\Http\Controllers\Admin\AdminAkademikController::class, 'penilaian'])->name('admin.akademik.penilaian');
        Route::get('/rapor', [\App\Http\Controllers\Admin\AdminAkademikController::class, 'rapor'])->name('admin.akademik.rapor');

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
        Route::get('/event', [\App\Http\Controllers\Admin\KegiatanController::class, 'eventIndex'])->name('admin.kegiatan.event.index');
        Route::post('/event', [\App\Http\Controllers\Admin\KegiatanController::class, 'eventStore'])->name('admin.kegiatan.event.store');
        Route::put('/event/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'eventUpdate'])->name('admin.kegiatan.event.update');
        Route::delete('/event/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'eventDestroy'])->name('admin.kegiatan.event.destroy');

        // Agenda
        Route::get('/agenda', [\App\Http\Controllers\Admin\KegiatanController::class, 'agendaIndex'])->name('admin.kegiatan.agenda.index');
        Route::post('/agenda', [\App\Http\Controllers\Admin\KegiatanController::class, 'agendaStore'])->name('admin.kegiatan.agenda.store');
        Route::put('/agenda/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'agendaUpdate'])->name('admin.kegiatan.agenda.update');
        Route::delete('/agenda/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'agendaDestroy'])->name('admin.kegiatan.agenda.destroy');

        // Dokumentasi
        Route::get('/dokumentasi', [\App\Http\Controllers\Admin\KegiatanController::class, 'dokumentasiIndex'])->name('admin.kegiatan.dokumentasi.index');
        Route::post('/dokumentasi', [\App\Http\Controllers\Admin\KegiatanController::class, 'dokumentasiStore'])->name('admin.kegiatan.dokumentasi.store');
        Route::put('/dokumentasi/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'dokumentasiUpdate'])->name('admin.kegiatan.dokumentasi.update');
        Route::delete('/dokumentasi/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'dokumentasiDestroy'])->name('admin.kegiatan.dokumentasi.destroy');

        // Pengumuman
        Route::get('/pengumuman', [\App\Http\Controllers\Admin\KegiatanController::class, 'pengumumanIndex'])->name('admin.kegiatan.pengumuman.index');
        Route::post('/pengumuman', [\App\Http\Controllers\Admin\KegiatanController::class, 'pengumumanStore'])->name('admin.kegiatan.pengumuman.store');
        Route::put('/pengumuman/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'pengumumanUpdate'])->name('admin.kegiatan.pengumuman.update');
        Route::delete('/pengumuman/{id}', [\App\Http\Controllers\Admin\KegiatanController::class, 'pengumumanDestroy'])->name('admin.kegiatan.pengumuman.destroy');
    });
    // ========================
    // PPDB (ADMIN)
    // ========================
    Route::prefix('ppdb')->group(function () {
        Route::get('/data-pendaftar', [\App\Http\Controllers\Admin\PpdbController::class, 'dataPendaftar'])->name('admin.ppdb.data-pendaftar');
        Route::post('/data-pendaftar', [\App\Http\Controllers\Admin\PpdbController::class, 'store'])->name('admin.ppdb.store');
        Route::put('/data-pendaftar/{id}/status', [\App\Http\Controllers\Admin\PpdbController::class, 'updateStatus'])->name('admin.ppdb.update-status');
        Route::delete('/data-pendaftar/{id}', [\App\Http\Controllers\Admin\PpdbController::class, 'destroy'])->name('admin.ppdb.destroy');

        Route::get('/verifikasi-berkas', [\App\Http\Controllers\Admin\PpdbController::class, 'verifikasiBerkas'])->name('admin.ppdb.verifikasi-berkas');
        Route::put('/verifikasi-berkas/{id}', [\App\Http\Controllers\Admin\PpdbController::class, 'updateBerkas'])->name('admin.ppdb.update-berkas');

        Route::get('/seleksi', [\App\Http\Controllers\Admin\PpdbController::class, 'seleksi'])->name('admin.ppdb.seleksi');
        Route::put('/seleksi/{id}', [\App\Http\Controllers\Admin\PpdbController::class, 'updateSeleksi'])->name('admin.ppdb.update-seleksi');

        Route::get('/pembayaran', [\App\Http\Controllers\Admin\PpdbController::class, 'pembayaran'])->name('admin.ppdb.pembayaran');
        Route::put('/pembayaran/{id}', [\App\Http\Controllers\Admin\PpdbController::class, 'updatePembayaran'])->name('admin.ppdb.update-pembayaran');
    });
    // ========================
    // LAPORAN
    // ========================
    Route::prefix('laporan')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/absensi', [\App\Http\Controllers\Admin\LaporanController::class, 'absensi'])->name('admin.laporan.absensi');
        Route::get('/akademik', [\App\Http\Controllers\Admin\LaporanController::class, 'akademik'])->name('admin.laporan.akademik');
        Route::get('/keuangan', [\App\Http\Controllers\Admin\LaporanController::class, 'keuangan'])->name('admin.laporan.keuangan');
        Route::get('/ppdb', [\App\Http\Controllers\Admin\LaporanController::class, 'ppdb'])->name('admin.laporan.ppdb');
        Route::get('/kegiatan', [\App\Http\Controllers\Admin\LaporanController::class, 'kegiatan'])->name('admin.laporan.kegiatan');
    });
});

// ========================
// GURU AREA
// ========================
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\GuruController::class, 'dashboard'])->name('dashboard');

    // Akademik
    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::get('/mata-pelajaran', [\App\Http\Controllers\GuruController::class, 'mataPelajaran'])->name('mata-pelajaran');
        // Route::post('/mata-pelajaran', [\App\Http\Controllers\GuruController::class, 'storeMataPelajaran'])->name('mata-pelajaran.store');
        // Route::put('/mata-pelajaran/{id}', [\App\Http\Controllers\GuruController::class, 'updateMataPelajaran'])->name('mata-pelajaran.update');
        // Route::delete('/mata-pelajaran/{id}', [\App\Http\Controllers\GuruController::class, 'destroyMataPelajaran'])->name('mata-pelajaran.destroy');

        Route::get('/jadwal-mengajar', [\App\Http\Controllers\GuruController::class, 'jadwalMengajar'])->name('jadwal-mengajar');
        Route::post('/jadwal-mengajar', [\App\Http\Controllers\GuruController::class, 'storeSchedule'])->name('jadwal-mengajar.store');
        Route::put('/jadwal-mengajar/{id}', [\App\Http\Controllers\GuruController::class, 'updateSchedule'])->name('jadwal-mengajar.update');
        Route::delete('/jadwal-mengajar/{id}', [\App\Http\Controllers\GuruController::class, 'destroySchedule'])->name('jadwal-mengajar.destroy');
        Route::get('/kelas-siswa', [\App\Http\Controllers\GuruController::class, 'kelasSiswa'])->name('kelas');
        
        // Student Management (Only Update Catatan remains)
        Route::post('/siswa/update-catatan/{id}', [\App\Http\Controllers\GuruController::class, 'updateStudentNote'])->name('siswa.update-catatan');
        
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
        Route::post('/absensi-pertemuan', [\App\Http\Controllers\GuruController::class, 'storeAbsensi'])->name('pertemuan.store');
        Route::get('/izin-sakit-alpha', [\App\Http\Controllers\GuruController::class, 'absensiIzinSakitAlpha'])->name('izin');
        Route::get('/rekap-absensi', [\App\Http\Controllers\GuruController::class, 'absensiRekap'])->name('rekap');
        
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
        Route::get('/feedback', [\App\Http\Controllers\GuruController::class, 'feedbackIndex'])->name('tugas.feedback');
    });

    // Kegiatan (masih statis)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/agenda', [\App\Http\Controllers\GuruController::class, 'kegiatanAgenda'])->name('agenda');
        Route::get('/event', [\App\Http\Controllers\GuruController::class, 'kegiatanEvent'])->name('event');
        Route::get('/pengumuman', [\App\Http\Controllers\GuruController::class, 'kegiatanPengumuman'])->name('pengumuman');
    });

    // Profil (Dinamis)
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/biodata', [\App\Http\Controllers\GuruController::class, 'profilBiodata'])->name('biodata');
        Route::get('/riwayat-mengajar', [\App\Http\Controllers\GuruController::class, 'profilRiwayat'])->name('riwayat');
        Route::get('/arsip-dokumen', [\App\Http\Controllers\GuruController::class, 'profilArsip'])->name('arsip');
        Route::post('/arsip-dokumen', [\App\Http\Controllers\GuruController::class, 'storeArsip'])->name('arsip.store');
        Route::delete('/arsip-dokumen/{id}', [\App\Http\Controllers\GuruController::class, 'destroyArsip'])->name('arsip.destroy');
        Route::get('/ganti-password', [\App\Http\Controllers\GuruController::class, 'profilPassword'])->name('password');
        Route::post('/ganti-password', [\App\Http\Controllers\GuruController::class, 'updatePassword'])->name('password.update');
    });

    // ========================
    // E-LEARNING (GURU)
    // ========================
    Route::prefix('elearning')->name('elearning.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ElearningGuruController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\ElearningGuruController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\ElearningGuruController::class, 'show'])->name('show');
        Route::put('/{id}', [\App\Http\Controllers\ElearningGuruController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\ElearningGuruController::class, 'destroy'])->name('destroy');

        // Soal pretest/posttest
        Route::post('/{sessionId}/soal', [\App\Http\Controllers\ElearningGuruController::class, 'storeQuestion'])->name('soal.store');
        Route::delete('/{sessionId}/soal/{questionId}', [\App\Http\Controllers\ElearningGuruController::class, 'destroyQuestion'])->name('soal.destroy');

        // Materi/Link Pembelajaran
        Route::post('/{sessionId}/materi', [\App\Http\Controllers\ElearningGuruController::class, 'storeMaterial'])->name('materi.store');
        Route::delete('/{sessionId}/materi/{materialId}', [\App\Http\Controllers\ElearningGuruController::class, 'destroyMaterial'])->name('materi.destroy');

        // Penugasan
        Route::post('/{sessionId}/tugas', [\App\Http\Controllers\ElearningGuruController::class, 'storeAssignment'])->name('tugas.store');
        Route::put('/submission/{submissionId}/grade', [\App\Http\Controllers\ElearningGuruController::class, 'gradeSubmission'])->name('submission.grade');

        // Diskusi
        Route::post('/{sessionId}/diskusi', [\App\Http\Controllers\ElearningGuruController::class, 'storeDiscussion'])->name('diskusi.store');
        Route::delete('/{sessionId}/diskusi/{discussionId}', [\App\Http\Controllers\ElearningGuruController::class, 'destroyDiscussion'])->name('diskusi.destroy');
    });
});

    // ========================
    // ORANG TUA AREA
    // ========================
    Route::middleware(['auth', 'role:orangtua'])->prefix('orangtua')->group(function () {
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
            Route::post('/izin', [\App\Http\Controllers\OrangtuaController::class, 'storeIzin'])->name('orangtua.absensi.izin.store');
            Route::get('/rekap', [\App\Http\Controllers\OrangtuaController::class, 'absensiRekap'])->name('orangtua.absensi.rekap');
        });

        // Keuangan
        Route::prefix('keuangan')->group(function () {
            Route::get('/tagihan', [\App\Http\Controllers\OrangtuaController::class, 'keuanganTagihan'])->name('orangtua.keuangan.tagihan');
            Route::get('/riwayat', [\App\Http\Controllers\OrangtuaController::class, 'keuanganRiwayat'])->name('orangtua.keuangan.riwayat');
            Route::get('/bukti', [\App\Http\Controllers\OrangtuaController::class, 'keuanganBukti'])->name('orangtua.keuangan.bukti');
            Route::post('/bukti', [\App\Http\Controllers\OrangtuaController::class, 'storeBukti'])->name('orangtua.keuangan.bukti.store');
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
    Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
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
            Route::post('/izin', [\App\Http\Controllers\SiswaController::class, 'storeIzin'])->name('siswa.kehadiran.izin.store');
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



        // Profil
        Route::prefix('profil')->group(function () {
            Route::get('/biodata', [\App\Http\Controllers\SiswaController::class, 'profilBiodata'])->name('siswa.profil.biodata');
            Route::get('/orangtua', [\App\Http\Controllers\SiswaController::class, 'profilOrangtua'])->name('siswa.profil.orangtua');
            Route::get('/password', [\App\Http\Controllers\SiswaController::class, 'profilPassword'])->name('siswa.profil.password');
        });

        // ========================
        // E-LEARNING (SISWA)
        // ========================
        Route::prefix('elearning')->group(function () {
            Route::get('/', [\App\Http\Controllers\ElearningSiswaController::class, 'index'])->name('siswa.elearning.index');
            Route::get('/{id}', [\App\Http\Controllers\ElearningSiswaController::class, 'show'])->name('siswa.elearning.show');

            // Pretest
            Route::get('/{id}/pretest', [\App\Http\Controllers\ElearningSiswaController::class, 'showPretest'])->name('siswa.elearning.pretest');
            Route::post('/{id}/pretest', [\App\Http\Controllers\ElearningSiswaController::class, 'submitPretest'])->name('siswa.elearning.pretest.submit');

            // Posttest
            Route::get('/{id}/posttest', [\App\Http\Controllers\ElearningSiswaController::class, 'showPosttest'])->name('siswa.elearning.posttest');
            Route::post('/{id}/posttest', [\App\Http\Controllers\ElearningSiswaController::class, 'submitPosttest'])->name('siswa.elearning.posttest.submit');

            // Hasil
            Route::get('/{id}/hasil/{tipe}', [\App\Http\Controllers\ElearningSiswaController::class, 'hasil'])->name('siswa.elearning.hasil');

            // Upload Tugas
            Route::post('/{sessionId}/submission', [\App\Http\Controllers\ElearningSiswaController::class, 'storeSubmission'])->name('siswa.elearning.submission.store');

            // Forum Diskusi
            Route::post('/{sessionId}/diskusi', [\App\Http\Controllers\ElearningSiswaController::class, 'storeDiscussion'])->name('siswa.elearning.diskusi.store');
        });
    });



// ========================
// KEUANGAN AREA
// ========================
Route::middleware(['auth', 'role:keuangan,admin'])->prefix('keuangan')->group(function () {
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

