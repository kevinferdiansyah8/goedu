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
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrangtuaController extends Controller
{
    private function getStudent() {
        $parent = Auth::user() ? Auth::user()->parent : null;
        return $parent ? $parent->student : Student::first();
    }

    public function monitoringPresensi()
    {
        $student = $this->getStudent();
        
        $hadir = Attendance::where('student_id', $student->id)->where('status', 'Hadir')->count();
        $sakit = Attendance::where('student_id', $student->id)->where('status', 'Sakit')->count();
        $izin = Attendance::where('student_id', $student->id)->where('status', 'Izin')->count();
        $alpha = Attendance::where('student_id', $student->id)->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
        $total = $hadir + $sakit + $izin + $alpha;
        
        $kehadiran = [
            'hadir' => $total > 0 ? round(($hadir / $total) * 100) : 100,
            'sakit' => $sakit,
            'izin'  => $izin,
            'alpha' => $alpha,
            'total' => $total,
            'count_hadir' => $hadir
        ];

        $riwayat = Attendance::where('student_id', $student->id)->orderByDesc('tanggal')->get();

        return view('orangtua.monitoring.presensi', compact('kehadiran', 'riwayat', 'student'));
    }

    public function monitoringNilai()
    {
        $student = $this->getStudent();
        $nilai = Grade::where('student_id', $student->id)->with('subject')->get();
        return view('orangtua.monitoring.nilai', compact('nilai', 'student'));
    }

    public function monitoringSpp()
    {
        $student = $this->getStudent();
        $tagihan = SppBill::where('student_id', $student->id)->orderByDesc('id')->get();
        $activeMonthBill = $tagihan->first();
        return view('orangtua.monitoring.spp', compact('tagihan', 'activeMonthBill', 'student'));
    }

    // Monitoring Akademik
    public function akademikTugas()
    {
        $student = $this->getStudent();
        $classId = $student->school_class_id;
        $tingkat = $student->schoolClass->tingkat ?? ($student->kelas ? (preg_match('/\d+/', $student->kelas, $m) ? $m[0] : null) : null);

        $query = Assignment::with('subject');
        if ($classId) {
            $query->where(function($q) use ($classId, $tingkat) {
                $q->where('school_class_id', $classId);
                if ($tingkat) {
                    $q->orWhereHas('subject', function($sq) use ($tingkat) {
                        $sq->where('tingkat', $tingkat);
                    });
                }
            });
        } elseif ($tingkat) {
            $query->whereHas('subject', function($sq) use ($tingkat) {
                $sq->where('tingkat', $tingkat);
            });
        }

        $tugas = $query->orderByDesc('created_at')->get()->map(function($t) use($student) {
            $sa = StudentAssignment::where('student_id', $student->id)->where('assignment_id', $t->id)->first();
            $status = 'Belum';
            if ($sa) {
                if ($sa->nilai !== null) {
                    $status = 'Selesai';
                } else {
                    $status = $sa->status ?? 'Terkumpul';
                }
            }
            return [
                'mapel' => $t->subject->nama_pelajaran ?? $t->subject->nama ?? 'Mata Pelajaran',
                'judul' => $t->judul,
                'deadline' => $t->deadline,
                'status' => $status,
                'deskripsi' => $t->deskripsi,
                'nilai' => ($sa && $sa->nilai !== null) ? $sa->nilai : '-',
                'feedback' => ($sa && $sa->catatan_guru) ? $sa->catatan_guru : (($sa && $sa->nilai !== null) ? 'Tugas diperiksa dengan baik. Pertahankan!' : '-')
            ];
        });

        return view('orangtua.akademik.tugas', compact('tugas', 'student'));
    }

    public function akademikRapor()
    {
        $student = $this->getStudent();
        $rapor = Grade::where('student_id', $student->id)->with('subject')->get();
        return view('orangtua.akademik.rapor', compact('rapor', 'student'));
    }

    public function akademikJadwal(Request $request)
    {
        $student = $this->getStudent();
        $classId = $student->school_class_id ?? null;
        $className = $student->kelas ?? '';

        $query = Schedule::with('subject.teacher');
        if ($classId && $className) {
            $query->where(function($q) use ($classId, $className) {
                $q->where('school_class_id', $classId)->orWhere('kelas', 'like', "%{$className}%");
            });
        } elseif ($classId) {
            $query->where('school_class_id', $classId);
        } elseif ($className) {
            $query->where('kelas', 'like', "%{$className}%");
        }

        $allJadwal = $query->get();
        $selectedHari = $request->input('hari', 'Senin');
        $jadwalHariIni = $allJadwal->filter(fn($j) => strtolower($j->hari) === strtolower($selectedHari));

        return view('orangtua.akademik.jadwal', compact('allJadwal', 'jadwalHariIni', 'selectedHari', 'student'));
    }

    // Absensi Anak
    public function absensiRiwayat()
    {
        $student = $this->getStudent();
        $riwayat = Attendance::where('student_id', $student->id)->orderByDesc('tanggal')->get();
        return view('orangtua.absensi.riwayat', compact('riwayat', 'student'));
    }

    public function storeAbsensiComment(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'catatan_orangtua' => 'required|string|max:1000'
        ]);

        $student = $this->getStudent();
        $attendance = Attendance::where('id', $request->attendance_id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        $attendance->update([
            'catatan_orangtua' => $request->catatan_orangtua
        ]);

        return redirect()->back()->with('success', 'Catatan / Alasan orang tua berhasil disimpan!');
    }

    public function absensiIzin()
    {
        $student = $this->getStudent();
        
        $izinSakit = Attendance::where('student_id', $student->id)
            ->whereIn('status', ['Izin', 'Sakit'])
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function($a) {
                return [
                    'tanggal_pengajuan' => date('d M Y', strtotime($a->created_at ?? $a->tanggal)),
                    'kategori' => $a->status,
                    'mulai_tanggal' => date('d M Y', strtotime($a->tanggal)),
                    'sampai_tanggal' => date('d M Y', strtotime($a->tanggal)),
                    'keterangan' => $a->keterangan ?? '-',
                    'bukti' => '-',
                    'status' => 'Disetujui',
                ];
            });
            
        return view('orangtua.absensi.izin', compact('izinSakit'));
    }

    public function storeIzin(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Izin,Sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string'
        ]);

        $student = $this->getStudent();

        $mulai = \Carbon\Carbon::parse($request->tanggal_mulai);
        $selesai = \Carbon\Carbon::parse($request->tanggal_selesai);
        $diffDays = $mulai->diffInDays($selesai);
        
        for ($i = 0; $i <= $diffDays; $i++) {
            $tgl = $mulai->copy()->addDays($i)->format('Y-m-d');
            \App\Models\Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'tanggal' => $tgl,
                ],
                [
                    'status' => $request->jenis,
                    'keterangan' => $request->keterangan,
                ]
            );
        }

        return redirect()->back()->with('success', 'Pengajuan izin/sakit berhasil dikirim.');
    }

    public function absensiRekap(Request $request)
    {
        $student = $this->getStudent();
        
        // Month list for dropdown
        $bulanList = Attendance::where('student_id', $student->id)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as yyyy_mm")
            ->distinct()
            ->orderBy('yyyy_mm', 'desc')
            ->pluck('yyyy_mm')
            ->toArray();
            
        // If empty, default to current month
        if (empty($bulanList)) {
            $bulanList[] = date('Y-m');
        }
        
        $selectedBulan = $request->input('bulan', $bulanList[0]);
        
        // Query summary for chosen month
        $attendances = Attendance::where('student_id', $student->id)
            ->where('tanggal', 'like', $selectedBulan . '%')
            ->get();
            
        $hadir = $attendances->where('status', 'Hadir')->count();
        $sakit = $attendances->where('status', 'Sakit')->count();
        $izin = $attendances->where('status', 'Izin')->count();
        $alpha = $attendances->whereIn('status', ['Alpha', 'Tanpa Keterangan'])->count();
        
        // Month name mapping
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $parts = explode('-', $selectedBulan);
        $selectedBulanName = ($months[$parts[1]] ?? 'Bulan') . ' ' . $parts[0];
        
        $dropdownOptions = [];
        foreach ($bulanList as $bl) {
            $blParts = explode('-', $bl);
            $dropdownOptions[$bl] = ($months[$blParts[1]] ?? 'Bulan') . ' ' . $blParts[0];
        }
        
        return view('orangtua.absensi.rekap', compact('student', 'dropdownOptions', 'selectedBulan', 'selectedBulanName', 'hadir', 'sakit', 'izin', 'alpha'));
    }

    // Keuangan
    public function keuanganTagihan()
    {
        $student = $this->getStudent();
        $tagihan_aktif = SppBill::where('student_id', $student->id)->where('status', '!=', 'Lunas')->get()->map(function($t) {
            $date = $t->created_at ?? now();
            $isOverdue = Carbon::parse($date)->addDays(10)->isPast(); // 10 days grace period
            return [
                'bulan' => $t->bulan,
                'jatuh_tempo' => Carbon::parse($date)->addDays(10)->translatedFormat('d F Y'),
                'nominal' => $t->nominal,
                'status' => $isOverdue ? 'Terlambat' : 'Belum Bayar',
                'denda' => $isOverdue ? 25000 : 0
            ];
        })->toArray();
        
        $riwayat_bayar = Transaction::whereHasMorph(
            'transactionable',
            [SppBill::class],
            function ($q) use ($student) {
                $q->where('student_id', $student->id);
            }
        )
            ->where('status', 'Terverifikasi')
            ->with('transactionable')
            ->latest()
            ->get()
            ->map(function($t) {
                return [
                    'bulan' => $t->transactionable->bulan ?? 'SPP',
                    'tanggal_bayar' => Carbon::parse($t->tanggal ?? $t->created_at)->translatedFormat('d M Y'),
                    'nominal' => $t->nominal,
                    'metode' => $t->metode,
                    'status' => 'Lunas'
                ];
            })->toArray();
            
        // Mock removed for real dynamic data
        $class = $student->schoolClass;
        $className = $class ? ($class->nama_display ?? $class->nama_lengkap) : ($student->kelas ?? 'Unknown');

        $anak = [
            'nama' => $student->nama, 
            'nis' => $student->nis, 
            'kelas' => $className, 
            'semester' => 'Genap ' . date('Y') . '/' . (date('Y') + 1)
        ];
        
        return view('orangtua.keuangan.tagihan', compact('tagihan_aktif', 'riwayat_bayar', 'anak'));
    }

    public function keuanganRiwayat()
    {
        $student = $this->getStudent();
        $riwayat = Transaction::whereHasMorph(
            'transactionable',
            [SppBill::class],
            function ($q) use ($student) {
                $q->where('student_id', $student->id);
            }
        )
            ->orderByDesc('tanggal')
            ->get();
        return view('orangtua.keuangan.riwayat', compact('riwayat'));
    }

    public function keuanganBukti()
    {
        $student = $this->getStudent();
        $tagihanOptions = SppBill::where('student_id', $student->id)->where('status', '!=', 'Lunas')->get();
        return view('orangtua.keuangan.bukti', compact('tagihanOptions'));
    }

    public function storeBukti(Request $request)
    {
        $request->validate([
            'spp_bill_id' => 'required|exists:spp_bills,id',
            'tanggal_transfer' => 'required|date',
            'nominal' => 'required|numeric|min:1',
            'metode' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        $bill = SppBill::findOrFail($request->spp_bill_id);
        
        $file = $request->file('file');
        $fileName = 'spp_' . $bill->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('bukti_spp', $fileName, 'public');
        
        Transaction::create([
            'tanggal' => $request->tanggal_transfer,
            'keterangan' => 'Pembayaran SPP ' . $bill->bulan . ' - ' . optional($bill->student)->nama,
            'jenis' => 'Masuk',
            'nominal' => $request->nominal,
            'metode' => $request->input('metode', 'Transfer Bank Mandiri'),
            'bukti' => $filePath,
            'status' => 'Pending',
            'transactionable_type' => SppBill::class,
            'transactionable_id' => $bill->id
        ]);
        
        return redirect()->route('orangtua.keuangan.riwayat')->with('success', 'Bukti pembayaran berhasil diunggah! Mohon menunggu verifikasi staf Keuangan.');
    }

    // Kegiatan & Info
    public function kegiatanAgenda()
    {
        $agenda = Event::where('tipe_info', 'Agenda')->latest()->get();
        return view('orangtua.kegiatan.agenda', compact('agenda'));
    }

    public function kegiatanEvent()
    {
        $events = Event::where('tipe_info', 'Event')->latest()->get();
        return view('orangtua.kegiatan.event', compact('events'));
    }

    public function kegiatanPengumuman()
    {
        $pengumuman = Event::where('tipe_info', 'Pengumuman')->latest()->get();
        return view('orangtua.kegiatan.pengumuman', compact('pengumuman'));
    }

    // Profil Orang Tua
    public function profilDataDiri()
    {
        $user = Auth::user();
        $student = $this->getStudent();
        $profil = ParentProfile::where('user_id', $user->id)->first();
        if (!$profil && $student) {
            $profil = ParentProfile::where('student_id', $student->id)->first();
        }

        return view('orangtua.profil.datadiri', compact('user', 'profil', 'student'));
    }

    public function updateDataDiri(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'telepon_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_ibu' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $student = $this->getStudent();
        ParentProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'student_id' => $student->id ?? null,
                'nama_ayah' => $request->nama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'telepon_ayah' => $request->telepon_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'telepon_ibu' => $request->telepon_ibu,
                'alamat' => $request->alamat,
            ]
        );

        return redirect()->back()->with('success', 'Data diri orang tua berhasil diperbarui!');
    }

    public function profilDataAnak()
    {
        $user = Auth::user();
        $students = collect();
        if ($user && $user->role === 'orangtua') {
            $parentProfiles = ParentProfile::where('user_id', $user->id)->with('student.schoolClass.teacher')->get();
            $students = $parentProfiles->map(fn($pp) => $pp->student)->filter();
        }
        
        if ($students->isEmpty()) {
            $students = Student::with('schoolClass.teacher')->take(1)->get();
        }

        return view('orangtua.profil.dataanak', compact('students'));
    }

    public function profilPassword()
    {
        return view('orangtua.profil.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }
}
