<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTimeSlot extends Model
{
    protected $table = 'booking_time_slots';

    protected $fillable = [
        'booking_date_id',
        'start_time',
        'end_time',
        'is_open',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    /**
     * Slot thuộc về 1 ngày
     */
    public function bookingDate(): BelongsTo
    {
        return $this->belongsTo(BookingDate::class);
    }
}
