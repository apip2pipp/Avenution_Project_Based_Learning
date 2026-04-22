<?php

namespace App\Services;

use App\Models\Analysis;
use App\Models\User;
use Illuminate\Support\Str;

class AnalysisProcessingService
{
    public function __construct(
        protected BodyAnalysisService $bodyAnalysisService,
        protected RecommendationService $recommendationService,
    ) {
    }

    /**
     * Create an analysis record and its recommendations from validated form payload.
     */
    public function process(array $payload, User $user): Analysis
    {
        $bmi = $this->bodyAnalysisService->calculateBMI(
            (float) $payload['weight'],
            (float) $payload['height']
        );

        $bmiCategory = $this->bodyAnalysisService->getBMICategory($bmi);

        $analysis = Analysis::create([
            'user_id' => $user->id,
            'session_id' => (string) Str::uuid(),
            'age' => $payload['age'],
            'weight' => $payload['weight'],
            'height' => $payload['height'],
            'gender' => $payload['gender'],
            'blood_pressure_systolic' => $payload['blood_pressure_systolic'] ?? null,
            'blood_pressure_diastolic' => $payload['blood_pressure_diastolic'] ?? null,
            'blood_sugar' => $payload['blood_sugar'] ?? null,
            'cholesterol' => $payload['cholesterol'] ?? null,
            'activity_level' => $payload['activity_level'],
            'dietary_restriction' => $payload['dietary_restriction'] ?? 'none',
            'goal' => $payload['goal'],
            'bmi' => $bmi,
            'bmi_category' => $bmiCategory,
        ]);

        $dailyCalories = $this->bodyAnalysisService->calculateDailyCalories($analysis);
        $dietType = $this->bodyAnalysisService->predictDietType($analysis);
        $conditions = $this->bodyAnalysisService->detectHealthConditions($analysis);

        $analysis->update([
            'predicted_diet_type' => $dietType,
            'health_conditions' => json_encode($conditions),
            'daily_calorie_target' => $dailyCalories,
        ]);

        $recommendations = $this->recommendationService->generateRecommendations($analysis);
        $this->recommendationService->saveRecommendations($analysis, $recommendations);

        return $analysis->load(['recommendations.food']);
    }
}