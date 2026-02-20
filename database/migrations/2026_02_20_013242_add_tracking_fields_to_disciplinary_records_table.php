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
            $table->boolean('meeting_participated')->default(false)->after('incident_count');
            $table->unsignedTinyInteger('meeting_month')->nullable()->after('meeting_participated');
            $table->boolean('bill_submitted')->default(false)->after('meeting_month');
            $table->unsignedTinyInteger('bill_month')->nullable()->after('bill_submitted');
            $table->dropColumn('remarks');
        });
    }

    public function down(): void
    {
        Schema::table('disciplinary_records', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('incident_count');
            $table->dropColumn(['meeting_participated', 'meeting_month', 'bill_submitted', 'bill_month']);
        });
    }
};
