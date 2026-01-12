<?php
namespace App\Repositories\BookingTimeSlot;

use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Cache;

class BookingTimeSlotRepositoryCache implements BookingTimeSlotRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(
        protected BookingTimeSlotRepositoryInterface $repository
    ) {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.booking_time_slots');
    }

    protected function cacheKey(int $bookingDateId): string
    {
        return $this->keys['by_date'] . $bookingDateId;
    }

    public function getByBookingDate(int $bookingDateId)
    {
        return $this->cache->remember(
            $this->cacheKey($bookingDateId),
            3600,
            fn () => $this->repository->getByBookingDate($bookingDateId)
        );
    }

    public function save(int $bookingDateId, array $slots): void
    {
        $this->repository->save($bookingDateId, $slots);
        $this->cache->forget($this->cacheKey($bookingDateId));
    }

    public function deleteByBookingDate(int $bookingDateId): void
    {
        $this->repository->deleteByBookingDate($bookingDateId);
        $this->cache->forget($this->cacheKey($bookingDateId));
    }
}
