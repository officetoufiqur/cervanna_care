<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    protected $fillable = [
        'companyName',
        'kraPin',
        'companyRegistrationNumber',
        'businessLocation',
        'registrationDocument',
    ];
}
