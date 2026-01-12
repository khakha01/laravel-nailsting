<?php
namespace App\Services\BookingDate;

use App\Models\BookingDate;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookingDateService
{
    public function __construct(
        protected BookingDateRepositoryInterface $bookingDateRepository,
        protected BookingTimeSlotRepositoryInterface $bookingTimeSlotRepository
    ) {}

    public function list()
    {
        return $this->bookingDateRepository->getOpenDates();
    }

    public function create(array $data): BookingDate
    {
        return DB::transaction(function () use ($data) {

            $bookingDate = $this->bookingDateRepository->save([
                'date' => $data['date'],
                'is_open' => $data['is_open'] ?? true,
            ]);

            $slots = collect($data['time_slots'] ?? [])
                ->filter(
                    fn($slot) =>
                    !empty($slot['start']) && !empty($slot['end'])
                )
                ->values()
                ->all();

            if (!empty($slots)) {
                $this->bookingTimeSlotRepository->save($bookingDate->id, $slots);
            }

            return $bookingDate;
        });
    }

    public function getAvailableDates()
    {
        return $this->bookingDateRepository->getOpenDates();
    }
}
