<?php

namespace Database\Factories;

use DateTime;
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
        $TenChoNgoi = '';

        do {
            $IdBanVe = 'TK' . $this->faker->numberBetween(1, 30000);

            $soLuong = DB::table('ticket_details')
                ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
                ->where('tickets.IdBanVe', '=', $IdBanVe)
                ->count();

            if ($soLuong < 36)
                break;
        } while (true);


        while (true) {
            $TenChoNgoi = 'A' . $this->faker->numberBetween(1, 36);
            $check = DB::table('ticket_details')
                ->where('IdBanVe', '=', $IdBanVe)
                ->where('TenChoNgoi', '=', $TenChoNgoi)
                ->count();

            if ($check == 0)
                break;
        }

        $thoiDiemBan = DB::table('tickets')
            ->select('created_at')
            ->where('tickets.IdBanVe', '=', $IdBanVe)
            ->value('created_at');

        array_push(self::$arr, $IdBanVe);

        // Lấy pttt của vé trước đó (nếu có)
        $temp = DB::table('ticket_details')
            ->where('IdBanVe', '=', $IdBanVe)
            ->first();

        $pttt = '';
        // Nếu pttt === null (chưa có vé nào bán) thì random pttt
        if ($temp === null) {
            $pttt = $this->faker->randomElement(['Thanh toán khi nhận vé', 'Thanh toán qua thẻ ngân hàng', 'Thanh toán qua Momo', 'Thanh toán qua ZaloPay', 'Thanh toán qua Paypal']);
        } else
            $pttt = $temp->pttt;


        // Nếu $ngayDi <= now() thì random tình trạng vé là 'Đã hoàn thành', 'Đã hủy'
        // Nếu $ngayDi > now() thì random tình trạng vé là 'Chờ xác nhận', 'Đã hủy', 'Đã hoàn thành', 'Chưa hoàn thành'
        $ttv = '';
        // Lấy chuyến xe của
        $IdChuyen = DB::table('tickets')
            ->select('IdChuyen')
            ->where('tickets.IdBanVe', '=', $IdBanVe)
            ->first()
            ->IdChuyen;

        // Lấy ngày đi của chuyến xe
        $ngayDi = DB::table('trips')
            ->select('NgayDi', 'GioDi')
            ->where('trips.IdChuyen', '=', $IdChuyen)
            ->first();

        // Chuyển ngày đi thành dạng datetime
        $ngayDi = date('Y-m-d H:i:s', strtotime($ngayDi->NgayDi . ' ' . $ngayDi->GioDi));

        // Seed vé
        if (strtotime($ngayDi) <= strtotime(date('Y-m-d H:i:s'))) {
            // tỉ lệ 7/8 vé đã hoàn thành, 1/8 vé đã hủy nếu ngày đi <= now()
            $ttv = $this->faker->randomElement(['Đã hoàn thành', 'Đã hoàn thành', 'Đã hoàn thành', 'Đã hoàn thành', 'Đã hoàn thành', 'Đã hoàn thành', 'Đã hoàn thành', 'Đã hủy']);
        } else {
            // tỉ lệ 2/8 vé chưa hoàn thành, 1/8 vé đã hủy, 3/8 vé đã hoàn thành, 2/8 vé chờ xác nhận nếu ngày đi > now()
            $ttv = $this->faker->randomElement(['Đã hoàn thành', 'Đã hoàn thành', 'Đã hoàn thành', 'Đã hủy', 'Chưa hoàn thành', 'Chưa hoàn thành', 'Chờ xác nhận', 'Chờ xác nhận']);
        }

        return [
            'IdCTBV' => 'TD' . count(self::$arr),
            'IdBanVe' => $IdBanVe,
            'TenChoNgoi' => $TenChoNgoi,
            'TinhTrangVe' => $ttv,
            'pttt' => $pttt,
            'created_at' => new DateTime($thoiDiemBan),
            'updated_at' => new DateTime($thoiDiemBan)
        ];
    }
}
