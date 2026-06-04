<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class, // Tạo Danh mục trước
            RoomSeeder::class,     // Tạo Phòng (cần category_id)
            UserSeeder::class,     // Tạo User
            BookingSeeder::class,  // Tạo Đơn (cần user_id và room_id)
            PaymentSeeder::class,  // Tạo Giao dịch (cần booking_id)
            ReviewSeeder::class,   // Tạo Đánh giá (cần user_id và room_id)
        ]);
    }
}