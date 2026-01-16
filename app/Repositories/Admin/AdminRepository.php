<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

class AdminRepository implements AdminRepositoryInterface
{
    /**
     * Lấy tất cả admin
     */
    public function getAll(): Collection
    {
        return Admin::with('permissions')->get();
    }

    /**
     * Lấy admin theo ID
     */
    public function findById(int $id): ?Admin
    {
        return Admin::with('permissions')->find($id);
    }

    /**
     * Lấy admin theo IDs
     */
    public function findByIds(array $ids): Collection
    {
        return Admin::with('permissions')
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     * Tạo admin mới
     */
    public function save(Admin $admin): Admin
    {
        $admin->save();
        return $admin;
    }

    /**
     * Xóa admin
     */
    public function delete(Admin $admin): bool
    {
        return $admin->delete();
    }

    /**
     * Xóa nhiều admin
     */
    public function deleteMany(array $ids): int
    {
        return Admin::whereIn('id', $ids)->delete();
    }
}
