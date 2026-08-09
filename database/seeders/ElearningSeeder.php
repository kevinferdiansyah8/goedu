<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ElearningSession;
use App\Models\ElearningMaterial;
use App\Models\ElearningAssignment;
use App\Models\ElearningAssignmentSubmission;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\ElearningQuestion;
use App\Models\ElearningStudentAnswer;
use App\Models\TeacherAttendance;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ElearningSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get Teachers
        $teacherAhmad = Teacher::where('nama', 'like', '%AHMAD ARI%')->first();
        if (!$teacherAhmad) {
            $teacherAhmad = Teacher::create(['nama' => 'AHMAD ARI MASYHURI', 'status' => 'Aktif']);
        }

        $teacherOkta = Teacher::where('nama', 'like', '%OKTARIYANI%')->first();
        if (!$teacherOkta) {
            $teacherOkta = Teacher::create(['nama' => 'OKTARIYANI', 'status' => 'Aktif']);
        }

        // 2. Get Subjects
        $subjPai = Subject::where('nama', 'like', '%Agama%')->orWhere('nama', 'like', '%PAI%')->first();
        if (!$subjPai) {
            $subjPai = Subject::create([
                'nama' => 'Pendidikan Agama dan Budi Pekerti',
                'teacher_id' => $teacherAhmad->id
            ]);
        } else {
            $subjPai->update(['teacher_id' => $teacherAhmad->id]);
        }

        $subjIndo = Subject::where('nama', 'like', '%Indonesia%')->first();
        if (!$subjIndo) {
            $subjIndo = Subject::create([
                'nama' => 'Bahasa Indonesia',
                'teacher_id' => $teacherOkta->id
            ]);
        } else {
            $subjIndo->update(['teacher_id' => $teacherOkta->id]);
        }

        // 3. Get Classes
        $classX = SchoolClass::where('nama_kelas', 'like', '%10%')->orWhere('tingkat', '10')->first();
        if (!$classX) $classX = SchoolClass::create(['tingkat' => '10', 'nama_kelas' => '10']);

        $classXI = SchoolClass::where('nama_kelas', 'like', '%11%')->orWhere('tingkat', '11')->first();
        if (!$classXI) $classXI = SchoolClass::create(['tingkat' => '11', 'nama_kelas' => '11']);

        // 4. Session Configurations
        $sessionsData = [
            // Pertemuan 1 - 13 Juli 2026
            [
                'teacher' => $teacherAhmad,
                'subject' => $subjPai,
                'class' => $classXI,
                'tanggal' => '2026-07-13 07:30:00',
                'deadline' => '2026-07-20 23:59:59',
                'judul' => 'Pertemuan 1 - Meneladani Kejujuran dalam Kehidupan Sehari-hari',
                'deskripsi' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\nSemoga seluruh siswa-siswi Kelas 11 MA senantiasa diberikan kesehatan dan keberkahan dalam menuntut ilmu. Pada kesempatan hari ini, Bapak memohon maaf yang sebesar-besarnya tidak dapat hadir untuk mendampingi pembelajaran secara tatap muka di kelas karena sedang bertugas mengikuti kegiatan Seminar Pendidikan Agama Islam se-Kabupaten Tangerang. Sebagai gantinya, pembelajaran kita hari ini dilaksanakan secara daring (E-Learning) melalui aplikasi GoEdu.\n\nPembelajaran hari ini akan membahas tentang pentingnya perilaku jujur (as-sidq) sebagai cerminan keimanan seorang muslim dalam kehidupan pribadi, madrasah, dan masyarakat. Silakan pelajari secara saksama ringkasan materi dan panduan yang telah Bapak unggah. Setelah mempelajari materi, silakan kerjakan tugas yang telah disediakan di buku catatan/kertas kerja Anda, dan dikumpulkan secara langsung (offline) saat pertemuan tatap muka di kelas minggu depan.\n\n### Tujuan Pembelajaran:\n1. Siswa mampu memahami hakikat kejujuran (as-sidq) menurut Al-Qur'an dan Hadis.\n2. Siswa mampu mengidentifikasi keutamaan dan hikmah memiliki sifat jujur.\n3. Siswa mampu menerapkan sikap jujur dalam perkataan, perbuatan, dan niat di kehidupan sehari-hari.\n\n### Materi yang Dipelajari:\n- Definisi dan tingkatan kejujuran (as-sidq) dalam Islam.\n- Dalil Al-Qur'an (QS. At-Taubah: 119) tentang perintah bertakwa dan bersamanya orang-orang yang jujur.\n- Hadis Nabi SAW mengenai kejujuran membimbing ke kebaikan dan surga (HR. Bukhari & Muslim).\n- Bentuk-bentuk kejujuran: jujur dalam lisan, jujur dalam niat/kemauan, dan jujur dalam perbuatan.\n- Dampak negatif dari kebohongan (al-kadzib) terhadap hati dan tatanan sosial.\n- Meneladani sifat Siddiq Nabi Muhammad SAW dalam berinteraksi sehari-hari.\n- Penerapan nilai kejujuran saat ujian sekolah dan kegiatan akademik madrasah.\n\n### Estimasi Waktu Belajar:\n90 Menit (2 Jam Pelajaran)\n\nDemikian petunjuk pembelajaran E-Learning untuk hari ini. Semoga materi ini menguatkan karakter dan akhlakul karimah kita semua. Apabila terdapat hal yang belum dipahami, silakan ajukan pertanyaan pada kolom diskusi. Terima kasih atas perhatian dan kedisiplinannya.\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'instruksi_tugas' => "1. Rangkumlah dalil Al-Qur'an dan Hadis tentang kejujuran beserta artinya di buku catatan PAI.\n2. Buatlah refleksi singkat (minimal 1 halaman) mengenai pengalaman pribadi Anda dalam menerapkan sikap jujur di lingkungan sekolah maupun keluarga.\n3. Bawa dan kumpulkan buku catatan/lembar kerja tugas Anda secara langsung (offline) kepada Bapak di kelas saat jam pelajaran PAI pada minggu depan (Senin, 20 Juli 2026).",
                'file_materi' => 'elearning/materi/PAI_Kelas11_Pertemuan1_Kejujuran.pdf'
            ],

            // Pertemuan 2 - 21 Juli 2026
            [
                'teacher' => $teacherOkta,
                'subject' => $subjIndo,
                'class' => $classX,
                'tanggal' => '2026-07-21 07:30:00',
                'deadline' => '2026-07-28 23:59:59',
                'judul' => 'Pertemuan 1 - Teks Laporan Hasil Observasi',
                'deskripsi' => "Assalamu’alaikum Warahmatullahi Wabarakatuh dan selamat pagi anak-anakku siswa-siswi Kelas 10 MA.\nSemoga kalian semua selalu bersemangat dalam menimba ilmu di semester baru ini. Ibu menginformasikan bahwa pada hari ini Ibu tidak dapat hadir mengajar langsung di kelas dikarenakan harus menghadiri Rapat Koordinasi Pengurus Yayasan Pendidikan Baitul Ahsin. Oleh karena itu, kegiatan belajar mengajar kita dialihkan secara mandiri melalui modul E-Learning di aplikasi GoEdu.\n\nPada awal semester ini, kita akan mengkaji bab pertama mengenai Teks Laporan Hasil Observasi (LHO). Kalian akan mempelajari bagaimana mengamati objek lingkungan secara objektif dan menyusunnya menjadi laporan ilmiah yang sistematis. Setelah mempelajari materi, silakan kerjakan tugas yang telah disediakan dan kumpulkan melalui menu Tugas di aplikasi GoEdu paling lambat minggu depan sesuai batas waktu yang telah ditentukan.\n\n### Tujuan Pembelajaran:\n1. Siswa mampu mengidentifikasi isi dan informasi penting dalam Teks Laporan Hasil Observasi (LHO).\n2. Siswa mampu menganalisis struktur Teks LHO (Pernyataan Umum, Deskripsi Bagian, Deskripsi Manfaat).\n3. Siswa mampu mengidentifikasi kaidah kebahasaan spesifik dalam Teks LHO (verba material, nomina, frasa).\n\n### Materi yang Dipelajari:\n- Pengertian dan karakteristik utama Teks Laporan Hasil Observasi.\n- Perbedaan Teks LHO dengan teks deskripsi umum.\n- Struktur pembangun Teks LHO: Pernyataan Umum / Klasifikasi, Deskripsi Bagian, dan Deskripsi Manfaat/Penutup.\n- Kaidah kebahasaan Teks LHO: Penggunaan kalimat definisi, kalimat deskripsi, dan istilah teknis ilmiah.\n- Penggunaan verba relasional dan imbuhan asing dalam teks ilmiah sederhana.\n- Langkah-langkah melakukan pengamatan/observasi objek sekitar secara objektif.\n- Penyuntingan tanda baca, ejaan (PUEBI/EYD), dan keefektifan kalimat pada laporan.\n\n### Estimasi Waktu Belajar:\n90 Menit (2 Jam Pelajaran)\n\nSelamat belajar dan tingkatkan terus kepekaan literasi kalian. Ibu yakin kalian semua mampu menyelesaikan tugas ini dengan sangat baik dan tepat waktu. Terima kasih atas pengertian dan kerjasamanya.\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'instruksi_tugas' => "1. Pilihlah 1 objek tanaman atau benda di lingkungan sekitar rumah Anda.\n2. Lakukan pengamatan singkat dan susunlah Teks Laporan Hasil Observasi sederhana (minimal 3 paragraf sesuai struktur LHO).\n3. Ketik atau tulis rapi di kertas, lalu kirimkan berkasnya dalam format PDF/Foto melalui menu Tugas di aplikasi GoEdu paling lambat minggu depan.",
                'file_materi' => 'elearning/materi/BIndo_Kelas10_Pertemuan1_LHO.pdf'
            ],

            // Pertemuan 3 - 28 Juli 2026
            [
                'teacher' => $teacherAhmad,
                'subject' => $subjPai,
                'class' => $classX,
                'tanggal' => '2026-07-28 07:30:00',
                'deadline' => '2026-08-04 23:59:59',
                'judul' => 'Pertemuan 2 - Iman kepada Kitab-kitab Allah SWT',
                'deskripsi' => "Assalamu’alaikum Warahmatullahi Wabarakatuh.\nSalam sejahtera untuk kita semua, semoga anak-anakku Kelas 10 MA selalu dalam lindungan Allah SWT. Pada pertemuan hari ini, Bapak berhalangan hadir di kelas karena sedang ditugaskan oleh Yayasan untuk mengikuti Workshop & Lokakarya Kurikulum Madrasah. Agar proses pembelajaran kita tetap berjalan efektif, materi pembelajaran disajikan secara daring melalui portal E-Learning GoEdu.\n\nPembelajaran PAI hari ini akan mendalami rukun iman yang ketiga, yaitu Iman kepada Kitab-kitab Allah SWT (Taurat, Zabur, Injil, dan Al-Qur'an). Kita akan membahas kedudukan Al-Qur'an sebagai penyempurna kitab-kitab terdahulu dan petunjuk hidup bagi umat manusia. Setelah mempelajari materi, silakan kerjakan tugas yang telah disediakan dan kumpulkan melalui menu Tugas di aplikasi GoEdu paling lambat minggu depan sesuai batas waktu yang telah ditentukan.\n\n### Tujuan Pembelajaran:\n1. Siswa mampu menjelaskan pengertian dan hakikat beriman kepada kitab-kitab Allah SWT.\n2. Siswa mampu menyebutkan nabi penerima kitab Allah serta isi kandungan utamanya.\n3. Siswa mampu menerapkan kebiasaan membaca, memahami, dan mengamalkan Al-Qur'an dalam kehidupan sehari-hari.\n\n### Materi yang Dipelajari:\n- Pengertian iman kepada kitab-kitab Allah SWT serta perbedaannya dengan suhuf.\n- Nama-nama kitab Allah beserta Nabi/Rasul penerimanya (Kitab Taurat, Zabur, Injil, dan Al-Qur'an).\n- Kedudukan Al-Qur'an sebagai kitab suci terakhir yang membenarkan dan menyempurnakan kitab sebelumnya (Muhaimin).\n- Keutamaan dan keistimewaan Al-Qur'an yang terpelihara kemurniannya hingga akhir zaman.\n- Tata cara dan adab membaca Al-Qur'an (Tilawah, Tadabbur, Hafalan).\n- Perilaku terpuji yang mencerminkan iman kepada kitab Allah dalam kehidupan madrasah dan bermasyarakat.\n- Bahaya mengabaikan ajaran Al-Qur'an dalam menghadapi era modernisasi.\n\n### Estimasi Waktu Belajar:\n90 Menit (2 Jam Pelajaran)\n\nSemoga pembelajaran ini menambah rasa kecintaan kita terhadap Al-Qur'anul Karim. Tetap jaga kedisiplinan dan sholat tepat waktu. Jika ada pertanyaan terkait materi, silakan tulis di forum diskusi.\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'instruksi_tugas' => "1. Jawablah 5 soal pemahaman materi tentang Kitab-kitab Allah yang tertera di modul E-Learning.\n2. Tulislah 1 ayat Al-Qur'an beserta terjemahannya tentang kewajiban beriman kepada kitab Allah (QS. An-Nisa: 136).\n3. Kumpulkan lembar jawaban Anda dengan cara diunggah ke menu Tugas di aplikasi GoEdu paling lambat minggu depan.",
                'file_materi' => 'elearning/materi/PAI_Kelas10_Pertemuan2_KitabAllah.pdf'
            ],

            // Pertemuan 4 - 2 Agustus 2026
            [
                'teacher' => $teacherOkta,
                'subject' => $subjIndo,
                'class' => $classXI,
                'tanggal' => '2026-08-02 07:30:00',
                'deadline' => '2026-08-09 23:59:59',
                'judul' => 'Pertemuan 2 - Teks Eksposisi',
                'deskripsi' => "Assalamu’alaikum Warahmatullahi Wabarakatuh dan selamat pagi siswa-siswi Kelas 11 MA.\nSemoga kalian selalu sehat, semangat, dan diberikan kemudahan dalam belajar. Pada kesempatan pembelajaran kali ini, Ibu memohon izin tidak dapat hadir secara langsung di dalam kelas karena sedang menjalankan tugas dinas dalam Rapat Evaluasi Program Pendidikan Yayasan. Meskipun demikian, KBM kita tetap dilaksanakan secara mandiri melalui E-Learning GoEdu.\n\nMateri yang akan kita bahas pada pertemuan kedua ini adalah Teks Eksposisi. Teks eksposisi merupakan jenis teks nonfiksi yang bertujuan menyampaikan argumentasi dan pendapat logis berlandaskan fakta yang akurat. Silakan baca uraian materi dan contoh analisis teks yang sudah Ibu siapkan. Setelah mempelajari materi, silakan kerjakan tugas yang telah disediakan dan kumpulkan melalui menu Tugas di aplikasi GoEdu paling lambat minggu depan sesuai batas waktu yang telah ditentukan.\n\n### Tujuan Pembelajaran:\n1. Siswa mampu mengidentifikasi gagasan utama dan argumentasi dalam Teks Eksposisi.\n2. Siswa mampu menganalisis struktur Teks Eksposisi (Tesis, Argumentasi, Penegasan Ulang).\n3. Siswa mampu menyusun paragraf eksposisi dengan bahasa yang lugas, padat, dan didukung fakta yang shahih.\n\n### Materi yang Dipelajari:\n- Pengertian, fungsi, dan tujuan utama penulisan Teks Eksposisi.\n- Struktur pembangun Teks Eksposisi: Tesis (Pernyataan Pendapat), Argumentasi (Alasan/Fakta), dan Penegasan Ulang (Rekomendasi).\n- Perbedaan fakta dan opini dalam pendukung argumentasi teks.\n- Unsur kebahasaan Teks Eksposisi: Pronomina (kata ganti), Konjungsi kausalitas/argumentatif, dan kata teknis/leksikal.\n- Pola pengembangan Teks Eksposisi (Pola Umum-Khusus, Pola Khusus-Umum, Ilustrasi, Perbandingan).\n- Teknik menanggapi isi teks eksposisi secara kritis dan santun.\n- Langkah-langkah menyunting Teks Eksposisi agar sesuai dengan PUEBI dan kaidah bahasa Indonesia yang baik dan benar.\n\n### Estimasi Waktu Belajar:\n90 Menit (2 Jam Pelajaran)\n\nTetap bersemangat mengembangkan kemampuan bernalar kritis dan keahlian menulis kalian. Ibu tunggu hasil pengerjaan terbaik dari kalian di aplikasi GoEdu. Terima kasih dan selamat belajar.\nWassalamu’alaikum Warahmatullahi Wabarakatuh.",
                'instruksi_tugas' => "1. Bacalah contoh teks eksposisi isu lingkungan yang terdapat di modul pembelajaran.\n2. Analisislah bagian Tesis, Argumentasi, dan Penegasan Ulang dari teks tersebut.\n3. Tuliskan analisis kalian secara rapi, lalu unggah dokumen/fotonya melalui menu Tugas di aplikasi GoEdu paling lambat minggu depan.",
                'file_materi' => 'elearning/materi/BIndo_Kelas11_Pertemuan2_TeksEksposisi.pdf'
            ]
        ];

        foreach ($sessionsData as $idx => $s) {
            $tgl = Carbon::parse($s['tanggal']);

            // 1. ElearningSession
            $session = ElearningSession::updateOrCreate(
                [
                    'judul' => $s['judul'],
                    'school_class_id' => $s['class']->id,
                ],
                [
                    'subject_id' => $s['subject']->id,
                    'teacher_id' => $s['teacher']->id,
                    'urutan' => $idx + 1,
                    'deskripsi' => $s['deskripsi'],
                    'is_published' => true,
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]
            );

            // 2. ElearningMaterial
            ElearningMaterial::where('session_id', $session->id)->delete();
            ElearningMaterial::create([
                'session_id' => $session->id,
                'judul' => "Modul Panduan - {$s['judul']}.pdf",
                'tipe' => 'file',
                'konten' => $s['file_materi'],
                'mime_type' => 'application/pdf',
                'created_at' => $tgl,
                'updated_at' => $tgl,
            ]);

            // 3. ElearningAssignment
            ElearningAssignment::where('session_id', $session->id)->delete();
            $assignment = ElearningAssignment::create([
                'session_id' => $session->id,
                'instruksi' => $s['instruksi_tugas'],
                'deadline' => $s['deadline'],
                'created_at' => $tgl,
                'updated_at' => $tgl,
            ]);

            // 4. Also seed standard LearningMaterial & Assignment tables
            LearningMaterial::updateOrCreate(
                ['judul' => $s['judul'], 'subject_id' => $s['subject']->id],
                [
                    'file_path' => $s['file_materi'],
                    'ukuran_file' => '2.4 MB',
                    'tanggal_upload' => $tgl->format('Y-m-d'),
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]
            );

            Assignment::updateOrCreate(
                ['judul' => "Tugas - {$s['judul']}", 'subject_id' => $s['subject']->id],
                [
                    'deskripsi' => $s['instruksi_tugas'],
                    'deadline' => Carbon::parse($s['deadline'])->format('Y-m-d'),
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]
            );

            // 5. Seed Pretest & Posttest Questions
            ElearningQuestion::where('session_id', $session->id)->delete();
            ElearningStudentAnswer::where('session_id', $session->id)->delete();

            $questionsData = [
                [
                    'pertanyaan' => "Apa arti kata As-Sidq menurut istilah dalam ajaran Islam?",
                    'opsi_a' => "Kesesuaian antara lisan, niat di dalam hati, dan perbuatan nyata",
                    'opsi_b' => "Menjaga rahasia pribadi orang lain dari prasangka buruk",
                    'opsi_c' => "Mengikuti keinginan mayoritas tanpa melihat aturan Al-Qur'an",
                    'opsi_d' => "Melakukan ibadah secara sembunyi-sembunyi agar terhindar dari riya",
                    'jawaban_benar' => 'a'
                ],
                [
                    'pertanyaan' => "Dalam QS. At-Taubah ayat 119, Allah SWT memerintahkan orang-orang beriman untuk bertakwa dan hendaknya bersama orang yang...",
                    'opsi_a' => "Berilmu tinggi dan kaya raya",
                    'opsi_b' => "Jujur (ash-shadiqin)",
                    'opsi_c' => "Sabar saat tertimpa musibah",
                    'opsi_d' => "Rajin berinfaq dan bersedekah",
                    'jawaban_benar' => 'b'
                ],
                [
                    'pertanyaan' => "Berdasarkan Hadis Nabi SAW (HR. Bukhari & Muslim), perilaku jujur (as-sidq) membimbing seorang muslim menuju...",
                    'opsi_a' => "Kejayaan materi dan kedudukan duniawi",
                    'opsi_b' => "Kebaikan (al-birr) dan kebaikan membimbing ke surga",
                    'opsi_c' => "Kebebasan dari segala ujian dan cobaan hidup",
                    'opsi_d' => "Ketenangan hati tanpa perlu bekerja keras",
                    'jawaban_benar' => 'b'
                ],
                [
                    'pertanyaan' => "Apakah yang dimaksud dengan jujur dalam niat (siddq an-niyyah)?",
                    'opsi_a' => "Mengerjakan tugas madrasah agar dipuji guru dan orang tua",
                    'opsi_b' => "Melakukan setiap amal kebaikan semata-mata mengharap ridha Allah SWT",
                    'opsi_c' => "Berkata manis kepada orang lain walaupun bertentangan dengan fakta",
                    'opsi_d' => "Menyampaikan pendapat pribadi dalam musyawarah kelas",
                    'jawaban_benar' => 'b'
                ],
                [
                    'pertanyaan' => "Manakah contoh penerapan sikap jujur di lingkungan madrasah yang paling tepat?",
                    'opsi_a' => "Memberikan jawaban ujian kepada teman dekat agar lulus bersama",
                    'opsi_b' => "Mengerjakan soal ulangan mandiri dengan percaya diri tanpa mencontek",
                    'opsi_c' => "Menyembunyikan kesalahan teman agar tidak mendapat teguran guru",
                    'opsi_d' => "Mengakui kebohongan hanya jika tertangkap tangan oleh guru BK",
                    'jawaban_benar' => 'b'
                ]
            ];

            // Create Pretest Questions
            $preQuestions = [];
            foreach ($questionsData as $qIdx => $q) {
                $preQuestions[] = ElearningQuestion::create([
                    'session_id' => $session->id,
                    'tipe' => 'pretest',
                    'pertanyaan' => $q['pertanyaan'],
                    'opsi_a' => $q['opsi_a'],
                    'opsi_b' => $q['opsi_b'],
                    'opsi_c' => $q['opsi_c'],
                    'opsi_d' => $q['opsi_d'],
                    'jawaban_benar' => $q['jawaban_benar'],
                    'urutan' => $qIdx + 1,
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]);
            }

            // Create Posttest Questions
            $postQuestions = [];
            foreach ($questionsData as $qIdx => $q) {
                $postQuestions[] = ElearningQuestion::create([
                    'session_id' => $session->id,
                    'tipe' => 'posttest',
                    'pertanyaan' => $q['pertanyaan'],
                    'opsi_a' => $q['opsi_a'],
                    'opsi_b' => $q['opsi_b'],
                    'opsi_c' => $q['opsi_c'],
                    'opsi_d' => $q['opsi_d'],
                    'jawaban_benar' => $q['jawaban_benar'],
                    'urutan' => $qIdx + 1,
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]);
            }

            // 6. Seed realistic student submissions for active students in class
            $students = Student::where('school_class_id', $s['class']->id)->get();
            foreach ($students as $st) {
                // Seed Pretest answers
                foreach ($preQuestions as $q) {
                    $isCorrect = (rand(1, 10) <= 8);
                    $studentAnswer = $isCorrect ? $q->jawaban_benar : ($q->jawaban_benar === 'a' ? 'b' : 'a');
                    ElearningStudentAnswer::create([
                        'session_id' => $session->id,
                        'student_id' => $st->id,
                        'question_id' => $q->id,
                        'tipe' => 'pretest',
                        'jawaban' => $studentAnswer,
                        'is_correct' => $isCorrect,
                        'nilai' => $isCorrect ? 20 : 0,
                        'created_at' => (clone $tgl)->addMinutes(rand(5, 30)),
                        'updated_at' => (clone $tgl)->addMinutes(rand(5, 30)),
                    ]);
                }

                // Seed Posttest answers
                foreach ($postQuestions as $q) {
                    $isCorrect = (rand(1, 10) <= 9);
                    $studentAnswer = $isCorrect ? $q->jawaban_benar : ($q->jawaban_benar === 'a' ? 'b' : 'a');
                    ElearningStudentAnswer::create([
                        'session_id' => $session->id,
                        'student_id' => $st->id,
                        'question_id' => $q->id,
                        'tipe' => 'posttest',
                        'jawaban' => $studentAnswer,
                        'is_correct' => $isCorrect,
                        'nilai' => $isCorrect ? 20 : 0,
                        'created_at' => (clone $tgl)->addDays(rand(2, 6)),
                        'updated_at' => (clone $tgl)->addDays(rand(2, 6)),
                    ]);
                }

                $submitDate = (clone $tgl)->addDays(rand(1, 5));
                ElearningAssignmentSubmission::updateOrCreate(
                    [
                        'assignment_id' => $assignment->id,
                        'student_id' => $st->id,
                    ],
                    [
                        'tipe_submit' => 'file',
                        'konten' => "Tugas_{$st->nama}_submitted.pdf",
                        'file_path' => "elearning/tugas/Tugas_{$st->id}.pdf",
                        'nama_file' => "Lembar_Jawaban_{$st->nama}.pdf",
                        'catatan' => "Assalamu'alaikum Bapak/Ibu, berikut tugas saya untuk " . $s['judul'] . ". Terima kasih.",
                        'nilai' => rand(85, 98),
                        'feedback' => "Alhamdulillah pengerjaan tugas sangat baik, rapi, dan sistematis. Pertahankan prestasimu!",
                        'created_at' => $submitDate,
                        'updated_at' => $submitDate,
                    ]
                );
            }
        }

        // 7. Seed TeacherAttendance starting from 13 Juli 2026 to 3 Agustus 2026
        $allTeachers = Teacher::all();

        $elearningAbsences = [
            '2026-07-13' => [
                'teacher_id' => $teacherAhmad->id,
                'status' => 'Izin',
                'keterangan' => 'Mengikuti Seminar Pendidikan Agama Islam se-Kabupaten Tangerang (KBM via GoEdu E-Learning)',
            ],
            '2026-07-21' => [
                'teacher_id' => $teacherOkta->id,
                'status' => 'Izin',
                'keterangan' => 'Rapat Koordinasi Pengurus Yayasan Pendidikan (KBM via GoEdu E-Learning)',
            ],
            '2026-07-28' => [
                'teacher_id' => $teacherAhmad->id,
                'status' => 'Izin',
                'keterangan' => 'Workshop & Lokakarya Kurikulum Madrasah (KBM via GoEdu E-Learning)',
            ],
            '2026-08-02' => [
                'teacher_id' => $teacherOkta->id,
                'status' => 'Izin',
                'keterangan' => 'Rapat Evaluasi Program Pendidikan Yayasan (KBM via GoEdu E-Learning)',
            ],
        ];

        $startDate = Carbon::parse('2026-07-13');
        $endDate   = Carbon::parse('2026-08-03');

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($date->isSunday()) continue;

            $dateStr = $date->format('Y-m-d');

            foreach ($allTeachers as $t) {
                if (isset($elearningAbsences[$dateStr]) && $elearningAbsences[$dateStr]['teacher_id'] == $t->id) {
                    $status = $elearningAbsences[$dateStr]['status'];
                    $keterangan = $elearningAbsences[$dateStr]['keterangan'];
                } else {
                    $status = 'Hadir';
                    $keterangan = 'Hadir mengajar tatap muka';
                }

                TeacherAttendance::updateOrCreate(
                    [
                        'teacher_id' => $t->id,
                        'tanggal'    => $dateStr,
                    ],
                    [
                        'status'     => $status,
                        'keterangan' => $keterangan,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]
                );
            }
        }

        // 8. Seed Student Attendance starting from 13 Juli 2026 to 3 Agustus 2026
        $allStudents  = Student::all();
        $sakitReasons = ['Demam & Flu', 'Sakit Perut & Pusing', 'Berobat ke Dokter', 'Kondisi Badan Kurang Fit', 'Radang Tenggorokan'];
        $izinReasons  = ['Acara Keluarga', 'Izin Kepentingan Mendesak', 'Menghadiri Acara Keluarga di Luar Kota', 'Izin Mengurus Dokumen'];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($date->isSunday()) continue;

            $dateStr = $date->format('Y-m-d');

            foreach ($allStudents as $st) {
                // Deterministic variation per student and date
                $randVal = abs(crc32($st->id . '_' . $dateStr)) % 100;

                if ($randVal < 82) {
                    $status     = 'Hadir';
                    $jamMasuk   = sprintf('06:%02d', 45 + ($randVal % 25)); // e.g. 06:45 - 07:10
                    $jamPulang  = '14:00';
                    $keterangan = null;
                } elseif ($randVal < 90) {
                    $status     = 'Sakit';
                    $jamMasuk   = null;
                    $jamPulang  = null;
                    $keterangan = $sakitReasons[$randVal % count($sakitReasons)];
                } elseif ($randVal < 96) {
                    $status     = 'Izin';
                    $jamMasuk   = null;
                    $jamPulang  = null;
                    $keterangan = $izinReasons[$randVal % count($izinReasons)];
                } else {
                    $status     = 'Alpha';
                    $jamMasuk   = null;
                    $jamPulang  = null;
                    $keterangan = 'Tanpa Keterangan';
                }

                Attendance::updateOrCreate(
                    [
                        'student_id' => $st->id,
                        'tanggal'    => $dateStr,
                    ],
                    [
                        'jam_masuk'  => $jamMasuk,
                        'jam_pulang' => $jamPulang,
                        'status'     => $status,
                        'keterangan' => $keterangan,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]
                );
            }
        }
    }
}
