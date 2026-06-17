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
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
            $table->enum('tipe', ['Guru', 'Staff'])->default('Guru');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->string('pendidikan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'tipe', 'status', 'pendidikan']);
        });
    }
};
