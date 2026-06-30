<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('elearning_sessions')->onDelete('cascade');
            $table->text('instruksi');
            $table->datetime('deadline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_assignments');
    }
};
