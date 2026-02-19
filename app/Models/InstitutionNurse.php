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
        'type',
        'subRole',
        'canDrive',
        'preferredRole',
        'languages',
        'educationCertificate',
        'isNursingInKenya',
        'practiceLicense',
        'registrationNumber',
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
        'serviceFeeDay',
        'serviceFeeMonth',
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
        'isNursingInKenya' => 'boolean',
        'canDrive' => 'boolean',
        'hospitalBasedCare' => 'boolean',
        'homeBasedCare' => 'boolean',
        'experience' => 'array',
        'languages' => 'array',
        'services' => 'array',
    ];



}
