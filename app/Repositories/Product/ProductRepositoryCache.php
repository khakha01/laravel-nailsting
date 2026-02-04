<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductRepositoryCache implements ProductRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.products');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    protected function cacheKeyBySlug(string $slug): string
    {
        return sprintf($this->keys['by_slug'], $slug);
    }

    protected function cacheKeyByCode(string $code): string
    {
        return sprintf($this->keys['by_code'], $code);
    }

    protected function cacheKeyByCategory(int $categoryId): string
    {
        return sprintf($this->keys['by_category'], $categoryId);
    }

    public function findById(int $id): ?Product
    {
        $key = $this->cacheKey($id);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->productRepository->findById($id)
        );
    }

    public function findByIds(array $ids): Collection
    {
        return $this->productRepository->findByIds($ids);
    }

    public function findByCode(string $code): ?Product
    {
        $key = $this->cacheKeyByCode($code);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->productRepository->findByCode($code)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->productRepository->getAll()
        );
    }

    public function getActiveProducts(): Collection
    {
        return $this->cache->remember(
            $this->keys['active'],
            now()->addMinutes(60),
            fn() => $this->productRepository->getActiveProducts()
        );
    }

    public function getProductsByCategory(int $categoryId): Collection
    {
        $key = $this->cacheKeyByCategory($categoryId);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->productRepository->getProductsByCategory($categoryId)
        );
    }

    public function save(Product $product): Product
    {
        $result = $this->productRepository->save($product);
        $this->invalidateCache($result->id);
        return $result;
    }

    public function delete(Product $product): bool
    {
        $this->invalidateCache($product->id);
        return $this->productRepository->delete($product);
    }

    public function bulkDelete(array $productIds): int
    {
        foreach ($productIds as $id) {
            $this->invalidateCache($id);
        }
        return $this->productRepository->bulkDelete($productIds);
    }

    public function countAll(): int
    {
        return $this->productRepository->countAll();
    }

    /**
     * Invalidate all related cache keys
     */
    protected function invalidateCache(?int $productId): void
    {
        if (!$productId) {
            $this->cache->forget($this->keys['all']);
            $this->cache->forget($this->keys['active']);
            return;
        }
        $product = Product::find($productId);

        $this->cache->forget($this->cacheKey($productId));
        if ($product) {
            $this->cache->forget($this->cacheKeyByCode($product->code));
            $this->cache->forget($this->cacheKeyByCategory($product->category_id));
        }
        $this->cache->forget($this->keys['all']);
        $this->cache->forget($this->keys['active']);
    }
}
