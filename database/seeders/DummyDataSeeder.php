<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentProfile;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Clean up previous dummy data (keep original seeders like budi@goedu.sch.id and ahmad@goedu.sch.id)
        $this->command->info('Cleaning up previous dummy students, parents, and teachers...');
        
        // Remove students (except Ahmad Fauzi / student with ID 1)
        $studentsToDelete = Student::where('id', '>', 1)->get();
        foreach ($studentsToDelete as $student) {
            if ($student->user_id) {
                User::where('id', $student->user_id)->delete();
            }
            $parentProfile = ParentProfile::where('student_id', $student->id)->first();
            if ($parentProfile) {
                if ($parentProfile->user_id) {
                    User::where('id', $parentProfile->user_id)->delete();
                }
                $parentProfile->delete();
            }
            $student->delete();
        }

        // Remove teachers (except Budi Santoso / teacher with ID 1)
        $teachersToDelete = Teacher::where('id', '>', 1)->get();
        foreach ($teachersToDelete as $teacher) {
            if ($teacher->user_id) {
                User::where('id', $teacher->user_id)->delete();
            }
            $teacher->delete();
        }

        // 1. Ensure standard classes exist
        $classesData = [
            ['tingkat' => '7', 'nama_kelas' => 'A'],
            ['tingkat' => '7', 'nama_kelas' => 'B'],
            ['tingkat' => '8', 'nama_kelas' => 'A'],
            ['tingkat' => '8', 'nama_kelas' => 'B'],
            ['tingkat' => '9', 'nama_kelas' => 'A'],
            ['tingkat' => '9', 'nama_kelas' => 'B'],
        ];

        $classes = [];
        foreach ($classesData as $c) {
            $classes[] = SchoolClass::firstOrCreate([
                'tingkat' => $c['tingkat'],
                'nama_kelas' => $c['nama_kelas']
            ]);
        }

        // Names generator helpers
        $firstNames = ['Ahmad', 'Siti', 'Budi', 'Dewi', 'Eko', 'Fitri', 'Gilang', 'Hana', 'Irfan', 'Jasmine', 'Kevin', 'Laras', 'Muhammad', 'Nabila', 'Oky', 'Putri', 'Rian', 'Sari', 'Taufik', 'Wulan', 'Yudi', 'Zahra', 'Adit', 'Bella', 'Cakra', 'Dinda', 'Fajar', 'Gita', 'Hendra', 'Indah', 'Lutfi', 'Mega', 'Niko', 'Olivia', 'Pratama', 'Ratih', 'Satria', 'Tania', 'Wahyu', 'Yulia'];
        $lastNames = ['Saputra', 'Rahayu', 'Santoso', 'Lestari', 'Prasetyo', 'Handayani', 'Ramadhan', 'Permata', 'Hakim', 'Putri', 'Kurniawan', 'Hidayat', 'Wahyuni', 'Pratama', 'Utami', 'Nugroho', 'Sari', 'Wijaya', 'Kusuma', 'Siregar', 'Subagyo', 'Wibowo', 'Kartika', 'Setiawan', 'Nasution', 'Hadi', 'Mahendra', 'Sudarsono', 'Purnama', 'Gunawan'];

        $genderMap = [
            'Ahmad' => 'Laki-laki', 'Budi' => 'Laki-laki', 'Eko' => 'Laki-laki', 'Gilang' => 'Laki-laki', 'Irfan' => 'Laki-laki',
            'Kevin' => 'Laki-laki', 'Muhammad' => 'Laki-laki', 'Oky' => 'Laki-laki', 'Rian' => 'Laki-laki', 'Taufik' => 'Laki-laki',
            'Yudi' => 'Laki-laki', 'Adit' => 'Laki-laki', 'Cakra' => 'Laki-laki', 'Fajar' => 'Laki-laki', 'Hendra' => 'Laki-laki',
            'Lutfi' => 'Laki-laki', 'Niko' => 'Laki-laki', 'Pratama' => 'Laki-laki', 'Satria' => 'Laki-laki', 'Wahyu' => 'Laki-laki',
            'Siti' => 'Perempuan', 'Dewi' => 'Perempuan', 'Fitri' => 'Perempuan', 'Hana' => 'Perempuan', 'Jasmine' => 'Perempuan',
            'Laras' => 'Perempuan', 'Nabila' => 'Perempuan', 'Putri' => 'Perempuan', 'Sari' => 'Perempuan', 'Wulan' => 'Perempuan',
            'Zahra' => 'Perempuan', 'Bella' => 'Perempuan', 'Dinda' => 'Perempuan', 'Gita' => 'Perempuan', 'Indah' => 'Perempuan',
            'Mega' => 'Perempuan', 'Olivia' => 'Perempuan', 'Ratih' => 'Perempuan', 'Tania' => 'Perempuan', 'Yulia' => 'Perempuan'
        ];

        // 2. Generate 20 students per class
        $this->command->info('Seeding 20 students per class with name-based emails and parent accounts...');
        foreach ($classes as $class) {
            $className = $class->tingkat . '-' . $class->nama_kelas;
            $this->command->info("Processing class: {$className}");

            // Count existing students in this class
            $existingCount = Student::where('school_class_id', $class->id)->count();
            $needed = 20 - $existingCount;

            if ($needed <= 0) {
                $this->command->info("Class {$className} already has {$existingCount} students. Skipping.");
                continue;
            }

            for ($i = 0; $i < $needed; $i++) {
                $fn = $firstNames[array_rand($firstNames)];
                $ln = $lastNames[array_rand($lastNames)];
                $name = $fn . ' ' . $ln;
                $gender = $genderMap[$fn] ?? (rand(0, 1) ? 'Laki-laki' : 'Perempuan');

                // Unique NIS generation
                // format: 2026[ClassTingkat][ClassID][Index] -> e.g. 202670105
                $nis = '2026' . $class->tingkat . str_pad($class->id, 2, '0', STR_PAD_LEFT) . str_pad($i + 1 + $existingCount, 2, '0', STR_PAD_LEFT);
                
                // Name-based email (e.g. ahmad.fauzi@goedu.sch.id)
                $emailBase = strtolower(preg_replace('/[^a-zA-Z0-9.]/', '', str_replace(' ', '.', $name)));
                $email = $emailBase . '@goedu.sch.id';
                
                // Ensure unique email
                $counter = 1;
                while (User::where('email', $email)->exists()) {
                    $email = $emailBase . $counter . '@goedu.sch.id';
                    $counter++;
                }

                // Parent email based on student email
                $parentEmail = 'ortu.' . $email;

                DB::transaction(function () use ($name, $email, $parentEmail, $nis, $gender, $class, $className) {
                    $user = User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name' => $name,
                            'password' => Hash::make('siswa123'),
                            'role' => 'siswa'
                        ]
                    );

                    $student = Student::firstOrCreate(
                        ['nis' => $nis],
                        [
                            'user_id' => $user->id,
                            'nisn' => '00' . rand(10000000, 99999999),
                            'nama' => $name,
                            'kelas' => $className,
                            'school_class_id' => $class->id,
                            'tempat_lahir' => 'Jakarta',
                            'tanggal_lahir' => rand(2010, 2013) . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                            'jenis_kelamin' => $gender,
                            'agama' => 'Islam',
                            'alamat' => 'Jl. Raya No. ' . rand(1, 150) . ', Jakarta',
                            'telepon' => '08' . rand(100000000, 999999999),
                            'email' => $email
                        ]
                    );

                    // Create Parent User Account
                    $parentUser = User::firstOrCreate(
                        ['email' => $parentEmail],
                        [
                            'name' => 'Wali ' . $name,
                            'password' => Hash::make('orangtua123'),
                            'role' => 'orangtua'
                        ]
                    );

                    ParentProfile::firstOrCreate(
                        ['student_id' => $student->id],
                        [
                            'user_id' => $parentUser->id,
                            'nama_ayah' => 'Bapak ' . $student->nama,
                            'pekerjaan_ayah' => 'Swasta',
                            'telepon_ayah' => '0812' . rand(10000000, 99999999),
                            'nama_ibu' => 'Ibu ' . $student->nama,
                            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                            'telepon_ibu' => '0813' . rand(10000000, 99999999),
                            'alamat' => $student->alamat
                        ]
                    );
                });
            }
        }

        // 3. Generate 10 teachers
        $this->command->info('Seeding 10 teachers with name-based emails...');
        $existingTeachers = Teacher::count();
        $neededTeachers = 10 - $existingTeachers;

        if ($neededTeachers > 0) {
            for ($i = 0; $i < $neededTeachers; $i++) {
                $fn = $firstNames[array_rand($firstNames)];
                $ln = $lastNames[array_rand($lastNames)];
                $name = $fn . ' ' . $ln;
                $gender = $genderMap[$fn] ?? (rand(0, 1) ? 'Laki-laki' : 'Perempuan');

                $nip = '1985' . str_pad($i + 1 + $existingTeachers, 4, '0', STR_PAD_LEFT);
                
                // Name-based email (e.g. budi.santoso@goedu.sch.id)
                $emailBase = strtolower(preg_replace('/[^a-zA-Z0-9.]/', '', str_replace(' ', '.', $name)));
                $email = $emailBase . '@goedu.sch.id';
                
                // Ensure unique email
                $counter = 1;
                while (User::where('email', $email)->exists()) {
                    $email = $emailBase . $counter . '@goedu.sch.id';
                    $counter++;
                }

                DB::transaction(function () use ($name, $email, $nip, $gender) {
                    $user = User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name' => $name,
                            'password' => Hash::make('guru123'),
                            'role' => 'guru'
                        ]
                    );

                    Teacher::firstOrCreate(
                        ['nip' => $nip],
                        [
                            'user_id' => $user->id,
                            'nuptk' => '31' . rand(10000000000000, 99999999999999),
                            'nama' => $name,
                            'telepon' => '08' . rand(100000000, 999999999),
                            'tempat_lahir' => 'Bandung',
                            'tanggal_lahir' => rand(1975, 1995) . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                            'jenis_kelamin' => $gender,
                            'agama' => 'Islam',
                            'alamat' => 'Jl. Pendidikan No. ' . rand(1, 100) . ', Jakarta',
                            'status' => 'Aktif',
                            'jabatan' => 'Guru Mata Pelajaran',
                            'golongan' => 'III/b',
                            'pendidikan' => 'S1 Pendidikan',
                            'tahun_masuk' => '2019'
                        ]
                    );
                });
            }
        }
        $this->command->info('Seeding finished successfully.');
    }
}
