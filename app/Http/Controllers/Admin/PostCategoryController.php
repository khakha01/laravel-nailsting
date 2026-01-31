<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategories\StorePostCategoryRequest;
use App\Http\Requests\PostCategories\UpdatePostCategoryRequest;
use App\Queries\ListPostCategories\ListPostCategoryHandler;
use App\Queries\ListPostCategories\ListPostCategoryQuery;
use App\Services\PostCategory\PostCategoryService;
use Exception;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function __construct(
        protected PostCategoryService $postCategoryService,
        protected ListPostCategoryHandler $listPostCategoryHandler
    ) {
    }

    public function index(Request $request)
    {
        try {
            $isActive = $request->filled('is_active') ? (bool) $request->get('is_active') : null;
            $query = new ListPostCategoryQuery(
                search: $request->get('search'),
                isActive: $isActive,
                parentId: $request->get('parent_id'),
                page: $request->get('page', 1),
                perPage: (int) $request->get('perPage', 15)
            );

            $categories = $this->listPostCategoryHandler->execute($query);
            $parentCategories = $this->postCategoryService->getAll();

            return view('admin.post-category-management.index', compact('categories', 'parentCategories'));
        } catch (Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách danh mục: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $categories = $this->postCategoryService->getAll();
        return view('admin.post-category-management.create', compact('categories'));
    }

    public function store(StorePostCategoryRequest $request)
    {
        $this->postCategoryService->create($request->validated());
        return redirect()->route('post-categories.index')->with('success', 'Tạo danh mục thành công');
    }

    public function edit(int $id)
    {
        $category = $this->postCategoryService->findById($id);
        $categories = $this->postCategoryService->getAll();
        return view('admin.post-category-management.edit', compact('category', 'categories'));
    }

    public function update(UpdatePostCategoryRequest $request, int $id)
    {
        $this->postCategoryService->update($id, $request->validated());
        return redirect()->route('post-categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(int $id)
    {
        $this->postCategoryService->delete($id);
        return redirect()->route('post-categories.index')->with('success', 'Xóa danh mục thành công');
    }
}
