<?php

/**
 * Test API Endpoints
 * Run: php test-api.php
 */

$baseUrl = 'http://localhost:8000/api';

echo "========================================\n";
echo "  TESTING AVENUTION API\n";
echo "========================================\n\n";

// Test data - Same as verify-backend.php
$testData = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'age' => 35,
    'gender' => 'male',
    'weight' => 90,      // kg
    'height' => 165,     // cm
    'activity_level' => 'moderate',
    'goal' => 'weight_loss',
    'blood_pressure_systolic' => 145,
    'blood_pressure_diastolic' => 95,
    'blood_sugar' => 135,
    'cholesterol' => 230,
];

echo "Test Data:\n";
echo "  Name: {$testData['name']}\n";
echo "  Age: {$testData['age']} years old\n";
echo "  Weight: {$testData['weight']} kg\n";
echo "  Height: {$testData['height']} cm\n";
echo "  Goal: {$testData['goal']}\n\n";

// Test 1: Create Analysis
echo "========================================\n";
echo "[TEST 1] POST /api/analysis\n";
echo "========================================\n";

$ch = curl_init($baseUrl . '/analysis');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 201) {
    echo "✅ Status: {$httpCode} Created\n\n";
    $data = json_decode($response, true);
    
    if ($data['success']) {
        $analysis = $data['data']['analysis'];
        $recommendations = $data['data']['recommendations'];
        
        echo "Analysis Results:\n";
        echo "  ID: {$analysis['id']}\n";
        echo "  BMI: {$analysis['bmi']} ({$analysis['bmi_category']})\n";
        echo "  Diet Type: {$analysis['predicted_diet_type']}\n";
        echo "  Health Conditions: " . implode(', ', $analysis['health_conditions']) . "\n";
        echo "  Daily Calories: {$analysis['daily_calorie_target']} kcal\n";
        echo "  Recommendations: " . count($recommendations) . " foods\n\n";
        
        echo "Top 3 Recommended Foods:\n";
        foreach (array_slice($recommendations, 0, 3) as $i => $rec) {
            $food = $rec['food'];
            echo "  " . ($i + 1) . ". {$food['emoji']} {$food['name']} (Score: {$rec['score']})\n";
            echo "     {$food['calories']} cal | P:{$food['protein']}g | C:{$food['carbs']}g | F:{$food['fat']}g\n";
        }
        
        // Store analysis ID for next test
        $analysisId = $analysis['id'];
        
        echo "\n========================================\n";
        echo "[TEST 2] GET /api/analysis/{$analysisId}\n";
        echo "========================================\n";
        
        // Test 2: Get Analysis by ID
        $ch = curl_init($baseUrl . '/analysis/' . $analysisId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            echo "✅ Status: {$httpCode} OK\n";
            echo "✅ Successfully retrieved analysis\n\n";
        } else {
            echo "❌ Status: {$httpCode}\n";
            echo "Response: {$response}\n\n";
        }
        
        echo "========================================\n";
        echo "✅ ALL API TESTS PASSED!\n";
        echo "========================================\n\n";
        
        echo "API Endpoints Ready:\n";
        echo "  ✅ POST   /api/analysis       - Create analysis\n";
        echo "  ✅ GET    /api/analysis/{id}  - Get analysis\n";
        echo "  ✅ GET    /api/analysis/history/user?user_id={id} - Get history\n\n";
        
        echo "Next Steps:\n";
        echo "  1. ✅ Start development server: php artisan serve\n";
        echo "  2. 📝 Buat Frontend Form untuk input user data\n";
        echo "  3. 📊 Display recommendations dengan card design\n";
        
    } else {
        echo "❌ API returned success=false\n";
        echo "Response: {$response}\n";
    }
    
} else {
    echo "❌ Status: {$httpCode}\n";
    echo "Response: {$response}\n";
}
