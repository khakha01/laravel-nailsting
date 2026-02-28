<?php

namespace App\Services;

use App\Contracts\GoogleAuthServiceInterface;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\GoogleLoginSuccessMail;
use Illuminate\Http\RedirectResponse;

class GoogleAuthService implements GoogleAuthServiceInterface
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google, create or update user, send confirmation email.
     */
    public function handleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if user already exists (to preserve their password)
        $existing = User::where('email', $googleUser->getEmail())->first();

        /** @var \App\Models\User $user */
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => $existing?->password ?? bcrypt(Str::random(24)),
            ]
        );

        // Send confirmation email
        try {
            Mail::to($user->email)->send(new GoogleLoginSuccessMail($user));
        } catch (\Throwable $e) {
            // Log but don't block login if mail fails
            logger()->error('Google login mail failed: ' . $e->getMessage());
        }

        // Log in using web guard
        Auth::guard('web')->login($user, true);

        return redirect('/');
    }
}
