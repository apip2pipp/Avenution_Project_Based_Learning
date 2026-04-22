<?php

namespace Tests\Feature;

use App\Models\Analysis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AnalysisFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_analyze_redirects_to_login_and_stores_pending_payload(): void
    {
        $response = $this->post('/analyze', $this->validAnalyzePayload());

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');
        $response->assertSessionHas('pending_analysis_payload');

        $this->assertDatabaseCount('analyses', 0);
        $this->assertDatabaseCount('recommendations', 0);
    }

    public function test_pending_payload_is_processed_after_user_login(): void
    {
        $payload = $this->validAnalyzePayload();

        $user = User::factory()->create([
            'username' => 'member-a',
            'email_verified_at' => now(),
        ]);

        $this->post('/analyze', $payload);

        $response = $this->withSession([
            'pending_analysis_payload' => $payload,
        ])->post('/login', [
            'login' => $user->email,
            'password' => 'password',
        ]);

        $analysis = Analysis::query()->where('user_id', $user->id)->latest('id')->first();

        $this->assertNotNull($analysis);
        $this->assertNotEmpty($analysis->session_id);

        $this->actingAs($user)
            ->get(route('result.show', $analysis->session_id))
            ->assertOk();
    }

    public function test_pending_payload_is_processed_after_registration(): void
    {
        $payload = $this->validAnalyzePayload();

        $this->post('/analyze', $payload);

        $response = $this->withSession([
            'pending_analysis_payload' => $payload,
        ])->post('/register', [
            'name' => 'New Member',
            'email' => 'newmember@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::query()->where('email', 'newmember@example.com')->first();

        $this->assertNotNull($user);
        $analysis = Analysis::query()->where('user_id', $user->id)->latest('id')->first();

        $this->assertNotNull($analysis);

        $this->actingAs($user)
            ->get(route('result.show', $analysis->session_id))
            ->assertOk();
    }

    public function test_user_cannot_access_other_users_result_page(): void
    {
        $owner = User::factory()->create([
            'username' => 'owner-user',
            'email_verified_at' => now(),
        ]);

        $otherUser = User::factory()->create([
            'username' => 'other-user',
            'email_verified_at' => now(),
        ]);

        $analysis = $this->createAnalysis([
            'user_id' => $owner->id,
            'session_id' => (string) Str::uuid(),
        ]);

        $this->actingAs($otherUser)
            ->get(route('result.show', $analysis->session_id))
            ->assertForbidden();
    }

    private function createAnalysis(array $overrides = []): Analysis
    {
        return Analysis::query()->create(array_merge([
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
