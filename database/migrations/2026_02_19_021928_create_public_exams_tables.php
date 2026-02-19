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
        // 1. The Exam (e.g. "G.C.E. O/L 2024")
        Schema::create('public_exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('exam_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Student's Entry (linking Student to Exam, storing Index & Result Sheet)
        Schema::create('student_public_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('public_exam_id')->constrained()->cascadeOnDelete();
            $table->string('index_number');
            $table->string('result_file_path')->nullable(); // Path to PDF/Image
            $table->timestamps();
            
            // Unique constraint: A student sits an exam only once (usually)
            $table->unique(['student_id', 'public_exam_id']);
        });

        // 3. Individual Subject Results (e.g. Maths: A, Science: B)
        Schema::create('public_exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_public_exam_id')->constrained('student_public_exams')->cascadeOnDelete();
            // We can link to existing 'subjects' table if they match, or just store subject name string if external.
            // Linking creates better structure if we map them. For now let's link to our subjects table 
            // but make it nullable in case of an external subject not in our curriculum? 
            // Or better: Let's assume we use our system's subjects for now for consistency.
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->string('grade'); // A, B, C, S, W, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_exam_results');
        Schema::dropIfExists('student_public_exams');
        Schema::dropIfExists('public_exams');
    }
};
