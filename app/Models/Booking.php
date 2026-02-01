<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'specialist_id',
        'booking_person_id',
        'patient_name',
        'patient_age',
        'patient_gender',
        'patient_currently_on_medication_data',
        'patient_currently_on_medication',
        'patient_have_any_known_allergies',
        'patient_have_any_known_allergies_details',
        'relationship_to_booking_person',
        'price_id',
        'booking_amount',
        'patient_have_any_conditions',
        'mobility_status_of_patient',
        'care_start_date',
        'care_end_date',
        'location_of_care',
        'emergency_contact_name',
        'emergency_contact_number',
        'primary_doctor_name',
        'primary_doctor_number',
        'primary_hospital',
        'booking_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'booking_person_id', 'id');
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id', 'id');
    }

    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id', 'id');
    }

    protected $casts = [
        'patient_have_any_conditions' => 'array',
        'patient_currently_on_medication' => 'boolean',
    ];
}
