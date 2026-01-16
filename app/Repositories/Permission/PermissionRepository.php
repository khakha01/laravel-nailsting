<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Lấy tất cả quyền
     */
    public function getAll(): Collection
    {
        return Permission::orderBy('group')
            ->orderBy('name')
            ->get();
    }

    /**
     * Lấy quyền theo ID
     */
    public function findById(int $id): ?Permission
    {
        return Permission::find($id);
    }

    /**
     * Lấy quyền theo code
     */
    public function findByCode(string $code): ?Permission
    {
        return Permission::where('code', $code)->first();
    }

    /**
     * Lấy quyền theo group
     */
    public function findByGroup(string $group): Collection
    {
        return Permission::where('group', $group)
            ->orderBy('name')
            ->get();
    }

    /**
     * Tạo/Cập nhật quyền
     */
    public function save(Permission $permission): Permission
    {
        $permission->save();
        return $permission;
    }

    /**
     * Xóa quyền
     */
    public function delete(Permission $permission): bool
    {
        return $permission->delete();
    }

    /**
     * Xóa nhiều quyền
     */
    public function deleteMany(array $ids): int
    {
        return Permission::whereIn('id', $ids)->delete();
    }

    /**
     * Lấy quyền theo group (cho form display)
     */
    public function getGrouped(): array
    {
        $permissions = $this->getAll();
        $grouped = [];

        foreach ($permissions as $permission) {
            $grouped[$permission->group][] = $permission;
        }

        return $grouped;
    }
}
