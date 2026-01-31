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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('specialist_id')->nullable();
            $table->foreignId('booking_person_id')->constrained('users')->cascadeOnDelete()->nullable();
            $table->string('patient_name')->nullable();
            $table->string('patient_age')->nullable();
            $table->string('patient_gender')->nullable();
            $table->string('relationship_to_booking_person')->nullable();
            $table->foreignId('price_id')->constrained('prices')->cascadeOnDelete()->nullable();
            $table->string('booking_amount')->nullable();
            $table->string('patient_have_any_conditions')->nullable();
            $table->string('patient_currently_on_medication')->nullable();
            $table->string('patient_have_any_known_allergies')->nullable();
            $table->string('mobility_status_of_patient')->nullable();
            $table->string('care_start_date')->nullable();
            $table->string('care_end_date')->nullable();
            $table->string('location_of_care')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('primary_doctor_name')->nullable();
            $table->string('primary_doctor_number')->nullable();
            $table->text('primary_hospital')->nullable();
            $table->text('patient_currently_on_medication_data')->nullable();
            $table->text('patient_have_any_known_allergies_details')->nullable();
            $table->string('booking_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
