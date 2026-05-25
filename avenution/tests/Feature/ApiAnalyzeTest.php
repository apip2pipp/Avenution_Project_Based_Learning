<?php

namespace Tests\Feature;

use App\Models\Analysis;
use App\Models\User;
use App\Services\AnalysisProcessingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAnalyzeTest extends TestCase
{
    use RefreshDatabase;

    protected function validPayload(): array
    {
        return [
            'age' => 30,
            'weight' => 70,
            'height' => 170,
            'gender' => 'male',
            'activity_level' => 'moderate',
            'goal' => 'maintain',
        ];
    }

    public function test_guest_post_analyze_redirects_to_login_and_stores_pending()
    {
        $payload = $this->validPayload();

        $response = $this->post(route('analyze.post'), $payload);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');
        $this->assertTrue(session()->has('pending_analysis_payload'));
        $this->assertTrue(session()->has('pending_analysis_token'));
    }

    public function test_authenticated_post_calls_processing_and_redirects_to_result()
    {
        $user = User::factory()->create();
        $payload = $this->validPayload();

        // Mock the AnalysisProcessingService to avoid running full processing
        $mock = \Mockery::mock(AnalysisProcessingService::class);
        $analysis = Analysis::create([
            'user_id' => $user->id,
            'session_id' => 'feature-test-session',
            'age' => $payload['age'],
            'weight' => $payload['weight'],
            'height' => $payload['height'],
            'gender' => $payload['gender'],
            'activity_level' => $payload['activity_level'],
            'goal' => $payload['goal'],
            'bmi' => 24,
            'bmi_category' => 'Normal',
        ]);

        $mock->shouldReceive('process')->once()->andReturn($analysis);

        $this->app->instance(AnalysisProcessingService::class, $mock);

        $response = $this->actingAs($user)->post(route('analyze.post'), $payload);

        $response->assertRedirect(route('result.show', ['sessionId' => $analysis->session_id]));
        $response->assertSessionHas('success');
    }
}
