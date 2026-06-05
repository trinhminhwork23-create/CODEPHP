<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'price',
        'capacity',
        'image',
        'status',
    ];

    // ── Boot ──────────────────────────────────────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->rooms()->count() > 0) {
                throw new \Exception('Không thể xóa loại phòng đang có phòng liên kết!');
            }
        });
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function rooms()
    {
        return $this->hasMany(Room::class, 'category_id', 'id');
    }
}
