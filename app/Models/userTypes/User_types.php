<?php

namespace App\Models\userTypes;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class User_types extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public static function getPermitionType(): Collection
    {
        $permitions = null;

        if(User::getMaster(Auth::user()->id) === true){
            $permitions = self::all()->pluck('name', 'id');
        }else{
            $permitions = self::whereNotIn('id',[1,2])->pluck('name', 'id');
        }

        return $permitions;
    }
}
