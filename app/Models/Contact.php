<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    const STATUS_NEW     = 0; // Mới
    const STATUS_REPLIED = 1; // Đã phản hồi
}
