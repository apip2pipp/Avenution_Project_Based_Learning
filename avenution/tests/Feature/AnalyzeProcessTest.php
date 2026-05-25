<?php

namespace Tests\Feature;

use App\Models\Analysis;
use App\Models\User;
use App\Services\AnalysisProcessingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyzeProcessTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_triggers_processing_and_redirects_to_result(): void
    {
        $user = User::factory()->create([
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

        // Prepare an Analysis that the mock will return
        $analysis = Analysis::create([
            'user_id' => $user->id,
            'session_id' => 'feature-test-session',
            'age' => $payload['age'],
            'weight' => $payload['weight'],
            'height' => $payload['height'],
            'gender' => $payload['gender'],
            'activity_level' => $payload['activity_level'],
            'dietary_restriction' => $payload['dietary_restriction'],
            'goal' => $payload['goal'],
            'bmi' => 24,
            'bmi_category' => 'Normal',
            'predicted_diet_type' => 'Balanced',
            'health_conditions' => json_encode([]),
            'daily_calorie_target' => 2000,
        ]);

        // Mock AnalysisProcessingService to avoid running full processing
        $mock = \Mockery::mock(AnalysisProcessingService::class);
        $mock->shouldReceive('process')->once()->andReturn($analysis);

        $this->app->instance(AnalysisProcessingService::class, $mock);

        // Act as authenticated user
        $response = $this->actingAs($user)->post('/analyze', $payload);

        $response->assertRedirect(route('result.show', ['sessionId' => $analysis->session_id]));
        $response->assertSessionHas('success');
    }
}
