<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\System\RedisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RedisController extends Controller
{
    protected $redisService;

    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function index()
    {
        if (!auth()->guard('admin')->user()->hasPermission('redis-view')) {
            abort(403);
        }

        $info = $this->redisService->getInfo();
        $keyStats = $this->redisService->getKeyStats();

        return view('admin.system.redis.index', compact('info', 'keyStats'));
    }

    public function flush()
    {
        if (!auth()->guard('admin')->user()->hasPermission('redis-delete')) {
            return response()->json(['success' => false, 'message' => 'Permission denied'], 403);
        }

        $this->redisService->clearCache();

        return redirect()->back()->with('success', 'Toàn bộ cache đã được xóa thành công!');
    }

    public function deletePattern(Request $request)
    {
        if (!auth()->guard('admin')->user()->hasPermission('redis-delete')) {
            return response()->json(['success' => false, 'message' => 'Permission denied'], 403);
        }

        $pattern = $request->input('pattern');
        if (empty($pattern)) {
            return redirect()->back()->with('error', 'Pattern không được để trống!');
        }

        $count = $this->redisService->deletePattern($pattern);

        return redirect()->back()->with('success', "Đã xóa $count keys khớp với pattern: $pattern");
    }
}
