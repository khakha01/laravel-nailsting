<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PostRepositoryCache implements PostRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected PostRepositoryInterface $postRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.posts');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    protected function cacheKeyBySlug(string $slug): string
    {
        return sprintf($this->keys['by_slug'], $slug);
    }

    protected function cacheKeyByCategory(int $categoryId): string
    {
        return sprintf($this->keys['by_category'], $categoryId);
    }

    public function findById(int $id): ?Post
    {
        return $this->cache->remember(
            $this->cacheKey($id),
            now()->addMinutes(60),
            fn() => $this->postRepository->findById($id)
        );
    }

    public function findBySlug(string $slug): ?Post
    {
        return $this->cache->remember(
            $this->cacheKeyBySlug($slug),
            now()->addMinutes(60),
            fn() => $this->postRepository->findBySlug($slug)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->postRepository->getAll()
        );
    }

    public function getPublishedPosts(): Collection
    {
        return $this->cache->remember(
            $this->keys['published'],
            now()->addMinutes(60),
            fn() => $this->postRepository->getPublishedPosts()
        );
    }

    public function getFeaturedPosts(): Collection
    {
        return $this->cache->remember(
            $this->keys['featured'],
            now()->addMinutes(60),
            fn() => $this->postRepository->getFeaturedPosts()
        );
    }

    public function getPostsByCategory(int $categoryId): Collection
    {
        return $this->cache->remember(
            $this->cacheKeyByCategory($categoryId),
            now()->addMinutes(60),
            fn() => $this->postRepository->getPostsByCategory($categoryId)
        );
    }

    public function save(Post $post): Post
    {
        $result = $this->postRepository->save($post);
        $this->invalidateCache($post->id);
        return $result;
    }

    public function delete(Post $post): bool
    {
        $this->invalidateCache($post->id);
        return $this->postRepository->delete($post);
    }

    public function bulkDelete(array $postIds): int
    {
        foreach ($postIds as $id) {
            $this->invalidateCache($id);
        }
        return $this->postRepository->bulkDelete($postIds);
    }

    protected function invalidateCache(int $postId): void
    {
        $post = Post::find($postId);
        $this->cache->forget($this->cacheKey($postId));
        if ($post) {
            $this->cache->forget($this->cacheKeyBySlug($post->slug));
            if ($post->post_category_id) {
                $this->cache->forget($this->cacheKeyByCategory($post->post_category_id));
            }
        }
        $this->cache->forget($this->keys['all']);
        $this->cache->forget($this->keys['published']);
        $this->cache->forget($this->keys['featured']);
    }
}
