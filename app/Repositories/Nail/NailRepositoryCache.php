<?php

namespace App\Repositories\Nail;

use App\Models\Nail;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class NailRepositoryCache implements NailRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;

    public function __construct(protected NailRepositoryInterface $nailRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.nails');
    }

    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    protected function cacheKeyBySlug(string $slug): string
    {
        return sprintf($this->keys['by_slug'], $slug);
    }

    public function findById(int $id): ?Nail
    {
        $key = $this->cacheKey($id);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->nailRepository->findById($id)
        );
    }

    public function findByIds(array $ids): Collection
    {
        return $this->nailRepository->findByIds($ids);
    }

    public function findBySlug(string $slug): ?Nail
    {
        $key = $this->cacheKeyBySlug($slug);

        return $this->cache->remember(
            $key,
            now()->addMinutes(60),
            fn() => $this->nailRepository->findBySlug($slug)
        );
    }

    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->nailRepository->getAll()
        );
    }

    public function getActiveNails(): Collection
    {
        return $this->cache->remember(
            $this->keys['active'],
            now()->addMinutes(60),
            fn() => $this->nailRepository->getActiveNails()
        );
    }

    public function save(Nail $nail): Nail
    {
        $result = $this->nailRepository->save($nail);
        $this->invalidateCache($result->id);
        return $result;
    }

    public function delete(Nail $nail): bool
    {
        $this->invalidateCache($nail->id);
        return $this->nailRepository->delete($nail);
    }

    public function bulkDelete(array $nailIds): int
    {
        foreach ($nailIds as $id) {
            $this->invalidateCache($id);
        }
        return $this->nailRepository->bulkDelete($nailIds);
    }

    public function getActiveNailsPaginated(int $perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->nailRepository->getActiveNailsPaginated($perPage);
    }

    public function countAll(): int
    {
        return $this->nailRepository->countAll();
    }

    /**
     * Invalidate all related cache keys
     */
    protected function invalidateCache(?int $nailId): void
    {
        if (!$nailId) {
            $this->cache->forget($this->keys['all']);
            $this->cache->forget($this->keys['active']);
            return;
        }
        $nail = Nail::find($nailId);

        $this->cache->forget($this->cacheKey($nailId));
        if ($nail) {
            $this->cache->forget($this->cacheKeyBySlug($nail->slug));
        }
        $this->cache->forget($this->keys['all']);
        $this->cache->forget($this->keys['active']);
    }
}

