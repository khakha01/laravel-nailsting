<?php

namespace App\Services\Permission;

use App\Models\Permission;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository,
    ) {}

    /**
     * Lấy tất cả quyền
     */
    public function getAll(): Collection
    {
        return $this->permissionRepository->getAll();
    }

    /**
     * Lấy quyền theo ID
     */
    public function findById(int $id): ?Permission
    {
        return $this->permissionRepository->findById($id);
    }

    /**
     * Lấy quyền theo nhóm (cho form)
     */
    public function getGrouped(): array
    {
        return $this->permissionRepository->getGrouped();
    }

    /**
     * Tạo quyền mới
     */
    public function createService(array $data): Permission
    {
        return DB::transaction(function () use ($data) {
            // Validate
            if (empty($data['name']) || empty($data['code']) || empty($data['group'])) {
                throw new \InvalidArgumentException("Tên, code và nhóm là bắt buộc");
            }

            // Kiểm tra code đã tồn tại chưa
            if ($this->permissionRepository->findByCode($data['code'])) {
                throw new \InvalidArgumentException("Code '{$data['code']}' đã tồn tại");
            }

            // Tạo quyền
            $permission = new Permission($data);
            return $this->permissionRepository->save($permission);
        });
    }

    /**
     * Cập nhật quyền
     */
    public function updateService(int $id, array $data): Permission
    {
        return DB::transaction(function () use ($id, $data) {
            $permission = $this->findById($id);

            if (!$permission) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Quyền không tồn tại");
            }

            // Nếu code thay đổi, kiểm tra code mới có bị trùng không
            if (isset($data['code']) && $data['code'] !== $permission->code) {
                if ($this->permissionRepository->findByCode($data['code'])) {
                    throw new \InvalidArgumentException("Code '{$data['code']}' đã tồn tại");
                }
            }

            // Cập nhật dữ liệu
            $permission->fill($data);
            return $this->permissionRepository->save($permission);
        });
    }

    /**
     * Xóa quyền
     */
    public function deleteService(int $id): void
    {
        DB::transaction(function () use ($id) {
            $permission = $this->findById($id);

            if (!$permission) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Quyền không tồn tại");
            }

            // Xóa quan hệ
            $permission->admins()->detach();

            // Xóa quyền
            $this->permissionRepository->delete($permission);
        });
    }

    /**
     * Xóa nhiều quyền
     */
    public function bulkDeleteService(array $permissionIds): void
    {
        DB::transaction(function () use ($permissionIds) {
            // Xóa quan hệ của các quyền
            DB::table('admin_permission')
                ->whereIn('permission_id', $permissionIds)
                ->delete();

            // Xóa quyền
            $this->permissionRepository->deleteMany($permissionIds);
        });
    }
}
