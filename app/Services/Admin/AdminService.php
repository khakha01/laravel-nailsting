<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AdminService
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository,
        protected PermissionRepositoryInterface $permissionRepository,
    ) {
    }

    /**
     * Lấy tất cả admin
     */
    public function getAll(): Collection
    {
        return $this->adminRepository->getAll();
    }

    /**
     * Lấy admin theo ID
     */
    public function findById(int $id): ?Admin
    {
        return $this->adminRepository->findById($id);
    }

    /**
     * Tạo admin mới
     */

    public function createService(
        array $permissionIds,
        string $name,
        string $email,
        string $password,
        ?string $phone,
        ?string $mediaId,
        bool $isActive,
    ): Admin {

        $hashedPassword = bcrypt($password);

        $admin = Admin::make(
            $name,
            $email,
            $hashedPassword,
            $phone,
            $mediaId,
            $isActive
        );

        return DB::transaction(function () use ($admin, $permissionIds) {
            $admin = $this->adminRepository->save($admin);
            if (!empty($permissionIds)) {
                $admin->permissions()->attach($permissionIds);
            }

            return $admin;
        });
    }


    /**
     * Cập nhật admin
     */
    public function updateService(int $id, array $data): Admin
    {
        return DB::transaction(function () use ($id, $data) {
            $admin = $this->findById($id);

            if (!$admin) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Admin không tồn tại");
            }

            // Hash password nếu được cung cấp
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            // Cập nhật dữ liệu
            $admin->fill($data);
            $admin = $this->adminRepository->save($admin);

            // Cập nhật quyền
            if (isset($data['permission_ids'])) {
                $admin->permissions()->sync($data['permission_ids']);
            }

            return $admin;
        });
    }

    /**
     * Xóa admin
     */
    public function deleteService(int $id): void
    {
        DB::transaction(function () use ($id) {
            $admin = $this->findById($id);

            if (!$admin) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Admin không tồn tại");
            }

            // Xóa quyền
            $admin->permissions()->detach();

            // Xóa admin
            $this->adminRepository->delete($admin);
        });
    }

    /**
     * Xóa nhiều admin
     */
    public function bulkDeleteService(array $adminIds): void
    {
        DB::transaction(function () use ($adminIds) {
            // Xóa quyền của các admin
            DB::table('admin_permission')
                ->whereIn('admin_id', $adminIds)
                ->delete();

            // Xóa admin
            $this->adminRepository->deleteMany($adminIds);
        });
    }

    /**
     * Gán quyền cho admin
     */
    public function assignPermissionsService(int $adminId, array $permissionIds): void
    {
        DB::transaction(function () use ($adminId, $permissionIds) {
            $admin = $this->findById($adminId);

            if (!$admin) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Admin không tồn tại");
            }

            $admin->permissions()->sync($permissionIds);
        });
    }
}
