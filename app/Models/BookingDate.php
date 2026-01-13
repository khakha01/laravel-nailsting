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

    /**
     * Factory method để tạo BookingDate
     */
    public static function make(string $date, bool $isOpen = true, array $timeSlots = []): static
    {
        $model = new static([
            'date'    => $date,
            'is_open' => $isOpen,
        ]);

        if ($timeSlots !== []) {
            $slots = collect($timeSlots)->map(fn(array $slot) => BookingTimeSlot::make(
                $slot['start'],
                $slot['end'],
                $slot['is_open'] ?? true
            ));

            $model->setRelation('timeSlots', $slots);
        }

        return $model;
    }
}
