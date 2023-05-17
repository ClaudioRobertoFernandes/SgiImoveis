<?php

namespace Database\Factories\Accouting;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accouting\Accoutting>
 */
class AccouttingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'price' => $this->faker->randomNumber(4),
            'descount' => $this->faker->randomNumber(4),
        ];
    }
}
