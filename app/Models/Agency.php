<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'user_id',
        'companyName',
        'kraPin',
        'number',
        'companyRegistrationNumber',
        'businessLocation',
        'registrationDocument',
        'agency_services',
        'placementFee',
        'replacementWindow',
        'numberOfReplacement',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function employees()
    {
        return $this->hasMany(AgencyEmployee::class, 'agency_id', 'id');
    }

    protected $casts = [
        'agency_services' => 'array',
    ];
}
