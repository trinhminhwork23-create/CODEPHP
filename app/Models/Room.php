<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'room_code',
        'category_id',
        'name',
        'location',
        'price',
        'image',
        'size',
        'capacity',
        'bed_type',
        'description',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'size'     => 'integer',
        'capacity' => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'room_id', 'id');
    }
}
