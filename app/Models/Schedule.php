<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'daily_plan',
        'day',
        'monthly_plan',
        'schedule_date',
    ];

    public function timeSlot()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [

        'day' => 'array',
        'daily_plan' => 'boolean',
        'monthly_plan' => 'boolean',
        'schedule_date' => 'date',
    ];

}
