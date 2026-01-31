<?php

namespace App\Repositories\PostCategory;

use App\Models\PostCategory;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PostCategoryRepositoryCache implements PostCategoryRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected PostCategoryRepositoryInterface $postCategoryRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.post_categories');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    protected function cacheKeyBySlug(string $slug): string
    {
        return sprintf($this->keys['by_slug'], $slug);
    }

    public function findById(int $id): ?PostCategory
    {
        return $this->cache->remember(
            $this->cacheKey($id),
            now()->addMinutes(60),
            fn() => $this->postCategoryRepository->findById($id)
        );
    }

    public function findBySlug(string $slug): ?PostCategory
    {
        return $this->cache->remember(
            $this->cacheKeyBySlug($slug),
            now()->addMinutes(60),
            fn() => $this->postCategoryRepository->findBySlug($slug)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->postCategoryRepository->getAll()
        );
    }

    public function getActiveCategories(): Collection
    {
        return $this->cache->remember(
            $this->keys['active'],
            now()->addMinutes(60),
            fn() => $this->postCategoryRepository->getActiveCategories()
        );
    }

    public function getRootCategories(): Collection
    {
        return $this->postCategoryRepository->getRootCategories();
    }

    public function save(PostCategory $category): PostCategory
    {
        $result = $this->postCategoryRepository->save($category);
        $this->invalidateCache($category);
        return $result;
    }

    public function delete(PostCategory $category): bool
    {
        $this->invalidateCache($category);
        return $this->postCategoryRepository->delete($category);
    }

    protected function invalidateCache(?PostCategory $category = null): void
    {
        if ($category) {
            $this->cache->forget($this->cacheKey($category->id));
            $this->cache->forget($this->cacheKeyBySlug($category->slug));
        }
        $this->cache->forget($this->keys['all']);
        $this->cache->forget($this->keys['active']);
        $this->cache->forget($this->keys['tree']);
    }
}
