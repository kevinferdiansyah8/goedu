<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('deskripsi');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('school_class_id')->nullable()->after('kelas')->constrained()->nullOnDelete();
            $table->text('catatan_guru')->nullable()->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->dropColumn(['school_class_id', 'catatan_guru']);
        });
    }
};
