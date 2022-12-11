<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BusCompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // private static $count = 1;

    public function definition()
    {
        $tenNX = $this->faker->unique()->randomElement(['Phương Trang', 'Thành Bưởi', 'Tuyết Hon', 'Thiện Thành', 'Thành Công', 'Khải Nam', 'Hưng Thịnh', 'Mỹ Hằng', 'Hùng Cường', 'Tân Lập', 'Thành Trung', 'Hoàng Khải', 'Sao Việt', 'Thuận Tiến', 'Phúc Xuyên', 'Huỳnh Gia', 'Khánh Học', 'Mai Linh', 'Hoàng Long', 'Phương Nam', 'Đức Tâm', 'Tâm Hồng', 'Đức Thuận', 'Bắc Hà', 'Xuân Hùng', 'Khánh Hoàn', 'Kim Chi', 'Hồng Anh', 'Anh Khôi', 'Hải Cường']);

        $emailNX = match ($tenNX) {
            'Phương Trang' => 'phuongtrang@gmail.com',
            'Thành Bưởi' => 'thanhbuoi@gmail.com',
            'Tuyết Hon' => 'tuyethon@gmail.com',
            'Thiện Thành' => 'thienthanh@gmail.com',
            'Thành Công' => 'thanhcong@gmail.com',
            'Khải Nam' => 'khainam@gmail.com',
            'Hưng Thịnh' => 'hungthinh@gmail.com',
            'Mỹ Hằng' => 'myhang@gmail.com',
            'Hùng Cường' => 'hungcuong@gmail.com',
            'Tân Lập' => 'tanlap@gmail.com',
            'Thành Trung' => 'thanhtrung@gmail.com',
            'Hoàng Khải' => 'hoangkhai@gmail.com',
            'Sao Việt' => 'saoviet@gmail.com',
            'Thuận Tiến' => 'thuantien@gmail.com',
            'Phúc Xuyên' => 'phucxuyen@gmail.com',
            'Huỳnh Gia' => 'huynhgia@gmail.com',
            'Khánh Học' => 'khanhhoc@gmail.com',
            'Mai Linh' => 'mailinh@gmail.com',
            'Hoàng Long' => 'hoanglong@gmail.com',
            'Phương Nam' => 'phuongnam@gmail.com',
            'Đức Tâm' => 'ductam@gmail.com',
            'Tâm Hồng' => 'tamhong@gmail.com',
            'Đức Thuận' => 'ducthuan@gmail.com',
            'Bắc Hà' => 'bacha@gmail.com',
            'Xuân Hùng' => 'xuanhung@gmail.com',
            'Khánh Hoàn' => 'khanhhoan@gmail.com',
            'Kim Chi' => 'kimchi@gmail.com',
            'Hồng Anh' => 'honganh@gmail.com',
            'Anh Khôi' => 'anhkhoi@gmail.com',
            'Hải Cường' => 'haicuong@gmail.com',
        };

        return [
            'IdNX' => 'BC' . $this->faker->unique()->numberBetween(1, 30),
            'Ten_NX' => $tenNX,
            'sdt' => '0' . $this->faker->regexify('[0-9]{9}'),
            'email' => $emailNX,
            'DichVu' => $this->faker->randomElement(['Điểm tâm, Xe trung chuyển, Khăn ướt', 'Wifi, Nước suối', 'Điểm tâm, Wifi, Nước suối', 'Xe trung chuyển, Wifi, Nước suối', 'Điểm tâm, Xe trung chuyển, Wifi, Nước suối']),
            // 'IdRate' => 'R' . $this->faker->numberBetween(1, 10),
        ];
    }
}
