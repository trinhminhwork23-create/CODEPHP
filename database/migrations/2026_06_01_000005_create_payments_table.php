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
        Schema::create('payments', function (Blueprint $table) {
            // id: unsignedBigInteger - Khóa chính tự tăng
            $table->id();

            // booking_id: Khóa ngoại liên kết với đơn đặt phòng
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');

            // vnp_txn_ref: Mã tham chiếu gửi đi VNPAY
            $table->string('vnp_txn_ref', 100);

            // vnp_transaction_no: Mã giao dịch VNPAY trả về
            $table->string('vnp_transaction_no', 100);

            // vnp_amount: Số tiền thực thu (Đã x100)
            $table->decimal('vnp_amount', 12, 2);

            // vnp_bank_code: Mã ngân hàng thanh toán
            $table->string('vnp_bank_code', 50);

            // vnp_response_code: Mã trạng thái (00 là thành công)
            $table->string('vnp_response_code', 10);

            // created_at: Chỉ cần lưu thời điểm thanh toán (Lịch sử thì ít khi update)
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};