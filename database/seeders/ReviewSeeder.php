<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        DB::table('reviews')->insert([
            ['user_id' => 3, 'room_id' => 1, 'rating' => 5, 'comment' => 'Phòng Panorama cực đẹp, bồn tắm ngâm chân lá dao đỏ rất thư giãn.', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'room_id' => 2, 'rating' => 4, 'comment' => 'View thung lũng sương mù rất đẹp, tuy nhiên phòng hơi xa nhà hàng.', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'room_id' => 3, 'rating' => 1, 'comment' => 'Mạng wifi quá yếu, không làm việc được!!', 'status' => 0, 'created_at' => now(), 'updated_at' => now()], // Bị ẩn
        ]);
    }
}