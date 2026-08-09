<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Support\Facades\Schema;

class WeeklyScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Schedule::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Match teachers with exact names in database & assign subjects
        $teachersInfo = [
            'OKTARIYANI' => ['Bahasa Indonesia'],
            'ARIF AZAMI' => ['Bahasa Inggris'],
            'ATANG AFENDI' => ['Matematika'],
            'MAHMUD SYAAHRO WARDI' => ['IPA / Sains', 'Ilmu Pengetahuan Alam (IPA)', 'IPA'],
            'DHINI DELIANA PUTRI' => ['IPS / Sosial', 'Ilmu Pengetahuan Sosial (IPS)', 'IPS'],
            'AHMAD ARI MASYHURI' => ['Pendidikan Agama dan Budi Pekerti', 'Pendidikan Agama Islam', 'PAI'],
            'SRI SAGITA' => ['Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)', 'PJOK'],
        ];

        $teacherSubjectMap = [];

        foreach ($teachersInfo as $tName => $mapelKeywords) {
            $teacher = Teacher::where('nama', 'like', "%{$tName}%")->first();
            if (!$teacher) {
                $teacher = Teacher::create([
                    'nama' => $tName,
                    'status' => 'Aktif'
                ]);
            }

            foreach ($mapelKeywords as $mk) {
                $subj = Subject::where('nama', 'like', "%{$mk}%")->first();
                if (!$subj) {
                    $subj = Subject::create([
                        'nama' => $mapelKeywords[0],
                        'teacher_id' => $teacher->id
                    ]);
                } else {
                    $subj->update(['teacher_id' => $teacher->id]);
                }
                $teacherSubjectMap[$tName] = $subj->id;
            }
        }

        // Get or create class models for Kelas 10, Kelas 11, Kelas 12
        $classX = SchoolClass::where('nama_kelas', 'like', '%10%')->orWhere('tingkat', '10')->first();
        if (!$classX) $classX = SchoolClass::create(['tingkat' => '10', 'nama_kelas' => '10']);

        $classXI = SchoolClass::where('nama_kelas', 'like', '%11%')->orWhere('tingkat', '11')->first();
        if (!$classXI) $classXI = SchoolClass::create(['tingkat' => '11', 'nama_kelas' => '11']);

        $classXII = SchoolClass::where('nama_kelas', 'like', '%12%')->orWhere('tingkat', '12')->first();
        if (!$classXII) $classXII = SchoolClass::create(['tingkat' => '12', 'nama_kelas' => '12']);

        $classMap = [
            '10' => $classX->id,
            '11' => $classXI->id,
            '12' => $classXII->id,
            'Kelas 10' => $classX->id,
            'Kelas 11' => $classXI->id,
            'Kelas 12' => $classXII->id,
        ];

        // Raw schedule matrix provided by user with FULL teacher names
        $rawSchedules = [
            // OKTARIYANI – Bahasa Indonesia
            ['teacher' => 'OKTARIYANI', 'hari' => 'Senin', 'jam_mulai' => '07:30', 'jam_selesai' => '08:10', 'kelas' => '10'],
            ['teacher' => 'OKTARIYANI', 'hari' => 'Senin', 'jam_mulai' => '08:10', 'jam_selesai' => '08:50', 'kelas' => '10'],

            ['teacher' => 'OKTARIYANI', 'hari' => 'Kamis', 'jam_mulai' => '09:45', 'jam_selesai' => '10:25', 'kelas' => '11'],
            ['teacher' => 'OKTARIYANI', 'hari' => 'Kamis', 'jam_mulai' => '10:25', 'jam_selesai' => '11:05', 'kelas' => '11'],

            ['teacher' => 'OKTARIYANI', 'hari' => 'Sabtu', 'jam_mulai' => '07:30', 'jam_selesai' => '08:10', 'kelas' => '12'],
            ['teacher' => 'OKTARIYANI', 'hari' => 'Sabtu', 'jam_mulai' => '08:10', 'jam_selesai' => '08:50', 'kelas' => '12'],

            // ARIF AZAMI – Bahasa Inggris
            ['teacher' => 'ARIF AZAMI', 'hari' => 'Senin', 'jam_mulai' => '09:45', 'jam_selesai' => '10:25', 'kelas' => '12'],
            ['teacher' => 'ARIF AZAMI', 'hari' => 'Senin', 'jam_mulai' => '10:25', 'jam_selesai' => '11:05', 'kelas' => '12'],

            ['teacher' => 'ARIF AZAMI', 'hari' => 'Rabu', 'jam_mulai' => '07:30', 'jam_selesai' => '08:10', 'kelas' => '10'],
            ['teacher' => 'ARIF AZAMI', 'hari' => 'Rabu', 'jam_mulai' => '08:10', 'jam_selesai' => '08:50', 'kelas' => '10'],

            ['teacher' => 'ARIF AZAMI', 'hari' => 'Jumat', 'jam_mulai' => '07:30', 'jam_selesai' => '08:10', 'kelas' => '11'],
            ['teacher' => 'ARIF AZAMI', 'hari' => 'Jumat', 'jam_mulai' => '08:10', 'jam_selesai' => '08:50', 'kelas' => '11'],

            // ATANG AFENDI – Matematika
            ['teacher' => 'ATANG AFENDI', 'hari' => 'Selasa', 'jam_mulai' => '07:30', 'jam_selesai' => '08:10', 'kelas' => '11'],
            ['teacher' => 'ATANG AFENDI', 'hari' => 'Selasa', 'jam_mulai' => '08:10', 'jam_selesai' => '08:50', 'kelas' => '11'],

            ['teacher' => 'ATANG AFENDI', 'hari' => 'Kamis', 'jam_mulai' => '11:05', 'jam_selesai' => '11:45', 'kelas' => '10'],
            ['teacher' => 'ATANG AFENDI', 'hari' => 'Kamis', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '10'],

            ['teacher' => 'ATANG AFENDI', 'hari' => 'Sabtu', 'jam_mulai' => '09:45', 'jam_selesai' => '10:25', 'kelas' => '12'],
            ['teacher' => 'ATANG AFENDI', 'hari' => 'Sabtu', 'jam_mulai' => '10:25', 'jam_selesai' => '11:05', 'kelas' => '12'],

            // MAHMUD SYAAHRO WARDI – IPA
            ['teacher' => 'MAHMUD SYAAHRO WARDI', 'hari' => 'Selasa', 'jam_mulai' => '09:45', 'jam_selesai' => '10:25', 'kelas' => '12'],
            ['teacher' => 'MAHMUD SYAAHRO WARDI', 'hari' => 'Selasa', 'jam_mulai' => '10:25', 'jam_selesai' => '11:05', 'kelas' => '12'],

            ['teacher' => 'MAHMUD SYAAHRO WARDI', 'hari' => 'Rabu', 'jam_mulai' => '09:45', 'jam_selesai' => '10:25', 'kelas' => '11'],
            ['teacher' => 'MAHMUD SYAAHRO WARDI', 'hari' => 'Rabu', 'jam_mulai' => '10:25', 'jam_selesai' => '11:05', 'kelas' => '11'],

            ['teacher' => 'MAHMUD SYAAHRO WARDI', 'hari' => 'Jumat', 'jam_mulai' => '09:45', 'jam_selesai' => '10:25', 'kelas' => '10'],
            ['teacher' => 'MAHMUD SYAAHRO WARDI', 'hari' => 'Jumat', 'jam_mulai' => '10:25', 'jam_selesai' => '11:05', 'kelas' => '10'],

            // DHINI DELIANA PUTRI – IPS
            ['teacher' => 'DHINI DELIANA PUTRI', 'hari' => 'Senin', 'jam_mulai' => '11:05', 'jam_selesai' => '11:45', 'kelas' => '11'],
            ['teacher' => 'DHINI DELIANA PUTRI', 'hari' => 'Senin', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '11'],

            ['teacher' => 'DHINI DELIANA PUTRI', 'hari' => 'Rabu', 'jam_mulai' => '11:05', 'jam_selesai' => '11:45', 'kelas' => '12'],
            ['teacher' => 'DHINI DELIANA PUTRI', 'hari' => 'Rabu', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '12'],

            ['teacher' => 'DHINI DELIANA PUTRI', 'hari' => 'Sabtu', 'jam_mulai' => '11:05', 'jam_selesai' => '11:45', 'kelas' => '10'],
            ['teacher' => 'DHINI DELIANA PUTRI', 'hari' => 'Sabtu', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '10'],

            // AHMAD ARI MASYHURI – Pendidikan Agama
            ['teacher' => 'AHMAD ARI MASYHURI', 'hari' => 'Selasa', 'jam_mulai' => '11:05', 'jam_selesai' => '11:45', 'kelas' => '10'],
            ['teacher' => 'AHMAD ARI MASYHURI', 'hari' => 'Selasa', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '10'],

            ['teacher' => 'AHMAD ARI MASYHURI', 'hari' => 'Kamis', 'jam_mulai' => '07:30', 'jam_selesai' => '08:10', 'kelas' => '12'],
            ['teacher' => 'AHMAD ARI MASYHURI', 'hari' => 'Kamis', 'jam_mulai' => '08:10', 'jam_selesai' => '08:50', 'kelas' => '12'],

            ['teacher' => 'AHMAD ARI MASYHURI', 'hari' => 'Jumat', 'jam_mulai' => '09:45', 'jam_selesai' => '10:25', 'kelas' => '11'],
            ['teacher' => 'AHMAD ARI MASYHURI', 'hari' => 'Jumat', 'jam_mulai' => '10:25', 'jam_selesai' => '11:05', 'kelas' => '11'],

            // SRI SAGITA – PJOK
            ['teacher' => 'SRI SAGITA', 'hari' => 'Selasa', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '11'],
            ['teacher' => 'SRI SAGITA', 'hari' => 'Selasa', 'jam_mulai' => '12:25', 'jam_selesai' => '13:00', 'kelas' => '11'],

            ['teacher' => 'SRI SAGITA', 'hari' => 'Kamis', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '10'],
            ['teacher' => 'SRI SAGITA', 'hari' => 'Kamis', 'jam_mulai' => '12:25', 'jam_selesai' => '13:00', 'kelas' => '10'],

            ['teacher' => 'SRI SAGITA', 'hari' => 'Sabtu', 'jam_mulai' => '11:45', 'jam_selesai' => '12:25', 'kelas' => '12'],
            ['teacher' => 'SRI SAGITA', 'hari' => 'Sabtu', 'jam_mulai' => '12:25', 'jam_selesai' => '13:00', 'kelas' => '12'],
        ];

        foreach ($rawSchedules as $item) {
            $tKey = $item['teacher'];
            $subjectId = $teacherSubjectMap[$tKey] ?? Subject::first()->id;
            $classId = $classMap[$item['kelas']] ?? null;

            Schedule::create([
                'subject_id' => $subjectId,
                'school_class_id' => $classId,
                'kelas' => $item['kelas'],
                'hari' => $item['hari'],
                'jam_mulai' => $item['jam_mulai'],
                'jam_selesai' => $item['jam_selesai'],
            ]);
        }
    }
}
