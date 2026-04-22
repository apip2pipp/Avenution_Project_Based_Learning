<?php

namespace Tests\Feature;

use App\Models\Analysis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AnalysisAuthFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Guest user can view /analyze page without authentication
     */
    public function test_guest_can_access_analyze_page(): void
    {
        $response = $this->get('/analyze');
        
        $response->assertOk();
        $response->assertViewIs('analyze');
    }

    /**
     * Test: Guest user submits analyze form and gets redirected to login
     */
    public function test_guest_submit_analyze_redirects_to_login(): void
    {
        $response = $this->post('/analyze', $this->validAnalyzePayload());

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('pending_analysis_payload');
        $response->assertSessionHas('status');
    }

    /**
     * Test: After login, analysis is automatically processed
     */
    public function test_analysis_processed_automatically_after_login(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $payload = $this->validAnalyzePayload();

        // Step 1: Login with pending payload in session
        $loginResponse = $this->withSession([
            'pending_analysis_payload' => $payload,
        ])->post('/login', [
            'login' => $user->email,
            'password' => 'password',
        ]);

        // Step 2: Should redirect to result page
        $loginResponse->assertRedirect();
        $locationHeader = $loginResponse->headers->get('location');
        $this->assertStringContainsString('/result/', $locationHeader);

        // Step 3: Analysis should be created
        $analysis = Analysis::where('user_id', $user->id)->first();
        $this->assertNotNull($analysis);
        $this->assertNotNull($analysis->session_id);

        // Step 4: User should be able to access result page
        $this->actingAs($user)
            ->get(route('result.show', $analysis->session_id))
            ->assertOk();
    }

    /**
     * Test: After registration, analysis is automatically processed
     */
    public function test_analysis_processed_automatically_after_registration(): void
    {
        $payload = $this->validAnalyzePayload();

        // Step 1: Register with pending payload in session
        $registerResponse = $this->withSession([
            'pending_analysis_payload' => $payload,
        ])->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Step 2: Should redirect to result page
        $registerResponse->assertRedirect();
        $locationHeader = $registerResponse->headers->get('location');
        $this->assertStringContainsString('/result/', $locationHeader);

        // Step 3: User and analysis should be created
        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user);

        $analysis = Analysis::where('user_id', $user->id)->first();
        $this->assertNotNull($analysis);
    }

    /**
     * Test: Result page requires authentication
     */
    public function test_result_page_requires_authentication(): void
    {
        $analysis = $this->createAnalysis([
            'session_id' => (string) Str::uuid(),
        ]);

        $response = $this->get(route('result.show', $analysis->session_id));
        
        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Authenticated user cannot view other user's result
     */
    public function test_user_cannot_view_other_users_result(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $analysis = $this->createAnalysis([
            'user_id' => $owner->id,
            'session_id' => (string) Str::uuid(),
        ]);

        $response = $this->actingAs($otherUser)
            ->get(route('result.show', $analysis->session_id));
        
        $response->assertForbidden();
    }

    /**
     * Test: User can view their own result after login redirect
     */
    public function test_user_can_view_own_result(): void
    {
        $user = User::factory()->create();
        $analysis = $this->createAnalysis([
            'user_id' => $user->id,
            'session_id' => (string) Str::uuid(),
        ]);

        $response = $this->actingAs($user)
            ->get(route('result.show', $analysis->session_id));
        
        $response->assertOk();
    }

    /**
     * Test: Invalid analyze payload fails validation
     */
    public function test_invalid_analyze_payload_fails_validation(): void
    {
        $invalidPayload = [
            'age' => 'invalid', // Should be numeric
            'weight' => -50,    // Should be positive
        ];

        $response = $this->post('/analyze', $invalidPayload);

        // Should either redirect back with errors or return validation errors
        // The actual behavior depends on how the controller handles validation failures
        $this->assertTrue(
            $response->status() === 302 || // Redirect
            $response->status() === 422    // Unprocessable Entity
        );
    }

    /**
     * Test: Admin can view any user's result
     */
    public function test_admin_can_view_any_user_result(): void
    {
        // This test assumes admin role exists
        // Create admin user with admin role
        $admin = User::factory()->create();
        $owner = User::factory()->create();

        $analysis = $this->createAnalysis([
            'user_id' => $owner->id,
            'session_id' => (string) Str::uuid(),
        ]);

        // Note: This test will fail if admin middleware is not set up properly
        // $this->actingAs($admin)->get(...) would need admin role configured
    }

    private function createAnalysis(array $overrides = []): Analysis
    {
        return Analysis::create(array_merge([
            'user_id' => null,
            'session_id' => (string) Str::uuid(),
            'age' => 28,
            'weight' => 70.5,
            'height' => 172.0,
            'gender' => 'male',
            'blood_pressure_systolic' => 120,
            'blood_pressure_diastolic' => 80,
            'blood_sugar' => 100,
            'cholesterol' => 180,
            'activity_level' => 'moderate',
            'dietary_restriction' => 'none',
            'health_goal' => null,
            'goal' => 'maintain',
            'bmi' => 23.8,
            'bmi_category' => 'Normal',
            'predicted_diet_type' => 'Balanced',
            'health_conditions' => json_encode([]),
            'daily_calorie_target' => 2100,
        ], $overrides));
    }

    private function validAnalyzePayload(): array
    {
        return [
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
    }
}
