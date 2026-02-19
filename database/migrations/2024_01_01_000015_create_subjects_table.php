<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('grade_from')->unsigned(); // e.g. 1
            $table->tinyInteger('grade_to')->unsigned();   // e.g. 5
            $table->foreignId('stream_id')->nullable()->constrained('streams')->nullOnDelete();
            $table->boolean('is_optional')->default(false); // for grade 6-11 optional subjects
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
