<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        /** @var \App\Models\User|null $user */
        $user = $request->user();
        $pendingGoogleLink = $request->session()->pull('google_link_pending');

        if (
            $user
            && $pendingGoogleLink
            && ! $user->hasRole('admin')
            && isset($pendingGoogleLink['email'])
            && strcasecmp((string) $user->email, (string) $pendingGoogleLink['email']) === 0
        ) {
            $user->forceFill([
                'google_id' => $pendingGoogleLink['google_id'] ?? $user->google_id,
                'google_avatar' => $pendingGoogleLink['google_avatar'] ?? $user->google_avatar,
                'name' => $pendingGoogleLink['google_name'] ?? $user->name,
                'auth_provider' => 'google',
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();

            return redirect()
                ->intended(RouteServiceProvider::HOME)
                ->with('status', 'Google account linked successfully.');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
