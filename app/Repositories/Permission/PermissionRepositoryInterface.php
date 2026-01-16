<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    /**
     * Lấy tất cả quyền
     */
    public function getAll(): Collection;

    /**
     * Lấy quyền theo ID
     */
    public function findById(int $id): ?Permission;

    /**
     * Lấy quyền theo code
     */
    public function findByCode(string $code): ?Permission;

    /**
     * Lấy quyền theo group
     */
    public function findByGroup(string $group): Collection;

    /**
     * Tạo/Cập nhật quyền
     */
    public function save(Permission $permission): Permission;

    /**
     * Xóa quyền
     */
    public function delete(Permission $permission): bool;

    /**
     * Xóa nhiều quyền
     */
    public function deleteMany(array $ids): int;

    /**
     * Lấy quyền theo group (cho form display)
     */
    public function getGrouped(): array;
}
