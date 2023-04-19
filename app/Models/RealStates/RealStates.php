<?php

namespace App\Models\RealStates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStates extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_release',
        'recurrent_release',
        'entrance_fees',
        'exit_fees',
        'daily_interest',
        'monthly_interest',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
