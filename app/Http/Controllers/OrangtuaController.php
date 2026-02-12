<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function monitoringPresensi()
    {
        return view('orangtua.monitoring.presensi');
    }

    public function monitoringNilai()
    {
        return view('orangtua.monitoring.nilai');
    }

    public function monitoringSpp()
    {
        return view('orangtua.monitoring.spp');
    }

    // Monitoring Akademik
    public function akademikTugas()
    {
        return view('orangtua.akademik.tugas');
    }

    public function akademikRapor()
    {
        return view('orangtua.akademik.rapor');
    }

    public function akademikJadwal()
    {
        return view('orangtua.akademik.jadwal');
    }

    // Absensi Anak
    public function absensiRiwayat()
    {
        return view('orangtua.absensi.riwayat');
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
        return view('orangtua.keuangan.tagihan');
    }

    public function keuanganRiwayat()
    {
        return view('orangtua.keuangan.riwayat');
    }

    public function keuanganBukti()
    {
        return view('orangtua.keuangan.bukti');
    }

    // Kegiatan & Info
    public function kegiatanAgenda()
    {
        return view('orangtua.kegiatan.agenda');
    }

    public function kegiatanEvent()
    {
        return view('orangtua.kegiatan.event');
    }

    public function kegiatanPengumuman()
    {
        return view('orangtua.kegiatan.pengumuman');
    }

    // Profil Orang Tua
    public function profilDataDiri()
    {
        return view('orangtua.profil.datadiri');
    }

    public function profilDataAnak()
    {
        return view('orangtua.profil.dataanak');
    }

    public function profilPassword()
    {
        return view('orangtua.profil.password');
    }
}
