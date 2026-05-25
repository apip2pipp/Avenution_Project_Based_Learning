<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AnalysisProcessingService;
use App\Services\BodyAnalysisService;
use App\Services\RecommendationService;
use App\Models\User;
use Mockery;

class AnalysisProcessingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_creates_analysis_and_saves_recommendations(): void
    {
        // Arrange: create a user and payload
        $user = User::factory()->create();

        $payload = [
            'age' => 30,
            'weight' => 72,
            'height' => 172,
            'gender' => 'male',
            'blood_pressure_systolic' => 120,
            'blood_pressure_diastolic' => 80,
            'blood_sugar' => 100,
            'cholesterol' => 180,
            'activity_level' => 'moderate',
            'dietary_restriction' => 'none',
            'goal' => 'maintain',
        ];

        // Mock BodyAnalysisService
        $bodyMock = Mockery::mock(BodyAnalysisService::class);
        $bodyMock->shouldReceive('calculateBMI')->once()->andReturn(24.4);
        $bodyMock->shouldReceive('getBMICategory')->once()->with(24.4)->andReturn('Normal');
        $bodyMock->shouldReceive('calculateDailyCalories')->once()->andReturn(2000);
        $bodyMock->shouldReceive('predictDietType')->once()->andReturn('balanced');
        $bodyMock->shouldReceive('detectHealthConditions')->once()->andReturn(['hypertension' => false]);

        // Mock RecommendationService
        $recMock = Mockery::mock(RecommendationService::class);
        $recMock->shouldReceive('generateRecommendations')->once()->andReturn([]);
        $recMock->shouldReceive('saveRecommendations')->once()->andReturnNull();

        // Act
        $service = new AnalysisProcessingService($bodyMock, $recMock);
        $analysis = $service->process($payload, $user);

        // Assert
        $this->assertNotNull($analysis->id);
        $this->assertEquals($user->id, $analysis->user_id);
        $this->assertEquals('Normal', $analysis->bmi_category);
        $this->assertEquals('balanced', $analysis->predicted_diet_type);
        $this->assertEquals(2000, (int) $analysis->daily_calorie_target);
    }
}
