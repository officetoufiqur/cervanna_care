<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalNurse extends Model
{
    protected $fillable = [
        'medical_id',
        'user_id',
        'role',
        'educationCertificate',
        'isNursingInKenya',
        'skills',
        'mobilityYears',
        'bathingYears',
        'feedingYears',
        'serviceFee',
    ];

    public function medical()
    {
        return $this->belongsTo(Medical::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
