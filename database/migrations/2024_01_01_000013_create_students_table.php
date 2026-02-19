<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->text('address')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('contact')->nullable();
            $table->year('admission_year');
            $table->string('ol_index')->nullable();
            $table->string('al_index')->nullable();
            $table->tinyInteger('current_grade')->unsigned(); // 1-13
            $table->foreignId('stream_id')->nullable()->constrained('streams')->nullOnDelete();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
