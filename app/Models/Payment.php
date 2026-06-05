<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    // Migration only defines created_at (no updated_at column)
    const UPDATED_AT = null;

    protected $fillable = [
        'booking_id',
        'vnp_txn_ref',
        'vnp_transaction_no',
        'vnp_amount',
        'vnp_bank_code',
        'vnp_response_code',
    ];

    protected $casts = [
        'vnp_amount' => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
