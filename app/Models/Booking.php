<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
            'booking_person_id',
            'specialist_id',
            'specialist_type',
            'patient_name',
            'patient_age',
            'patient_gender',
            'relationship_to_booking_person',
            'booking_amount',
            'booking_type',
            'selected_dates_or_months',
            'patient_have_any_conditions',
            'patient_have_any_others_conditions',
            'patient_currently_on_medication',
            'patient_currently_on_medication_data',
            'prescription_file',
            'patient_have_any_known_allergies',
            'patient_have_any_known_allergies_details',
            'mobility_status_of_patient',
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

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    protected $casts = [
        'patient_have_any_conditions' => 'array',
        'selected_dates_or_months' => 'array',
        'patient_currently_on_medication' => 'boolean',
    ];
}
