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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
