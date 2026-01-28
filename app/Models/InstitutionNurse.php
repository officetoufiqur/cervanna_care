<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionNurse extends Model
{
    protected $fillable = [
        'care_institution_id',
        'fullName',
        'age',
        'location',
        'experience',
        'gender',
        'education',
        'canDrive',
        'preferredRole',
        'languages',
        'educationCertificate',
        'isNursingInKenya',
        'hospitalBasedCare',
        'hospitalBasedYearsOfExperience',
        'hospitalBasedReferenceContact',
        'homeBasedCare',
        'homeBasedYearsOfExperience',
        'homeBasedReferenceContact',
        'mobilityYears',
        'bathingYears',
        'feedingYears',
        'serviceFee',
        'bio',
        'idCopy',
        'profilePhoto',
        'services'
    ];

    public function careInstitution()
    {
        return $this->belongsTo(CareInstitution::class);
    }


    protected $casts = [
        'experience' => 'array',
        'languages' => 'array',
        'services' => 'array',
    ];



}
