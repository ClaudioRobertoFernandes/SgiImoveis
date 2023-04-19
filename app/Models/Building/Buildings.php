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

    public static function getBuildings(int $owner_id)
    {
        $building = self::where('owner_id', $owner_id)->pluck('name', 'id');
        if ($building->isEmpty()) {
            return 'Nenhum edifício Cadastrado para este usuario';
        }

        return $building;
    }
}
