<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HouseManager extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'experience',
        'experienceYear',
        'salaryRange',
        'serviceOffered',
        'isMother',
        'ageOfKids',
        'isHandelingPet',
        'preferBeingA',
        'firstAidCertificate',
        'goodConductCertificate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
