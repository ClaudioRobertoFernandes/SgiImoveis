<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserTypes\UserTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use PharIo\Manifest\Email;

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
    ];

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
