<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AboutItem extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'about_id',
        'tag',
        'tag_icon'
    ];

    public function about()
    {
        return $this->belongsTo(About::class);
    }
}
