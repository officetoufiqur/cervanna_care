<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class About extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    public function items()
    {
        return $this->hasMany(AboutItem::class);
    }
}
