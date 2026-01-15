<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillService extends Model
{
    protected $fillable = [
        'nurse_id',
        'skill_id',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
