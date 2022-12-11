<?php

namespace Database\Factories;

use App\Models\BusRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusRoute>
 */
class BusRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected static $routes = [];
    public function definition()
    {
        $city = [
            'Hòa Bình',
            'Sơn La',
            'Điện Biên',
            'Lai Châu',
            'Lào Cai',
            'Yên Bái',
            'Phú Thọ',
            'Hà Giang',
            'Tuyên Quang',
            'Cao Bằng',
            'Bắc Kạn',
            'Thái Nguyên',
            'Lạng Sơn',
            'Bắc Giang',
            'Quảng Ninh',
            'Hà Nội',
            'Bắc Ninh',
            'Hà Nam',
            'Hải Dương',
            'Hải Phòng',
            'Hưng Yên',
            'Nam Định',
            'Thái Bình',
            'Vĩnh Phúc',
            'Ninh Bình',
            'Thanh Hóa',
            'Nghệ An',
            'Hà Tĩnh',
            'Quảng Bình',
            'Quảng Trị',
            'Huế',
            'Đà Nẵng',
            'Quảng Nam',
            'Quảng Ngãi',
            'Bình Định',
            'Phú Yên',
            'Khánh Hòa',
            'Ninh Thuận',
            'Bình Thuận',
            'TP. Hồ Chí Minh',
            'Vũng Tàu',
            'Bình Dương',
            'Bình Phước',
            'Đồng Nai',
            'Tây Ninh',
            'An Giang',
            'Bạc Liêu',
            'Bến Tre',
            'Cà Mau',
            'Cần Thơ',
            'Đồng Tháp',
            'Hậu Giang',
            'Kiên Giang',
            'Long An',
            'Sóc Trăng',
            'Tiền Giang',
            'Trà Vinh',
            'Vĩnh Long',
            'Kon Tum',
            'Gia Lai',
            'Đắk Lắk',
            'Đắk Nông',
            'Lâm Đồng',
        ];

        $from = '';
        $to = '';

        do {
            $from = $this->faker->randomElement($city);
            $to = $this->faker->randomElement($city);
        } while ($from == $to || in_array($from . ' - ' . $to, self::$routes));


        // self::$routes[] = $from . ' - ' . $to;
        array_push(self::$routes, $from . ' - ' . $to);

        return [
            'IdTuyen' => 'BR' . $this->faker->unique()->numberBetween(1, 3906),
            'TenTuyen' => $from . ' - ' . $to,
            'DiaDiemDi' => $from,
            'DiaDiemDen' => $to,
        ];
    }
}
