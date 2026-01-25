<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Services\Admin\AdminAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function __construct(
        protected AdminAuthService $adminAuthService
    ) {}

    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle admin login
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->adminAuthService->loginService($request->only('email', 'password'));

        $cookie = cookie(
            'admin_token', 
            $result['access_token'], 
            $result['expires_in'] / 60, 
            null, 
            null, 
            false, 
            true, // HttpOnly
            false, 
            'Lax'
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng nhập thành công',
            'data' => $result
        ])->withCookie($cookie);
    }

    /**
     * Handle admin logout
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->adminAuthService->logoutService();

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng xuất thành công'
        ])->withoutCookie('admin_token');
    }

    /**
     * Get the authenticated admin
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $admin = $this->adminAuthService->meService();

        return response()->json([
            'status' => 'success',
            'data' => $admin
        ]);
    }

    /**
     * Refresh a token
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $result = $this->adminAuthService->refreshService();

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }
}
