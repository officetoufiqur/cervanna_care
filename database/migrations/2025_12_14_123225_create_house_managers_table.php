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
            $table->boolean('isMother')->default(false);
            $table->string('ageOfKids')->nullable();
            $table->boolean('isHandelingPet')->default(false);
            $table->string('preferBeingA')->nullable();
            $table->string('firstAidCertificate')->nullable();
            $table->string('goodConductCertificate')->nullable();
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
