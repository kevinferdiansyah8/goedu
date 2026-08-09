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

        // 1. Ensure standard classes exist for MA/SMA (10, 11, 12)
        $classesData = [
            ['tingkat' => '10', 'nama_kelas' => '10'],
            ['tingkat' => '11', 'nama_kelas' => '11'],
            ['tingkat' => '12', 'nama_kelas' => '12'],
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

        // 2. Real Students Data per Class (Kelas 10, 11, 12)
        $studentsData = [
            '10' => [
                ['nisn' => '0105722223', 'nik' => '3603061401100001', 'nama' => 'FAREL ARDIANSYAH', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2010-01-14', 'nama_ibu' => 'SUTIHAT', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0102905386', 'nik' => '3604140702110002', 'nama' => 'Rangga', 'tempat_lahir' => 'Serang', 'tanggal_lahir' => '2010-02-07', 'nama_ibu' => 'Rokayah', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '3114680435', 'nik' => '3603320705110002', 'nama' => 'AHMAD IBNU FAHRI', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2011-05-07', 'nama_ibu' => 'KASIH', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '3115878903', 'nik' => '3603322105110001', 'nama' => 'FATURAHMAN', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2011-05-21', 'nama_ibu' => 'SITI HABIBAH', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0112358132', 'nik' => '3211190606110002', 'nama' => 'HASAN ALGIFARI FAUZI', 'tempat_lahir' => 'Sumedang', 'tanggal_lahir' => '2011-06-06', 'nama_ibu' => 'Sukitah', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0127177559', 'nik' => '3603320909120003', 'nama' => 'BABAY', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2012-09-09', 'nama_ibu' => 'ROPI\'AH', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0123999533', 'nik' => '3603332901120003', 'nama' => 'AHMAD MAULANA YUSUP', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2012-01-29', 'nama_ibu' => 'MASNIAH', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0124823437', 'nik' => '3603320101120004', 'nama' => 'IYUS', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2012-01-01', 'nama_ibu' => 'Silpiani', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0113130737', 'nik' => '3603333005110001', 'nama' => 'SYARIF HIDAYATULLOH', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2011-05-30', 'nama_ibu' => 'MAESAROH', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0116013216', 'nik' => '3603326009100003', 'nama' => 'PATMAH', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2010-09-20', 'nama_ibu' => 'NURHAYATI', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '0129117167', 'nik' => '3603331202120004', 'nama' => 'RIZKI MAULANA', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2012-02-12', 'nama_ibu' => 'MURNI', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0112819534', 'nik' => '3172032002121001', 'nama' => 'VALENTINO HENDRICK', 'tempat_lahir' => 'JAKARTA', 'tanggal_lahir' => '2012-02-20', 'nama_ibu' => 'ISAH', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0118016814', 'nik' => '3603326703120001', 'nama' => 'SITI AISYAH', 'tempat_lahir' => 'TANGERANG', 'tanggal_lahir' => '2012-03-27', 'nama_ibu' => 'AMINAH', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '0104328070', 'nik' => '3603325106100001', 'nama' => 'APIYAH EPI', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2010-06-11', 'nama_ibu' => 'HALIMAH', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '0113580162', 'nik' => '3603321806110003', 'nama' => 'Muhamad Risky', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2011-06-18', 'nama_ibu' => 'Rijah', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0103741232', 'nik' => '3603061209100001', 'nama' => 'Albi', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2010-09-12', 'nama_ibu' => 'Siti Warsih', 'jenis_kelamin' => 'Laki-laki'],
            ],
            '11' => [
                ['nisn' => '0063003445', 'nik' => '3603321508090001', 'nama' => 'Farhan', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2009-08-15', 'nama_ibu' => 'Mariam', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0092469669', 'nik' => '3603321204090002', 'nama' => 'Aditiya', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2009-04-12', 'nama_ibu' => 'Ratna', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0074545985', 'nik' => '3603322011090003', 'nama' => 'Ibnu', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2009-11-20', 'nama_ibu' => 'Sulastri', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0079151882', 'nik' => '3603326503090004', 'nama' => 'Wulan', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2009-03-25', 'nama_ibu' => 'Sri Astuti', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '0093408031', 'nik' => '3603325707090005', 'nama' => 'Endang', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2009-07-17', 'nama_ibu' => 'Murtini', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '0089570911', 'nik' => '3603320310090006', 'nama' => 'Abu', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2009-10-03', 'nama_ibu' => 'Kalsum', 'jenis_kelamin' => 'Laki-laki'],
            ],
            '12' => [
                ['nisn' => '3093673003', 'nik' => '3603324505080001', 'nama' => 'Ageng Fitri', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2008-05-05', 'nama_ibu' => 'Kurnia', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '3090761328', 'nik' => '3603325112080002', 'nama' => 'Adinda fajarina', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2008-12-11', 'nama_ibu' => 'Hartati', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '3090642446', 'nik' => '3603326802080003', 'nama' => 'Puspa Hadi', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2008-02-28', 'nama_ibu' => 'Wiwin', 'jenis_kelamin' => 'Perempuan'],
                ['nisn' => '0094230615', 'nik' => '3603321406080004', 'nama' => 'Marsum', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2008-06-14', 'nama_ibu' => 'Rasmanah', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0074450125', 'nik' => '3603322209080005', 'nama' => 'M. Aryadilah', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2008-09-22', 'nama_ibu' => 'Aisyah', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '3082586557', 'nik' => '3603321001080006', 'nama' => 'Hafid', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2008-01-10', 'nama_ibu' => 'Samsiah', 'jenis_kelamin' => 'Laki-laki'],
                ['nisn' => '0094044279', 'nik' => '3603324810080007', 'nama' => 'Novi Angraeni', 'tempat_lahir' => 'Tangerang', 'tanggal_lahir' => '2008-10-08', 'nama_ibu' => 'Yuyun', 'jenis_kelamin' => 'Perempuan'],
            ]
        ];

        $this->command->info('Seeding real students per class with user accounts and parent profiles...');
        foreach ($classes as $class) {
            $tingkatKey = (string) $class->tingkat;
            $list = $studentsData[$tingkatKey] ?? [];

            foreach ($list as $idx => $sData) {
                $name = $sData['nama'];
                $gender = $sData['jenis_kelamin'];
                $nis = '2026' . $class->tingkat . str_pad($idx + 1, 2, '0', STR_PAD_LEFT);

                // Email base
                $emailBase = strtolower(preg_replace('/[^a-zA-Z0-9.]/', '', str_replace(' ', '.', $name)));
                $emailBase = preg_replace('/\.+/', '.', $emailBase);
                $email = trim($emailBase, '.') . '@goedu.sch.id';

                $counter = 1;
                while (User::where('email', $email)->exists()) {
                    $email = $emailBase . $counter . '@goedu.sch.id';
                    $counter++;
                }

                $parentEmail = 'ortu.' . $email;

                DB::transaction(function () use ($name, $email, $parentEmail, $nis, $gender, $class, $sData) {
                    $user = User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name' => $name,
                            'password' => Hash::make('siswa123'),
                            'role' => 'siswa'
                        ]
                    );

                    $student = Student::firstOrCreate(
                        ['nisn' => $sData['nisn']],
                        [
                            'user_id' => $user->id,
                            'nis' => $nis,
                            'nik' => $sData['nik'],
                            'nama' => $name,
                            'kelas' => $class->tingkat,
                            'school_class_id' => $class->id,
                            'tempat_lahir' => $sData['tempat_lahir'],
                            'tanggal_lahir' => $sData['tanggal_lahir'],
                            'jenis_kelamin' => $gender,
                            'agama' => 'Islam',
                            'alamat' => 'Jl. Raya Tangerang No. ' . rand(1, 100),
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
                            'nama_ibu' => $sData['nama_ibu'],
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
