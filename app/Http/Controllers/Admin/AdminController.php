<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignPermissionRequest;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Permission;
use App\Queries\ListAdmins\ListAdminQuery;
use App\Queries\ListAdmins\ListAdminHandler;
use App\Services\Admin\AdminService;
use App\Services\Permission\PermissionService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        protected AdminService $adminService,
        protected PermissionService $permissionService,
        protected ListAdminHandler $listAdminHandler,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = new ListAdminQuery(
            page: $request->get('page', 1),
            perPage: $request->get('per_page', 15),
            search: $request->get('search'),
            isActive: $request->get('is_active'),
        );

        $admins = $this->listAdminHandler->execute($query);

        return view('admin.admin-management.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissionsByGroup = $this->permissionService->getGrouped();

        return view('admin.admin-management.create', compact('permissionsByGroup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        try {
            $this->adminService->createService(
                $request->get('permission_ids', []),
                $request->get('name'),
                $request->get('email'),
                $request->get('password'),
                $request->get('phone'),
                $request->get('avatar'),
                $request->boolean('is_active'),
            );

            return redirect()
                ->route('admins.index')
                ->with('success', 'Tạo admin thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        $permissions = $admin->permissions;

        return view('admin.admin-management.show', compact('admin', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $permissionsByGroup = $this->permissionService->getGrouped();
        $adminPermissions = $admin->permissions->pluck('id')->toArray();

        return view('admin.admin-management.edit', compact('admin', 'permissionsByGroup', 'adminPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        try {
            $this->adminService->updateService($admin->id, $request->validated());

            return redirect()
                ->route('admins.index')
                ->with('success', 'Cập nhật admin thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        try {
            $this->adminService->deleteService($admin->id);

            return redirect()
                ->route('admins.index')
                ->with('success', 'Xóa admin thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Show form to assign permissions
     */
    public function assignPermissionsForm(Admin $admin)
    {
        $permissionsByGroup = $this->permissionService->getGrouped();
        $adminPermissions = $admin->permissions->pluck('id')->toArray();

        return view('admin.admin-management.assign-permissions', compact('admin', 'permissionsByGroup', 'adminPermissions'));
    }

    /**
     * Assign permissions to admin
     */
    public function assignPermissions(AssignPermissionRequest $request, Admin $admin)
    {
        try {
            $this->adminService->assignPermissionsService($admin->id, $request->validated('permission_ids'));

            return redirect()
                ->route('admins.index', $admin)
                ->with('success', 'Gán quyền thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
