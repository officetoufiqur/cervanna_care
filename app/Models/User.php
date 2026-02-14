<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
        'number_two',
        'otp',
        'age',
        'education',
        'location',
        'role',
        'subRole',
        'type',
        'gender',
        'languages',
        'preferredRole',
        'bio',
        'canDrive',
        'idCopy',
        'profilePhoto',
        'drivingLicense',
        'goodConductCertificate',
        'referenceLetter',
        'hospitalBasedCare',
        'hospitalBasedYearsOfExperience',
        'hospitalBasedReferenceContact',
        'homeBasedCare',
        'homeBasedYearsOfExperience',
        'homeBasedReferenceContact',
        'preferred',
        'is_profile_completed',
        'is_profile_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'languages' => 'array',
            'preferred' => 'array',
            'canDrive' => 'boolean',
            'is_profile_completed' => 'boolean',
            'is_profile_verified' => 'boolean',
            'hospitalBasedCare' => 'boolean',
            'homeBasedCare' => 'boolean',
        ];
    }

    public function houseManager()
    {
        return $this->hasOne(HouseManager::class);
    }

    public function nurse()
    {
        return $this->hasOne(Nurse::class);
    }

    public function physiotherapist()
    {
        return $this->hasOne(Physiotherapist::class);
    }

    public function nurseAssistant()
    {
        return $this->hasOne(NurseAssistant::class);
    }

    public function specialNeed()
    {
        return $this->hasOne(SpecialNeed::class);
    }

    public function agency()
    {
        return $this->hasOne(Agency::class);
    }

    public function careInstitution()
    {
        return $this->hasOne(CareInstitution::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'specialist_id', 'id');
    }


}
