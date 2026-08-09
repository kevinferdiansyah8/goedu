<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SppBill;
use App\Models\PpdbSetting;
use App\Models\PpdbApplicant;
use App\Models\Transaction;

class KeuanganController extends Controller
{
    public function index()
    {
        $todayStr = date('Y-m-d');
        $currentYear = date('Y');
        
        $stats = [
            'total_pemasukan' => Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->sum('nominal'),
            'total_tunggakan' => SppBill::where('status', '!=', 'Lunas')->sum('nominal') + PpdbApplicant::where('status', '!=', 'Lunas')->sum('nominal'),
            'pembayaran_hari_ini' => Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->where('tanggal', $todayStr)->sum('nominal'),
            'siswa_belum_bayar' => SppBill::where('status', 'Belum Bayar')->distinct('student_id')->count('student_id'),
        ];
        
        if ($stats['pembayaran_hari_ini'] == 0) {
            $stats['pembayaran_hari_ini'] = Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->latest()->value('nominal') ?: 350000;
        }

        // Aggregate monthly income/expenses
        $pemasukan_bulanan = [];
        $pengeluaran_bulanan = [];
        $bulan_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($m = 1; $m <= 12; $m++) {
            $monthStr = $currentYear . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
            $pemasukan_bulanan[] = Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->where('tanggal', 'like', $monthStr . '%')->sum('nominal');
            $pengeluaran_bulanan[] = Transaction::where('jenis', 'Keluar')->where('tanggal', 'like', $monthStr . '%')->sum('nominal');
        }
        
        // Calculate dynamic source percentages
        $totalSpp = Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->where(function($q) {
            $q->where('transactionable_type', SppBill::class)->orWhere('keterangan', 'like', '%SPP%');
        })->sum('nominal');

        $totalPpdb = Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->where(function($q) {
            $q->where('transactionable_type', PpdbApplicant::class)->orWhere('keterangan', 'like', '%PPDB%');
        })->sum('nominal');

        $totalAll = $totalSpp + $totalPpdb;
        
        if ($totalAll > 0) {
            $sppPct = round(($totalSpp / $totalAll) * 100);
            $ppdbPct = 100 - $sppPct;
            $sumber_pemasukan = [
                'labels' => ['SPP', 'PPDB', 'Uang Gedung', 'Lainnya'],
                'data' => [$sppPct, $ppdbPct, 0, 0],
            ];
        } else {
            $sumber_pemasukan = [
                'labels' => ['SPP', 'PPDB', 'Uang Gedung', 'Lainnya'],
                'data' => [70, 30, 0, 0],
            ];
        }

        return view('keuangan.dashboard.index', compact('stats', 'pemasukan_bulanan', 'pengeluaran_bulanan', 'bulan_labels', 'sumber_pemasukan'));
    }

    private function getIndonesianMonthYear($date = null)
    {
        $d = $date ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::now();
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $months[(int)$d->format('n')] . ' ' . $d->format('Y');
    }

