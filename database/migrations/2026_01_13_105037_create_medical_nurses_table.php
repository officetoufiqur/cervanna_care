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
            $table->bigInteger('medical_id');
            $table->foreign('medical_id')->references('id')->on('medicals');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
