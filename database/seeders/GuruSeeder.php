<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruData = [
            [
                'nama' => 'OKTARIYANI',
                'nik' => '1501145410880004',
                'nuptk' => null,
                'status_kepegawaian' => 'Non PNS',
                'status' => 'Aktif',
                'nip' => null,
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'BANJIT LAMPUNG',
                'tanggal_lahir' => '1988-10-14',
                'email' => 'oktariyani@goedu.sch.id',
                'subject_search' => 'Bahasa Indonesia',
                'jabatan' => 'Guru Bahasa Indonesia',
            ],
            [
                'nama' => 'ARIF AZAMI',
                'nik' => '3603061808920002',
                'nuptk' => null,
                'status_kepegawaian' => 'Non PNS',
                'status' => 'Aktif',
                'nip' => null,
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'TANGERANG',
                'tanggal_lahir' => '1992-08-18',
                'email' => 'arif.azami@goedu.sch.id',
                'subject_search' => 'Bahasa Inggris',
                'jabatan' => 'Guru Bahasa Inggris',
            ],
            [
                'nama' => 'ATANG AFENDI',
                'nik' => '3603320207910002',
                'nuptk' => null,
                'status_kepegawaian' => 'Non PNS',
                'status' => 'Aktif',
                'nip' => null,
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'TANGERANG',
                'tanggal_lahir' => '1991-07-02',
                'email' => 'atang.afendi@goedu.sch.id',
                'subject_search' => 'Matematika',
                'jabatan' => 'Guru Matematika',
            ],
            [
                'nama' => 'MAHMUD SYAAHRO WARDI',
                'nik' => '3524111608910001',
                'nuptk' => null,
                'status_kepegawaian' => 'Non PNS',
                'status' => 'Aktif',
                'nip' => null,
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'LAMONGAN',
                'tanggal_lahir' => '1991-08-16',
                'email' => 'mahmud.syaahro@goedu.sch.id',
                'subject_search' => 'IPA',
                'jabatan' => 'Guru IPA',
            ],
            [
                'nama' => 'DHINI DELIANA PUTRI',
                'nik' => '3603276407030002',
                'nuptk' => null,
                'status_kepegawaian' => 'Non PNS',
                'status' => 'Aktif',
                'nip' => null,
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'TANGERANG',
                'tanggal_lahir' => '2003-07-24',
                'email' => 'dhini.deliana@goedu.sch.id',
                'subject_search' => 'IPS',
                'jabatan' => 'Guru IPS',
            ],
            [
                'nama' => 'AHMAD ARI MASYHURI',
                'nik' => '3174061307740003',
                'nuptk' => null,
                'status_kepegawaian' => 'Non PNS',
                'status' => 'Aktif',
                'nip' => null,
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'SUMENEP',
                'tanggal_lahir' => '1974-07-13',
                'email' => 'ahmad.ari@goedu.sch.id',
                'subject_search' => 'Agama',
                'jabatan' => 'Guru Agama Islam',
            ],
            [
                'nama' => 'SRI SAGITA',
                'nik' => '3604116001000005',
                'nuptk' => null,
                'status_kepegawaian' => 'Non PNS',
                'status' => 'Aktif',
                'nip' => null,
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'SERANG',
                'tanggal_lahir' => '2000-01-20',
                'email' => 'sri.sagita@goedu.sch.id',
                'subject_search' => 'PJOK',
                'jabatan' => 'Guru PJOK',
            ],
        ];

        foreach ($guruData as $data) {
            DB::transaction(function () use ($data) {
                // Create or update User
                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    [
                        'name' => $data['nama'],
                        'password' => Hash::make('guru123'),
                        'role' => 'guru',
                    ]
                );

                // Create or update Teacher
                $teacher = Teacher::updateOrCreate(
                    ['nik' => $data['nik']],
                    [
                        'user_id' => $user->id,
                        'nama' => $data['nama'],
                        'nip' => $data['nip'],
                        'nuptk' => $data['nuptk'],
                        'status_kepegawaian' => $data['status_kepegawaian'],
                        'status' => $data['status'],
                        'jenis_kelamin' => $data['jenis_kelamin'],
                        'tempat_lahir' => $data['tempat_lahir'],
                        'tanggal_lahir' => $data['tanggal_lahir'],
                        'jabatan' => $data['jabatan'],
                        'tipe' => 'Guru',
                    ]
                );

                // Assign subject(s) if matching subjects exist
                if (!empty($data['subject_search'])) {
                    Subject::where('nama', 'like', '%' . $data['subject_search'] . '%')
                        ->update(['teacher_id' => $teacher->id]);
                }
            });
        }
    }
}
