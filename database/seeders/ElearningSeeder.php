<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ElearningSession;
use App\Models\ElearningQuestion;
use App\Models\ElearningMaterial;
use App\Models\ElearningAssignment;

class ElearningSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a session for Matematika (subject_id = 1), School Class (school_class_id = 1)
        $session = ElearningSession::updateOrCreate(
            ['judul' => 'Pertemuan 1 - Aljabar Dasar'],
            [
                'subject_id' => 1,
                'school_class_id' => 1,
                'teacher_id' => 1,
                'urutan' => 1,
                'deskripsi' => 'Pengenalan variabel, koefisien, konstanta, dan persamaan linear satu variabel.',
                'is_published' => true,
            ]
        );

        // 2. Create 5 Pretest questions
        $questions = [
            [
                'pertanyaan' => 'Berapakah nilai x dari persamaan 2x + 4 = 10?',
                'opsi_a' => '2',
                'opsi_b' => '3',
                'opsi_c' => '4',
                'opsi_d' => '5',
                'jawaban_benar' => 'b',
            ],
            [
                'pertanyaan' => 'Berapakah nilai y dari persamaan 3y - 2 = 7?',
                'opsi_a' => '1',
                'opsi_b' => '2',
                'opsi_c' => '3',
                'opsi_d' => '4',
                'jawaban_benar' => 'c',
            ],
            [
                'pertanyaan' => 'Hasil penyederhanaan dari 5x + 3x - 2x adalah...',
                'opsi_a' => '6x',
                'opsi_b' => '8x',
                'opsi_c' => '5x',
                'opsi_d' => '10x',
                'jawaban_benar' => 'a',
            ],
            [
                'pertanyaan' => 'Jika nilai x = 3, berapakah nilai dari ekspresi aljabar 4x - 2?',
                'opsi_a' => '8',
                'opsi_b' => '10',
                'opsi_c' => '12',
                'opsi_d' => '14',
                'jawaban_benar' => 'b',
            ],
            [
                'pertanyaan' => 'Berapakah nilai x dari persamaan x / 2 + 5 = 9?',
                'opsi_a' => '4',
                'opsi_b' => '6',
                'opsi_c' => '8',
                'opsi_d' => '10',
                'jawaban_benar' => 'c',
            ],
        ];

        // Seed Pretest & Posttest questions (they must mirror each other)
        ElearningQuestion::where('session_id', $session->id)->delete();
        foreach ($questions as $idx => $q) {
            // Pretest
            ElearningQuestion::create(array_merge($q, [
                'session_id' => $session->id,
                'tipe' => 'pretest',
                'urutan' => $idx + 1
            ]));
            // Posttest
            ElearningQuestion::create(array_merge($q, [
                'session_id' => $session->id,
                'tipe' => 'posttest',
                'urutan' => $idx + 1
            ]));
        }

        // 3. Create Learning Materials
        ElearningMaterial::where('session_id', $session->id)->delete();
        ElearningMaterial::create([
            'session_id' => $session->id,
            'judul' => 'Konsep Aljabar Dasar',
            'tipe' => 'youtube',
            'konten' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);
        ElearningMaterial::create([
            'session_id' => $session->id,
            'judul' => 'Buku Pendamping Aljabar.pdf',
            'tipe' => 'file',
            'konten' => 'elearning/materi/sample_aljabar.pdf',
            'mime_type' => 'application/pdf'
        ]);

        // 4. Create structured assignment
        ElearningAssignment::where('session_id', $session->id)->delete();
        ElearningAssignment::create([
            'session_id' => $session->id,
            'instruksi' => "1. Kerjakan Latihan 3.1 pada buku paket halaman 84 nomor 1-5.\n2. Tuliskan jawaban Anda beserta caranya secara rapi di kertas atau ketik menggunakan Word/Google Docs.\n3. Simpan dalam format PDF atau foto/gambar, kemudian unggah di kolom pengumpulan tugas di bawah.",
            'deadline' => now()->addDays(7),
        ]);
    }
}
