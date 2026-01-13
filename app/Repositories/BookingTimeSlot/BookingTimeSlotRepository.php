<?php
namespace App\Repositories\BookingTimeSlot;

use App\Models\BookingTimeSlot;

class BookingTimeSlotRepository implements BookingTimeSlotRepositoryInterface
{
    public function save(BookingTimeSlot $bookingTimeSlot): void
    {
        $bookingTimeSlot->save();
    }

    public function delete(BookingTimeSlot $bookingTimeSlot): bool
    {
        return $bookingTimeSlot->delete();
    }

    public function getByBookingDate(int $bookingDateId)
    {
        return BookingTimeSlot::where('booking_date_id', $bookingDateId)
            ->orderBy('start_time')
            ->get();
    }
}
