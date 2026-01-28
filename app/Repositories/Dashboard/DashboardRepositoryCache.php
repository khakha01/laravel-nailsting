<?php

namespace App\Repositories\Dashboard;

use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DashboardRepositoryCache implements DashboardRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected DashboardRepositoryInterface $repository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.dashboard');
    }

    public function getStats(): array
    {
        return $this->cache->remember(
            $this->keys['stats'],
            now()->addMinutes(10), // Short cache for dashboard stats
            fn() => $this->repository->getStats()
        );
    }

    public function getRecentBookings(int $limit = 8): Collection
    {
        return $this->cache->remember(
            $this->keys['recent'],
            now()->addMinutes(5),
            fn() => $this->repository->getRecentBookings($limit)
        );
    }

    public function getStatusDistribution(): array
    {
        return $this->cache->remember(
            $this->keys['status_dist'],
            now()->addMinutes(15),
            fn() => $this->repository->getStatusDistribution()
        );
    }
}
