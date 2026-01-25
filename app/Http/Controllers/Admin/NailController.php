<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nails\StoreNailRequest;
use App\Http\Requests\Nails\UpdateNailRequest;
use App\Queries\ListNails\ListNailHandler;
use App\Queries\ListNails\ListNailQuery;
use App\Services\Nail\NailService;
use Illuminate\Http\Request;

class NailController extends Controller
{
    public function __construct(
        protected NailService $nailService
    ) {}

    // ===== LIST & PAGINATION =====
    public function index(Request $request)
    {
        try {
            $query = new ListNailQuery(
                search: $request->get('search'),
                status: $request->get('status'),
                page: $request->get('page', 1),
                perPage: (int) ($request->get('perPage', 15)),
            );

            $nails = app(ListNailHandler::class)->execute($query);

            return view('admin.nail-management.index', compact('nails'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách nail: ' . $e->getMessage());
        }
    }

    // ===== SHOW CREATE FORM =====
    public function create()
    {
        return view('admin.nail-management.create');
    }

    // ===== STORE NEW =====
    public function store(StoreNailRequest $request)
    {
        try {
            // Xử lý images: merge files vào array
            $images = [];
            if ($request->has('images')) {
                foreach ($request->input('images', []) as $index => $imageData) {
                    $images[] = [
                        'media_id' => $imageData['media_id'] ?? null,
                        'is_primary' => $imageData['is_primary'] ?? false,
                        'sort_order' => $imageData['sort_order'] ?? $index,
                    ];
                }
            }

            $this->nailService->createService(
                $request->get('name'),
                $request->get('slug'),
                $request->get('description'),
                $request->get('status', 'active'),
                $images ?: null,
                $request->get('prices')
            );

            return redirect()
                ->route('nails.index')
                ->with('success', 'Tạo nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // ===== SHOW DETAIL & EDIT FORM =====
    public function show(Request $request)
    {
        $id = (int) $request->route('id');
        $nail = $this->nailService->findById($id);
        return view('admin.nail-management.edit', compact('nail'));
    }

    // ===== UPDATE =====
    public function update(UpdateNailRequest $request)
    {
        $nailId = (int) $request->route('id');

        try {
            // Xử lý images: merge files vào array, giữ path cũ nếu không upload mới
            $images = [];
            if ($request->has('images')) {
                foreach ($request->input('images', []) as $index => $imageData) {
                    $images[] = [
                        'media_id' => $imageData['media_id'] ?? null,
                        'is_primary' => $imageData['is_primary'] ?? false,
                        'sort_order' => $imageData['sort_order'] ?? $index,
                    ];
                }
            }

            $this->nailService->updateService(
                $nailId,
                $request->get('name'),
                $request->get('slug'),
                $request->get('description'),
                $request->get('status', 'active'),
                $images ?: null,
                $request->get('prices')
            );

            return redirect()
                ->route('nails.index')
                ->with('success', 'Cập nhật nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('nails.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== DELETE SINGLE =====
    public function destroy(Request $request)
    {
        try {
            $id = (int) $request->route('id');
            $this->nailService->deleteService($id);

            return redirect()
                ->route('nails.index')
                ->with('success', 'Xóa nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('nails.index')
                ->with('error', $e->getMessage());
        }
    }

    // ===== DELETE BULK =====
    public function bulkDelete(Request $request)
    {
        try {
            $nailIds = $request->input('nail_ids', []);
            $this->nailService->bulkDeleteService($nailIds);
            return redirect()
                ->route('nails.index')
                ->with('success', 'Xóa các nail thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('nails.index')
                ->with('error', $e->getMessage());
        }
    }
}

