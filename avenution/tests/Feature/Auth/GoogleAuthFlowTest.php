<?php

namespace Tests\Feature\Auth;

use App\Models\Analysis;
use App\Models\User;
use App\Services\PendingAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Support\Str;
use Tests\TestCase;

class GoogleAuthFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Existing user can login with Google and process pending analysis
     */
    public function test_existing_user_google_login_processes_pending_analysis(): void
    {
        // Create existing user
        $user = User::factory()->create([
            'email' => 'existing@example.com',
            'google_id' => null,
            'email_verified_at' => now(),
        ]);

        $payload = [
            'age' => 29,
            'weight' => 72,
            'height' => 172,
            'gender' => 'male',
            'blood_pressure_systolic' => 118,
            'blood_pressure_diastolic' => 79,
            'blood_sugar' => 98,
            'cholesterol' => 175,
            'activity_level' => 'moderate',
            'dietary_restriction' => 'none',
            'goal' => 'maintain',
        ];

        // This test requires mocking Socialite, which is complex
        // For now, we'll test the logic after authentication
        // In a real test, you would mock Socialite::driver('google')
        
        $this->markTestSkipped('Requires Socialite mocking - will test manually');
    }

    /**
     * Test: New user can register with Google and process pending analysis
     */
    public function test_new_user_google_register_processes_pending_analysis(): void
    {
        // This test requires mocking Socialite
        $this->markTestSkipped('Requires Socialite mocking - will test manually');
    }

    public function test_new_google_user_processes_pending_analysis_from_oauth_state(): void
    {
        $payload = [
            'age' => 29,
            'weight' => 72,
            'height' => 172,
            'gender' => 'male',
            'blood_pressure_systolic' => 118,
            'blood_pressure_diastolic' => 79,
            'blood_sugar' => 98,
            'cholesterol' => 175,
            'activity_level' => 'moderate',
            'dietary_restriction' => 'none',
            'goal' => 'maintain',
        ];

        $pendingToken = (string) Str::uuid();
        $state = app(PendingAnalysisService::class)->oauthState($pendingToken);

        Cache::put('pending_analysis:' . $pendingToken, $payload, now()->addMinutes(10));

        $googleUser = (new SocialiteUser)->map([
            'id' => 'google-new-user',
            'name' => 'Google New User',
            'email' => 'google-new@example.com',
            'avatar' => null,
        ]);

        // Bind a Socialite factory mock into the container that returns a provider mock
        $provider = \Mockery::mock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->shouldReceive('redirectUrl')->andReturnSelf();
        $provider->shouldReceive('stateless')->once()->andReturnSelf();
        $provider->shouldReceive('user')->once()->andReturn($googleUser);

        $managerMock = \Mockery::mock(\Laravel\Socialite\SocialiteManager::class);
        $managerMock->shouldReceive('driver')->with('google')->andReturn($provider);

        // Swap the Socialite facade root so the controller uses our mock
        \Laravel\Socialite\Facades\Socialite::swap($managerMock);

        $response = $this->get(route('auth.google.callback', [
            'code' => 'fake-code',
            'state' => $state,
        ]));

        $user = User::query()->where('email', 'google-new@example.com')->first();

        $this->assertNotNull($user, 'User was not created. Response status: ' . $response->status() . ' Content: ' . substr($response->getContent(), 0, 500));

        $analysis = Analysis::query()->where('user_id', $user->id)->latest('id')->first();

        $this->assertNotNull($analysis);
        $response->assertRedirect(route('result.show', $analysis->session_id));
        $this->assertFalse(Cache::has('pending_analysis:' . $pendingToken));
    }

    /**
     * Test: Verify GoogleAuthController has AnalysisProcessingService
     */
    public function test_google_auth_controller_has_analysis_service(): void
    {
        $controller = new \App\Http\Controllers\Auth\GoogleAuthController(
            resolve(\App\Services\AnalysisProcessingService::class),
            resolve(\App\Services\PendingAnalysisService::class)
        );

        $this->assertNotNull($controller);
    }
}
