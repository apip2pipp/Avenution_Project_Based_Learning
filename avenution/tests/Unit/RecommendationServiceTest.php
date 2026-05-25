<?php

namespace Tests\Unit;

use App\Models\Analysis;
use App\Models\Food;
use App\Services\RecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_recommendations_returns_expected_structure(): void
    {
        // Arrange: create some foods
        Food::create([
            'name' => 'Tempe Goreng',
            'category' => 'Protein Nabati',
            'calories' => 180,
            'protein' => 19,
            'carbs' => 10,
            'fat' => 9,
            'fiber' => 3,
        ]);

        Food::create([
            'name' => 'Nasi Putih',
            'category' => 'Karbohidrat',
            'calories' => 200,
            'protein' => 4,
            'carbs' => 45,
            'fat' => 0,
            'fiber' => 1,
        ]);

        Food::create([
            'name' => 'Salad Buah',
            'category' => 'Buah',
            'calories' => 90,
            'protein' => 1,
            'carbs' => 20,
            'fat' => 0,
            'fiber' => 4,
        ]);

        // Create a minimal Analysis model instance
        $analysis = Analysis::create([
            'user_id' => null,
            'session_id' => 'unit-test-session',
            'age' => 30,
            'weight' => 70,
            'height' => 170,
            'gender' => 'male',
            'activity_level' => 'moderate',
            'dietary_restriction' => 'none',
            'goal' => 'maintain',
            'bmi' => 24,
            'bmi_category' => 'Normal',
            'predicted_diet_type' => null,
            'health_conditions' => json_encode([]),
            'daily_calorie_target' => 2000,
        ]);

        // Mock BodyAnalysisService with predictable outputs
        $bodyMock = \Mockery::mock(\App\Services\BodyAnalysisService::class);
        $bodyMock->shouldReceive('predictDietType')->andReturn('Balanced');
        $bodyMock->shouldReceive('detectHealthConditions')->andReturn([]);
        $bodyMock->shouldReceive('calculateDailyCalories')->andReturn(2000);

        // Bind mock into container so DI type-hint is satisfied
        $this->app->instance(\App\Services\BodyAnalysisService::class, $bodyMock);
        $service = $this->app->make(RecommendationService::class);

        // Act
        $recommendations = $service->generateRecommendations($analysis);

        // Assert basic structure
        $this->assertIsArray($recommendations);

        foreach ($recommendations as $rec) {
            $this->assertArrayHasKey('food', $rec);
            $this->assertArrayHasKey('score', $rec);
            $this->assertArrayHasKey('timing', $rec);
            $this->assertArrayHasKey('diet_type', $rec);
            $this->assertArrayHasKey('conditions', $rec);
            $this->assertArrayHasKey('daily_calorie_target', $rec);
        }
    }
}
