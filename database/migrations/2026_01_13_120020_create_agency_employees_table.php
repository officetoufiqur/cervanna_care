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
        Schema::create('agency_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained('agencies')->cascadeOnDelete();
            $table->string('name');
            $table->string('educationLevel');
            $table->string('location');
            $table->string('experience');
            $table->string('salaryRange');
            $table->boolean('isMother');
            $table->string('kidAges');
            $table->boolean('handlePets');
            $table->string('preferredRole');
            $table->string('languages');
            $table->string('cooking');
            $table->string('housekeeping');
            $table->string('childcare');
            $table->string('liveType');
            $table->string('idCopy');
            $table->string('profilePhoto');
            $table->string('drivingLicense');
            $table->string('goodConductCertificate');
            $table->string('aidCertificate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_employees');
    }
};
