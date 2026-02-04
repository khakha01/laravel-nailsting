<?php

namespace App\Repositories\NailCategory;

use App\Models\NailCategory;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class NailCategoryRepositoryCache implements NailCategoryRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected NailCategoryRepositoryInterface $nailCategoryRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.nail_categories');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    protected function cacheKeyBySlug(string $slug): string
    {
        return sprintf($this->keys['by_slug'], $slug);
    }

    public function findById(int $id): ?NailCategory
    {
        $key = $this->cacheKey($id);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->nailCategoryRepository->findById($id)
        );
    }

    public function findByIds(array $ids): Collection
    {
        return $this->nailCategoryRepository->findByIds($ids);
    }

    public function findBySlug(string $slug): ?NailCategory
    {
        $key = $this->cacheKeyBySlug($slug);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->nailCategoryRepository->findBySlug($slug)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->nailCategoryRepository->getAll()
        );
    }

    public function getRootCategories(): Collection
    {
        return $this->cache->remember(
            $this->keys['root'],
            now()->addMinutes(60),
            fn() => $this->nailCategoryRepository->getRootCategories()
        );
    }

    public function save(NailCategory $nailCategory): NailCategory
    {
        $result = $this->nailCategoryRepository->save($nailCategory);
        $this->invalidateCache($result->id);
        return $result;
    }

    public function delete(NailCategory $nailCategory): bool
    {
        $this->invalidateCache($nailCategory->id);
        return $this->nailCategoryRepository->delete($nailCategory);
    }

    public function bulkDelete(array $nailCategoryIds): int
    {
        foreach ($nailCategoryIds as $id) {
            $this->invalidateCache($id);
        }
        return $this->nailCategoryRepository->bulkDelete($nailCategoryIds);
    }

    public function findByParentId(int $parentId): Collection
    {
        return $this->nailCategoryRepository->findByParentId($parentId);
    }

    /**
     * Invalidate all related cache keys
     */
    protected function invalidateCache(?int $nailCategoryId): void
    {
        if (!$nailCategoryId) {
            $this->cache->forget($this->keys['all']);
            $this->cache->forget($this->keys['root']);
            return;
        }
        $this->cache->forget($this->cacheKey($nailCategoryId));
        $this->cache->forget($this->keys['all']);
        $this->cache->forget($this->keys['root']);
    }
}

