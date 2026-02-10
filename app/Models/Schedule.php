<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'specialist_id',
        'specialist_type',
        'month',
        'year',
        'date',
    ];

    protected $casts = [

        'date' => 'array',
    ];

}
