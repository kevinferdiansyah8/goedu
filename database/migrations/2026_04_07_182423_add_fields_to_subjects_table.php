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
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('kode')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('tingkat')->nullable();
            $table->integer('jumlah_jam')->default(2);
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['kode', 'jurusan', 'tingkat', 'jumlah_jam', 'status']);
        });
    }
};
