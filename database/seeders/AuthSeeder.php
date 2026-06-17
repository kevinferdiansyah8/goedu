<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentProfile;
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
            $teacher->update([
                'user_id' => $userGuru->id,
                'nuptk' => '4647750652200003',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '15 Juni 1987',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 45, Kel. Cibinong, Kec. Cibinong, Kab. Bogor, Jawa Barat 16911',
                'status' => 'Aktif',
                'jabatan' => 'Guru Matematika',
                'golongan' => 'III/c',
                'pendidikan' => 'S2 — Pendidikan Matematika, Universitas Pendidikan Indonesia',
                'tahun_masuk' => '2010',
            ]);

            // Seed histories
            \App\Models\TeacherHistory::updateOrCreate(
                ['teacher_id' => $teacher->id, 'tahun' => '2025/2026'],
                ['jabatan' => 'Guru Matematika X RPL 1']
            );
            \App\Models\TeacherHistory::updateOrCreate(
                ['teacher_id' => $teacher->id, 'tahun' => '2024/2025'],
                ['jabatan' => 'Guru Matematika X IPA 1']
            );
            \App\Models\TeacherHistory::updateOrCreate(
                ['teacher_id' => $teacher->id, 'tahun' => '2023/2024'],
                ['jabatan' => 'Guru Matematika XII IPA 1']
            );

            // Seed certifications
            \App\Models\TeacherCertification::updateOrCreate(
                ['teacher_id' => $teacher->id, 'nama_sertifikasi' => 'Sertifikat Pendidik (Serdik)']
            );
            \App\Models\TeacherCertification::updateOrCreate(
                ['teacher_id' => $teacher->id, 'nama_sertifikasi' => 'Sertifikat Pelatihan Kurikulum Merdeka']
            );

            // Seed documents
            $teacher->documents()->delete();
            \App\Models\TeacherDocument::create([
                'teacher_id' => $teacher->id,
                'nama_dokumen' => 'SK Mengajar TA 2025/2026',
                'kategori' => 'Surat Keputusan',
                'file_path' => 'bukti_spp/SK_Mengajar_2025.pdf',
            ]);
            \App\Models\TeacherDocument::create([
                'teacher_id' => $teacher->id,
                'nama_dokumen' => 'SK Wali Kelas X RPL 1',
                'kategori' => 'Surat Keputusan',
                'file_path' => 'bukti_spp/SK_WaliKelas_XRPL1.pdf',
            ]);
            \App\Models\TeacherDocument::create([
                'teacher_id' => $teacher->id,
                'nama_dokumen' => 'Sertifikat Pelatihan Kurikulum Merdeka',
                'kategori' => 'Sertifikat & Pelatihan',
                'file_path' => 'bukti_spp/Sertif_KurMer_2025.pdf',
            ]);
            \App\Models\TeacherDocument::create([
                'teacher_id' => $teacher->id,
                'nama_dokumen' => 'Ijazah S2 — Pend. Matematika UPI',
                'kategori' => 'Ijazah & Transkrip',
                'file_path' => 'bukti_spp/Ijazah_S2_UPI.pdf',
            ]);
            \App\Models\TeacherDocument::create([
                'teacher_id' => $teacher->id,
                'nama_dokumen' => 'KTP',
                'kategori' => 'Dokumen Lainnya',
                'file_path' => 'bukti_spp/KTP_Bambang.pdf',
            ]);
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

        // 4. Create Orang Tua for Ahmad Fauzi (Student ID 1)
        if ($student) {
            $userOrangtua = User::updateOrCreate(
                ['email' => 'orangtua@goedu.sch.id'],
                [
                    'name' => 'Wali Ahmad Fauzi',
                    'password' => Hash::make('orangtua123'),
                    'role' => 'orangtua',
                ]
            );
            $parentProfile = ParentProfile::where('student_id', $student->id)->first();
            if ($parentProfile) {
                $parentProfile->update(['user_id' => $userOrangtua->id]);
            } else {
                ParentProfile::create([
                    'user_id' => $userOrangtua->id,
                    'student_id' => $student->id,
                    'nama_ayah' => 'Bapak Ahmad Fauzi',
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'telepon_ayah' => '081234567890',
                    'nama_ibu' => 'Ibu Ahmad Fauzi',
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'telepon_ibu' => '081234567891',
                    'alamat' => 'Jl. Merdeka No. 10, Jakarta'
                ]);
            }
        }

        // 5. Create Keuangan User
        User::updateOrCreate(
            ['email' => 'keuangan@goedu.sch.id'],
            [
                'name' => 'Staf Keuangan',
                'password' => Hash::make('keuangan123'),
                'role' => 'keuangan',
            ]
        );
    }
}
