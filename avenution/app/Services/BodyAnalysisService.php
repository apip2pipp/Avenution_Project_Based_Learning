<?php

namespace App\Services;

use App\Models\Analysis;

class BodyAnalysisService
{
    /**
     * Calculate BMI from weight and height
     * 
     * @param float $weight Weight in kg
     * @param float $height Height in cm
     * @return float BMI value
     */
    public function calculateBMI(float $weight, float $height): float
    {
        // Convert height from cm to meters
        $heightInMeters = $height / 100;
        
        // BMI = weight (kg) / height² (m²)
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        
        return round($bmi, 2);
    }

    /**
     * Get BMI category based on BMI value
     * 
     * @param float $bmi BMI value
     * @return string Category name
     */
    public function getBMICategory(float $bmi): string
    {
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'Normal';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }

    /**
     * Generate health warnings based on analysis data
     * 
     * @param Analysis $analysis
     * @return array Array of warning messages
     */
    public function generateHealthWarnings(Analysis $analysis): array
    {
        $warnings = [];

        // Blood Pressure Warnings
        if ($analysis->blood_pressure_systolic >= 140 || $analysis->blood_pressure_diastolic >= 90) {
            $warnings[] = [
                'type' => 'High Blood Pressure',
                'message' => 'Your blood pressure is elevated. Consider reducing sodium intake and increasing physical activity.',
                'severity' => 'high',
            ];
        } elseif ($analysis->blood_pressure_systolic >= 130 || $analysis->blood_pressure_diastolic >= 80) {
            $warnings[] = [
                'type' => 'Elevated Blood Pressure',
                'message' => 'Your blood pressure is slightly elevated. Monitor it regularly and maintain a healthy lifestyle.',
                'severity' => 'medium',
            ];
        }

        // Blood Sugar Warnings
        if ($analysis->blood_sugar >= 126) {
            $warnings[] = [
                'type' => 'High Blood Sugar',
                'message' => 'Elevated blood sugar detected. Limit refined carbohydrates and sugary foods. Consult a healthcare provider.',
                'severity' => 'high',
            ];
        } elseif ($analysis->blood_sugar >= 100) {
            $warnings[] = [
                'type' => 'Pre-diabetic Range',
                'message' => 'Your blood sugar is in the pre-diabetic range. Focus on whole grains and reduce sugar intake.',
                'severity' => 'medium',
            ];
        }

        // Cholesterol Warnings
        if ($analysis->cholesterol >= 240) {
            $warnings[] = [
                'type' => 'High Cholesterol',
                'message' => 'High cholesterol detected. Increase fiber intake, eat more omega-3 rich foods, and reduce saturated fats.',
                'severity' => 'high',
            ];
        } elseif ($analysis->cholesterol >= 200) {
            $warnings[] = [
                'type' => 'Borderline High Cholesterol',
                'message' => 'Your cholesterol is borderline high. Focus on heart-healthy foods and regular exercise.',
                'severity' => 'medium',
            ];
        }

        // BMI Warnings
        if ($analysis->bmi >= 30) {
            $warnings[] = [
                'type' => 'Obesity',
                'message' => 'Your BMI indicates obesity. Consider consulting a nutritionist for a personalized meal plan.',
                'severity' => 'high',
            ];
        } elseif ($analysis->bmi >= 25) {
            $warnings[] = [
                'type' => 'Overweight',
                'message' => 'Your BMI indicates you are overweight. Focus on portion control and regular physical activity.',
                'severity' => 'medium',
            ];
        } elseif ($analysis->bmi < 18.5) {
            $warnings[] = [
                'type' => 'Underweight',
                'message' => 'Your BMI indicates you are underweight. Ensure adequate calorie and nutrient intake.',
                'severity' => 'medium',
            ];
        }

        return $warnings;
    }

