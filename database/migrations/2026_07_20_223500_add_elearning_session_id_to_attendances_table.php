<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('elearning_session_id')->nullable()->constrained('elearning_sessions')->nullOnDelete()->after('schedule_id');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['elearning_session_id']);
            $table->dropColumn('elearning_session_id');
        });
    }
};
