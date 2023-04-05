<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\userTypes\User_types;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User_types::factory(1)->create(
            [
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
        ]);
    }
}
