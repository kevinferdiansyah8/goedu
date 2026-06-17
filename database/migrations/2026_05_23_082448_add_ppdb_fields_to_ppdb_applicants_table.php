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
        Schema::table('ppdb_applicants', function (Blueprint $table) {
            $table->string('jurusan')->nullable()->after('nama');
            $table->string('jalur')->nullable()->after('jurusan'); // Reguler, Prestasi, dll
            $table->string('berkas_status')->default('Belum Upload')->after('status'); // Belum Upload, Sudah Upload, Terverifikasi
            $table->string('catatan')->nullable()->after('berkas_status');
            $table->string('email')->nullable()->after('catatan');
            $table->string('telepon')->nullable()->after('email');
            $table->string('asal_sekolah')->nullable()->after('telepon');
            $table->enum('status_pembayaran', ['Belum Bayar', 'Sudah Bayar', 'Lunas'])->default('Belum Bayar')->after('asal_sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_applicants', function (Blueprint $table) {
            $table->dropColumn(['jurusan','jalur','berkas_status','catatan','email','telepon','asal_sekolah','status_pembayaran']);
        });
    }
};
