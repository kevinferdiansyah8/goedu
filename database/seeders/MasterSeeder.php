<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ParentProfile;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // Add Parents to existing Students
        $students = Student::all();
        foreach ($students as $student) {
            ParentProfile::create([
                'student_id' => $student->id,
                'nama_ayah' => 'Bapak ' . $student->nama,
                'pekerjaan_ayah' => 'Wiraswasta',
                'telepon_ayah' => '0812' . rand(10000000, 99999999),
                'nama_ibu' => 'Ibu ' . $student->nama,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'telepon_ibu' => '0813' . rand(10000000, 99999999),
                'alamat' => 'Jl. Merdeka No. ' . rand(1, 100) . ', Jakarta'
            ]);

            // Attendance
            Attendance::create(['student_id' => $student->id, 'tanggal' => '2023-10-24', 'jam_masuk' => '06:55', 'jam_pulang' => '14:00', 'status' => 'Hadir']);
            Attendance::create(['student_id' => $student->id, 'tanggal' => '2023-10-23', 'jam_masuk' => '06:58', 'jam_pulang' => '14:05', 'status' => 'Hadir']);
            Attendance::create(['student_id' => $student->id, 'tanggal' => '2023-10-20', 'jam_masuk' => null, 'jam_pulang' => null, 'status' => 'Izin', 'keterangan' => 'Acara Keluarga']);
        }

        // Teachers
        $teachersData = [
            ['nip' => '198001', 'nama' => 'Budi Santoso', 'telepon' => '0811'],
            ['nip' => '198002', 'nama' => 'Siti Aminah', 'telepon' => '0812'],
            ['nip' => '198003', 'nama' => 'Agus Dermawan', 'telepon' => '0813'],
            ['nip' => '198004', 'nama' => 'Eko Prasetyo', 'telepon' => '0814'],
            ['nip' => '198005', 'nama' => 'Dewi Lestari', 'telepon' => '0815']
        ];
        
        foreach ($teachersData as $tData) {
            $t = Teacher::create($tData);
            
            // Subjects
           $mapel = match($t->nama) {
               'Budi Santoso' => 'Matematika',
               'Siti Aminah' => 'Bahasa Indonesia',
               'Agus Dermawan' => 'Fisika',
               'Eko Prasetyo' => 'Biologi',
               'Dewi Lestari' => 'Sejarah',
               default => 'Kimia'
           };
           $subject = Subject::create(['nama' => $mapel, 'teacher_id' => $t->id]);

           // Learning Materials
           LearningMaterial::create([
               'subject_id' => $subject->id, 
               'judul' => 'Bab 1: Pengantar ' . $subject->nama, 
               'file_path' => strtolower($subject->nama) . '.pdf',
               'ukuran_file' => '2.5 MB',
               'tanggal_upload' => '2023-10-20'
           ]);

           // Schedule for X-A
           Schedule::create(['subject_id' => $subject->id, 'kelas' => 'X-A', 'hari' => 'Senin', 'jam_mulai' => '07:00', 'jam_selesai' => '08:30']);

           // Assignment
           $assignment = Assignment::create([
               'subject_id' => $subject->id,
               'judul' => 'Latihan Soal ' . $subject->nama,
               'deskripsi' => 'Kerjakan Latihan Bab 1',
               'deadline' => '2023-10-30'
           ]);

           // Student Assignments & Grades
           foreach ($students as $student) {
               StudentAssignment::create([
                   'student_id' => $student->id,
                   'assignment_id' => $assignment->id,
                   'tanggal_kumpul' => '2023-10-28',
                   'file_jawaban' => 'tugas.pdf',
                   'nilai' => rand(70, 95),
                   'feedback' => 'Bagus',
                   'status' => 'Selesai'
               ]);

               Grade::create([
                   'student_id' => $student->id,
                   'subject_id' => $subject->id,
                   'nilai_uh' => rand(75, 95),
                   'nilai_uts' => rand(75, 95),
                   'nilai_uas' => rand(75, 95),
                   'nilai_akhir' => rand(75, 95)
               ]);
           }
        }

        // Library Books
        $books = [
            ['judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'kategori' => 'Novel', 'stok' => 5],
            ['judul' => 'Bumi', 'penulis' => 'Tere Liye', 'kategori' => 'Fiksi', 'stok' => 3],
            ['judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'kategori' => 'Self Improvement', 'stok' => 8]
        ];
        foreach ($books as $b) {
            $book = Book::create($b);
            foreach ($students->take(2) as $s) {
                BookLoan::create([
                    'student_id' => $s->id,
                    'book_id' => $book->id,
                    'tanggal_pinjam' => '2023-10-01',
                    'tanggal_kembali' => '2023-10-08',
                    'status' => 'Dipinjam',
                    'denda' => 0
                ]);
            }
        }

        // Events
        Event::create(['tipe_info' => 'Pengumuman', 'judul' => 'Libur Nasional', 'tanggal_pelaksanaan' => '2023-10-20', 'deskripsi' => 'Sekolah libur.']);
        Event::create(['tipe_info' => 'Event', 'judul' => 'Pentas Seni', 'tanggal_pelaksanaan' => '2023-11-15', 'lokasi' => 'Aula Utama']);
    }
}
