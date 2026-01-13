<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseAssistant extends Model
{
    protected $fillable = [
        'user_id',
        'educationCertificate',
        'isRegisterPCK',
        'registrationNumber',
        'practiceLicense',
        'serviceFee',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
