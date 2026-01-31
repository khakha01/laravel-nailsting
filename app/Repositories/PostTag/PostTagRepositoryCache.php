<?php

namespace App\Repositories\PostTag;

use App\Models\PostTag;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PostTagRepositoryCache implements PostTagRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected PostTagRepositoryInterface $postTagRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.post_tags');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    public function findById(int $id): ?PostTag
    {
        return $this->cache->remember(
            $this->cacheKey($id),
            now()->addMinutes(60),
            fn() => $this->postTagRepository->findById($id)
        );
    }

    public function findByName(string $name): ?PostTag
    {
        return $this->postTagRepository->findByName($name);
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->postTagRepository->getAll()
        );
    }

    public function save(PostTag $tag): PostTag
    {
        $result = $this->postTagRepository->save($tag);
        $this->invalidateCache($tag->id);
        return $result;
    }

    public function delete(PostTag $tag): bool
    {
        $this->invalidateCache($tag->id);
        return $this->postTagRepository->delete($tag);
    }

    protected function invalidateCache(int $id): void
    {
        $this->cache->forget($this->cacheKey($id));
        $this->cache->forget($this->keys['all']);
    }
}
