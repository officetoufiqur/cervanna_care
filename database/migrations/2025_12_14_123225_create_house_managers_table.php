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
        Schema::create('house_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('experience')->nullable();
            $table->string('experienceYear')->nullable();
            $table->string('salaryRange')->nullable();
            $table->string('serviceOffered');
            $table->boolean('isMother')->default(false);
            $table->string('ageOfKids');
            $table->boolean('isHandelingPet')->default(false);
            $table->string('preferBeingA');
            $table->string('firstAidCertificate');
            $table->string('goodConductCertificate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_managers');
    }
};
