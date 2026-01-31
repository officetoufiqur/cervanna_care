<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Physiotherapist extends Model
{
    protected $fillable = [
        'user_id',
        'isRegisterPCK',
        'registrationNumber',
        'practiceLicense',
        'eduCertificate',
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
