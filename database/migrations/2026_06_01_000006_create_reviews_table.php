<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Khóa ngoại
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            
            $table->tinyInteger('rating'); // Sẽ validate 1-5 ở tầng PHP Controller
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(1); // 1: Hiện, 0: Ẩn
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};