    private function ensureCurrentMonthBillsExist()
    {
        $currentMonth = $this->getIndonesianMonthYear();
        $students = Student::all();

        foreach ($students as $student) {
            SppBill::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'bulan' => $currentMonth,
                ],
                [
                    'nominal' => 350000,
                    'status' => 'Belum Bayar',
                ]
            );
        }
    }

    private function sortIndonesianMonths($monthList)
    {
        $monthMap = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
        ];

        return collect($monthList)->sort(function ($a, $b) use ($monthMap) {
            $partsA = explode(' ', strtolower(trim($a)));
            $partsB = explode(' ', strtolower(trim($b)));

            $yearA = (int)($partsA[1] ?? 2026);
            $yearB = (int)($partsB[1] ?? 2026);

            if ($yearA !== $yearB) {
                return $yearB <=> $yearA; // Descending year
            }

            $mA = $monthMap[$partsA[0] ?? ''] ?? 1;
            $mB = $monthMap[$partsB[0] ?? ''] ?? 1;

            return $mB <=> $mA; // Descending month
        })->values();
    }

    public function tagihanSpp(Request $request)
    {
        // Auto-generate current month's bills if missing
        $this->ensureCurrentMonthBillsExist();

        $kelasFilter = $request->input('kelas');
        $bulanFilter = $request->input('bulan');
        $statusFilter = $request->input('status');
        $search = $request->input('search');

        $query = SppBill::with('student')->orderByDesc('id');

        if ($kelasFilter) {
            $query->whereHas('student', function ($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter);
            });
        }

        if ($bulanFilter) {
            $query->where('bulan', $bulanFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('student', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%{$search}%")->orWhere('nis', 'like', "%{$search}%");
                })->orWhere('bulan', 'like', "%{$search}%");
            });
        }

        $allBills = SppBill::all();
        $totalLunas = $allBills->where('status', 'Lunas')->count();
        $totalBelumBayar = $allBills->where('status', 'Belum Bayar')->count();
        $totalCicilan = $allBills->where('status', 'Cicilan')->count();

        // Dynamic classes
        $availableClasses = Student::whereNotNull('kelas')->distinct()->pluck('kelas')->sort()->values();
        if ($availableClasses->isEmpty()) {
            $availableClasses = collect(['10', '11', '12']);
        }

        // Dynamic sorted months (Newest first)
        $rawMonths = SppBill::distinct()->pluck('bulan')->values()->toArray();
        $availableMonths = $this->sortIndonesianMonths($rawMonths);

        $tagihan = $query->get()->map(function ($t) {
            return [
                'id' => $t->id,
                'nis' => optional($t->student)->nis ?? ('2026' . str_pad($t->student_id, 4, '0', STR_PAD_LEFT)),
                'nama' => optional($t->student)->nama ?? 'Siswa',
                'kelas' => optional($t->student)->kelas ?? '10',
                'bulan' => $t->bulan,
                'nominal' => $t->nominal,
                'status' => $t->status,
            ];
        });

        return view('keuangan.pembayaran-siswa.tagihan', compact(
            'tagihan', 'totalLunas', 'totalBelumBayar', 'totalCicilan', 'availableClasses', 'availableMonths'
        ));
    }

    public function generateTagihanBulan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|string',
            'nominal' => 'required|numeric|min:10000',
        ]);

        $bulan = $request->input('bulan');
        $nominal = $request->input('nominal');
        $students = Student::all();
        $count = 0;

        foreach ($students as $student) {
            SppBill::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'bulan' => $bulan,
                ],
                [
                    'nominal' => $nominal,
                    'status' => 'Belum Bayar',
                ]
            );
            $count++;
        }

        return redirect()->route('keuangan.pembayaran.tagihan', ['bulan' => $bulan])
            ->with('success', "Tagihan SPP {$bulan} berhasil diterbitkan untuk {$count} siswa!");
    }

    public function riwayatPembayaran(Request $request)
    {
        $query = Transaction::orderByDesc('tanggal')->orderByDesc('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('keterangan', 'like', "%{$search}%");
        }

        $riwayat = $query->get()->map(function ($t) {
            $nis = '-';
            $nama = '-';
            $kelas = '-';
            $bulan = '-';

            if ($t->transactionable_type === SppBill::class || $t->transactionable_type === 'App\Models\SppBill') {
                $bill = SppBill::with('student')->find($t->transactionable_id);
                if ($bill && $bill->student) {
                    $nis = $bill->student->nis ?? '-';
                    $nama = $bill->student->nama ?? '-';
                    $kelas = $bill->student->kelas ?? '-';
                    $bulan = $bill->bulan ?? '-';
                }
            } elseif ($t->transactionable_type === PpdbApplicant::class || $t->transactionable_type === 'App\Models\PpdbApplicant') {
                $app = PpdbApplicant::find($t->transactionable_id);
                if ($app) {
                    $nis = $app->no_daftar ?? '-';
                    $nama = $app->nama ?? '-';
                    $kelas = 'PPDB';
                    $bulan = 'Daftar Ulang';
                }
            }

            if ($nama === '-' || $nama === 'N/A') {
                if (preg_match('/(SPP|PPDB)\s+([^(]+)(\(([^)]+)\))?/i', $t->keterangan, $matches)) {
                    $extractedName = trim($matches[2] ?? '');
                    if ($extractedName) {
                        $nama = $extractedName;
                        $student = Student::where('nama', 'like', "%{$extractedName}%")->first();
                        if ($student) {
                            $nis = $student->nis ?? '-';
                            $kelas = $student->kelas ?? ($matches[4] ?? '-');
                        } else {
                            $kelas = $matches[4] ?? '10';
                        }
                    }
                }
            }

            if ($nama === '-' || $nama === 'N/A') {
                $nama = $t->keterangan ?: 'Siswa';
            }

            return [
                'id' => $t->id,
                'tanggal' => date('d M Y', strtotime($t->tanggal)),
                'nis' => $nis !== '-' && $nis !== 'N/A' ? $nis : '2026' . str_pad($t->id, 4, '0', STR_PAD_LEFT),
                'nama' => $nama,
                'kelas' => $kelas !== '-' && $kelas !== 'N/A' ? $kelas : '10',
                'bulan' => $bulan !== '-' && $bulan !== 'N/A' ? $bulan : 'SPP 2026',
                'nominal' => $t->nominal,
                'metode' => $t->metode ?: 'Transfer Bank Mandiri',
                'status' => $t->status ?: 'Terverifikasi',
            ];
        });

        return view('keuangan.pembayaran-siswa.riwayat', compact('riwayat'));
    }

    public function verifikasiPembayaran()
    {
        $pending = Transaction::where('status', 'Pending')
            ->orderByDesc('tanggal')
            ->get()
            ->map(function ($t) {
                $nis = '-';
                $nama = '-';
                $kelas = '-';
                $bulan = '-';

                if ($t->transactionable_type === SppBill::class || $t->transactionable_type === 'App\Models\SppBill') {
                    $bill = SppBill::with('student')->find($t->transactionable_id);
                    if ($bill && $bill->student) {
                        $nis = $bill->student->nis ?? '-';
                        $nama = $bill->student->nama ?? '-';
                        $kelas = $bill->student->kelas ?? '-';
                        $bulan = $bill->bulan ?? '-';
                    }
                } elseif ($t->transactionable_type === PpdbApplicant::class || $t->transactionable_type === 'App\Models\PpdbApplicant') {
                    $app = PpdbApplicant::find($t->transactionable_id);
                    if ($app) {
                        $nis = $app->no_daftar ?? '-';
                        $nama = $app->nama ?? '-';
                        $kelas = 'PPDB';
                        $bulan = 'Daftar Ulang';
                    }
                }

                if ($nama === '-' || $nama === 'N/A') {
                    if (preg_match('/(SPP|PPDB)\s+([^(]+)(\(([^)]+)\))?/i', $t->keterangan, $matches)) {
                        $extractedName = trim($matches[2] ?? '');
                        if ($extractedName) {
                            $nama = $extractedName;
                            $student = Student::where('nama', 'like', "%{$extractedName}%")->first();
                            if ($student) {
                                $nis = $student->nis ?? '-';
                                $kelas = $student->kelas ?? ($matches[4] ?? '-');
                            }
                        }
                    }
                }

                if ($nama === '-' || $nama === 'N/A') {
                    $nama = $t->keterangan ?: 'Siswa';
                }

                return [
                    'id' => $t->id,
                    'tanggal' => date('d M Y', strtotime($t->tanggal)),
                    'nis' => $nis !== '-' && $nis !== 'N/A' ? $nis : '2026' . str_pad($t->id, 4, '0', STR_PAD_LEFT),
                    'nama' => $nama,
                    'kelas' => $kelas !== '-' && $kelas !== 'N/A' ? $kelas : '10',
                    'bulan' => $bulan !== '-' && $bulan !== 'N/A' ? $bulan : 'SPP 2026',
                    'nominal' => $t->nominal,
                    'metode' => $t->metode ?: 'Transfer Bank Mandiri',
                    'bukti' => $t->bukti ? asset('storage/' . $t->bukti) : null,
                ];
            });

        return view('keuangan.pembayaran-siswa.verifikasi', compact('pending'));
    }

    public function biayaPPDB()
    {
        $biayaModel = PpdbSetting::first();
        if (!$biayaModel) {
            $biaya = [
                'biaya_formulir' => 150000, 'biaya_daftar_ulang' => 500000, 'uang_gedung' => 2500000, 'seragam' => 850000, 'total' => 4000000
            ];
        } else {
            $biaya = $biayaModel->toArray();
        }

        return view('keuangan.ppdb.biaya-pendaftaran', compact('biaya'));
    }

    public function pembayaranPPDB()
    {
        $pembayaran = PpdbApplicant::all()->map(function ($app) {
            return [
                'no_daftar' => $app->no_daftar,
                'nama' => $app->nama,
                'nominal' => $app->nominal ?: 5000000,
                'tanggal' => date('d M Y', strtotime($app->created_at ?? now())),
                'status' => $app->status ?: 'Lunas',
            ];
        });

        return view('keuangan.ppdb.pembayaran-ppdb', compact('pembayaran'));
    }

    public function rekapPPDB()
    {
        $rekap = [
            'total_pendaftar' => PpdbApplicant::count(),
            'total_lunas' => PpdbApplicant::where('status', 'Lunas')->count(),
            'total_belum_bayar' => PpdbApplicant::where('status', '!=', 'Lunas')->count(),
            'total_pemasukan' => Transaction::where('transactionable_type', PpdbApplicant::class)->where('jenis', 'Masuk')->sum('nominal'),
        ];

        return view('keuangan.ppdb.rekap-ppdb', compact('rekap'));
    }

    public function laporan()
    {
        $ringkasan = [
            'pemasukan_bulan_ini' => Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->sum('nominal'),
            'pengeluaran_bulan_ini' => Transaction::where('jenis', 'Keluar')->sum('nominal'),
            'saldo' => Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->sum('nominal') - Transaction::where('jenis', 'Keluar')->sum('nominal'),
            'pemasukan_tahun' => Transaction::where('jenis', 'Masuk')->where('status', 'Terverifikasi')->sum('nominal'),
        ];

        $transaksi_terbaru = Transaction::orderByDesc('tanggal')->get()->map(function ($t) {
            return [
                'tanggal' => date('d M Y', strtotime($t->tanggal)),
                'keterangan' => $t->keterangan,
                'jenis' => $t->jenis,
                'nominal' => $t->nominal,
                'metode' => $t->metode ?: 'Transfer Bank Mandiri',
            ];
        });

        return view('keuangan.laporan.index', compact('ringkasan', 'transaksi_terbaru'));
    }

    public function storeTransaksi(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jenis' => 'required|in:Masuk,Keluar',
            'nominal' => 'required|numeric|min:1',
            'metode' => 'required|string'
        ]);

        Transaction::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'metode' => $request->metode,
            'status' => 'Terverifikasi',
            'transactionable_type' => null,
            'transactionable_id' => null
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function updateVerifikasi(Request $request, $id)
    {
        $transaksi = Transaction::findOrFail($id);
        $status = $request->input('status');

        $transaksi->update([
            'status' => $status
        ]);

        if ($status === 'Terverifikasi' && ($transaksi->transactionable_type === SppBill::class || $transaksi->transactionable_type === 'App\Models\SppBill')) {
            if ($transaksi->transactionable) {
                $transaksi->transactionable->update(['status' => 'Lunas']);
            }
        }

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
