<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\SppBill;
use App\Models\Transaction;

class FinancialSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();

        foreach ($students as $student) {
            // Bill 1: Mei 2026 (Lunas)
            $b1 = SppBill::updateOrCreate(
                ['student_id' => $student->id, 'bulan' => 'Mei 2026'],
                ['nominal' => 350000, 'status' => 'Lunas']
            );
            Transaction::updateOrCreate(
                ['transactionable_type' => SppBill::class, 'transactionable_id' => $b1->id],
                [
                    'tanggal' => '2026-05-08',
                    'keterangan' => 'Pembayaran SPP Mei 2026 - ' . $student->nama,
                    'jenis' => 'Masuk',
                    'nominal' => 350000,
                    'metode' => 'Transfer Bank Mandiri',
                    'status' => 'Terverifikasi'
                ]
            );

            // Bill 2: Juni 2026 (Lunas)
            $b2 = SppBill::updateOrCreate(
                ['student_id' => $student->id, 'bulan' => 'Juni 2026'],
                ['nominal' => 350000, 'status' => 'Lunas']
            );
            Transaction::updateOrCreate(
                ['transactionable_type' => SppBill::class, 'transactionable_id' => $b2->id],
                [
                    'tanggal' => '2026-06-10',
                    'keterangan' => 'Pembayaran SPP Juni 2026 - ' . $student->nama,
                    'jenis' => 'Masuk',
                    'nominal' => 350000,
                    'metode' => 'Pembayaran Langsung (Tunai)',
                    'status' => 'Terverifikasi'
                ]
            );

            // Bill 3: Juli 2026 (Lunas)
            $b3 = SppBill::updateOrCreate(
                ['student_id' => $student->id, 'bulan' => 'Juli 2026'],
                ['nominal' => 350000, 'status' => 'Lunas']
            );
            Transaction::updateOrCreate(
                ['transactionable_type' => SppBill::class, 'transactionable_id' => $b3->id],
                [
                    'tanggal' => '2026-07-05',
                    'keterangan' => 'Pembayaran SPP Juli 2026 - ' . $student->nama,
                    'jenis' => 'Masuk',
                    'nominal' => 350000,
                    'metode' => 'Transfer Bank Mandiri',
                    'status' => 'Terverifikasi'
                ]
            );

            // Bill 4: Agustus 2026 (Belum Bayar)
            SppBill::updateOrCreate(
                ['student_id' => $student->id, 'bulan' => 'Agustus 2026'],
                ['nominal' => 350000, 'status' => 'Belum Bayar']
            );
        }
    }
}
