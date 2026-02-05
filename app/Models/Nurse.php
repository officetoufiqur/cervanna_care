<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'isNursingInKenya',
        'registrationNumber',
        'educationCertificate',
        'practiceLicense',
        'mobilityYears',
        'bathingYears',
        'feedingYears',
        'serviceFee',
        'serviceFeeDay',
        'serviceFeeMonth',
        'skills',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'skills' => 'array',
        'isNursingInKenya' => 'boolean',
    ];

}
