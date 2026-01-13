<?php
namespace App\Repositories\BookingTimeSlot;

use App\Models\BookingTimeSlot;

interface BookingTimeSlotRepositoryInterface
{
    public function save(BookingTimeSlot $bookingTimeSlot): void;

    public function delete(BookingTimeSlot $bookingTimeSlot): bool;

    public function getByBookingDate(int $bookingDateId);
}
