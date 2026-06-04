<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Khởi tạo chuỗi mật khẩu Bcrypt cố định (tương ứng với chữ 'password')
        $passwordHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        
        $users = [
            ['name' => 'Quản trị viên', 'email' => 'admin@sapajadehill.com', 'password' => $passwordHash, 'role' => 'admin', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lễ tân Thu Hà', 'email' => 'thuha.staff@sapajadehill.com', 'password' => $passwordHash, 'role' => 'staff', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CSKH Minh Tuấn', 'email' => 'minhtuan.staff@sapajadehill.com', 'password' => $passwordHash, 'role' => 'staff', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nguyễn Văn An', 'email' => 'nguyenvanan@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Trần Thị Bích', 'email' => 'bichtran9x@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lê Hoàng Long', 'email' => 'longle.hoang@yahoo.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Phạm Quang Khải', 'email' => 'quangkhai.pham@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đặng Thu Thảo', 'email' => 'thuthaodang@hotmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bùi Hữu Trí', 'email' => 'huutri.bui@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Võ Ngọc Mai', 'email' => 'ngocmai.vo@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đỗ Quỳnh Anh', 'email' => 'quynhanh.do2000@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lý Tiểu Long', 'email' => 'lytieulong@bruce.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hồ Gia Hân', 'email' => 'giahan.ho@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vũ Văn Thanh', 'email' => 'vanthanh.vu@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ngô Phương Lan', 'email' => 'phuonglan.ngo@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Trịnh Đình Quang', 'email' => 'dinhquang.trinh@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Châu Tinh Trì', 'email' => 'tinhtri.chau@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mai Phương Thúy', 'email' => 'phuongthuy.mai@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hoàng Thùy Linh', 'email' => 'thuylinh.hoang@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 1, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Spammer Bị Khóa', 'email' => 'spam.hacker@gmail.com', 'password' => $passwordHash, 'role' => 'customer', 'status' => 0, 'remember_token' => Str::random(10), 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('users')->insert($users);
    }
}