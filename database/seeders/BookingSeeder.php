<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = [
            [
                'user_id' => 4, // Nguyễn Văn An
                'room_id' => 1,
                'check_in' => '2026-06-10',
                'check_out' => '2026-06-12',
                'adults' => 2,
                'children' => 1,
                'total_money' => 5000000.00,
                'status' => 2, // Đã thanh toán (Thành công hoàn toàn)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 5, // Trần Thị Bích
                'room_id' => 2,
                'check_in' => '2026-06-15',
                'check_out' => '2026-06-16',
                'adults' => 2,
                'children' => 0,
                'total_money' => 1800000.00,
                'status' => 1, // Đã duyệt (Chờ khách đến nhận phòng)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 6, // Lê Hoàng Long
                'room_id' => 3,
                'check_in' => '2026-06-20',
                'check_out' => '2026-06-23',
                'adults' => 4,
                'children' => 2,
                'total_money' => 9000000.00,
                'status' => 0, // Chờ duyệt (Đơn mới đặt, Admin cần xử lý)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 7, // Phạm Quang Khải
                'room_id' => 1,
                'check_in' => '2026-06-01',
                'check_out' => '2026-06-03',
                'adults' => 2,
                'children' => 0,
                'total_money' => 5000000.00,
                'status' => 3, // Đã hủy (Khách hủy hoặc trùng lịch)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 8, // Đặng Thu Thảo
                'room_id' => 4,
                'check_in' => '2026-07-01',
                'check_out' => '2026-07-05',
                'adults' => 1,
                'children' => 0,
                'total_money' => 6000000.00,
                'status' => 2, // Đã thanh toán
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 9, // Bùi Hữu Trí
                'room_id' => 2,
                'check_in' => '2026-07-10',
                'check_out' => '2026-07-12',
                'adults' => 2,
                'children' => 1,
                'total_money' => 3600000.00,
                'status' => 0, // Chờ duyệt
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 10, // Võ Ngọc Mai
                'room_id' => 3,
                'check_in' => '2026-07-15',
                'check_out' => '2026-07-18',
                'adults' => 3,
                'children' => 0,
                'total_money' => 9000000.00,
                'status' => 1, // Đã duyệt
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 11, // Đỗ Quỳnh Anh
                'room_id' => 1,
                'check_in' => '2026-08-01',
                'check_out' => '2026-08-02',
                'adults' => 2,
                'children' => 0,
                'total_money' => 2500000.00,
                'status' => 2, // Đã thanh toán
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('bookings')->insert($bookings);
    }
}