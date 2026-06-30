<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('elearning_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable(); // for replies
            $table->text('pesan');
            $table->string('file_path')->nullable();
            $table->string('nama_file')->nullable();
            $table->string('tipe_file')->nullable(); // gambar, dokumen, dll
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('elearning_discussions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_discussions');
    }
};
