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


    /**
     * Factory method để tạo slot
     */
    public static function make(string $start, string $end, bool $isOpen = true): static
    {
        return new static([
            'start_time' => $start,
            'end_time' => $end,
            'is_open' => $isOpen,
        ]);
    }
}
