<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('cancel_reason')->nullable()->after('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_locked')->default(false)->after('status');
            $table->text('lock_reason')->nullable()->after('is_locked');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('cancel_reason');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_locked', 'lock_reason']);
        });
    }
};
