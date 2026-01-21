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
            $table->foreignId('agency_id')->constrained('agencies')->cascadeOnDelete()->nullable();
            $table->string('name')->nullable();
            $table->string('educationLevel')->nullable();
            $table->string('location')->nullable();
            $table->string('experience')->nullable();
            $table->string('salaryRange')->nullable();
            $table->boolean('isMother')->nullable();
            $table->string('kidAges')->nullable();
            $table->boolean('handlePets')->nullable();
            $table->string('preferredRole')->nullable();
            $table->string('languages')->nullable();
            $table->string('cooking')->nullable();
            $table->string('housekeeping')->nullable();
            $table->string('childcare')->nullable();
            $table->string('liveType')->nullable();
            $table->string('idCopy')->nullable();
            $table->string('profilePhoto')->nullable();
            $table->string('drivingLicense')->nullable();
            $table->string('goodConductCertificate')->nullable();
            $table->string('aidCertificate')->nullable();
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
