<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Villa (Biệt thự biệt lập)',
                'description' => 'Không gian biệt thự sang trọng, thích hợp cho gia đình hoặc nhóm bạn muốn tận hưởng sự riêng tư trọn vẹn giữa mây ngàn Sapa.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bungalow (Nhà tre/gỗ mộc mạc)',
                'description' => 'Thiết kế mái cọ, vách gỗ mang đậm hơi thở bản địa Tây Bắc nhưng vẫn đầy đủ tiện nghi cao cấp, view nhìn thẳng ra thung lũng Mường Hoa.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Deluxe Room (Phòng hạng sang)',
                'description' => 'Phòng tiêu chuẩn khách sạn 5 sao với ban công rộng, không gian ấm cúng, đón trọn ánh nắng ban mai và sương mù Sapa.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Studio Room (Phòng căn hộ tiện ích)',
                'description' => 'Không gian tích hợp thông minh giữa phòng ngủ và khu vực bếp nhỏ tiện lợi, cực kỳ lý tưởng cho các cặp đôi đi nghỉ dưỡng dài ngày.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Khu Biệt Thự Triền Núi (Nest Villa)',
                'description' => 'Khu biệt thự cao cấp nằm lọt thỏm giữa triền núi, mang lại không gian tĩnh lặng và riêng tư tuyệt đối.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}