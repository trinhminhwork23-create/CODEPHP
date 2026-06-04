<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            // id: unsignedBigInteger - Khóa chính tự tăng (Mã hóa đơn)
            $table->id();

            // user_id: Khóa ngoại liên kết với id của bảng users (Ai đặt)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // room_id: Khóa ngoại liên kết với id của bảng rooms (Đặt phòng nào)
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');

            // check_in / check_out: Kiểu DATE quản lý ngày nhận/trả phòng
            $table->date('check_in');
            $table->date('check_out');

            // adults / children: Số lượng người lớn và trẻ em
            $table->tinyInteger('adults');
            $table->tinyInteger('children')->default(0);

            // total_money: decimal(12,2) - Tổng tiền toán (Sẽ được Trigger tự động tính toán lại)
            $table->decimal('total_money', 12, 2)->default(0.00);

            // status: tinyInteger (0: Chờ duyệt, 1: Đã duyệt, 2: Đã thanh toán, 3: Đã hủy)
            $table->tinyInteger('status')->default(0);

            // created_at / updated_at: Thời gian đặt phòng và cập nhật đơn
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};