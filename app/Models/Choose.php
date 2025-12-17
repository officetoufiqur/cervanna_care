<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Choose extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'subtitle',
        'icon',
    ];
}
