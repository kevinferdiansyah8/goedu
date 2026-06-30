<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('elearning_assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->enum('tipe_submit', ['file', 'link', 'gambar', 'video']);
            $table->text('konten')->nullable(); // URL link jika tipe link
            $table->string('file_path')->nullable(); // Path file jika tipe file/gambar/video
            $table->string('nama_file')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('nilai')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->unique(['assignment_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_assignment_submissions');
    }
};
