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

    // ── Boot ──────────────────────────────────────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($room) {
            if ($room->bookings()->whereIn('status', ['pending', 'confirmed'])->exists()) {
                throw new \Exception('Kh\u00f4ng th\u1ec3 x\u00f3a ph\u00f2ng \u0111ang c\u00f3 \u0111\u1eb7t ph\u00f2ng \u0111ang x\u1eed l\u00fd!');
            }
        });
    }

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
