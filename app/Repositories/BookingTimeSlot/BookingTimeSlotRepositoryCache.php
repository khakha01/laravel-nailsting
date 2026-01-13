<?php

namespace App\Repositories\BookingTimeSlot;

use App\Models\BookingTimeSlot;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Cache;

class BookingTimeSlotRepositoryCache implements BookingTimeSlotRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected BookingTimeSlotRepositoryInterface $repository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.booking_time_slots');
    }

    protected function cacheKey(int $bookingDateId): string
    {
        return sprintf($this->keys['by_booking_date_id'], $bookingDateId);
    }


    public function getByBookingDate(int $bookingDateId)
    {
        $key = $this->cacheKey($bookingDateId);

        return $this->cache->remember(
            $key,
            now()->addMinutes(10),
            fn() => $this->repository->getByBookingDate($bookingDateId)
        );
    }

    public function save(BookingTimeSlot $bookingTimeSlot): void
    {
        $this->repository->save($bookingTimeSlot);
        $this->cache->forget($this->cacheKey($bookingTimeSlot->booking_date_id));
    }

    public function delete(BookingTimeSlot $bookingTimeSlot): bool
    {
        $result = $this->repository->delete($bookingTimeSlot);

        $this->cache->forget($this->cacheKey($bookingTimeSlot->booking_date_id));

        return $result;
    }
}
