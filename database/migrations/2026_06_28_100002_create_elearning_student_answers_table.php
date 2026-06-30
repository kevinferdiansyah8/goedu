<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('elearning_sessions')->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained('elearning_questions')->onDelete('cascade');
            $table->enum('tipe', ['pretest', 'posttest']);
            $table->enum('jawaban', ['a', 'b', 'c', 'd'])->nullable();
            $table->boolean('is_correct')->default(false);
            $table->integer('nilai')->default(0); // 20 if correct, 0 if wrong
            $table->timestamps();

            $table->unique(['session_id', 'student_id', 'question_id', 'tipe'], 'unique_student_answer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_student_answers');
    }
};
