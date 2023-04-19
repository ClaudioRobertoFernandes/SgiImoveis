<?php

namespace Database\Factories\RealStates;

use App\Models\RealStates\RealStates;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RealStates>
 */
class RealStatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> 18,
            'real_estate_belongs'=> 1,
            'first_release' => 60,
            'recurrent_release' => 10,
            'entrance_fees' => 20,
            'exit_fees' => 20,
            'daily_interest' => 1,
            'monthly_interest' => 2,
        ];
    }
}
