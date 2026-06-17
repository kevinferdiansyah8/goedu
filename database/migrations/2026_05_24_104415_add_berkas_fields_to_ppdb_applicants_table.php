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
            $table->string('status_kk')->default('Belum Upload')->after('status_pembayaran');
            $table->string('status_akta')->default('Belum Upload')->after('status_kk');
            $table->string('status_ijazah')->default('Belum Upload')->after('status_akta');
            $table->string('status_raport')->default('Belum Upload')->after('status_ijazah');
            $table->string('status_foto')->default('Belum Upload')->after('status_raport');
            $table->text('catatan_kk')->nullable()->after('status_foto');
            $table->text('catatan_akta')->nullable()->after('catatan_kk');
            $table->text('catatan_ijazah')->nullable()->after('catatan_akta');
            $table->text('catatan_raport')->nullable()->after('catatan_ijazah');
            $table->text('catatan_foto')->nullable()->after('catatan_raport');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_applicants', function (Blueprint $table) {
            $table->dropColumn([
                'status_kk','status_akta','status_ijazah','status_raport','status_foto',
                'catatan_kk','catatan_akta','catatan_ijazah','catatan_raport','catatan_foto',
            ]);
        });
    }
};
