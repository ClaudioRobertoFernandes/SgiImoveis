<?php

namespace App\Models\RealStates;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RealStates extends Model
{
    use HasFactory;

    protected $table = 'real_states';
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

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): hasOne
    {
        return $this->hasOne(User::class);
    }

    public function getValueBaseAttribute($value): float|int
    {
        $this->attributes['value_base'] = number_format($value / 100, 2, ',', '.');
        return $this->attributes['value_base'];
    }

    protected function entranceFees(): Attribute
    {
        return Attribute::make(
            get: static fn(int $value) => $value,
            set: static fn(int $value) => $value,
        );
    }

    public function getEntranceFeesAttribute($value): float|int
    {
        return $this->attributes['entrance_fees'] = $value;
    }
}
