<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\BodyAnalysisService;
use App\Models\Analysis;

class BodyAnalysisServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_bmi_and_category(): void
    {
        $svc = new BodyAnalysisService();

        $bmi = $svc->calculateBMI(72, 172); // ~24.34 -> rounded 24.34
        $this->assertEquals(24.34, $bmi);

        $category = $svc->getBMICategory($bmi);
        $this->assertEquals('Normal', $category);
    }

    public function test_calculate_daily_calories(): void
    {
        $svc = new BodyAnalysisService();

        $user = \App\Models\User::factory()->create();

        $analysis = Analysis::create([
            'user_id' => $user->id,
            'session_id' => 's1',
            'age' => 30,
            'weight' => 72,
            'height' => 172,
            'gender' => 'male',
            'activity_level' => 'moderately_active',
            'health_goal' => 'maintain',
            'bmi' => 24.34,
            'bmi_category' => 'Normal',
        ]);

        $cal = $svc->calculateDailyCalories($analysis);

        // BMR = 1650, multiplier 1.55 => 2557.5 => rounded 2558
        $this->assertEquals(2558, $cal);
    }

    public function test_predict_diet_type_and_detect_conditions(): void
    {
        $svc = new BodyAnalysisService();

        $user2 = \App\Models\User::factory()->create();

        $analysis = Analysis::create([
            'user_id' => $user2->id,
            'session_id' => 's2',
            'age' => 45,
            'weight' => 90,
            'height' => 170,
            'gender' => 'male',
            'activity_level' => 'sedentary',
            'health_goal' => 'lose_weight',
            'blood_pressure_systolic' => 145,
            'blood_pressure_diastolic' => 95,
            'blood_sugar' => 130,
            'cholesterol' => 250,
            'bmi' => 31.14,
            'bmi_category' => 'Obese',
        ]);

        $diet = $svc->predictDietType($analysis);
        $this->assertEquals('Low_Carb', $diet);

        $conditions = $svc->detectHealthConditions($analysis);
        $this->assertContains('Diabetes', $conditions);
        $this->assertContains('Hypertension', $conditions);
        $this->assertContains('Obesity', $conditions);
        $this->assertContains('High_Cholesterol', $conditions);
    }

    public function test_calculate_ideal_weight(): void
    {
        $svc = new BodyAnalysisService();

        $res = $svc->calculateIdealWeight(172);

        $this->assertEqualsWithDelta(54.7, $res['min'], 0.1);
        $this->assertEqualsWithDelta(65.1, $res['ideal'], 0.1);
        $this->assertEqualsWithDelta(73.7, $res['max'], 0.1);
    }
}
