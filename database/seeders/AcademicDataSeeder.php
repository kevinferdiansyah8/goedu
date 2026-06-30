<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\Grade;
use App\Models\SchoolClass;

class AcademicDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Cleaning up existing academic records...');
        
        // Delete child tables first to avoid foreign key constraint errors
        StudentAssignment::query()->delete();
        Assignment::query()->delete();
        Schedule::query()->delete();
        LearningMaterial::query()->delete();
        Grade::query()->delete();

        $classes = SchoolClass::all();

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $this->command->info('Seeding academic data for all classes...');

        foreach ($classes as $class) {
            $className = $class->tingkat . '-' . $class->nama_kelas;
            $students = Student::where('school_class_id', $class->id)->get();
            $subjects = Subject::where('tingkat', $class->tingkat)->get();

            if ($subjects->isEmpty()) {
                $this->command->warn("No subjects found for tingkat {$class->tingkat}. Skipping class {$className}.");
                continue;
            }

            $this->command->info("Processing {$students->count()} students in class {$className}...");

            // 1. Seed schedules (distribute 10 subjects over 5 days)
            foreach ($subjects as $idx => $subject) {
                $dayIndex = floor($idx / 2);
                $day = $days[$dayIndex] ?? 'Senin';
                $slot = $idx % 2;
                $jamMulai = $slot == 0 ? '07:00' : '08:45';
                $jamSelesai = $slot == 0 ? '08:30' : '10:15';

                Schedule::create([
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'kelas' => $className,
                    'hari' => $day,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                ]);
            }

            // 2. Seed learning materials and assignments for each subject
            foreach ($subjects as $subject) {
                // Materials
                LearningMaterial::create([
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'judul' => 'Bab 1: Pendahuluan ' . $subject->nama,
                    'file_path' => 'materi_bab1_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $subject->nama)) . '.pdf',
                    'ukuran_file' => '2.' . rand(1, 9) . ' MB',
                    'tanggal_upload' => date('Y-m-d', strtotime('-' . rand(5, 10) . ' days')),
                ]);

                LearningMaterial::create([
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'judul' => 'Bab 2: Pokok Bahasan ' . $subject->nama,
                    'file_path' => 'materi_bab2_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $subject->nama)) . '.pdf',
                    'ukuran_file' => '1.' . rand(1, 9) . ' MB',
                    'tanggal_upload' => date('Y-m-d', strtotime('-' . rand(1, 4) . ' days')),
                ]);

                // Assignments
                $assignment1 = Assignment::create([
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'judul' => 'Tugas Mandiri 1: ' . $subject->nama,
                    'deskripsi' => 'Kerjakan soal latihan nomor 1 sampai 10 di buku cetak halaman ' . rand(10, 50),
                    'deadline' => date('Y-m-d', strtotime('+' . rand(2, 5) . ' days')),
                ]);

                $assignment2 = Assignment::create([
                    'subject_id' => $subject->id,
                    'school_class_id' => $class->id,
                    'judul' => 'Tugas Kelompok 1: Analisis ' . $subject->nama,
                    'deskripsi' => 'Diskusikan bab materi terkait dan buat ringkasan minimal 3 halaman.',
                    'deadline' => date('Y-m-d', strtotime('+' . rand(6, 12) . ' days')),
                ]);

                // 3. Seed student assignments submissions & Grades for each student
                foreach ($students as $student) {
                    // Assignment 1 (80% submission rate)
                    $hasFinished1 = rand(1, 10) <= 8;
                    StudentAssignment::create([
                        'student_id' => $student->id,
                        'assignment_id' => $assignment1->id,
                        'tanggal_kumpul' => $hasFinished1 ? date('Y-m-d', strtotime('-' . rand(1, 3) . ' days')) : null,
                        'file_jawaban' => $hasFinished1 ? 'jawaban_tugas_' . $student->nis . '.pdf' : null,
                        'nilai' => $hasFinished1 ? rand(75, 98) : null,
                        'feedback' => $hasFinished1 ? 'Tugas diperiksa dengan baik. Pertahankan!' : null,
                        'status' => $hasFinished1 ? 'Selesai' : 'Belum',
                    ]);

                    // Assignment 2 (30% submission rate)
                    $hasFinished2 = rand(1, 10) <= 3;
                    StudentAssignment::create([
                        'student_id' => $student->id,
                        'assignment_id' => $assignment2->id,
                        'tanggal_kumpul' => $hasFinished2 ? date('Y-m-d', strtotime('-' . rand(0, 1) . ' days')) : null,
                        'file_jawaban' => $hasFinished2 ? 'jawaban_tugas2_' . $student->nis . '.pdf' : null,
                        'nilai' => $hasFinished2 ? rand(70, 95) : null,
                        'feedback' => $hasFinished2 ? 'Hasil analisis cukup baik.' : null,
                        'status' => $hasFinished2 ? 'Selesai' : 'Belum',
                    ]);

                    // Subject Report Grades
                    $uh = rand(70, 95);
                    $uts = rand(70, 95);
                    $uas = rand(70, 95);
                    $akhir = round(($uh * 0.4) + ($uts * 0.3) + ($uas * 0.3));

                    Grade::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'nilai_uh' => $uh,
                        'nilai_uts' => $uts,
                        'nilai_uas' => $uas,
                        'nilai_akhir' => $akhir,
                        'score' => $akhir
                    ]);
                }
            }
        }

        $this->command->info('Academic data seeded successfully.');
    }
}
