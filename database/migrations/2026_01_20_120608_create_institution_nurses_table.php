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
        Schema::create('institution_nurses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('care_institution_id')->constrained('care_institutions')->onDelete('cascade')->nullable();
            $table->string('fullName')->nullable();
            $table->integer('age')->nullable();
            $table->string('location')->nullable();
            $table->string('experience')->nullable();
            $table->string('gender')->nullable();
            $table->string('education')->nullable();
            $table->boolean('canDrive')->default(false);
            $table->string('preferredRole')->nullable();
            $table->string('languages')->nullable();  
            $table->string('educationCertificate')->nullable();
            $table->boolean('isNursingInKenya')->default(false);
            $table->string('practiceLicense')->nullable();
            $table->string('registrationNumber')->nullable();
            $table->boolean('hospitalBasedCare')->default(false);
            $table->integer('hospitalBasedYearsOfExperience')->nullable();
            $table->string('hospitalBasedReferenceContact')->nullable();
            $table->boolean('homeBasedCare')->default(false);
            $table->integer('homeBasedYearsOfExperience')->nullable();
            $table->string('homeBasedReferenceContact')->nullable();
            $table->string('mobilityYears')->nullable();
            $table->string('bathingYears')->nullable();
            $table->string('feedingYears')->nullable();
            $table->integer('serviceFee')->nullable();
            $table->string('serviceFeeDay')->nullable();
            $table->string('serviceFeeMonth')->nullable();
            $table->text('bio')->nullable();
            $table->string('idCopy')->nullable();
            $table->string('profilePhoto')->nullable();
            $table->string('services')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_nurses');
    }
};
