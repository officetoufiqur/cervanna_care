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
            $table->foreignId('nurse_id')->nullable()->constrained('nurses')->onDelete('cascade');
            $table->foreignId('nurse_assistant_id')->nullable()->constrained('nurse_assistants')->onDelete('cascade');
            $table->foreignId('institution_nurse_id')->nullable()->constrained('institution_nurses')->onDelete('cascade');
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
