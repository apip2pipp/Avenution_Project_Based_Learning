<?php

namespace Tests\Feature\Integration;

use App\Models\Food;
use App\Models\User;
use App\Services\AnalysisProcessingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResultPageIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_result_page_shows_recommendations_for_owner()
    {
        $user = User::factory()->create();

        // Add foods so RecommendationService has data to choose from
        Food::create([
            'name' => 'Tempe Goreng',
            'category' => 'Protein Nabati',
            'calories' => 180,
            'protein' => 19,
            'carbs' => 10,
            'fat' => 9,
            'fiber' => 3,
        ]);

        $payload = [
            'age' => 30,
            'weight' => 70,
            'height' => 170,
            'gender' => 'male',
            'activity_level' => 'moderate',
            'goal' => 'maintain',
        ];

        $service = $this->app->make(AnalysisProcessingService::class);
        $analysis = $service->process($payload, $user);

        $response = $this->actingAs($user)->get('/result/' . $analysis->session_id);
        $response->assertStatus(200);
        $response->assertSee('Tempe Goreng');
    }

    public function test_result_page_forbidden_for_other_user()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

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
            'height' => 165,
            'gender' => 'female',
            'activity_level' => 'light',
            'goal' => 'lose',
        ];

        $service = $this->app->make(AnalysisProcessingService::class);
        $analysis = $service->process($payload, $owner);

        $response = $this->actingAs($other)->get('/result/' . $analysis->session_id);
        $response->assertStatus(403);
    }
}
