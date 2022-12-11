<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $day = $this->faker->dateTimeBetween('now - 11 months', 'now + 1 years');

        $gioDi = $this->faker->randomElement(['06:00:00', '09:00:00', '13:00:00', '15:00:00', '17:00:00', '20:00:00']);

        $gioDen = intval(substr($gioDi, 0, 2)) + $this->faker->numberBetween(1, 3);
        $gioDen = $gioDen < 10 ? '0' . $gioDen : strval($gioDen);
        $gioDen = $gioDen . ':00:00';
        return [
            'IdChuyen' => 'T' . $this->faker->unique()->numberBetween(1, 7000),
            'IdTuyen' => 'BR' . $this->faker->numberBetween(1, 3906),
            'NgayDi' => $day,
            'GioDi' => $gioDi,
            'NgayDen' => $day,
            'GioDen' => $gioDen,
            'IdXe' => 'B' . $this->faker->numberBetween(1, 2000),
            'GiaVe' => $this->faker->randomElement([100, 150, 200, 250, 300, 350, 400, 450, 500]) * 1000,
        ];
    }
}
