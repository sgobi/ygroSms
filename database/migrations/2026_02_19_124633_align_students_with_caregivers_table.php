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
            $table->foreignId('caregiver_id')->after('donor_id')->nullable()->constrained('caregivers')->nullOnDelete();
            
            $table->dropColumn([
                'caregiver_title', 
                'caregiver_name', 
                'caregiver_address', 
                'caregiver_email', 
                'caregiver_contact'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['caregiver_id']);
            $table->dropColumn('caregiver_id');

            $table->string('caregiver_title')->nullable();
            $table->string('caregiver_name')->nullable();
            $table->text('caregiver_address')->nullable();
            $table->string('caregiver_email')->nullable();
            $table->string('caregiver_contact')->nullable();
        });
    }
};
