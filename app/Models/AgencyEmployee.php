<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyEmployee extends Model
{
    protected $fillable = [
        'agency_id',
        'name',
        'educationLevel',
        'location',
        'experience',
        'salaryRange',
        'isMother',
        'kidAges',
        'handlePets',
        'preferredRole',
        'languages',
        'cooking',
        'housekeeping',
        'childcare',
        'liveType',
        'idCopy',
        'profilePhoto',
        'drivingLicense',
        'goodConductCertificate',
        'aidCertificate',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
