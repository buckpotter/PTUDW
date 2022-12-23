<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Support\Facades\DB;
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
        $IdBanVe = 'TK' . $this->faker->unique()->numberBetween(20001, 30000);
        $IdChuyen =  'T' . $this->faker->numberBetween(1, 7000);
        // Lấy ngày đi
        $ngayDi = DB::table('trips')->select('NgayDi')
            ->where('trips.IdChuyen', '=', $IdChuyen)
            ->value('NgayDi');

        // Đảm bảo ngày bán vé < ngày đi và ngày bán vé < now
        $ngayBan = $this->faker->dateTimeBetween($ngayDi . ' -15 days', $ngayDi);
        // Nếu ngày đi < now thì random 15 ngày trước ngày đi
        if ($ngayDi < now()) {
            $ngayBan = $this->faker->dateTimeBetween($ngayDi . ' -15 days', $ngayDi);
        } else {
            // nếu ngày đi > now thì random 3 tháng trước kể từ now
            $ngayBan = $this->faker->dateTimeBetween(now() . ' -3 months', now());
        }

        $thoiDiemBan = $ngayBan->format('Y-m-d H:i:s');
        return [
            'IdBanVe' => $IdBanVe,
            'IdChuyen' => $IdChuyen,
            'IdUser' => 'NU' . $this->faker->numberBetween(1, 10000),
            'created_at' => new DateTime($thoiDiemBan),
            'updated_at' => new DateTime($thoiDiemBan),
        ];
    }
}
