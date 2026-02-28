<?php

namespace App\Contracts;

interface GoogleAuthServiceInterface
{
    /**
     * Get the Google OAuth redirect response.
     */
    public function redirect();

    /**
     * Handle the Google OAuth callback, create or update user, send confirmation email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleCallback();
}
