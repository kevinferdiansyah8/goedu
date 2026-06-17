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
            $table->string('nuptk')->nullable()->after('nip');
            $table->string('tempat_lahir')->nullable()->after('nama');
            $table->string('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir');
            $table->string('agama')->nullable()->after('jenis_kelamin');
            $table->text('alamat')->nullable()->after('agama');
            $table->string('golongan')->nullable()->after('jabatan');
            $table->string('tahun_masuk')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'nuptk',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'alamat',
                'golongan',
                'tahun_masuk'
            ]);
        });
    }
};
