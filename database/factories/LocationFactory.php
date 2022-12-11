<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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

        return [
            'TenDiaDiem' => $this->faker->unique()->randomElement($city),
            'slider_img' => $this->faker->imageUrl(1920, 1080, 'city'),
            'content_img' => $this->faker->imageUrl(300, 300, 'city'),
        ];
    }
}
