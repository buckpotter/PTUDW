<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'IdBanVe' => 'TK' . $this->faker->unique()->numberBetween(1, 10000),
            'IdChuyen' => 'T' . $this->faker->numberBetween(1, 7000),
            'IdUser' => 'NU' . $this->faker->numberBetween(1, 10000),
            // 'Soluong' => $this->faker->numberBetween(1, 10),
        ];
    }
}
