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
        Schema::create('medical_nurses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_id')->constrained('medicals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role');
            $table->string('educationCertificate');
            $table->boolean('isNursingInKenya');
            $table->string('skills');
            $table->string('mobilityYears');
            $table->string('bathingYears');
            $table->string('feedingYears');
            $table->string('serviceFee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_nurses');
    }
};
