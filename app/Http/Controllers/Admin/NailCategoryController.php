<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NailCategories\StoreNailCategoryRequest;
use App\Http\Requests\NailCategories\UpdateNailCategoryRequest;
use App\Services\NailCategory\NailCategoryService;
use Illuminate\Http\Request;

class NailCategoryController extends Controller
{
    public function __construct(
        protected NailCategoryService $nailCategoryService
    ) {}

    // ===== LIST & PAGINATION =====
    public function index(Request $request)
    {
        $nailCategories = $this->nailCategoryService->getAll();
        return view('admin.nail-category-management.index', compact('nailCategories'));
    }

    // ===== SHOW CREATE FORM =====
    public function create()
    {
        $parentCategories = $this->nailCategoryService->getRootCategories();
        return view('admin.nail-category-management.create', compact('parentCategories'));
    }

    // ===== STORE NEW =====
    public function store(StoreNailCategoryRequest $request)
    {
        try {
            $this->nailCategoryService->createService(
                $request->get('name'),
                $request->get('slug'),
                $request->get('parent_id')
            );

            return redirect()
                ->route('nail-categories.index')
                ->with('success', 'Tạo danh mục nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('nail-categories.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== SHOW DETAIL & EDIT FORM =====
    public function show(Request $request)
    {
        $id = (int) $request->route('id');
        $nailCategory = $this->nailCategoryService->findById($id);
        $parentCategories = $this->nailCategoryService->getRootCategories()
            ->reject(fn($cat) => $cat->id === $id);

        return view('admin.nail-category-management.edit', compact('nailCategory', 'parentCategories'));
    }

    // ===== UPDATE =====
    public function update(UpdateNailCategoryRequest $request)
    {
        $nailCategoryId = (int) $request->route('id');

        try {
            $this->nailCategoryService->updateService(
                $nailCategoryId,
                $request->get('name'),
                $request->get('slug'),
                $request->get('parent_id')
            );

            return redirect()
                ->route('nail-categories.index')
                ->with('success', 'Cập nhật danh mục nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('nail-categories.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== DELETE SINGLE =====
    public function destroy(Request $request)
    {
        try {
            $id = (int) $request->route('id');
            $this->nailCategoryService->deleteService($id);

            return redirect()
                ->route('nail-categories.index')
                ->with('success', 'Xóa danh mục nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('nail-categories.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== DELETE BULK =====
    public function bulkDelete(Request $request)
    {
        try {
            $nailCategoryIds = $request->input('nail_category_ids', []);
            $this->nailCategoryService->bulkDeleteService($nailCategoryIds);
            return redirect()
                ->route('nail-categories.index')
                ->with('success', 'Xóa các danh mục nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('nail-categories.index')
                ->with('error', $e->getMessage());
        }
    }
}

