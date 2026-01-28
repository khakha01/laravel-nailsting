<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class AdminRepositoryCache implements AdminRepositoryInterface
{
    protected array $keys;

    public function __construct(
        protected AdminRepositoryInterface $repository
    ) {
        $this->keys = config('cache_keys.admins');
    }

    public function findByEmail(string $email): ?Admin
    {
        return $this->repository->findByEmail($email);
    }

    /**
     * Tạo cache key cho admin theo ID
     */
    protected function cacheKeyById(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    /**
     * Lấy tất cả admin
     */
    public function getAll(): Collection
    {
        return Cache::remember(
            $this->keys['all'],
            now()->addMinutes(30),
            fn() => $this->repository->getAll()
        );
    }

    /**
     * Lấy admin theo ID
     */
    public function findById(int $id): ?Admin
    {
        return Cache::remember(
            $this->cacheKeyById($id),
            now()->addMinutes(30),
            fn() => $this->repository->findById($id)
        );
    }

    /**
     * Lấy admin theo IDs
     */
    public function findByIds(array $ids): Collection
    {
        return $this->repository->findByIds($ids);
    }

    /**
     * Tạo admin mới
     */
    public function save(Admin $admin): Admin
    {
        // Invalidate cache
        Cache::forget($this->keys['all']);
        if ($admin->id) {
            Cache::forget($this->cacheKeyById($admin->id));
        }

        return $this->repository->save($admin);
    }

    /**
     * Xóa admin
     */
    public function delete(Admin $admin): bool
    {
        // Invalidate cache
        Cache::forget($this->keys['all']);
        Cache::forget($this->cacheKeyById($admin->id));

        return $this->repository->delete($admin);
    }

    /**
     * Xóa nhiều admin
     */
    public function deleteMany(array $ids): int
    {
        // Invalidate cache
        Cache::forget($this->keys['all']);
        foreach ($ids as $id) {
            Cache::forget($this->cacheKeyById($id));
        }

        return $this->repository->deleteMany($ids);
    }

    public function countAll(): int
    {
        return $this->repository->countAll();
    }
}