    /**
     * Get health summary and recommendations
     * 
     * @param Analysis $analysis
     * @return array Summary data
     */
    public function getHealthSummary(Analysis $analysis): array
    {
        $category = $this->getBMICategory($analysis->bmi);
        $warnings = $this->generateHealthWarnings($analysis);
        
        return [
            'bmi' => $analysis->bmi,
            'category' => $category,
            'category_color' => $this->getCategoryColor($category),
            'warnings' => $warnings,
            'risk_level' => $this->calculateRiskLevel($analysis),
        ];
    }

    /**
     * Get color code for BMI category
     * 
     * @param string $category
     * @return string Tailwind color class
     */
    private function getCategoryColor(string $category): string
    {
        return match($category) {
            'Underweight' => 'text-yellow-600',
            'Normal' => 'text-green-600',
            'Overweight' => 'text-orange-600',
            'Obese' => 'text-red-600',
            default => 'text-gray-600',
        };
    }

    /**
     * Calculate overall health risk level
     * 
     * @param Analysis $analysis
     * @return string Risk level (low, medium, high)
     */
    private function calculateRiskLevel(Analysis $analysis): string
    {
        $riskScore = 0;

        // BMI risk
        if ($analysis->bmi < 18.5 || $analysis->bmi >= 30) {
            $riskScore += 2;
        } elseif ($analysis->bmi >= 25) {
            $riskScore += 1;
        }

        // Blood pressure risk
        if ($analysis->blood_pressure_systolic >= 140) {
            $riskScore += 2;
        } elseif ($analysis->blood_pressure_systolic >= 130) {
            $riskScore += 1;
        }

        // Blood sugar risk
        if ($analysis->blood_sugar >= 126) {
            $riskScore += 2;
        } elseif ($analysis->blood_sugar >= 100) {
            $riskScore += 1;
        }

        // Cholesterol risk
        if ($analysis->cholesterol >= 240) {
            $riskScore += 2;
        } elseif ($analysis->cholesterol >= 200) {
            $riskScore += 1;
        }

        if ($riskScore >= 5) {
            return 'high';
        } elseif ($riskScore >= 3) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    /**
     * Predict diet recommendation using Naive Bayes-inspired approach
     * Based on user's health condition
     * 
     * @param Analysis $analysis
     * @return string Diet type recommendation (Balanced, Low_Carb, Low_Sodium, High_Protein)
     */
    public function predictDietType(Analysis $analysis): string
    {
        $scores = [
            'Balanced' => 0,
            'Low_Carb' => 0,
            'Low_Sodium' => 0,
            'High_Protein' => 0,
        ];

        // BMI-based scoring
        if ($analysis->bmi >= 30) {
            // Obesity - prefer Low Carb for weight loss
            $scores['Low_Carb'] += 30;
            $scores['High_Protein'] += 20;
        } elseif ($analysis->bmi >= 25) {
            // Overweight
            $scores['Low_Carb'] += 20;
            $scores['Balanced'] += 15;
            $scores['High_Protein'] += 10;
        } elseif ($analysis->bmi < 18.5) {
            // Underweight - need more calories
            $scores['Balanced'] += 25;
            $scores['High_Protein'] += 25;
        } else {
            // Normal BMI
            $scores['Balanced'] += 30;
        }

        // Blood Pressure-based scoring
        if ($analysis->blood_pressure_systolic >= 140 || $analysis->blood_pressure_diastolic >= 90) {
            // Hypertension - MUST have Low Sodium
            $scores['Low_Sodium'] += 40;
        } elseif ($analysis->blood_pressure_systolic >= 130) {
            $scores['Low_Sodium'] += 25;
            $scores['Balanced'] += 10;
        }

        // Blood Sugar-based scoring
        if ($analysis->blood_sugar >= 126) {
            // Diabetic range - Low Carb is essential
            $scores['Low_Carb'] += 40;
        } elseif ($analysis->blood_sugar >= 100) {
            // Pre-diabetic
            $scores['Low_Carb'] += 25;
            $scores['Balanced'] += 10;
        }

        // Cholesterol-based scoring
        if ($analysis->cholesterol >= 240) {
            $scores['Low_Carb'] += 15;
            $scores['Balanced'] += 10;
        }

        // Activity level adjustment
        if ($analysis->activity_level === 'sedentary') {
            $scores['Low_Carb'] += 10;
        } elseif ($analysis->activity_level === 'active' || $analysis->activity_level === 'very_active') {
            $scores['High_Protein'] += 15;
            $scores['Balanced'] += 10;
        }

        // Health goal consideration
        if ($analysis->health_goal === 'lose_weight') {
            $scores['Low_Carb'] += 20;
            $scores['High_Protein'] += 10;
        } elseif ($analysis->health_goal === 'gain_muscle') {
            $scores['High_Protein'] += 30;
        } elseif ($analysis->health_goal === 'maintain') {
            $scores['Balanced'] += 20;
        }

        // Get the diet type with highest score
        arsort($scores);
        $predictedDiet = array_key_first($scores);

        return $predictedDiet;
    }

    /**
     * Get disease/condition based on health metrics
     * 
     * @param Analysis $analysis
     * @return array List of detected conditions
     */
    public function detectHealthConditions(Analysis $analysis): array
    {
        $conditions = [];

        // Diabetes detection
        if ($analysis->blood_sugar >= 126) {
            $conditions[] = 'Diabetes';
        }

        // Hypertension detection
        if ($analysis->blood_pressure_systolic >= 140 || $analysis->blood_pressure_diastolic >= 90) {
            $conditions[] = 'Hypertension';
        }

        // Obesity detection
        if ($analysis->bmi >= 30) {
            $conditions[] = 'Obesity';
        }

        // High Cholesterol
        if ($analysis->cholesterol >= 240) {
            $conditions[] = 'High_Cholesterol';
        }

        if (empty($conditions)) {
            $conditions[] = 'None';
        }

        return $conditions;
    }

    /**
     * Calculate daily caloric needs
     * Using Mifflin-St Jeor Equation
     * 
     * @param Analysis $analysis
     * @return int Recommended daily calories
     */
    public function calculateDailyCalories(Analysis $analysis): int
    {
        // BMR calculation
        if (strtolower($analysis->gender) === 'male') {
            $bmr = (10 * $analysis->weight) + (6.25 * $analysis->height) - (5 * $analysis->age) + 5;
        } else {
            $bmr = (10 * $analysis->weight) + (6.25 * $analysis->height) - (5 * $analysis->age) - 161;
        }

        // Activity multiplier
        $activityMultipliers = [
            'sedentary' => 1.2,
            'lightly_active' => 1.375,
            'moderately_active' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
        ];

        $multiplier = $activityMultipliers[$analysis->activity_level] ?? 1.2;
        $tdee = $bmr * $multiplier;

        // Adjust based on health goal
        if ($analysis->health_goal === 'lose_weight') {
            $tdee *= 0.85; // 15% deficit
        } elseif ($analysis->health_goal === 'gain_weight' || $analysis->health_goal === 'gain_muscle') {
            $tdee *= 1.15; // 15% surplus
        }

        return (int) round($tdee);
    }

    /**
     * Calculate ideal weight based on height
     * Using BMI 22 (middle of normal range 18.5-24.9)
     * 
     * @param float $height Height in cm
     * @return array ['min' => min_weight, 'ideal' => ideal_weight, 'max' => max_weight] all in kg
     */
    public function calculateIdealWeight(float $height): array
    {
        $heightInMeters = $height / 100;
        
        // Normal BMI range is 18.5 - 24.9
        // Min weight = 18.5 × height²
        $minWeight = round(18.5 * ($heightInMeters * $heightInMeters), 1);
        
        // Ideal weight = 22 × height² (middle of normal range)
        $idealWeight = round(22 * ($heightInMeters * $heightInMeters), 1);
        
        // Max weight = 24.9 × height²
        $maxWeight = round(24.9 * ($heightInMeters * $heightInMeters), 1);
        
        return [
            'min' => $minWeight,
            'ideal' => $idealWeight,
            'max' => $maxWeight,
        ];
    }
}
