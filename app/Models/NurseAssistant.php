<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseAssistant extends Model
{
    protected $fillable = [
        'user_id',
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
        return $this->belongsToMany(Skill::class, 'skill_services', 'nurse_assistant_id', 'skill_id');
    }
}
