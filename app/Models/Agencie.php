<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agencie extends Model
{
    protected $fillable = [
        'companyName',
        'kraPin',
        'companyRegistrationNumber',
        'businessLocation',
        'registrationDocument',
        'trainingAreas',
        'placementFee',
        'replacementWindow',
        'numberOfReplacement',
    ];
}
