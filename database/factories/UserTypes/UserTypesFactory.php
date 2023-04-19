<?php

namespace Database\Factories\UserTypes;

use App\Models\UserTypes\UserTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserTypes>
 */
class UserTypesFactory extends Factory
{
    protected $model = UserTypes::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            [
                'name'=> 'Master',
                'description'=> 'Admin geral do sistema',
            ],
            [
                'name'=> 'Proprietário',
                'description'=> 'Proprietario do imóvel',
            ],
            [
                'name'=> 'Usuário',
                'description'=> 'Usuário comum do sistema',
            ],
            [
                'name'=> 'Inquilino',
                'description'=> 'Usuário que aluga um imóvel',
            ],
            [
                'name'=> 'Imobiliaria',
                'description'=> 'Imobiliaria que aluga um imóvel',
            ],
            [
                'name'=> 'Contabilidade',
                'description'=> 'Contabilidade orienta, controla e registra e administra um imóvel',
            ]
        ];
    }
}
