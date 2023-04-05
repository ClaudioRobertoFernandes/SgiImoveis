<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_types')->insert([
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
