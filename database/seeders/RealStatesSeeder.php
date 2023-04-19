<?php

namespace Database\Seeders;

use App\Models\RealStates\RealStates;
use Illuminate\Database\Seeder;

class RealStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RealStates::factory(1)->create([
            'user_id'=> 18,
            'real_estate_belongs'=> 1,
            'first_release' => 60,
            'recurrent_release' => 10,
            'entrance_fees' => 20,
            'exit_fees' => 20,
            'daily_interest' => 1,
            'monthly_interest' => 2,
        ]);
    }
}
