<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EventPartner extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'event_id',
        'name'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
