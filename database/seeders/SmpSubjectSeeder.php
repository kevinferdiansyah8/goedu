<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Teacher;

class SmpSubjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Delete subjects with ID > 1 to clean up old dummy subjects
        Subject::where('id', '>', 1)->delete();

        // 2. Define our 10 standard subjects and their assigned teacher name keywords
        $subjectsDefinition = [
            ['nama' => 'Matematika', 'teacher_keyword' => 'Budi Santoso', 'jumlah_jam' => 4, 'code_suffix' => 'MTK'],
            ['nama' => 'Bahasa Indonesia', 'teacher_keyword' => 'Oky Setiawan', 'jumlah_jam' => 4, 'code_suffix' => 'IND'],
            ['nama' => 'Bahasa Inggris', 'teacher_keyword' => 'Ahmad Kurniawan', 'jumlah_jam' => 4, 'code_suffix' => 'ING'],
            ['nama' => 'Ilmu Pengetahuan Alam (IPA)', 'teacher_keyword' => 'Bella Permata', 'jumlah_jam' => 4, 'code_suffix' => 'IPA'],
            ['nama' => 'Ilmu Pengetahuan Sosial (IPS)', 'teacher_keyword' => 'Wahyu Putri', 'jumlah_jam' => 4, 'code_suffix' => 'IPS'],
            ['nama' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn)', 'teacher_keyword' => 'Bella Kurniawan', 'jumlah_jam' => 2, 'code_suffix' => 'PPN'],
            ['nama' => 'Pendidikan Agama dan Budi Pekerti', 'teacher_keyword' => 'Wahyu Kusuma', 'jumlah_jam' => 2, 'code_suffix' => 'AGM'],
            ['nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)', 'teacher_keyword' => 'Ratih Hadi', 'jumlah_jam' => 3, 'code_suffix' => 'PJK'],
            ['nama' => 'Seni Budaya', 'teacher_keyword' => 'Yulia Kusuma', 'jumlah_jam' => 3, 'code_suffix' => 'SNB'],
            ['nama' => 'Informatika', 'teacher_keyword' => 'Gilang Hadi', 'jumlah_jam' => 2, 'code_suffix' => 'INF'],
        ];

        $tingkats = ['7', '8', '9'];

        $this->command->info('Seeding SMP subjects for levels 7, 8, and 9...');

        foreach ($tingkats as $tingkat) {
            foreach ($subjectsDefinition as $def) {
                // Find teacher by name
                $teacher = Teacher::where('nama', $def['teacher_keyword'])->first();
                if (!$teacher) {
                    // Fallback to first teacher if not found
                    $teacher = Teacher::first();
                }

                $kode = 'SMP' . $tingkat . '-' . $def['code_suffix'];

                // For Matematika tingkat 7, update subject ID 1 if it exists to maintain relationships
                if ($def['nama'] === 'Matematika' && $tingkat === '7') {
                    $subject1 = Subject::find(1);
                    if ($subject1) {
                        $subject1->update([
                            'kode' => $kode,
                            'nama' => 'Matematika Kelas 7',
                            'teacher_id' => $teacher->id,
                            'tingkat' => $tingkat,
                            'jumlah_jam' => $def['jumlah_jam'],
                            'status' => 'Aktif',
                            'jurusan' => ''
                        ]);
                        continue;
                    }
                }

                Subject::create([
                    'kode' => $kode,
                    'nama' => $def['nama'] . ' Kelas ' . $tingkat,
                    'teacher_id' => $teacher->id,
                    'tingkat' => $tingkat,
                    'jumlah_jam' => $def['jumlah_jam'],
                    'status' => 'Aktif',
                    'jurusan' => ''
                ]);
            }
        }

        $this->command->info('SMP Subjects seeded successfully.');
    }
}
