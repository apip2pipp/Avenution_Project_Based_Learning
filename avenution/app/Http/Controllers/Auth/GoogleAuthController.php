<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $exception) {
            return redirect()
                ->route('login')
                ->withErrors(['login' => 'Google sign in failed. Please try again.']);
        }

        $email = Str::lower((string) $googleUser->getEmail());
        $googleId = (string) $googleUser->getId();

        if ($email === '' || $googleId === '') {
            return redirect()
                ->route('login')
                ->withErrors(['login' => 'Google did not return a valid account.']);
        }

        $existingUser = User::query()->where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->hasRole('admin')) {
                return redirect()
                    ->route('login')
                    ->withErrors(['login' => 'Admin accounts must sign in using username and password.']);
            }

            if (! $existingUser->google_id) {
                $request->session()->put('google_link_pending', [
                    'email' => $email,
                    'google_id' => $googleId,
                    'google_avatar' => $googleUser->getAvatar(),
                    'google_name' => $googleUser->getName(),
                ]);

                return redirect()
                    ->route('login')
                    ->with('status', 'This email is already registered. Please sign in with your password to confirm Google linking.');
            }

            $existingUser->forceFill([
                'google_avatar' => $googleUser->getAvatar() ?: $existingUser->google_avatar,
                'name' => $googleUser->getName() ?: $existingUser->name,
                'auth_provider' => 'google',
                'email_verified_at' => $existingUser->email_verified_at ?? now(),
            ])->save();

            Auth::login($existingUser, true);
            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $user = User::create([
            'name' => $googleUser->getName() ?: 'Google User',
            'email' => $email,
            'password' => Hash::make(Str::random(40)),
            'google_id' => $googleId,
            'google_avatar' => $googleUser->getAvatar(),
            'auth_provider' => 'google',
            'email_verified_at' => now(),
        ]);

        if (! $user->hasRole('user')) {
            $user->assignRole('user');
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
