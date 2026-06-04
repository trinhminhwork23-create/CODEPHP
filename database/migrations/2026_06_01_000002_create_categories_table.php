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
        Schema::create('categories', function (Blueprint $table) {
            // id: unsignedBigInteger - Khóa chính tự tăng
            $table->id();

            // name: string (255) - Tên loại phòng
            $table->string('name', 255);

            // description: text - Mô tả ngắn gọn đặc trưng loại phòng
            $table->text('description');

            // created_at / updated_at: timestamp (Laravel tự sinh)
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
        Schema::dropIfExists('categories');
    }
};