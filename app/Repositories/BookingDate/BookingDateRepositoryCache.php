<?php

namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BookingDateRepositoryCache implements BookingDateRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected BookingDateRepositoryInterface $bookingDateRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.booking_dates');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    public function findById(int $id): ?BookingDate
    {
        $key = $this->cacheKey($id);

        return $this->cache->remember(
            $key,
            now()->addMinutes(10),
            fn() => $this->bookingDateRepository->findById($id)
        );
    }

    public function findByIds(array $ids): Collection
    {
        return $this->bookingDateRepository->findByIds($ids);
    }

    public function save(BookingDate $bookingDate): BookingDate
    {
        $this->cache->forget($this->cacheKey($bookingDate->id));
        $this->cache->forget($this->keys['open']);
        return $this->bookingDateRepository->save($bookingDate);
    }

    public function delete(BookingDate $bookingDate): bool
    {
        $result = $this->bookingDateRepository->delete($bookingDate);
        $this->cache->forget($this->cacheKey($bookingDate->id));
        $this->cache->forget($this->keys['open']);

        return $result;
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['open'],
            now()->addMinutes(10),
            fn() => $this->bookingDateRepository->getAll()
        );
    }
}
