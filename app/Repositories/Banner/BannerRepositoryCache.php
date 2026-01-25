<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BannerRepositoryCache implements BannerRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected BannerRepositoryInterface $bannerRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.banners');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    public function findById(int $id): ?Banner
    {
        $key = $this->cacheKey($id);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->bannerRepository->findById($id)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->bannerRepository->getAll()
        );
    }

    public function getActiveBanners(): Collection
    {
        return $this->cache->remember(
            $this->keys['active'],
            now()->addMinutes(60),
            fn() => $this->bannerRepository->getActiveBanners()
        );
    }

    public function save(Banner $banner): Banner
    {
        $this->invalidateCache($banner->id ?? 0);
        return $this->bannerRepository->save($banner);
    }

    public function delete(Banner $banner): bool
    {
        $this->invalidateCache($banner->id);
        return $this->bannerRepository->delete($banner);
    }

    public function bulkDelete(array $ids): int
    {
        foreach ($ids as $id) {
            $this->invalidateCache($id);
        }
        return $this->bannerRepository->bulkDelete($ids);
    }

    protected function invalidateCache(int $bannerId): void
    {
        $this->cache->forget($this->cacheKey($bannerId));
        $this->cache->forget($this->keys['all']);
        $this->cache->forget($this->keys['active']);
    }
}
