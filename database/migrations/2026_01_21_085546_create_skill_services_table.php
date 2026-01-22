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
        Schema::create('skill_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nurse_id')->constrained('nurses')->onDelete('cascade')->nullable();
            $table->foreignId('nurse_assistant_id')->constrained('nurse_assistants')->onDelete('cascade')->nullable();
            $table->foreignId('institution_nurse_id')->constrained('institution_nurses')->onDelete('cascade')->nullable();
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_services');
    }
};
