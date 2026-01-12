<?php
namespace App\Repositories\BookingTimeSlot;

use App\Models\BookingTimeSlot;

class BookingTimeSlotRepository implements BookingTimeSlotRepositoryInterface
{
    public function save(int $bookingDateId, array $slots): void
    {
        foreach ($slots as $slot) {
            BookingTimeSlot::create([
                'booking_date_id' => $bookingDateId,
                'start_time' => $slot['start'],
                'end_time' => $slot['end'],
                'is_open' => $slot['is_open'] ?? true,
            ]);
        }
    }

    public function deleteByBookingDate(int $bookingDateId): void
    {
        BookingTimeSlot::where('booking_date_id', $bookingDateId)->delete();
    }

    public function getByBookingDate(int $bookingDateId)
    {
        return BookingTimeSlot::where('booking_date_id', $bookingDateId)
            ->orderBy('start_time')
            ->get();
    }
}
