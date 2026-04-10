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
        $stats = [
            'total_pemasukan' => Transaction::where('jenis', 'Masuk')->sum('nominal'),
            'total_tunggakan' => SppBill::where('status', '!=', 'Lunas')->sum('nominal') + PpdbApplicant::where('status', '!=', 'Lunas')->sum('nominal'),
            // Dummy for today since seeded dates are hardcoded
            'pembayaran_hari_ini' => Transaction::where('jenis', 'Masuk')->where('tanggal', '2026-04-07')->sum('nominal'),
            'siswa_belum_bayar' => SppBill::where('status', 'Belum Bayar')->count(),
        ];

        // Hardcoded for chart visuals
        $pemasukan_bulanan = [12500000, 15200000, 13800000, 16100000, 14700000, 18500000, 15900000, 17200000, 16800000, 19100000, 15400000, 17050000];
        $pengeluaran_bulanan = [8200000, 9100000, 7800000, 10200000, 8900000, 11500000, 9700000, 10800000, 9900000, 12100000, 10200000, 11050000];
        $bulan_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $sumber_pemasukan = [
            'labels' => ['SPP', 'PPDB', 'Uang Gedung', 'Lainnya'],
            'data' => [65, 20, 10, 5],
        ];

        return view('keuangan.dashboard.index', compact('stats', 'pemasukan_bulanan', 'pengeluaran_bulanan', 'bulan_labels', 'sumber_pemasukan'));
    }

    public function tagihanSpp()
    {
        $tagihan = SppBill::with('student')->get()->map(function ($t) {
            return [
                'nis' => optional($t->student)->nis ?? 'N/A',
                'nama' => optional($t->student)->nama ?? 'N/A',
                'kelas' => optional($t->student)->kelas ?? 'N/A',
                'bulan' => $t->bulan,
                'nominal' => $t->nominal,
                'status' => $t->status,
            ];
        });

        return view('keuangan.pembayaran-siswa.tagihan', compact('tagihan'));
    }

    public function riwayatPembayaran()
    {
        $riwayat = Transaction::where('transactionable_type', SppBill::class)
            ->with('transactionable.student')
            ->orderByDesc('tanggal')
            ->get()
            ->map(function ($t) {
                return [
                    'tanggal' => date('d M Y', strtotime($t->tanggal)),
                    'nis' => optional(optional($t->transactionable)->student)->nis ?? 'N/A',
                    'nama' => optional(optional($t->transactionable)->student)->nama ?? 'N/A',
                    'kelas' => optional(optional($t->transactionable)->student)->kelas ?? 'N/A',
                    'bulan' => optional($t->transactionable)->bulan ?? 'N/A',
                    'nominal' => $t->nominal,
                    'metode' => $t->metode,
                    'status' => $t->status,
                ];
            });

        return view('keuangan.pembayaran-siswa.riwayat', compact('riwayat'));
    }

    public function verifikasiPembayaran()
    {
        $pending = Transaction::where('status', 'Pending')
            ->where('transactionable_type', SppBill::class)
            ->with('transactionable.student')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'tanggal' => date('d M Y', strtotime($t->tanggal)),
                    'nis' => $t->transactionable->student->nis,
                    'nama' => $t->transactionable->student->nama,
                    'kelas' => $t->transactionable->student->kelas,
                    'bulan' => $t->transactionable->bulan,
                    'nominal' => $t->nominal,
                    'metode' => $t->metode,
                    'bukti' => 'bukti_00' . rand(1,9) . '.jpg', // mock proof
                ];
            });

        return view('keuangan.pembayaran-siswa.verifikasi', compact('pending'));
    }

    public function biayaPPDB()
    {
        $biayaModel = PpdbSetting::first();
        if (!$biayaModel) {
            // fail-safe empty array format
            $biaya = [
                'biaya_formulir' => 0, 'biaya_daftar_ulang' => 0, 'uang_gedung' => 0, 'seragam' => 0, 'total' => 0
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
                'nominal' => $app->nominal,
                'tanggal' => $app->tanggal,
                'status' => $app->status,
            ];
        });

        return view('keuangan.ppdb.pembayaran-ppdb', compact('pembayaran'));
    }

    public function rekapPPDB()
    {
        $rekap = [
            'total_pendaftar' => PpdbApplicant::count(),
            'total_lunas' => PpdbApplicant::where('status', 'Lunas')->count(),
            'total_belum_bayar' => PpdbApplicant::where('status', 'Belum Bayar')->count(),
            'total_pemasukan' => Transaction::where('transactionable_type', PpdbApplicant::class)->where('jenis', 'Masuk')->sum('nominal'),
        ];

        return view('keuangan.ppdb.rekap-ppdb', compact('rekap'));
    }

    public function laporan()
    {
        $ringkasan = [
            'pemasukan_bulan_ini' => Transaction::where('jenis', 'Masuk')->sum('nominal'),
            'pengeluaran_bulan_ini' => Transaction::where('jenis', 'Keluar')->sum('nominal'),
            'saldo' => Transaction::where('jenis', 'Masuk')->sum('nominal') - Transaction::where('jenis', 'Keluar')->sum('nominal'),
            'pemasukan_tahun' => Transaction::where('jenis', 'Masuk')->sum('nominal'),
        ];

        $transaksi_terbaru = Transaction::orderByDesc('tanggal')->get()->map(function ($t) {
            return [
                'tanggal' => date('d M Y', strtotime($t->tanggal)),
                'keterangan' => $t->keterangan,
                'jenis' => $t->jenis,
                'nominal' => $t->nominal,
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
            'status' => 'Selesai', // manual transactions are immediately done
            'transactionable_type' => null,
            'transactionable_id' => null
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function updateVerifikasi(Request $request, $id)
    {
        $transaksi = Transaction::findOrFail($id);
        $status = $request->input('status'); // 'Terverifikasi' atau 'Ditolak'

        $transaksi->update([
            'status' => $status
        ]);

        // Jika Approve, otomatis lunas di tagihan SPP
        if ($status === 'Terverifikasi' && $transaksi->transactionable_type === SppBill::class) {
            $transaksi->transactionable->update(['status' => 'Lunas']);
        }

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
