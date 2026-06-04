<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run()
    {
        DB::table('rooms')->insert([
            // Panorama
            ['room_code' => 'SJD-101', 'category_id' => 1, 'name' => 'Bungalow Panorama P1', 'location' => 'Khu Rừng Thông', 'price' => 3200000, 'image' => 'panorama_101.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Phòng có ban công lớn, bồn tắm ngâm thảo dao đỏ.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-102', 'category_id' => 1, 'name' => 'Bungalow Panorama P2', 'location' => 'Khu Rừng Thông', 'price' => 3200000, 'image' => 'panorama_102.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '2 Single Beds', 'description' => 'Phòng có ban công lớn, bồn tắm ngâm thảo dao đỏ.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-103', 'category_id' => 1, 'name' => 'Bungalow Panorama P3', 'location' => 'Khu Rừng Thông', 'price' => 3200000, 'image' => 'panorama_103.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Gần lối đi nội khu, view trọn vẹn thung lũng.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-104', 'category_id' => 1, 'name' => 'Bungalow Panorama P4', 'location' => 'Khu Rừng Thông', 'price' => 3200000, 'image' => 'panorama_104.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Nội thất gỗ mộc mạc, lò sưởi giả.', 'created_at' => now(), 'updated_at' => now()],

            // Mountain
            ['room_code' => 'SJD-201', 'category_id' => 2, 'name' => 'Bungalow Mountain M1', 'location' => 'Khu Sườn Núi', 'price' => 2800000, 'image' => 'mountain_201.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Tầm nhìn ra rừng thông và đỉnh Fansipan mờ ảo.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-202', 'category_id' => 2, 'name' => 'Bungalow Mountain M2', 'location' => 'Khu Sườn Núi', 'price' => 2800000, 'image' => 'mountain_202.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '2 Single Beds', 'description' => 'Hướng núi, trang bị quạt sưởi, bàn làm việc.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-203', 'category_id' => 2, 'name' => 'Bungalow Mountain M3', 'location' => 'Khu Sườn Núi', 'price' => 2800000, 'image' => 'mountain_203.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Tầm nhìn ra rừng thông, gần khu vui chơi trẻ em.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-204', 'category_id' => 2, 'name' => 'Bungalow Mountain M4', 'location' => 'Khu Sườn Núi', 'price' => 2800000, 'image' => 'mountain_204.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Góc view sống ảo cực đẹp, riêng tư tuyệt đối.', 'created_at' => now(), 'updated_at' => now()],

            ['room_code' => 'SJD-304', 'category_id' => 3, 'name' => 'Deluxe Bungalow D4', 'location' => 'Khu Nest Castle', 'price' => 2500000, 'image' => 'deluxe_304.jpg', 'size' => 40, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Không gian mở, ánh sáng tự nhiên ngập tràn.', 'created_at' => now(), 'updated_at' => now()],

             // Deluxe Valley View
            ['room_code' => 'SJD-401', 'category_id' => 4, 'name' => 'Deluxe Valley View V1', 'location' => 'Khu Tòa Nhà Trung Tâm', 'price' => 1800000, 'image' => 'valley_401.jpg', 'size' => 30, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Nằm trong tòa nhà chính, phù hợp du khách ngại di chuyển xa.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-402', 'category_id' => 4, 'name' => 'Deluxe Valley View V2', 'location' => 'Khu Tòa Nhà Trung Tâm', 'price' => 1800000, 'image' => 'valley_402.jpg', 'size' => 30, 'capacity' => 2, 'bed_type' => '2 Single Beds', 'description' => 'Phòng có ban công nhỏ, view nhìn ra thung lũng.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-403', 'category_id' => 4, 'name' => 'Deluxe Valley View V3', 'location' => 'Khu Tòa Nhà Trung Tâm', 'price' => 1800000, 'image' => 'valley_403.jpg', 'size' => 30, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Nội thất hiện đại, phòng tắm kính sang trọng.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-404', 'category_id' => 4, 'name' => 'Deluxe Valley View V4', 'location' => 'Khu Tòa Nhà Trung Tâm', 'price' => 1800000, 'image' => 'valley_404.jpg', 'size' => 30, 'capacity' => 2, 'bed_type' => '1 King Bed', 'description' => 'Phòng yên tĩnh, thích hợp cho nghỉ dưỡng.', 'created_at' => now(), 'updated_at' => now()],

             // Nest Villa
            ['room_code' => 'SJD-501', 'category_id' => 5, 'name' => 'Nest Villa N1 - Biệt Thự Tổ Chim', 'location' => 'Khu Biệt Thự Triền Núi', 'price' => 6500000, 'image' => 'nest_501.jpg', 'size' => 90, 'capacity' => 5, 'bed_type' => '1 King Bed & 2 Single Beds', 'description' => 'Biệt thự 3 phòng ngủ, phòng khách rộng rãi, bếp đầy đủ tiện nghi.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-502', 'category_id' => 5, 'name' => 'Nest Villa N2 - Biệt Thự Tổ Chim', 'location' => 'Khu Biệt Thự Triền Núi', 'price' => 6500000, 'image' => 'nest_502.jpg', 'size' => 90, 'capacity' => 5, 'bed_type' => '2 Double Beds', 'description' => 'Không gian sinh hoạt chung lớn, BBQ ngoài trời tự túc.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-503', 'category_id' => 5, 'name' => 'Nest Villa N3 - Biệt Thự Tổ Chim', 'location' => 'Khu Biệt Thự Triền Núi', 'price' => 6500000, 'image' => 'nest_503.jpg', 'size' => 90, 'capacity' => 5, 'bed_type' => '1 Double Bed & 2 Single Beds', 'description' => 'Ban công rộng, 2 phòng tắm riêng biệt, dịch vụ quản gia.', 'created_at' => now(), 'updated_at' => now()],
            ['room_code' => 'SJD-504', 'category_id' => 5, 'name' => 'Nest Villa N4 - Biệt Thự Tổ Chim', 'location' => 'Khu Biệt Thự Triền Núi', 'price' => 6500000, 'image' => 'nest_504.jpg', 'size' => 90, 'capacity' => 5, 'bed_type' => '2 Double Beds', 'description' => 'View đỉnh Fansipan hùng vĩ, không gian yên tĩnh.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}