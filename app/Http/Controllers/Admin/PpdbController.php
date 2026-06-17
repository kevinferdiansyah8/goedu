<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpdbApplicant;

class PpdbController extends Controller
{
    public function dataPendaftar(Request $request)
    {
        $query = PpdbApplicant::query();

        if ($request->jurusan) $query->where('jurusan', $request->jurusan);
        if ($request->status && $request->status !== 'Semua Status') $query->where('status', $request->status);
        if ($request->q) $query->where(function($q) use ($request) {
            $q->where('nama', 'like', '%'.$request->q.'%')
              ->orWhere('no_daftar', 'like', '%'.$request->q.'%');
        });

        $pendaftar = $query->latest()->paginate(20)->withQueryString();
        $summary = [
            'total'        => PpdbApplicant::count(),
            'diverifikasi' => PpdbApplicant::where('status', 'Diverifikasi')->count(),
            'lulus'        => PpdbApplicant::where('status', 'Lulus')->count(),
            'tidak_lulus'  => PpdbApplicant::where('status', 'Tidak Lulus')->count(),
        ];
        $jurusanList = PpdbApplicant::select('jurusan')->distinct()->pluck('jurusan')->filter()->values();

        return view('admin.ppdb.data-pendaftar', compact('pendaftar', 'summary', 'jurusanList'));
    }

    public function updateStatus(Request $request, $id)
    {
        $applicant = PpdbApplicant::findOrFail($id);
        $applicant->update(['status' => $request->status, 'catatan' => $request->catatan]);
        return back()->with('success', 'Status pendaftar berhasil diperbarui');
    }

    public function verifikasiBerkas(Request $request)
    {
        $query = PpdbApplicant::query();
        if ($request->status_berkas) $query->where('berkas_status', $request->status_berkas);
        $pendaftar = $query->latest()->paginate(20)->withQueryString();
        $summary = [
            'belum'        => PpdbApplicant::where('berkas_status', 'Belum Upload')->count(),
            'sudah'        => PpdbApplicant::where('berkas_status', 'Sudah Upload')->count(),
            'terverifikasi' => PpdbApplicant::where('berkas_status', 'Terverifikasi')->count(),
        ];

        $selectedApplicant = null;
        if ($request->id) {
            $selectedApplicant = PpdbApplicant::findOrFail($request->id);
        }

        return view('admin.ppdb.verifikasi-berkas', compact('pendaftar', 'summary', 'selectedApplicant'));
    }

    public function updateBerkas(Request $request, $id)
    {
        $applicant = PpdbApplicant::findOrFail($id);
        
        $applicant->update([
            'status_kk' => $request->status_kk,
            'catatan_kk' => $request->catatan_kk,
            'status_akta' => $request->status_akta,
            'catatan_akta' => $request->catatan_akta,
            'status_ijazah' => $request->status_ijazah,
            'catatan_ijazah' => $request->catatan_ijazah,
            'status_raport' => $request->status_raport,
            'catatan_raport' => $request->catatan_raport,
            'status_foto' => $request->status_foto,
            'catatan_foto' => $request->catatan_foto,
            
            'berkas_status' => $request->berkas_status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.ppdb.verifikasi-berkas', ['id' => $id])->with('success', 'Status berkas berhasil diperbarui');
    }

    public function seleksi(Request $request)
    {
        $query = PpdbApplicant::query();
        if ($request->jurusan) $query->where('jurusan', $request->jurusan);
        $pendaftar = $query->latest()->paginate(20)->withQueryString();
        $jurusanList = PpdbApplicant::select('jurusan')->distinct()->pluck('jurusan')->filter()->values();

        $selectedApplicant = null;
        if ($request->id) {
            $selectedApplicant = PpdbApplicant::findOrFail($request->id);
        }

        return view('admin.ppdb.seleksi', compact('pendaftar', 'jurusanList', 'selectedApplicant'));
    }

    public function updateSeleksi(Request $request, $id)
    {
        $applicant = PpdbApplicant::findOrFail($id);
        
        $request->validate([
            'nilai_seleksi' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:Menunggu,Diverifikasi,Lulus,Tidak Lulus,Perbaikan',
            'catatan' => 'nullable|string',
        ]);

        $applicant->update([
            'nilai_seleksi' => $request->nilai_seleksi,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.ppdb.seleksi', ['id' => $id])->with('success', 'Keputusan seleksi berhasil disimpan');
    }

    public function pembayaran(Request $request)
    {
        $query = PpdbApplicant::where('status', 'Lulus');
        if ($request->status_bayar) $query->where('status_pembayaran', $request->status_bayar);
        $pendaftar = $query->latest()->paginate(20)->withQueryString();
        $summary = [
            'belum'  => PpdbApplicant::where('status', 'Lulus')->where('status_pembayaran', 'Belum Bayar')->count(),
            'sudah'  => PpdbApplicant::where('status', 'Lulus')->where('status_pembayaran', 'Sudah Bayar')->count(),
            'lunas'  => PpdbApplicant::where('status', 'Lulus')->where('status_pembayaran', 'Lunas')->count(),
        ];

        $selectedApplicant = null;
        $payment = null;
        if ($request->id) {
            $selectedApplicant = PpdbApplicant::findOrFail($request->id);
            $payment = $selectedApplicant->transactions()->where('jenis', 'Masuk')->latest()->first();
        }

        return view('admin.ppdb.pembayaran', compact('pendaftar', 'summary', 'selectedApplicant', 'payment'));
    }

    public function updatePembayaran(Request $request, $id)
    {
        $applicant = PpdbApplicant::findOrFail($id);
        $status_pembayaran = $request->status_pembayaran;

        $applicant->update([
            'status_pembayaran' => $status_pembayaran,
            'nominal' => $status_pembayaran === 'Lunas' ? 250000 : 0,
        ]);

        $payment = $applicant->transactions()->where('jenis', 'Masuk')->latest()->first();
        if ($payment) {
            $payment->update([
                'status' => $status_pembayaran === 'Lunas' ? 'Terverifikasi' : ($status_pembayaran === 'Ditolak' ? 'Ditolak' : 'Pending'),
                'keterangan' => $request->catatan ?: $payment->keterangan,
            ]);
        }

        return redirect()->route('admin.ppdb.pembayaran', ['id' => $id])->with('success', 'Status verifikasi pembayaran berhasil disimpan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'      => 'nullable|string|max:10',
            'tanggal_lahir' => 'nullable|date',
            'nama'      => 'required|string',
            'jurusan'   => 'required|string',
            'jalur'     => 'required|string',
            'email'     => 'nullable|email',
            'telepon'   => 'nullable|string',
            'asal_sekolah' => 'nullable|string',
        ]);

        $no_daftar = 'PPDB' . str_pad(PpdbApplicant::count() + 1, 4, '0', STR_PAD_LEFT);

        PpdbApplicant::create([
            'no_daftar'   => $no_daftar,
            'nisn'        => $request->nisn,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nama'        => $request->nama,
            'jurusan'     => $request->jurusan,
            'jalur'       => $request->jalur,
            'email'       => $request->email,
            'telepon'     => $request->telepon,
            'asal_sekolah' => $request->asal_sekolah,
            'status'      => 'Menunggu',
            'berkas_status' => 'Belum Upload',
            'status_pembayaran' => 'Belum Bayar',
            'tanggal'     => now(),
            'nominal'     => 0,
        ]);

        return back()->with('success', 'Pendaftar baru berhasil ditambahkan');
    }

    public function destroy($id)
    {
        PpdbApplicant::findOrFail($id)->delete();
        return back()->with('success', 'Data pendaftar berhasil dihapus');
    }
}
