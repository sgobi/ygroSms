<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_exam_result_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_exam_result_id')->constrained()->cascadeOnDelete();
            $table->string('subject_name', 100);     // Free-text — public exam subject names
            $table->enum('grade', ['A', 'B', 'C', 'S', 'W', 'X', 'AB']); // X = Absent, AB = Over-aged/Invalid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_exam_result_subjects');
    }
};
