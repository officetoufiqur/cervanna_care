<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialNeed extends Model
{
    protected $fillable = [
        'user_id',
        'educationCertificate',
        'experience',
        'isRegisterPCK',
        'registrationNumber',
        'practiceLicense',
        'serviceFee',
        'serviceFeeDay',
        'serviceFeeMonth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'isRegisterPCK' => 'boolean',
    ];
}
