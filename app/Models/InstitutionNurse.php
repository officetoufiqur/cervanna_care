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
    ];

    public function careInstitution()
    {
        return $this->belongsTo(CareInstitution::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_services', 'institution_nurse_id', 'skill_id');
    }


    protected $casts = [
        'experience' => 'array',
        'languages' => 'array',
    ];



}
