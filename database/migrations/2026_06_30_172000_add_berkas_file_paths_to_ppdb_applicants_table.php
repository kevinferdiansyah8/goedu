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
            $table->string('berkas_kk')->nullable()->after('status_kk');
            $table->string('berkas_akta')->nullable()->after('status_akta');
            $table->string('berkas_ijazah')->nullable()->after('status_ijazah');
            $table->string('berkas_raport')->nullable()->after('status_raport');
            $table->string('berkas_foto')->nullable()->after('status_foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_applicants', function (Blueprint $table) {
            $table->dropColumn([
                'berkas_kk',
                'berkas_akta',
                'berkas_ijazah',
                'berkas_raport',
                'berkas_foto',
            ]);
        });
    }
};
