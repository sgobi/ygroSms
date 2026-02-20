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
        Schema::create('meeting_calendars', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->unsignedTinyInteger('month');
            $table->string('meeting_title')->nullable();
            $table->date('meeting_date')->nullable();
            $table->timestamps();

            $table->unique(['year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_calendars');
    }
};
