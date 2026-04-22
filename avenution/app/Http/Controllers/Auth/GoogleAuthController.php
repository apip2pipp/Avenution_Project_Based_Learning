<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\AnalysisProcessingService;
use App\Services\PendingAnalysisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Spatie\Permission\Models\Role;

class GoogleAuthController extends Controller
{
    public function __construct(
        protected AnalysisProcessingService $analysisProcessingService,
        protected PendingAnalysisService $pendingAnalysisService
    ) {
    }

    private function normalizeGoogleAvatar(?string $avatar): ?string
    {
        if (! $avatar) {
            return null;
        }

        return strlen($avatar) <= 255 ? $avatar : null;
    }

    public function redirect(Request $request): RedirectResponse
    {
        /** @var GoogleProvider $provider */
        $provider = Socialite::driver('google');
        $pendingState = $this->pendingAnalysisService->oauthState(
            $this->pendingAnalysisService->token($request)
        );

        if ($pendingState) {
            $provider->stateless()->with(['state' => $pendingState]);
        }

        return $provider
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            /** @var GoogleProvider $provider */
            $provider = Socialite::driver('google');
            $googleUser = $provider->stateless()->user();
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
                'google_avatar' => $this->normalizeGoogleAvatar($googleUser->getAvatar()) ?: $existingUser->google_avatar,
                'name' => $googleUser->getName() ?: $existingUser->name,
                'auth_provider' => 'google',
                'email_verified_at' => $existingUser->email_verified_at ?? now(),
            ])->save();

            Auth::login($existingUser, true);
            $request->session()->regenerate();

            $pendingAnalysisPayload = $this->pendingAnalysisService->pull($request);

            if ($existingUser && $pendingAnalysisPayload) {
                $analysis = $this->analysisProcessingService->process($pendingAnalysisPayload, $existingUser);

                return redirect()
                    ->route('result.show', ['sessionId' => $analysis->session_id])
                    ->with('success', 'Analysis completed successfully!');
            }

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $user = User::create([
            'name' => $googleUser->getName() ?: 'Google User',
            'email' => $email,
            'password' => null,
            'google_id' => $googleId,
            'google_avatar' => $this->normalizeGoogleAvatar($googleUser->getAvatar()),
            'auth_provider' => 'google',
            'email_verified_at' => now(),
        ]);

        if (! $user->hasRole('user')) {
            $userRole = Role::findOrCreate('user', 'web');
            $user->assignRole($userRole);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        $pendingAnalysisPayload = $this->pendingAnalysisService->pull($request);

        if ($pendingAnalysisPayload) {
            $analysis = $this->analysisProcessingService->process($pendingAnalysisPayload, $user);

            return redirect()
                ->route('result.show', ['sessionId' => $analysis->session_id])
                ->with('success', 'Analysis completed successfully!');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
