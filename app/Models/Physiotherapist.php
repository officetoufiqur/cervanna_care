<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Physiotherapist extends Model
{
    protected $fillable = [
        'user_id',
        'eduCertificate',
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
