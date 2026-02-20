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
        Schema::table('disciplinary_records', function (Blueprint $table) {
            $table->foreignId('meeting_calendar_id')->nullable()->after('academic_year_id')->constrained('meeting_calendars')->nullOnDelete();
            
            // In case bill_submitted was nullable, ensure it's not. 
            // Although in previous turns I defined it with ->default(false), 
            // the user wants it specifically NOT NULL and REQUIRED.
            $table->boolean('bill_submitted')->default(false)->change();
            
            // Clean up old month fields if they exist from previous turns
            if (Schema::hasColumn('disciplinary_records', 'meeting_month')) {
                $table->dropColumn('meeting_month');
            }
            if (Schema::hasColumn('disciplinary_records', 'bill_month')) {
                $table->dropColumn('bill_month');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disciplinary_records', function (Blueprint $table) {
            //
        });
    }
};
