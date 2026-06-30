<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('elearning_sessions')->onDelete('cascade');
            $table->string('judul');
            $table->enum('tipe', ['youtube', 'file', 'link'])->default('file');
            $table->text('konten'); // URL or file path
            $table->string('mime_type')->nullable(); // for uploaded files
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_materials');
    }
};
