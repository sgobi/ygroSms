<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('term'); // 1, 2, or 3
            $table->tinyInteger('grade')->unsigned(); // grade 1-13 at time of entry
            $table->decimal('marks', 5, 2)->nullable();
            $table->string('grade_letter')->nullable(); // A, B, C, etc.
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'academic_year_id', 'term'], 'marks_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
