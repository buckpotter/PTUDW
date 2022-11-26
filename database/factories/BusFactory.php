<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bus>
 */
class BusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'So_xe' => $this->faker->numberBetween(11, 99) .
                $this->faker->regexify('[A-Z]{1}') . '-' .
                $this->faker->numerify('#####'),

            'Hieu_xe' => $this->faker->randomElement(['Huyndai', 'Toyota', 'Mazda', 'Ford', 'Kia', 'Honda']),

            'Doi_xe' => $this->faker->numberBetween(1990, 2022),

            'So_ghe' => 32,
        ];
    }
}
