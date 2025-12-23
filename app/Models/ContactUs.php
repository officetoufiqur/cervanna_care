<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'heading',
        'sub_heading',
        'title',
        'subtitle',
        'icon',
        'map',
    ];
}
