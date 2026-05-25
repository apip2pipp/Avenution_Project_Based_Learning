<?php

namespace Tests\Feature\Integration;

use App\Models\Food;
use App\Models\User;
use App\Services\AnalysisProcessingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalysisProcessingIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_creates_analysis_and_recommendations()
    {
        $user = User::factory()->create();

        // Create sample foods that RecommendationService will consider
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

        $payload = [
            'age' => 28,
            'weight' => 68,
            'height' => 170,
            'gender' => 'male',
            'activity_level' => 'moderate',
            'goal' => 'maintain',
        ];

        $service = $this->app->make(AnalysisProcessingService::class);

        $analysis = $service->process($payload, $user);

        $this->assertNotNull($analysis->id);
        $this->assertNotEmpty($analysis->session_id);
        $this->assertDatabaseHas('analyses', ['id' => $analysis->id]);

        // recommendations relation should be saved
        $this->assertGreaterThanOrEqual(0, $analysis->recommendations->count());
        $this->assertDatabaseHas('recommendations', ['analysis_id' => $analysis->id]);
    }
}
