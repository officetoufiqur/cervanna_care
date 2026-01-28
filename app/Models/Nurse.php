<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'isNursingInKenya',
        'educationCertificate',
        'mobilityYears',
        'bathingYears',
        'feedingYears',
        'serviceFee',
        'skills',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'skills' => 'array',
    ];

}
