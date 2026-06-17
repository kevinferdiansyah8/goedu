<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    // ==========================================
    // EVENT METHODS
    // ==========================================
    public function eventIndex(Request $request)
    {
        $events = Event::where('tipe_info', 'Event')->latest()->get();
        return view('admin.kegiatan.event.index', compact('events'));
    }

    public function eventStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Draft,Dipublikasikan',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $filepath = null;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = 'event_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kegiatan', $filename, 'public');
            $filepath = 'kegiatan/' . $filename;
        }

        Event::create([
            'tipe_info' => 'Event',
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_pelaksanaan' => $request->tanggal_mulai,
            'waktu_pelaksanaan' => $request->tanggal_selesai, // Repurpose waktu_pelaksanaan to store end date for Event
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'gambar_attachment' => $filepath,
        ]);

        return back()->with('success', 'Event baru berhasil ditambahkan');
    }

    public function eventUpdate(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Draft,Dipublikasikan',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_pelaksanaan' => $request->tanggal_mulai,
            'waktu_pelaksanaan' => $request->tanggal_selesai,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
        ];

        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($event->gambar_attachment) {
                Storage::disk('public')->delete($event->gambar_attachment);
            }

            $file = $request->file('banner');
            $filename = 'event_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kegiatan', $filename, 'public');
            $data['gambar_attachment'] = 'kegiatan/' . $filename;
        }

        $event->update($data);

        return back()->with('success', 'Event berhasil diperbarui');
    }

    public function eventDestroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->gambar_attachment) {
            Storage::disk('public')->delete($event->gambar_attachment);
        }
        $event->delete();

        return back()->with('success', 'Event berhasil dihapus');
    }

    // ==========================================
    // AGENDA METHODS
    // ==========================================
    public function agendaIndex(Request $request)
    {
        $query = Event::where('tipe_info', 'Agenda');
        if ($request->jenis) $query->where('jenis', $request->jenis);
        if ($request->status) $query->where('status', $request->status);
        $agenda = $query->latest()->get();

        return view('admin.kegiatan.agenda.index', compact('agenda'));
    }

    public function agendaStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:255',
            'status' => 'required|in:Akan Datang,Selesai',
            'keterangan' => 'nullable|string',
        ]);

        Event::create([
            'tipe_info' => 'Agenda',
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'lokasi' => $request->lokasi,
            'tanggal_pelaksanaan' => $request->tanggal,
            'waktu_pelaksanaan' => $request->waktu,
            'status' => $request->status,
            'deskripsi' => $request->keterangan,
        ]);

        return back()->with('success', 'Agenda baru berhasil ditambahkan');
    }

    public function agendaUpdate(Request $request, $id)
    {
        $agenda = Event::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:255',
            'status' => 'required|in:Akan Datang,Selesai',
            'keterangan' => 'nullable|string',
        ]);

        $agenda->update([
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'lokasi' => $request->lokasi,
            'tanggal_pelaksanaan' => $request->tanggal,
            'waktu_pelaksanaan' => $request->waktu,
            'status' => $request->status,
            'deskripsi' => $request->keterangan,
        ]);

        return back()->with('success', 'Agenda berhasil diperbarui');
    }

    public function agendaDestroy($id)
    {
        Event::findOrFail($id)->delete();
        return back()->with('success', 'Agenda berhasil dihapus');
    }

    // ==========================================
    // DOKUMENTASI METHODS
    // ==========================================
    public function dokumentasiIndex(Request $request)
    {
        $dokumentasi = Event::where('tipe_info', 'Dokumentasi')->latest()->get();
        return view('admin.kegiatan.dokumentasi.index', compact('dokumentasi'));
    }

    public function dokumentasiStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $filepath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'doc_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kegiatan', $filename, 'public');
            $filepath = 'kegiatan/' . $filename;
        }

        Event::create([
            'tipe_info' => 'Dokumentasi',
            'judul' => $request->judul,
            'jenis' => $request->kategori,
            'tanggal_pelaksanaan' => $request->tanggal,
            'gambar_attachment' => $filepath,
            'waktu_pelaksanaan' => rand(10, 30), // mock jumlah_foto
        ]);

        return back()->with('success', 'Dokumentasi baru berhasil ditambahkan');
    }

    public function dokumentasiUpdate(Request $request, $id)
    {
        $doc = Event::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'jenis' => $request->kategori,
            'tanggal_pelaksanaan' => $request->tanggal,
        ];

        if ($request->hasFile('foto')) {
            if ($doc->gambar_attachment) {
                Storage::disk('public')->delete($doc->gambar_attachment);
            }

            $file = $request->file('foto');
            $filename = 'doc_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kegiatan', $filename, 'public');
            $data['gambar_attachment'] = 'kegiatan/' . $filename;
        }

        $doc->update($data);

        return back()->with('success', 'Dokumentasi berhasil diperbarui');
    }

    public function dokumentasiDestroy($id)
    {
        $doc = Event::findOrFail($id);
        if ($doc->gambar_attachment) {
            Storage::disk('public')->delete($doc->gambar_attachment);
        }
        $doc->delete();

        return back()->with('success', 'Dokumentasi berhasil dihapus');
    }

    // ==========================================
    // PENGUMUMAN METHODS
    // ==========================================
    public function pengumumanIndex(Request $request)
    {
        $query = Event::where('tipe_info', 'Pengumuman');
        if ($request->target) $query->where('jenis', $request->target);
        if ($request->status) $query->where('status', $request->status);
        if ($request->q) $query->where('judul', 'like', '%'.$request->q.'%');
        
        $pengumuman = $query->latest()->get();

        return view('admin.kegiatan.pengumuman.index', compact('pengumuman'));
    }

    public function pengumumanStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:Aktif,Arsip',
        ]);

        Event::create([
            'tipe_info' => 'Pengumuman',
            'judul' => $request->judul,
            'jenis' => $request->target,
            'deskripsi' => $request->isi,
            'tanggal_pelaksanaan' => $request->tanggal,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Pengumuman baru berhasil ditambahkan');
    }

    public function pengumumanUpdate(Request $request, $id)
    {
        $ann = Event::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:Aktif,Arsip',
        ]);

        $ann->update([
            'judul' => $request->judul,
            'jenis' => $request->target,
            'deskripsi' => $request->isi,
            'tanggal_pelaksanaan' => $request->tanggal,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function pengumumanDestroy($id)
    {
        Event::findOrFail($id)->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus');
    }
}
