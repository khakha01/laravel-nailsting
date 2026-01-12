<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingDate extends Model
{
    //
    protected $table = 'booking_dates';

    protected $fillable = [
        'date',
        'is_open',
    ];

    protected $casts = [
        'date' => 'date',
        'is_open' => 'boolean',
    ];


    /**
     * Một ngày có nhiều khung giờ
     */
    public function timeSlots(): HasMany
    {
        return $this->hasMany(BookingTimeSlot::class);
    }
}
