<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_code', 50)->unique();
            
            // Khóa ngoại liên kết với bảng categories
            $table->foreignId('category_id')->constrained('categories')
                  ->onUpdate('cascade')->onDelete('restrict');
                  
            $table->string('name');
            $table->string('location')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->integer('size')->nullable();
            $table->tinyInteger('capacity');
            $table->string('bed_type', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};