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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_services', 'nurse_id', 'skill_id');
    }
}
