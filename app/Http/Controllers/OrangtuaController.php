<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ParentProfile;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\SppBill;
use App\Models\Transaction;
use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\Schedule;
use App\Models\Event;

class OrangtuaController extends Controller
{
    // Mock user session fetching for Parent
    private function getStudent() {
        return Student::first(); // Assuming the parent is viewing their first child
    }

    public function monitoringPresensi()
    {
        $student = $this->getStudent();
        $kehadiran = [
            'hadir' => Attendance::where('student_id', $student->id)->where('status', 'Hadir')->count() * 10,
            'sakit' => Attendance::where('student_id', $student->id)->where('status', 'Sakit')->count(),
            'izin'  => Attendance::where('student_id', $student->id)->where('status', 'Izin')->count(),
            'alpha' => Attendance::where('student_id', $student->id)->where('status', 'Alpha')->count(),
        ];
        return view('orangtua.monitoring.presensi', compact('kehadiran'));
    }

    public function monitoringNilai()
    {
        $student = $this->getStudent();
        $nilai = Grade::where('student_id', $student->id)->with('subject')->get();
        return view('orangtua.monitoring.nilai', compact('nilai'));
    }

    public function monitoringSpp()
    {
        $student = $this->getStudent();
        $tagihan = SppBill::where('student_id', $student->id)->get();
        return view('orangtua.monitoring.spp', compact('tagihan'));
    }

    // Monitoring Akademik
    public function akademikTugas()
    {
        $student = $this->getStudent();
        $tugas = StudentAssignment::where('student_id', $student->id)->with('assignment.subject')->get();
        return view('orangtua.akademik.tugas', compact('tugas'));
    }

    public function akademikRapor()
    {
        $student = $this->getStudent();
        $rapor = Grade::where('student_id', $student->id)->with('subject')->get();
        return view('orangtua.akademik.rapor', compact('rapor'));
    }

    public function akademikJadwal()
    {
        $student = $this->getStudent();
        $jadwal = Schedule::where('kelas', $student->kelas)->with('subject.teacher')->get();
        return view('orangtua.akademik.jadwal', compact('jadwal'));
    }

    // Absensi Anak
    public function absensiRiwayat()
    {
        $student = $this->getStudent();
        $riwayat = Attendance::where('student_id', $student->id)->orderByDesc('tanggal')->get();
        return view('orangtua.absensi.riwayat', compact('riwayat'));
    }

    public function absensiIzin()
    {
        return view('orangtua.absensi.izin');
    }

    public function absensiRekap()
    {
        return view('orangtua.absensi.rekap');
    }

    // Keuangan
    public function keuanganTagihan()
    {
        $student = $this->getStudent();
        $tagihan = SppBill::where('student_id', $student->id)->get();
        return view('orangtua.keuangan.tagihan', compact('tagihan'));
    }

    public function keuanganRiwayat()
    {
        $student = $this->getStudent();
        $riwayat = Transaction::where('transactionable_type', SppBill::class)
            ->whereHasMorph('transactionable', [SppBill::class], function($q) use($student){
                $q->where('student_id', $student->id);
            })->get();
        return view('orangtua.keuangan.riwayat', compact('riwayat'));
    }

    public function keuanganBukti()
    {
        return view('orangtua.keuangan.bukti');
    }

    // Kegiatan & Info
    public function kegiatanAgenda()
    {
        $agenda = Event::where('tipe_info', 'Agenda')->get();
        return view('orangtua.kegiatan.agenda', compact('agenda'));
    }

    public function kegiatanEvent()
    {
        $events = Event::where('tipe_info', 'Event')->get();
        return view('orangtua.kegiatan.event', compact('events'));
    }

    public function kegiatanPengumuman()
    {
        $pengumuman = Event::where('tipe_info', 'Pengumuman')->get();
        return view('orangtua.kegiatan.pengumuman', compact('pengumuman'));
    }

    // Profil Orang Tua
    public function profilDataDiri()
    {
        $student = $this->getStudent();
        $profil = $student->parentProfile;
        return view('orangtua.profil.datadiri', compact('profil'));
    }

    public function profilDataAnak()
    {
        $student = $this->getStudent();
        return view('orangtua.profil.dataanak', compact('student'));
    }

    public function profilPassword()
    {
        return view('orangtua.profil.password');
    }
}
