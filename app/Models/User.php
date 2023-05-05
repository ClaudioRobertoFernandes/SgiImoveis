<?php

namespace App\Models;

use App\Models\UserTypes\UserTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'belongs',
        'email',
        'password',
        'document',
        'phone',
        'zipCode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getDocumentAttribute($value): array|string
    {
        $document = null;
        $str = preg_replace('/(\D)/', '', $value);
        if (strlen($str) === 11) {
            $document = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $str);
        }else {
            $document = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $str);
        }
        return $document;
    }

    public function getPhoneAttribute($value): array|string|null
    {
        return preg_replace('/^(?:(?:\+|00)?(55)\s?)?(?:\(?(\d\d)\)?\s?)?(?:((?:9\d|\d)\d{3})\-?(\d{4}))$/','$1 ($2) $3-$4', $value , );
    }
    public function getzipCodeAttribute($value): array|string|null
    {
        return preg_replace('/^(\d{2})\.?(\d{3})\-?(\d{3})/','$1.$2-$3', $value);
    }

    public function getNumberAttribute($value)
    {
        return $this->attributes['number'];
    }

    public function setNumberAttribute($value): string
    {
        if($value === null || $value === ''){
            return $this->attributes['number'] = 'S/N';
        }

        return $this->attributes['number'] = $value;
    }

    public function getComplementAttribute($value)
    {
        return $this->attributes['complement'];
    }

    public function setComplementAttribute($value): string
    {
        if($value === null || $value === ''){
            return $this->attributes['complement'] = 'S/C';
        }

        return $this->attributes['complement'] = $value;
    }
    public function userTypes(): HasOne
    {
        return $this->hasOne(UserTypes::class);
    }

    public static function getMaster(int $idUser): bool
    {
        $master = self::select('user_type_id')->where('id', $idUser)->first();

        return $master->user_type_id === 1;
    }

    public static function getBelongsToUser()
    {

        return Auth::user()->belongs ?? Auth::user()->id;
    }

    public static function isPermited(String $email)
    {
        $user = self::where('email', $email)->first();
        if($user){
            if ($user->user_type_id === 1 || $user->user_type_id === 2 || $user->user_type_id === 3 || $user->user_type_id === 4) {
                return ['permited' => 2];
            }

            if($user->user_type_id === 5 || $user->user_type_id === 6) {
                return ['permited' => 1];

            }
        }
        else{
            return ['permited' => 0];
        }
    }
}
