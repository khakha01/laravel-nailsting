<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PermissionRepositoryCache implements PermissionRepositoryInterface
{
    protected array $keys;

    public function __construct(
        protected PermissionRepositoryInterface $repository
    ) {
        $this->keys = config('cache_keys.permissions');
    }

    /**
     * Tạo cache key cho quyền theo ID
     */
    protected function cacheKeyById(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }

    /**
     * Lấy tất cả quyền
     */
    public function getAll(): Collection
    {
        return Cache::remember(
            $this->keys['all'],
            now()->addMinutes(60),
            fn() => $this->repository->getAll()
        );
    }

    /**
     * Lấy quyền theo ID
     */
    public function findById(int $id): ?Permission
    {
        return Cache::remember(
            $this->cacheKeyById($id),
            now()->addMinutes(60),
            fn() => $this->repository->findById($id)
        );
    }

    /**
     * Lấy quyền theo code
     */
    public function findByCode(string $code): ?Permission
    {
        return $this->repository->findByCode($code);
    }

    /**
     * Lấy quyền theo group
     */
    public function findByGroup(string $group): Collection
    {
        return $this->repository->findByGroup($group);
    }

    /**
     * Tạo/Cập nhật quyền
     */
    public function save(Permission $permission): Permission
    {
        // Invalidate cache
        Cache::forget($this->keys['all']);
        Cache::forget($this->keys['grouped']);
        if ($permission->id) {
            Cache::forget($this->cacheKeyById($permission->id));
        }

        return $this->repository->save($permission);
    }

    /**
     * Xóa quyền
     */
    public function delete(Permission $permission): bool
    {
        // Invalidate cache
        Cache::forget($this->keys['all']);
        Cache::forget($this->keys['grouped']);
        Cache::forget($this->cacheKeyById($permission->id));

        return $this->repository->delete($permission);
    }

    /**
     * Xóa nhiều quyền
     */
    public function deleteMany(array $ids): int
    {
        // Invalidate cache
        Cache::forget($this->keys['all']);
        Cache::forget($this->keys['grouped']);
        foreach ($ids as $id) {
            Cache::forget($this->cacheKeyById($id));
        }

        return $this->repository->deleteMany($ids);
    }

    /**
     * Lấy quyền theo group (cho form display)
     */
    public function getGrouped(): array
    {
        return Cache::remember(
            $this->keys['grouped'],
            now()->addMinutes(60),
            fn() => $this->repository->getGrouped()
        );
    }
}
