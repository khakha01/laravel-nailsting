<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Queries\ListPosts\ListPostHandler;
use App\Queries\ListPosts\ListPostQuery;
use App\Services\Post\PostService;
use App\Services\PostCategory\PostCategoryService;
use App\Services\PostTag\PostTagService;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected PostCategoryService $postCategoryService,
        protected PostTagService $postTagService,
        protected ListPostHandler $listPostHandler
    ) {
    }

    public function index(Request $request)
    {
        try {
            $query = new ListPostQuery(
                search: $request->get('search'),
                status: $request->get('status'),
                postCategoryId: $request->get('post_category_id'),
                page: $request->get('page', 1),
                perPage: (int) $request->get('perPage', 15)
            );

            $posts = $this->listPostHandler->execute($query);
            $categories = $this->postCategoryService->getAll();

            return view('admin.post-management.index', compact('posts', 'categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách bài viết: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $categories = $this->postCategoryService->getActiveCategories();
        $tags = $this->postTagService->getAll();
        return view('admin.post-management.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $this->postService->create($request->validated());
        return redirect()->route('posts.index')->with('success', 'Tạo bài viết thành công');
    }

    public function edit(int $id)
    {
        $post = $this->postService->findById($id);
        $categories = $this->postCategoryService->getActiveCategories();
        $tags = $this->postTagService->getAll();
        return view('admin.post-management.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, int $id)
    {
        $this->postService->update($id, $request->validated());
        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công');
    }

    public function destroy(int $id)
    {
        $this->postService->delete($id);
        return redirect()->route('posts.index')->with('success', 'Xóa bài viết thành công');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        $count = $this->postService->bulkDelete($ids);
        return response()->json(['success' => true, 'message' => "Đã xóa $count bài viết"]);
    }
}
