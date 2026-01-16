<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface
{
    /**
     * Lấy tất cả admin
     */
    public function getAll(): Collection;

    /**
     * Lấy admin theo ID
     */
    public function findById(int $id): ?Admin;

    /**
     * Lấy admin theo IDs
     */
    public function findByIds(array $ids): Collection;

    /**
     * Tạo admin mới
     */
    public function save(Admin $admin): Admin;

    /**
     * Xóa admin
     */
    public function delete(Admin $admin): bool;

    /**
     * Xóa nhiều admin
     */
    public function deleteMany(array $ids): int;
}
