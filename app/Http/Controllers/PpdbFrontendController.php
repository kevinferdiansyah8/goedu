<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpdbApplicant;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;

class PpdbFrontendController extends Controller
{
    public function index()
    {
        return view('ppdb.index');
    }

    public function showRegisterForm()
    {
        return view('ppdb.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nisn'          => 'required|string|max:10|unique:ppdb_applicants,nisn',
            'tanggal_lahir' => 'required|date',
            'jurusan'       => 'required|string',
            'jalur'         => 'required|string',
            'asal_sekolah'  => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'telepon'       => 'nullable|string|max:20',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar. Silakan login atau hubungi panitia.',
        ]);

        $no_daftar = 'PPDB' . str_pad(PpdbApplicant::count() + 1, 4, '0', STR_PAD_LEFT);

        $applicant = PpdbApplicant::create([
            'no_daftar'         => $no_daftar,
            'nisn'              => $request->nisn,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'nama'              => $request->nama,
            'jurusan'           => $request->jurusan,
            'jalur'             => $request->jalur,
            'asal_sekolah'      => $request->asal_sekolah,
            'email'             => $request->email,
            'telepon'           => $request->telepon,
            'status'            => 'Menunggu',
            'berkas_status'     => 'Belum Upload',
            'status_pembayaran' => 'Belum Bayar',
            'tanggal'           => now(),
            'nominal'           => 0,
        ]);

        Session::put('ppdb_applicant_id', $applicant->id);

        return redirect()->route('ppdb.dashboard')->with('success', 'Pendaftaran berhasil! Silakan lengkapi berkas Anda.');
    }

    public function showLoginForm()
    {
        if (Session::has('ppdb_applicant_id')) {
            return redirect()->route('ppdb.dashboard');
        }
        return view('ppdb.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:10',
            'tanggal_lahir' => 'required|date',
        ]);

        $applicant = PpdbApplicant::where('nisn', $request->nisn)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if ($applicant) {
            Session::put('ppdb_applicant_id', $applicant->id);
            return redirect()->route('ppdb.dashboard');
        }

        return back()->withErrors([
            'nisn' => 'NISN atau Tanggal Lahir tidak ditemukan. Pastikan Anda sudah terdaftar.',
        ])->onlyInput('nisn');
    }

    public function dashboard()
    {
        if (!Session::has('ppdb_applicant_id')) {
            return redirect()->route('ppdb.login')->withErrors(['nisn' => 'Silakan login terlebih dahulu.']);
        }

        $applicant = PpdbApplicant::with('transactions')->find(Session::get('ppdb_applicant_id'));
        
        if (!$applicant) {
            Session::forget('ppdb_applicant_id');
            return redirect()->route('ppdb.login');
        }

        $payment = $applicant->transactions()->where('jenis', 'Masuk')->latest()->first();

        return view('ppdb.dashboard', compact('applicant', 'payment'));
    }

    public function logout()
    {
        Session::forget('ppdb_applicant_id');
        return redirect()->route('ppdb.login');
    }

    public function showCekStatus()
    {
        return view('ppdb.cek-status');
    }

    public function searchStatus(Request $request)
    {
        $query = $request->query_input;
        $applicant = PpdbApplicant::where('nisn', $query)
            ->orWhere('no_daftar', $query)
            ->first();

        if ($applicant) {
            $formatted_date = $applicant->tanggal ? \Carbon\Carbon::parse($applicant->tanggal)->translatedFormat('d F Y') : '-';
            return response()->json([
                'success' => true,
                'applicant' => $applicant,
                'formatted_date' => $formatted_date,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan. Pastikan NISN atau Nomor Pendaftaran benar.'
        ]);
    }

    public function cetakBukti(Request $request)
    {
        $id = $request->id ?: Session::get('ppdb_applicant_id');
        if (!$id) {
            return redirect()->route('ppdb.login');
        }
        $applicant = PpdbApplicant::findOrFail($id);
        return view('ppdb.cetak-bukti', compact('applicant'));
    }

    public function uploadDocument(Request $request)
    {
        if (!Session::has('ppdb_applicant_id')) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }
        $applicant = PpdbApplicant::findOrFail(Session::get('ppdb_applicant_id'));

        $request->validate([
            'file_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20480',
            'file_akta' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20480',
            'file_raport' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20480',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20480',
            'file_ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20480',
        ]);

        $types = ['kk', 'akta', 'raport', 'foto', 'ijazah'];
        $uploadedAny = false;

        foreach ($types as $type) {
            if ($request->hasFile('file_' . $type)) {
                $file = $request->file('file_' . $type);
                $filename = 'ppdb_' . $type . '_' . $applicant->no_daftar . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Store in public/ppdb storage folder
                $file->storeAs('ppdb', $filename, 'public');

                // Update database
                $applicant->update([
                    'berkas_' . $type => 'ppdb/' . $filename,
                    'status_' . $type => 'Sudah Upload',
                    'catatan_' . $type => null,
                ]);

                $uploadedAny = true;
            }
        }

        if (!$uploadedAny) {
            return back()->with('error', 'Pilih minimal satu dokumen untuk diunggah.');
        }

        // Automatically update berkas_status to "Sudah Upload" if all documents have been uploaded
        $required = ['kk', 'akta', 'raport', 'foto', 'ijazah'];
        $allUploaded = true;
        foreach ($required as $req) {
            if (empty($applicant->{'berkas_' . $req})) {
                $allUploaded = false;
            }
        }
        
        if ($allUploaded) {
            $applicant->update(['berkas_status' => 'Sudah Upload']);
        }

        return back()->with('success', 'Dokumen berhasil diunggah!');
    }

    public function uploadPayment(Request $request)
    {
        if (!Session::has('ppdb_applicant_id')) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }
        $applicant = PpdbApplicant::findOrFail(Session::get('ppdb_applicant_id'));

        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
            'catatan' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $filename = 'ppdb_pay_' . $applicant->no_daftar . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        $file->storeAs('ppdb', $filename, 'public');

        // Create transaction entry
        $applicant->transactions()->create([
            'tanggal' => date('Y-m-d'),
            'keterangan' => 'Pembayaran PPDB: ' . $applicant->nama,
            'jenis' => 'Masuk',
            'nominal' => 250000,
            'metode' => 'Transfer Bank',
            'bukti' => 'ppdb/' . $filename,
            'status' => 'Pending',
        ]);

        // Update applicant's payment status
        $applicant->update([
            'status_pembayaran' => 'Sudah Bayar'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');
    }

    public function getStatusApi(Request $request)
    {
        $id = $request->id ?: Session::get('ppdb_applicant_id');
        if (!$id) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $applicant = PpdbApplicant::find($id);
        if (!$applicant) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        // Return current status fields for realtime polling
        return response()->json([
            'status' => $applicant->status,
            'catatan' => $applicant->catatan,
            'berkas_status' => $applicant->berkas_status,
            'status_pembayaran' => $applicant->status_pembayaran,
            'status_kk' => $applicant->status_kk,
            'status_akta' => $applicant->status_akta,
            'status_raport' => $applicant->status_raport,
            'status_foto' => $applicant->status_foto,
            'status_ijazah' => $applicant->status_ijazah,
            'catatan_kk' => $applicant->catatan_kk,
            'catatan_akta' => $applicant->catatan_akta,
            'catatan_raport' => $applicant->catatan_raport,
            'catatan_foto' => $applicant->catatan_foto,
            'catatan_ijazah' => $applicant->catatan_ijazah,
        ]);
    }
}
