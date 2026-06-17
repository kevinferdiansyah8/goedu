<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TeacherDocument;
use App\Models\TeacherHistory;
use App\Models\TeacherCertification;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with(['documents', 'histories', 'certifications']);
        
        if ($request->tipe && $request->tipe != 'Semua Tipe') {
            $query->where('tipe', $request->tipe);
        }
        if ($request->status && $request->status != 'Semua Status') {
            $query->where('status', $request->status);
        }
        
        $pegawai = $query->get();
        return view('admin.kepegawaian.arsip-kepegawaian', compact('pegawai'));
    }

    public function updateProfile(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update([
            'jabatan' => $request->jabatan,
            'tipe' => $request->tipe,
            'status' => $request->status,
            'pendidikan' => $request->pendidikan,
        ]);
        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function storeDocument(Request $request, $id)
    {
        $request->validate([
            'nama_dokumen' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $teacher = Teacher::findOrFail($id);
        $path = $request->file('file')->store('arsip_dokumen', 'public');

        $teacher->documents()->create([
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Dokumen berhasil diunggah');
    }

    public function destroyDocument($id)
    {
        $doc = TeacherDocument::findOrFail($id);
        if (Storage::disk('public')->exists($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        return back()->with('success', 'Dokumen berhasil dihapus');
    }

    public function storeHistory(Request $request, $id)
    {
        $request->validate([
            'jabatan' => 'required|string',
            'tahun' => 'required|string',
        ]);
        Teacher::findOrFail($id)->histories()->create($request->only('jabatan', 'tahun'));
        return back()->with('success', 'Riwayat berhasil ditambahkan');
    }

    public function destroyHistory($id)
    {
        TeacherHistory::findOrFail($id)->delete();
        return back()->with('success', 'Riwayat berhasil dihapus');
    }

    public function storeCertification(Request $request, $id)
    {
        $request->validate([
            'nama_sertifikasi' => 'required|string',
        ]);
        Teacher::findOrFail($id)->certifications()->create($request->only('nama_sertifikasi'));
        return back()->with('success', 'Sertifikasi berhasil ditambahkan');
    }

    public function destroyCertification($id)
    {
        TeacherCertification::findOrFail($id)->delete();
        return back()->with('success', 'Sertifikasi berhasil dihapus');
    }
}
