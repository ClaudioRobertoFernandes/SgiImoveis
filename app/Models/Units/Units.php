<?php

namespace App\Models\Units;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'tenant_id',
        'name',
        'description',
        'zip_code',
        'state',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'active' => 'boolean',
        'empty' => 'boolean',
    ];
}
