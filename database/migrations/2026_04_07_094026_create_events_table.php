<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
$table->id();
            $table->string('tipe_info');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('tanggal_pelaksanaan')->nullable();
            $table->string('waktu_pelaksanaan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('gambar_attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
