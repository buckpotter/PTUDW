<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rate>
 */
class RateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'IdRate' => 'R' . $this->faker->unique()->numberBetween(1, 10000),
            'IdNX' => 'BC' . $this->faker->numberBetween(1, 30),
            // 'IdChuyen' => 'T' . $this->faker->numberBetween(1, 5000),
            'IdUser' => 'NU' . $this->faker->numberBetween(1, 10000),
            // 'IdCTBV' => 'TD' . $this->faker->numberBetween(1, 10000),
            'DanhGia' => $this->faker->numberBetween(1, 5),
            'BinhLuan' => $this->faker->text(100),
            'NgayDanhGia' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
