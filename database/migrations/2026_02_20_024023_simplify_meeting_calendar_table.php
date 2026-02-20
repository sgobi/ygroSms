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
        Schema::table('meeting_calendars', function (Blueprint $table) {
            $table->dropUnique(['year', 'month']);
            $table->dropColumn(['year', 'month']);
            $table->date('meeting_date')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('meeting_calendars', function (Blueprint $table) {
            $table->integer('year')->after('id');
            $table->unsignedTinyInteger('month')->after('year');
            $table->date('meeting_date')->nullable()->change();
            $table->dropUnique(['meeting_date']);
            $table->unique(['year', 'month']);
        });
    }
};
