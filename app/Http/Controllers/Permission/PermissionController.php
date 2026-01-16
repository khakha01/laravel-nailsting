<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Admin;
use App\Models\Permission;
use App\Queries\ListPermissions\ListPermissionQuery;
use App\Queries\ListPermissions\ListPermissionHandler;
use App\Services\Permission\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $permissionService,
        protected ListPermissionHandler $listPermissionHandler,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = new ListPermissionQuery(
            page: $request->get('page', 1),
            perPage: $request->get('per_page', 15),
            search: $request->get('search'),
            group: $request->get('group'),
        );

        $permissions = $this->listPermissionHandler->execute($query);

        return view('admin.permission-management.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            $this->permissionService->createService($request->validated());

            return redirect()
                ->route('permissions.index')
                ->with('success', 'Tạo quyền thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $admins = $permission->admins;

        return view('admin.permission-management.show', compact('permission', 'admins'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permission-management.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            $this->permissionService->updateService($permission->id, $request->validated());

            return redirect()
                ->route('permissions.index')
                ->with('success', 'Cập nhật quyền thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $this->permissionService->deleteService($permission->id);

            return redirect()
                ->route('permissions.index')
                ->with('success', 'Xóa quyền thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Show form to assign admins to permission
     */
    public function assignAdminsForm(Permission $permission)
    {
        $allAdmins = Admin::all();
        $permissionAdmins = $permission->admins->pluck('id')->toArray();

        return view('admin.permission-management.assign-admins', compact('permission', 'allAdmins', 'permissionAdmins'));
    }

    /**
     * Assign admins to permission
     */
    public function assignAdmins(Request $request, Permission $permission)
    {
        $request->validate([
            'admin_ids' => ['required', 'array', 'min:1'],
            'admin_ids.*' => ['integer', 'exists:admins,id'],
        ]);

        try {
            $permission->admins()->sync($request->validated('admin_ids'));

            return redirect()
                ->route('permissions.show', $permission)
                ->with('success', 'Gán admin thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
