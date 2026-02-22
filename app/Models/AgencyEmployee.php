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
        'type',
        'subRole',
        'isMother',
        'kidAges',
        'handlePets',
        'preferredRole',
        'languages',
        'cooking',
        'housekeeping',
        'childcare',
        'preferred',
        'idCopy',
        'profilePhoto',
        'drivingLicense',
        'goodConductCertificate',
        'aidCertificate',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'specialist_id')
            ->where('specialist_type', 'agency-employee');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'specialist_id', 'id')
            ->where('specialist_type', 'agency-employee');
    }

    protected $casts = [
        'isMother' => 'boolean',
        'handlePets' => 'boolean',
        'languages' => 'array',
        'kidAges' => 'array',
        'preferred' => 'array',
    ];

}
