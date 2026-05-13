<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class AuthSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin
        User::updateOrCreate(
            ['email' => 'admin@goedu.sch.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Create Guru (Budi Santoso)
        $teacher = Teacher::find(1);
        if ($teacher) {
            $userGuru = User::updateOrCreate(
                ['email' => 'budi@goedu.sch.id'],
                [
                    'name' => $teacher->nama,
                    'password' => Hash::make('guru123'),
                    'role' => 'guru',
                ]
            );
            $teacher->update(['user_id' => $userGuru->id]);
        }

        // 3. Create Siswa (Ahmad Fauzi)
        $student = Student::find(1);
        if ($student) {
            $userSiswa = User::updateOrCreate(
                ['email' => 'ahmad@goedu.sch.id'],
                [
                    'name' => $student->nama,
                    'password' => Hash::make('siswa123'),
                    'role' => 'siswa',
                ]
            );
            $student->update(['user_id' => $userSiswa->id]);
        }
    }
}
