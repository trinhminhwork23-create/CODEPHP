<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lưu ý: Giá trị vnp_amount = Giá thực tế x 100 (Cấu trúc bắt buộc của VNPAY)
        // Ví dụ: 5.000.000 VNĐ -> 500.000.000
        
        $payments = [
            [
                'booking_id' => 1, // Đơn 5 triệu
                'vnp_txn_ref' => 'VNP_20260601_001',
                'vnp_transaction_no' => '13526547',
                'vnp_amount' => 500000000.00,
                'vnp_bank_code' => 'NCB',
                'vnp_response_code' => '00', // 00 = Thành công
                'created_at' => now()
            ],
            [
                'booking_id' => 5, // Đơn 6 triệu
                'vnp_txn_ref' => 'VNP_20260701_002',
                'vnp_transaction_no' => '13526588',
                'vnp_amount' => 600000000.00,
                'vnp_bank_code' => 'VIETCOMBANK',
                'vnp_response_code' => '00',
                'created_at' => now()
            ],
            [
                'booking_id' => 8, // Đơn 2,5 triệu
                'vnp_txn_ref' => 'VNP_20260801_003',
                'vnp_transaction_no' => '13526599',
                'vnp_amount' => 250000000.00,
                'vnp_bank_code' => 'VNPAYQR',
                'vnp_response_code' => '00',
                'created_at' => now()
            ]
        ];

        DB::table('payments')->insert($payments);
    }
}