<?php

namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Cache\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BookingDateRepositoryCache implements BookingDateRepositoryInterface
{
    protected Repository $cache;
    protected array $keys;

    public function __construct(
        protected BookingDateRepositoryInterface $bookingDateRepository
    ) {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.booking_dates');
    }


    public function findByDate(string $date): ?BookingDate
    {
        $key = sprintf($this->keys['by_date'], $date);

        return $this->cache->remember(
            $key,
            now()->addMinutes(10),
            fn() => $this->bookingDateRepository->findByDate($date)
        );
    }


    public function save(array $data): BookingDate
    {
        // clear cache liên quan
        $this->cache->forget($this->keys['open']);
        $this->cache->forget(
            sprintf($this->keys['by_date'], $data['date'])
        );

        return $this->bookingDateRepository->save($data);
    }

    /**
     * Lấy danh sách ngày đang mở
     */
    public function getOpenDates(): Collection
    {
        return $this->cache->remember(
            $this->keys['open'],
            now()->addMinutes(10),
            fn() => $this->bookingDateRepository->getOpenDates()
        );
    }
}
