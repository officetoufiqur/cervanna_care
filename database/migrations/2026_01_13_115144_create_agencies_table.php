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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('companyName')->nullable();
            $table->string('number')->nullable();
            $table->string('kraPin')->nullable();
            $table->string('companyRegistrationNumber')->nullable();
            $table->string('businessLocation')->nullable();
            $table->string('registrationDocument')->nullable();
            $table->string('agency_services')->nullable();
            $table->integer('placementFee')->nullable();
            $table->integer('replacementWindow')->nullable();
            $table->integer('numberOfReplacement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
