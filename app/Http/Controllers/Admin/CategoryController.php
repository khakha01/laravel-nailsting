<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Queries\ListCategories\ListCategoryHandler;
use App\Queries\ListCategories\ListCategoryQuery;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    // ===== LIST & PAGINATION =====
    public function index(Request $request)
    {
        $isActive = $request->filled('is_active') ? (bool) $request->get('is_active') : null;
        
        // Parse category_id properly
        $categoryId = $request->filled('category_id') ? (int) $request->get('category_id') : null;

        $query = new ListCategoryQuery(
            page: (int) ($request->get('page', 1)),
            perPage: (int) ($request->get('perPage', 15)),
            search: $request->get('search'),
            isActive: $isActive,
            categoryId: $categoryId,
        );

        $categories = app(ListCategoryHandler::class)->execute($query);
        
        // Get all categories in hierarchical order for filter dropdown
        $allCategories = $this->categoryService->getHierarchicalCategories();

        return view('admin.category-management.index', compact('categories', 'allCategories'));
    }

    // ===== SHOW CREATE FORM =====
    public function create()
    {
        // Use hierarchical categories to show proper indentation in dropdown
        $parentCategories = $this->categoryService->getHierarchicalCategories();
        return view('admin.category-management.create', compact('parentCategories'));
    }

    // ===== STORE NEW =====
    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->categoryService->createService(
                $request->get('name'),
                $request->get('slug'),
                $request->get('parent_id'),
                $request->get('description'),
                (bool) ($request->get('is_active') ?? true),
                (int) ($request->get('display_order') ?? 0)
            );

            return redirect()
                ->route('categories.index')
                ->with('success', 'Tạo danh mục thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('categories.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== SHOW DETAIL & EDIT FORM =====
    public function show(Request $request)
    {
        $id = (int) $request->route('id');
        $category = $this->categoryService->findById($id);
        
        // Use hierarchical categories but exclude current category and its children
        // to prevent circular parent reference
        $allChildren = $category->getAllChildren()->pluck('id')->toArray();
        $excludeIds = array_merge([$id], $allChildren);
        
        $parentCategories = $this->categoryService->getHierarchicalCategories()
            ->reject(fn($cat) => in_array($cat->id, $excludeIds));

        return view('admin.category-management.edit', compact('category', 'parentCategories'));
    }

    // ===== UPDATE =====
    public function update(UpdateCategoryRequest $request)
    {
        $categoryId = (int) $request->route('id');

        try {
            $this->categoryService->updateService(
                $categoryId,
                $request->get('name'),
                $request->get('slug'),
                $request->get('parent_id'),
                $request->get('description'),
                (bool) $request->get('is_active'),
                (int) ($request->get('display_order') ?? 0)
            );

            return redirect()
                ->route('categories.index')
                ->with('success', 'Cập nhật danh mục thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('categories.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== DELETE SINGLE =====
    public function destroy(Request $request)
    {
        try {
            $id = (int) $request->route('id');
            $this->categoryService->deleteService($id);

            return redirect()
                ->route('categories.index')
                ->with('success', 'Xóa danh mục thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('categories.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== DELETE BULK =====
    public function bulkDelete(Request $request)
    {
        try {
            $categoryIds = $request->input('category_ids', []);
            $this->categoryService->bulkDeleteService($categoryIds);
            return redirect()
                ->route('categories.index')
                ->with('success', 'Xóa các danh mục thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('categories.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== TREE VIEW =====
    public function tree()
    {
        $categoriesTree = $this->categoryService->getCategoriesTree();
        return view('admin.category-management.tree', compact('categoriesTree'));
    }
}
