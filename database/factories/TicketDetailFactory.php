<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketDetail>
 */
class TicketDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $arr = [];
    public function definition()
    {
        ini_set('memory_limit', '2048M');
        $IdBanVe = '';
        $soLuong = '';
        // $soChoNgoi = '';
        $TenChoNgoi = '';

        do {
            $IdBanVe = 'TK' . $this->faker->numberBetween(1, 30000);

            $soLuong = DB::table('ticket_details')
                ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
                ->where('tickets.IdBanVe', '=', $IdBanVe)
                ->count();

            // Lấy số ghế
            // $soChoNgoi = DB::table('buses')
            //     ->select('So_Cho_Ngoi')
            //     ->join('trips', 'buses.IdXe', '=', 'trips.IdXe')
            //     ->join('tickets', 'trips.IdChuyen', '=', 'tickets.IdChuyen')
            //     ->where('tickets.IdBanVe', '=', $IdBanVe)->value('So_Cho_Ngoi');

            if ($soLuong < 42)
                break;
        } while (true);


        while (true) {
            $TenChoNgoi = 'A' . $this->faker->numberBetween(1, 42);
            $check = DB::table('ticket_details')
                ->where('IdBanVe', '=', $IdBanVe)
                ->where('TenChoNgoi', '=', $TenChoNgoi)
                ->count();

            if ($check == 0)
                break;
        }


        // Lấy ngày đi
        $ngayDi = DB::table('ticket_details')->select('NgayDi')
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->where('tickets.IdBanVe', '=', $IdBanVe)->value('NgayDi');

        // Lấy giờ đi
        $gioDi = DB::table('ticket_details')->select('GioDi')
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->where('tickets.IdBanVe', '=', $IdBanVe)->value('GioDi');

        // Random ngày bán giữa (ngày đi -15) và ngày đi
        $ngayBan = $this->faker->dateTimeBetween('-15 days', $ngayDi);

        // Random giờ bán
        $gioBan = $this->faker->time();
        if ($ngayBan === $ngayDi) {
            // nếu ngày đi === ngày bán thì giờ bán phải <= giờ đi
            $gioBan = $this->faker->time('H:i:s', $gioDi);
        }

        array_push(self::$arr, $IdBanVe);

        $temp = DB::table('ticket_details')
            ->select('pttt')
            ->where('ticket_details.IdBanVe', '=', $IdBanVe)
            ->first();
        $pttt = '';
        // Nếu pttt === null (chưa có vé nào bán) thì random pttt
        if ($temp === null) {
            $pttt = $this->faker->randomElement(['Thanh toán khi nhận vé', 'Thanh toán qua thẻ ngân hàng', 'Thanh toán qua Momo', 'Thanh toán qua ZaloPay', 'Thanh toán qua Paypal']);
        } else
            $pttt = $temp->pttt;

        return [
            'IdCTBV' => 'TD' . count(self::$arr),
            'IdBanVe' => $IdBanVe,
            'TenChoNgoi' => $TenChoNgoi,
            'TinhTrangVe' => $this->faker->randomElement(['Đã hoàn thành', 'Chưa hoàn thành', 'Đã hủy']),
            'NgayBan' => $ngayBan,
            'GioBan' => $gioBan,
            'pttt' => $pttt
        ];
    }
}
