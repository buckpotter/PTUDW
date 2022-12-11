<?php

namespace Database\Factories;

use App\Models\NormalUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NormalUser>
 */
class NormalUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ho = ['Nguyễn', 'Hoàng', 'Huỳnh', 'Võ', 'Lý', 'Vũ', 'Quách', 'Đinh', 'Trần', 'Đặng', 'Trương', 'Danh', 'Lê'];
        $ten = ['Văn Cường', 'Thị Hồng Nhung', 'Hồng Ngọc', 'Thành Trung', 'Tuyết Mai', 'Thành Công', 'Hùng Dũng', 'Tuấn Hưng', 'Hữu Nhật', 'Minh Khánh', 'Minh Trí', 'Kim Ngân', 'Như Ngọc', 'Như Ý', 'Kim Ngọc', 'Thành Nhân', 'Văn Đạt', 'Văn Minh'];

        $name = $this->faker->randomElement($ho) . ' ' . $this->faker->randomElement($ten);

        return [
            'IdUser' => 'NU' . $this->faker->unique()->numberBetween(1, 10000),
            'HoTen' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(),
            'sdt' => '0' . $this->faker->unique()->regexify('[0-9]{9}'),
            'image' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
        ];
    }
}
