<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostTags\StorePostTagRequest;
use App\Http\Requests\PostTags\UpdatePostTagRequest;
use App\Services\PostTag\PostTagService;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function __construct(
        protected PostTagService $postTagService
    ) {
    }

    public function index()
    {
        $tags = $this->postTagService->getAll();
        return view('admin.post-tag-management.index', compact('tags'));
    }

    public function store(StorePostTagRequest $request)
    {
        $this->postTagService->create($request->validated());
        return redirect()->back()->with('success', 'Tạo tag thành công');
    }

    public function update(UpdatePostTagRequest $request, int $id)
    {
        $this->postTagService->update($id, $request->validated());
        return redirect()->back()->with('success', 'Cập nhật tag thành công');
    }

    public function destroy(int $id)
    {
        $this->postTagService->delete($id);
        return redirect()->back()->with('success', 'Xóa tag thành công');
    }
}
