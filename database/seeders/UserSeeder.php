<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                "user_type_id" => 1,
                "name" => "Claudio Roberto Fernandes",
                "email" => "claudio.crfdev@gmail.com",
                "password" => bcrypt("password"),
                "document" => "98763285285",
                "phone" => "47999882232",
                "zipCode" => "88337520",
                "state" => "SC",
                "city" => "Balneario Camboriu",
                "neighborhood" => "Vila Real",
                "street" => "Dom José"
            ],
            [
                "user_type_id" => 5,
                "name" => "Imobi Teste",
                "email" => "imobitest@gmail.com",
                "password" => bcrypt("password"),
                "document" => "987.632.852-85",
                "phone" => "(47) 9 9999-8888",
                "zipCode" => "88337-520",
                "state" => "SC",
                "city" => "Balneario Camboriu",
                "neighborhood" => "Vila Real",
                "street" => "Dom José"
            ],
            [
                "user_type_id" => 6,
                "name" => "Teste Contabilidade",
                "email" => "testecontabilidade@gmail.com",
                "password" => bcrypt("password"),
                "document" => "83.106.058/0001-41",
                "phone" => "(47) 9 7777-6666",
                "zipCode" => "88337520",
                "state" => "SC",
                "city" => "Balneario Camboriu",
                "neighborhood" => "Vila Real",
                "street" => "Dom José"
            ],
        ]);
    }
}
