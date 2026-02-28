<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\GoogleAuthServiceInterface;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class GoogleController extends Controller
{
    protected $googleAuthService;

    public function __construct(GoogleAuthServiceInterface $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirect(): RedirectResponse
    {
        return $this->googleAuthService->redirect();
    }

    /**
     * Handle Google callback.
     */
    public function callback(): RedirectResponse
    {
        return $this->googleAuthService->handleCallback();
    }
}
