<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banners\StoreBannerRequest;
use App\Http\Requests\Banners\UpdateBannerRequest;
use App\Services\Banner\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct(
        protected BannerService $bannerService
    ) {
    }

    public function index()
    {
        $banners = $this->bannerService->getAll();
        return view('admin.banner-management.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner-management.create');
    }

    public function store(StoreBannerRequest $request)
    {
        try {
            $this->bannerService->createBanner($request->validated());

            return redirect()
                ->route('banners.index')
                ->with('success', 'Tạo banner thành công');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $id = (int) $request->route('id');
        $banner = $this->bannerService->findById($id);
        return view('admin.banner-management.edit', compact('banner'));
    }

    public function update(UpdateBannerRequest $request)
    {
        $id = (int) $request->route('id');
        try {
            $this->bannerService->updateBanner($id, $request->validated());

            return redirect()
                ->route('banners.index')
                ->with('success', 'Cập nhật banner thành công');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $id = (int) $request->route('id');
        try {
            $this->bannerService->deleteBanner($id);

            return redirect()
                ->route('banners.index')
                ->with('success', 'Xóa banner thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('banners.index')
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            $this->bannerService->bulkDeleteBanners($ids);

            return redirect()
                ->route('banners.index')
                ->with('success', 'Xóa các banner thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('banners.index')
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
