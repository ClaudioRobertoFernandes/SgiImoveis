<?php

namespace App\Models\Accouting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accoutting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'price',
        'descount',
    ];

    public function getPriceAttribute($value): string
    {
        return $this->attributes['price'] = $value;
    }

}
