<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Throwable;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $usingLocalMailpitHost = app()->isLocal()
            && config('mail.default') === 'smtp'
            && config('mail.mailers.smtp.host') === 'mailpit';

        if ($usingLocalMailpitHost) {
            // Prevent SMTP host errors on local machines that do not run Mailpit.
            config(['mail.default' => 'log']);
        }

        try {
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status == Password::RESET_LINK_SENT
                        ? back()->with('status', $usingLocalMailpitHost
                            ? 'Reset link generated. Check storage/logs/laravel.log (local development mode).'
                            : __($status))
                        : back()->withInput($request->only('email'))
                                ->withErrors(['email' => __($status)]);
        } catch (Throwable $exception) {
            report($exception);

            return back()->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Unable to send reset email right now. Please check mail configuration and try again.',
                ]);
        }
    }
}
