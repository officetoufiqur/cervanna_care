<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareInstitution extends Model
{
    protected $fillable = [
        'user_id',
        'companyName',
        'kraPin',
        'number',
        'companyRegistrationNumber',
        'businessLocation',
        'registrationDocument',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institutionNurses()
    {
        return $this->hasMany(InstitutionNurse::class);
    }


}
