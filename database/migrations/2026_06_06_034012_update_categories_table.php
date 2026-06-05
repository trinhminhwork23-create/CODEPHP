<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0.00)->after('description');
            $table->integer('capacity')->default(1)->after('price');
            $table->string('image')->nullable()->after('capacity');
            $table->boolean('status')->default(1)->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['price', 'capacity', 'image', 'status']);
        });
    }
};
