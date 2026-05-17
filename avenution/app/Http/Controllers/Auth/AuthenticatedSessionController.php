<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\AnalysisProcessingService;
use App\Services\PendingAnalysisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        protected AnalysisProcessingService $analysisProcessingService,
        protected PendingAnalysisService $pendingAnalysisService
    ) {
    }

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
        $pendingAnalysisPayload = $this->pendingAnalysisService->pull($request);
        $pendingGoogleLink = $request->session()->pull('google_link_pending');

        if (
            $user
            && $pendingGoogleLink
            && ! $user->hasRole('admin')
            && isset($pendingGoogleLink['email'])
            && strcasecmp((string) $user->email, (string) $pendingGoogleLink['email']) === 0
        ) {
            $updates = [
                'google_id' => $pendingGoogleLink['google_id'] ?? $user->google_id,
                'google_avatar' => $pendingGoogleLink['google_avatar'] ?? $user->google_avatar,
                'auth_provider' => 'google',
                'email_verified_at' => $user->email_verified_at ?? now(),
            ];

            $googleName = trim((string) ($pendingGoogleLink['google_name'] ?? ''));
            if (blank($user->name) && $googleName !== '') {
                $updates['name'] = $googleName;
            }

            $user->forceFill($updates)->save();

            if (! $pendingAnalysisPayload) {
                return redirect()
                    ->intended(RouteServiceProvider::HOME)
                    ->with('status', 'Google account linked successfully.');
            }
        }

        if ($user && $pendingAnalysisPayload) {
            $analysis = $this->analysisProcessingService->process($pendingAnalysisPayload, $user);

            return redirect()
                ->route('result.show', ['sessionId' => $analysis->session_id])
                ->with('success', 'Analysis completed successfully!');
        }

        if ($request->session()->has('url.intended')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        if ($user && $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect(RouteServiceProvider::HOME);
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
