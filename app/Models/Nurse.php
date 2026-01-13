<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $fillable = [
        'user_id',
        'isNursingInKenya',
        'educationCertificate',
        'skills',
        'mobilityYears',
        'bathingYears',
        'feedingYears',
        'serviceFee',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
