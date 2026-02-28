<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $admin = auth('admin')->user();

        if (!$admin || !method_exists($admin, 'hasPermission') || !$admin->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Bạn không có quyền thực hiện hành động này.'], 403);
            }
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
