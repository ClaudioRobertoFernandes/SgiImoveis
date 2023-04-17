<?php

namespace App\Models\Building;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
