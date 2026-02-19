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
            $table->string('caregiver_title')->nullable()->after('address');
            $table->string('caregiver_name')->nullable()->after('caregiver_title');
            $table->string('caregiver_address')->nullable()->after('caregiver_name');
            $table->string('caregiver_email')->nullable()->after('caregiver_address');
            $table->string('caregiver_contact')->nullable()->after('caregiver_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
