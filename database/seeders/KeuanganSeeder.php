<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\SppBill;
use App\Models\PpdbSetting;
use App\Models\PpdbApplicant;
use App\Models\Transaction;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PPDB Setting
        PpdbSetting::create([
            'biaya_formulir' => 100000,
            'biaya_daftar_ulang' => 1000000,
            'uang_gedung' => 3000000,
            'seragam' => 900000,
            'total' => 5000000
        ]);

        // 2. PPDB Applicants
        $applicants = [
            ['no_daftar' => 'PPDB-2026-0001', 'nama' => 'Alya Nurdiana'],
            ['no_daftar' => 'PPDB-2026-0002', 'nama' => 'Bagas Pratama'],
            ['no_daftar' => 'PPDB-2026-0003', 'nama' => 'Citra Dewi'],
            ['no_daftar' => 'PPDB-2026-0004', 'nama' => 'Daffa Mahendra'],
            ['no_daftar' => 'PPDB-2026-0005', 'nama' => 'Elsa Kirana'],
            ['no_daftar' => 'PPDB-2026-0006', 'nama' => 'Farhan Maulana'],
        ];

        foreach ($applicants as $idx => $app) {
            $status = 'Belum Bayar';
            if ($idx == 0 || $idx == 3) $status = 'Lunas';
            if ($idx == 1 || $idx == 4) $status = 'Menunggu Verifikasi';

            $applicant = PpdbApplicant::create([
                'no_daftar' => $app['no_daftar'],
                'nama' => $app['nama'],
                'nominal' => 5000000,
                'tanggal' => '0' . rand(5, 7) . ' Apr 2026',
                'status' => $status,
            ]);

            if ($status !== 'Belum Bayar') {
                Transaction::create([
                    'tanggal' => '2026-04-0' . rand(5, 7),
                    'keterangan' => 'PPDB ' . $applicant->nama,
                    'jenis' => 'Masuk',
                    'nominal' => 5000000,
                    'metode' => 'Transfer Bank',
                    'status' => $status === 'Lunas' ? 'Terverifikasi' : 'Pending',
                    'transactionable_id' => $applicant->id,
                    'transactionable_type' => PpdbApplicant::class,
                ]);
            }
        }

        // 3. Students
        $students = [
            ['nis' => '2024001', 'nama' => 'Ahmad Fauzi', 'kelas' => 'X-A', 'spp_amount' => 350000],
            ['nis' => '2024002', 'nama' => 'Siti Rahayu', 'kelas' => 'X-A', 'spp_amount' => 350000],
            ['nis' => '2024003', 'nama' => 'Budi Santoso', 'kelas' => 'X-B', 'spp_amount' => 350000],
            ['nis' => '2024004', 'nama' => 'Dewi Lestari', 'kelas' => 'XI-A', 'spp_amount' => 375000],
            ['nis' => '2024005', 'nama' => 'Eka Prasetya', 'kelas' => 'XI-A', 'spp_amount' => 375000],
            ['nis' => '2024006', 'nama' => 'Fitri Handayani', 'kelas' => 'XI-B', 'spp_amount' => 375000],
            ['nis' => '2024007', 'nama' => 'Gilang Ramadhan', 'kelas' => 'XII-A', 'spp_amount' => 400000],
            ['nis' => '2024008', 'nama' => 'Hana Permata', 'kelas' => 'XII-A', 'spp_amount' => 400000],
            ['nis' => '2024009', 'nama' => 'Irfan Hakim', 'kelas' => 'XII-B', 'spp_amount' => 400000],
            ['nis' => '2024010', 'nama' => 'Jasmine Putri', 'kelas' => 'XII-B', 'spp_amount' => 400000],
        ];

        foreach ($students as $idx => $stu) {
            $student = Student::create([
                'nis' => $stu['nis'],
                'nama' => $stu['nama'],
                'kelas' => $stu['kelas'],
            ]);

            $status = 'Belum Bayar';
            if (in_array($idx + 1, [2, 5, 7, 10])) $status = 'Lunas';
            if (in_array($idx + 1, [3, 8])) $status = 'Cicilan';

            $bill = SppBill::create([
                'student_id' => $student->id,
                'bulan' => 'April 2026',
                'nominal' => $stu['spp_amount'],
                'status' => $status
            ]);

            if ($status !== 'Belum Bayar') {
                Transaction::create([
                    'tanggal' => '2026-04-0' . rand(5, 7),
                    'keterangan' => 'SPP ' . $student->nama . ' (' . $student->kelas . ')',
                    'jenis' => 'Masuk',
                    'nominal' => $status === 'Cicilan' ? $bill->nominal / 2 : $bill->nominal,
                    'metode' => rand(0, 1) ? 'Transfer Bank' : 'QRIS',
                    'status' => 'Terverifikasi',
                    'transactionable_id' => $bill->id,
                    'transactionable_type' => SppBill::class,
                ]);
            }
        }

        // 4. Pengeluaran
        Transaction::create([
            'tanggal' => '2026-04-06',
            'keterangan' => 'Pembelian ATK Kantor',
            'jenis' => 'Keluar',
            'nominal' => 450000,
            'metode' => 'Tunai',
            'status' => 'Terverifikasi',
        ]);
        Transaction::create([
            'tanggal' => '2026-04-05',
            'keterangan' => 'Gaji Guru Bulan Maret',
            'jenis' => 'Keluar',
            'nominal' => 18500000,
            'metode' => 'Transfer Bank',
            'status' => 'Terverifikasi',
        ]);
        Transaction::create([
            'tanggal' => '2026-04-04',
            'keterangan' => 'Biaya Listrik & Air',
            'jenis' => 'Keluar',
            'nominal' => 2800000,
            'metode' => 'Transfer Bank',
            'status' => 'Terverifikasi',
        ]);
    }
}
