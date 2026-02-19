<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->enum('exam_type', ['OL', 'AL']); // O/L or A/L
            $table->integer('exam_year');             // Year the exam was sat
            $table->string('index_number', 20);      // Public exam index number
            $table->string('result_sheet_path')->nullable(); // Uploaded result sheet
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'exam_type', 'exam_year'], 'unique_student_exam');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_exam_results');
    }
};
