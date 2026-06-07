<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'adults',
        'children',
        'total_money',
        'status',
        'cancel_reason',
    ];

    protected $casts = [
        'check_in'    => 'date',
        'check_out'   => 'date',
        'total_money' => 'decimal:2',
        'adults'      => 'integer',
        'children'    => 'integer',
        'status'      => 'integer',
    ];

    // Booking status constants
    const STATUS_PENDING       = 0; // Chờ thanh toán
    const STATUS_DEPOSIT_PAID  = 1; // Đã đặt cọc 50%
    const STATUS_PAID          = 2; // Đã thanh toán 100%
    const STATUS_CANCELLED     = 3; // Đã hủy
    const STATUS_CHECKED_IN    = 4; // Đã nhận phòng
    const STATUS_COMPLETED     = 5; // Đã trả phòng / Hoàn thành

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }
}
