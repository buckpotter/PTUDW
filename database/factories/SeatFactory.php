<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $IdChuyen = 'T' . $this->faker->numberBetween(1, 7000);
        $IdXe = 'B' . $this->faker->numberBetween(1, 2000);

        $soChoNgoi = DB::table('buses')->select('So_Cho_Ngoi')
            ->select('So_Cho_Ngoi')
            ->where('IdXe', $IdXe)
            ->value('So_Cho_Ngoi');

        return [
            'IdChuyen' => $IdChuyen,
            'IdXe' => $IdXe,
            'TenChoNgoi' => 'A' . $this->faker->numberBetween(1, $soChoNgoi),
        ];
    }
}
