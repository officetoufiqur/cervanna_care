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
            $table->bigInteger('booking_person_id')->nullable();
            $table->string('patient_name')->nullable();
            $table->string('patient_age')->nullable();
            $table->string('patient_gender')->nullable();
            $table->string('relationship_to_booking_person')->nullable();
            $table->string('booking_amount')->nullable();
            $table->string('booking_type')->nullable();
            $table->string('selected_dates_or_months')->nullable();
            $table->string('total_count')->nullable();
            $table->json('patient_have_any_conditions')->nullable();
            $table->boolean('patient_currently_on_medication')->nullable();
            $table->string('patient_currently_on_medication_data')->nullable();
            $table->string('prescription_file')->nullable();
            $table->string('patient_have_any_known_allergies')->nullable();
            $table->string('patient_have_any_known_allergies_details')->nullable();
            $table->string('mobility_status_of_patient')->nullable();
            $table->string('location_of_care')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('primary_doctor_name')->nullable();
            $table->string('primary_doctor_number')->nullable();
            $table->string('primary_hospital')->nullable();
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
