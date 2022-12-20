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
            'IdXe' => 'B' . $this->faker->unique()->numberBetween(1, 2000),
            'So_xe' => $this->faker->numberBetween(11, 99) .
                $this->faker->regexify('[A-Z]{1}') . '-' .
                $this->faker->numerify('#####'),

            'IdNX' => 'BC' . $this->faker->numberBetween(1, 30),

            'Doi_xe' => $this->faker->numberBetween(1990, 2022),

            'Loai_xe' => $this->faker->randomElement(['Giường nằm', 'Ghế ngồi', 'Limousine']),

            // 'So_cho_ngoi' => $this->faker->randomElement([24, 29, 32, 45, 50]),
            'So_cho_ngoi' => 36,
        ];
    }
}
