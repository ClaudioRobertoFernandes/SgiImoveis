<?php

namespace App\Models\RealStates;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStates extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_release',
        'value_base',
        'recurrent_release',
        'entrance_fees',
        'exit_fees',
        'daily_interest',
        'monthly_interest',
    ];

    protected $appends = [
//        'valor',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected function getValueBaseAttribute($value): float|int
    {
        return $this->attributes['value_base'] = sprintf('R$ %s', number_format($value, 2));
    }


    protected function valueBase(): Attribute
    {
        return Attribute::make(
            get: static fn (string $value) => 'Meu nome: ' . strtoupper($value) . ' e tenho '. 35 . ' anos.',
        );
    }
}
