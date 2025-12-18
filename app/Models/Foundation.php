<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Foundation extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'heading',
        'subheading',
        'vision_title',
        'vision_subtitle',
        'mission_title',
        'mission_subtitle',
        'image',
    ];
}