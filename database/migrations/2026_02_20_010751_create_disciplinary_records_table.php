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
        Schema::create('disciplinary_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('month'); // 1 = January, ..., 12 = December
            $table->integer('incident_count')->default(0);
            $table->text('remarks')->nullable();
            $table->string('status')->default('Good')->index(); // Good or Warning
            $table->timestamps();

            // Prevent duplicate monthly entries per student per academic year
            $table->unique(['student_id', 'academic_year_id', 'month'], 'student_monthly_discipline_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_records');
    }
};
