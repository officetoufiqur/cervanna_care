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
        Schema::create('physiotherapists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('eduCertificate')->nullable();
            $table->boolean('isRegisterPCK')->nullable();
            $table->string('registrationNumber')->nullable();
            $table->string('practiceLicense')->nullable();
            $table->integer('serviceFee')->nullable();
            $table->string('serviceFeeDay')->nullable();
            $table->string('serviceFeeMonth')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physiotherapists');
    }
};
