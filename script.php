<?php
$base_dir = 'c:\\laragon\\www\\GOEDU';

$migrations = [
    '2026_04_07_092447_create_students_table.php' => "\$table->id();\n\$table->string('nis')->unique();\n\$table->string('nisn')->nullable();\n\$table->string('nama');\n\$table->string('kelas');\n\$table->string('tempat_lahir')->nullable();\n\$table->string('tanggal_lahir')->nullable();\n\$table->string('jenis_kelamin')->nullable();\n\$table->string('agama')->nullable();\n\$table->string('alamat')->nullable();\n\$table->string('telepon')->nullable();\n\$table->string('email')->nullable();\n\$table->string('foto')->nullable();\n\$table->timestamps();",
    '2026_04_07_094019_create_parent_profiles_table.php' => "\$table->id();\n\$table->foreignId('student_id')->constrained()->cascadeOnDelete();\n\$table->string('nama_ayah')->nullable();\n\$table->string('pekerjaan_ayah')->nullable();\n\$table->string('telepon_ayah')->nullable();\n\$table->string('nama_ibu')->nullable();\n\$table->string('pekerjaan_ibu')->nullable();\n\$table->string('telepon_ibu')->nullable();\n\$table->string('alamat')->nullable();\n\$table->timestamps();",
    '2026_04_07_094019_create_teachers_table.php' => "\$table->id();\n\$table->string('nip')->nullable();\n\$table->string('nama');\n\$table->string('telepon')->nullable();\n\$table->timestamps();",
    '2026_04_07_094020_create_subjects_table.php' => "\$table->id();\n\$table->string('nama');\n\$table->foreignId('teacher_id')->constrained()->cascadeOnDelete();\n\$table->timestamps();",
    '2026_04_07_094021_create_schedules_table.php' => "\$table->id();\n\$table->foreignId('subject_id')->constrained()->cascadeOnDelete();\n\$table->string('kelas');\n\$table->string('hari');\n\$table->string('jam_mulai');\n\$table->string('jam_selesai');\n\$table->timestamps();",
    '2026_04_07_094021_create_learning_materials_table.php' => "\$table->id();\n\$table->foreignId('subject_id')->constrained()->cascadeOnDelete();\n\$table->string('judul');\n\$table->string('file_path')->nullable();\n\$table->string('ukuran_file')->nullable();\n\$table->string('tanggal_upload')->nullable();\n\$table->timestamps();",
    '2026_04_07_094022_create_assignments_table.php' => "\$table->id();\n\$table->foreignId('subject_id')->constrained()->cascadeOnDelete();\n\$table->string('judul');\n\$table->text('deskripsi')->nullable();\n\$table->string('deadline')->nullable();\n\$table->timestamps();",
    '2026_04_07_094023_create_student_assignments_table.php' => "\$table->id();\n\$table->foreignId('student_id')->constrained()->cascadeOnDelete();\n\$table->foreignId('assignment_id')->constrained()->cascadeOnDelete();\n\$table->string('tanggal_kumpul')->nullable();\n\$table->string('file_jawaban')->nullable();\n\$table->integer('nilai')->nullable();\n\$table->text('feedback')->nullable();\n\$table->string('status')->default('Belum');\n\$table->timestamps();",
    '2026_04_07_094023_create_grades_table.php' => "\$table->id();\n\$table->foreignId('student_id')->constrained()->cascadeOnDelete();\n\$table->foreignId('subject_id')->constrained()->cascadeOnDelete();\n\$table->integer('nilai_uh')->nullable();\n\$table->integer('nilai_uts')->nullable();\n\$table->integer('nilai_uas')->nullable();\n\$table->integer('nilai_akhir')->nullable();\n\$table->timestamps();",
    '2026_04_07_094024_create_attendances_table.php' => "\$table->id();\n\$table->foreignId('student_id')->constrained()->cascadeOnDelete();\n\$table->string('tanggal');\n\$table->string('jam_masuk')->nullable();\n\$table->string('jam_pulang')->nullable();\n\$table->string('status');\n\$table->string('keterangan')->nullable();\n\$table->timestamps();",
    '2026_04_07_094025_create_books_table.php' => "\$table->id();\n\$table->string('judul');\n\$table->string('penulis')->nullable();\n\$table->string('kategori')->nullable();\n\$table->integer('stok')->default(0);\n\$table->string('gambar')->nullable();\n\$table->timestamps();",
    '2026_04_07_094025_create_book_loans_table.php' => "\$table->id();\n\$table->foreignId('student_id')->constrained()->cascadeOnDelete();\n\$table->foreignId('book_id')->constrained()->cascadeOnDelete();\n\$table->string('tanggal_pinjam');\n\$table->string('tanggal_kembali');\n\$table->string('status');\n\$table->integer('denda')->default(0);\n\$table->timestamps();",
    '2026_04_07_094026_create_events_table.php' => "\$table->id();\n\$table->string('tipe_info');\n\$table->string('judul');\n\$table->text('deskripsi')->nullable();\n\$table->string('tanggal_pelaksanaan')->nullable();\n\$table->string('waktu_pelaksanaan')->nullable();\n\$table->string('lokasi')->nullable();\n\$table->string('gambar_attachment')->nullable();\n\$table->timestamps();",
];

// Update Migrations
foreach ($migrations as $file => $content) {
    $path = $base_dir . '\\database\\migrations\\' . $file;
    if (file_exists($path)) {
        $data = file_get_contents($path);
        // Find inside up()
        $pattern = '/Schema::create\(\'[a_z_]+\', function \(Blueprint \$table\) \{(.*?)\}\);/s';
        $data = preg_replace_callback('/(Schema::create\(\'[a-z_]+\', function \(Blueprint \$table\) \{)(.*?)(\}\);)/s', function($m) use ($content) {
            // Indent content properly
            $indentedContent = implode("\n", array_map(function($line) { return '            ' . ltrim($line); }, explode("\n", $content)));
            return $m[1] . "\n" . ltrim($indentedContent) . "\n        " . $m[3];
        }, $data);
        file_put_contents($path, $data);
        echo "Updated migration: $file\n";
    }
}

// Update Models (Add guarded)
$models = ['ParentProfile', 'Teacher', 'Subject', 'Schedule', 'LearningMaterial', 'Assignment', 'StudentAssignment', 'Grade', 'Attendance', 'Book', 'BookLoan', 'Event'];
foreach ($models as $model) {
    $path = $base_dir . '\\app\\Models\\' . $model . '.php';
    if (file_exists($path)) {
        $data = file_get_contents($path);
        if (strpos($data, 'protected $guarded = [];') === false) {
            $data = str_replace("{\n    //", "{\n    protected \$guarded = [];", $data); // Default laravel 11 
            // Fallback strategy if needed
            if (!strpos($data, 'protected $guarded')) {
                 $data = preg_replace('/class\s+[A-Za-z0-9_]+\s+extends\s+Model\s*\{/', "$0\n    protected \$guarded = [];\n", $data);
            }
            file_put_contents($path, $data);
            echo "Updated model: $model\n";
        }
    }
}
?>
