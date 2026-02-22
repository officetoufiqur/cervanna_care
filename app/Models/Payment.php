<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'user_id',
        'user_type',
        'plan_id',
        'plan_type',
        'amount',
        'currency',
        'payment_method',
        'payment_status',
    ];
}
