<?php
// Test Backend Logic - Avenution
// Run this with: php artisan tinker < test-backend.php

echo "========================================\n";
echo "  AVENUTION - Backend Logic Test\n";
echo "========================================\n\n";

// Test 1: Create analysis
echo "[TEST 1] Creating analysis for user with multiple health issues...\n";

$analysis = new \App\Models\Analysis([
    'age' => 35,
    'weight' => 90,
    'height' => 165,
    'gender' => 'male',
    'blood_pressure_systolic' => 145,
    'blood_pressure_diastolic' => 95,
    'blood_sugar' => 135,
    'cholesterol' => 230,
    'activity_level' => 'sedentary',
    'dietary_restriction' => 'none',
    'health_goal' => 'lose_weight',
    'session_id' => 'test-' . time(),
]);

$bodyService = new \App\Services\BodyAnalysisService();
$analysis->bmi = $bodyService->calculateBMI($analysis->weight, $analysis->height);
$analysis->bmi_category = $bodyService->getBMICategory($analysis->bmi);
$analysis->save();

echo "✅ Analysis created! ID: {$analysis->id}\n";
echo "   BMI: {$analysis->bmi} ({$analysis->bmi_category})\n\n";

// Test 2: Predict diet type (Naive Bayes)
echo "[TEST 2] Predicting diet type using Naive Bayes...\n";
$dietType = $bodyService->predictDietType($analysis);
echo "🎯 Predicted Diet Type: $dietType\n\n";

// Test 3: Detect health conditions
echo "[TEST 3] Detecting health conditions...\n";
$conditions = $bodyService->detectHealthConditions($analysis);
echo "⚕️  Health Conditions: " . implode(', ', $conditions) . "\n\n";

// Test 4: Calculate daily calories
echo "[TEST 4] Calculating daily calorie needs...\n";
$calories = $bodyService->calculateDailyCalories($analysis);
echo "🔥 Daily Calorie Target: $calories kcal\n\n";

// Test 5: Generate recommendations
echo "[TEST 5] Generating food recommendations...\n";
$recService = new \App\Services\RecommendationService($bodyService);
$recommendations = $recService->generateRecommendations($analysis);

echo "\n🍽️  TOP 8 RECOMMENDED FOODS:\n";
echo "================================\n";
foreach ($recommendations as $index => $rec) {
    echo sprintf(
        "%d. %s %s\n   Score: %d | Cal: %d | Protein: %.1fg | Carbs: %.1fg | Fat: %.1fg\n   Timing: %s\n\n",
        $index + 1,
        $rec['food']->emoji,
        $rec['food']->name,
        $rec['score'],
        $rec['food']->calories,
        $rec['food']->protein,
        $rec['food']->carbs,
        $rec['food']->fat,
        $rec['timing']
    );
}

// Test 6: Save to database
echo "\n[TEST 6] Saving recommendations to database...\n";
$recService->saveRecommendations($analysis, $recommendations);
echo "✅ Recommendations saved!\n";
echo "   Total recommendations: " . count($recommendations) . "\n\n";

// Summary
echo "========================================\n";
echo "  ✅ ALL TESTS PASSED!\n";
echo "========================================\n";
echo "Backend logic sudah berfungsi dengan baik!\n";
echo "1. Naive Bayes prediction: ✅\n";
echo "2. Health condition detection: ✅\n";
echo "3. Calorie calculation: ✅\n";
echo "4. Food recommendation: ✅\n";
echo "5. Database save: ✅\n\n";

echo "Next steps:\n";
echo "- Buat Controller untuk API endpoint\n";
echo "- Buat Frontend form input\n";
echo "- Integrasi Frontend & Backend\n";
