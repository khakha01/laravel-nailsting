<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepositoryCache implements CategoryRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected CategoryRepositoryInterface $categoryRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.categories');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    protected function cacheKeyBySlug(string $slug): string
    {
        return sprintf($this->keys['by_slug'], $slug);
    }

    public function findById(int $id): ?Category
    {
        $key = $this->cacheKey($id);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->categoryRepository->findById($id)
        );
    }

    public function findByIds(array $ids): Collection
    {
        return $this->categoryRepository->findByIds($ids);
    }

    public function findBySlug(string $slug): ?Category
    {
        $key = $this->cacheKeyBySlug($slug);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->categoryRepository->findBySlug($slug)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->categoryRepository->getAll()
        );
    }

    public function getRootCategories(): Collection
    {
        return $this->cache->remember(
            $this->keys['root'],
            now()->addMinutes(60),
            fn() => $this->categoryRepository->getRootCategories()
        );
    }

    public function getActiveCategories(): Collection
    {
        return $this->cache->remember(
            $this->keys['active'],
            now()->addMinutes(60),
            fn() => $this->categoryRepository->getActiveCategories()
        );
    }

    public function getActiveCategoriesWithProducts(): Collection
    {
        return $this->cache->remember(
            $this->keys['with_products'],
            now()->addMinutes(30),
            fn() => $this->categoryRepository->getActiveCategoriesWithProducts()
        );
    }

    public function getCategoriesTree(): Collection
    {
        return $this->cache->remember(
            $this->keys['tree'],
            now()->addMinutes(60),
            fn() => $this->categoryRepository->getCategoriesTree()
        );
    }

    public function save(Category $category): Category
    {
        $this->invalidateCache($category->id);
        return $this->categoryRepository->save($category);
    }

    public function delete(Category $category): bool
    {
        $this->invalidateCache($category->id);
        return $this->categoryRepository->delete($category);
    }

    public function bulkDelete(array $categoryIds): int
    {
        foreach ($categoryIds as $id) {
            $this->invalidateCache($id);
        }
        return $this->categoryRepository->bulkDelete($categoryIds);
    }

    public function findByParentId(int $parentId): Collection
    {
        return $this->categoryRepository->findByParentId($parentId);
    }

    /**
     * Invalidate all related cache keys
     */
    protected function invalidateCache(int $categoryId): void
    {
        $this->cache->forget($this->cacheKey($categoryId));
        $this->cache->forget($this->keys['all']);
        $this->cache->forget($this->keys['root']);
        $this->cache->forget($this->keys['active']);
        $this->cache->forget($this->keys['with_products']);
        $this->cache->forget($this->keys['tree']);
    }
}
