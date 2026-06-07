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
    const STATUS_PENDING  = 0;
    const STATUS_APPROVED = 1;
    const STATUS_PAID     = 2;
    const STATUS_CANCELLED = 3;

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
