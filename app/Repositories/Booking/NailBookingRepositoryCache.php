<?php

namespace App\Repositories\Booking;

use App\Models\NailBooking;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class NailBookingRepositoryCache implements NailBookingRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected NailBookingRepositoryInterface $repository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.nail_bookings');
    }

    public function findById(int $id): ?NailBooking
    {
        return $this->cache->remember(
            sprintf($this->keys['by_id'], $id),
            now()->addMinutes(60),
            fn() => $this->repository->findById($id)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->repository->getAll()
        );
    }

    public function countByDate(Carbon $date): int
    {
        return $this->repository->countByDate($date);
    }

    public function sumRevenueBetween(Carbon $start, Carbon $end): float
    {
        return $this->repository->sumRevenueBetween($start, $end);
    }

    public function getUniqueCustomerPhones(): Collection
    {
        return $this->repository->getUniqueCustomerPhones();
    }

    public function getRecentBookings(int $limit): Collection
    {
        return $this->repository->getRecentBookings($limit);
    }

    public function countByStatus(string $status): int
    {
        return $this->repository->countByStatus($status);
    }

    public function countAll(): int
    {
        return $this->repository->countAll();
    }
}
