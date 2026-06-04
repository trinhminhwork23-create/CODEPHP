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
        Schema::create('users', function (Blueprint $table) {
            // id: unsignedBigInteger - Khóa chính tự tăng
            $table->id(); 
            
            // name: string (255) - Họ và tên
            $table->string('name', 255); 
            
            // email: string (255) - Unique không trùng lặp
            $table->string('email', 255)->unique(); 
            
            // password: string (255) - Mật khẩu mã hóa
            $table->string('password', 255); 
            
            // role: string (50) - Phân quyền (admin, staff, customer)
            $table->string('role', 50); 
            
            // status: tinyInteger - Trạng thái (1: Hoạt động, 0: Bị khóa)
            $table->tinyInteger('status')->default(1); 
            
            // remember_token: string (100) - Duy trì đăng nhập
            $table->rememberToken(); 
            
            // created_at / updated_at: timestamp
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
        Schema::dropIfExists('users');
    }
};