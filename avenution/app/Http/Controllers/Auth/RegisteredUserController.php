<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\AnalysisProcessingService;
use App\Services\PendingAnalysisService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected AnalysisProcessingService $analysisProcessingService,
        protected PendingAnalysisService $pendingAnalysisService
    ) {
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $pendingAnalysisPayload = $this->pendingAnalysisService->pull($request);

        if ($pendingAnalysisPayload) {
            $analysis = $this->analysisProcessingService->process($pendingAnalysisPayload, $user);

            return redirect()
                ->route('result.show', ['sessionId' => $analysis->session_id])
                ->with('success', 'Analysis completed successfully!');
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
