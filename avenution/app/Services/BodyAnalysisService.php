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
}
