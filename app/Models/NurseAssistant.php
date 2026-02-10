<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseAssistant extends Model
{
    protected $fillable = [
        'user_id',
        'educationCertificate',
        'experience',
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
    ];

}
