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
        Schema::table('students', function (Blueprint $table) {
            $table->string('medical_emergency_name')->nullable()->after('contact');
            $table->string('medical_emergency_contact')->nullable()->after('medical_emergency_name');
            $table->string('gn_division')->nullable()->after('medical_emergency_contact');
            $table->string('gs_division')->nullable()->after('gn_division');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['medical_emergency_name', 'medical_emergency_contact', 'gn_division', 'gs_division']);
        });
    }
};
