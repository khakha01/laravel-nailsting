<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AdminAuthService
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository
    ) {}

    /**
     * Handle admin login
     *
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    public function loginService(array $credentials): array
    {
        if (!$token = Auth::guard('admin')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }

        $admin = Auth::guard('admin')->user();

        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            throw ValidationException::withMessages([
                'email' => ['Tài khoản của bạn đã bị khóa.'],
            ]);
        }

        return $this->createNewToken($token);
    }

    /**
     * Handle admin logout
     *
     * @return void
     */
    public function logoutService(): void
    {
        Auth::guard('admin')->logout();
    }

    /**
     * Get the authenticated admin
     *
     * @return mixed
     */
    public function meService()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refreshService(): array
    {
        return $this->createNewToken(Auth::guard('admin')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return array
     */
    protected function createNewToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('admin')->factory()->getTTL() * 60,
            'user' => Auth::guard('admin')->user()
        ];
    }
}
