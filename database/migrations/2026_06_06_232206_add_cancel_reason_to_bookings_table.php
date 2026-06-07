<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Thêm cột cancel_reason, cho phép null vì các đơn bình thường không bị hủy sẽ không có lý do
            $table->text('cancel_reason')->nullable()->after('status'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Xóa cột nếu lùi migration
            $table->dropColumn('cancel_reason');
        });
    }
};
