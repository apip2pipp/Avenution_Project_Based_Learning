<?php

namespace App\Services;

use App\Models\Analysis;
use App\Models\Food;
use App\Models\Recommendation;

class RecommendationService
{
    /**
     * Generate food recommendations based on analysis
     * Uses simplified Naive Bayes approach with rule-based filtering
     * 
     * @param Analysis $analysis
     * @return array Array of recommendations with food data
     */
    public function generateRecommendations(Analysis $analysis): array
    {
        $allFoods = Food::all();
        $scoredFoods = [];

        foreach ($allFoods as $food) {
            $score = $this->calculateMatchScore($food, $analysis);
            
            if ($score > 70) { // Only include foods with >70% match
                $scoredFoods[] = [
                    'food' => $food,
                    'score' => $score,
                    'timing' => $this->determineMealTiming($food->category),
                ];
            }
        }

        // Sort by score (highest first)
        usort($scoredFoods, function($a, $b) {
            return $b['score'] - $a['score'];
        });

        // Group by timing and select top foods for each meal
        $recommendations = [];
        $timings = ['morning', 'afternoon', 'evening', 'snack'];
        
        foreach ($timings as $timing) {
            $timingFoods = array_filter($scoredFoods, fn($item) => $item['timing'] === $timing);
            $topFood = reset($timingFoods);
            
            if ($topFood) {
                $recommendations[] = $topFood;
            }
        }

        // If we have less than 4 recommendations, add more top-scored foods
        if (count($recommendations) < 4) {
            $remaining = array_slice($scoredFoods, 0, 6);
            foreach ($remaining as $item) {
                if (count($recommendations) >= 6) break;
                if (!in_array($item, $recommendations)) {
                    $recommendations[] = $item;
                }
            }
        }

        return $recommendations;
    }

    /**
     * Calculate match score for a food based on user's health profile
     * Simplified Naive Bayes-inspired scoring
     * 
     * @param Food $food
     * @param Analysis $analysis
     * @return int Match score (0-100)
     */
    private function calculateMatchScore(Food $food, Analysis $analysis): int
    {
        $score = 75; // Base score

        // BMI-based adjustments
        if ($analysis->bmi < 18.5) {
            // Underweight - prefer higher calorie foods
            if ($food->calories > 350) $score += 10;
            if ($food->protein > 20) $score += 5;
        } elseif ($analysis->bmi >= 25) {
            // Overweight/Obese - prefer lower calorie, high fiber foods
            if ($food->calories < 350) $score += 10;
            if ($food->fiber >= 8) $score += 8;
            if ($food->fiber >= 5) $score += 5;
        }

        // Blood pressure adjustments
        if ($analysis->blood_pressure_systolic >= 130) {
            // High BP - prefer low sodium, heart-healthy foods
            if (in_array('heart-healthy', $food->health_benefits ?? [])) $score += 10;
            if (in_array('low-sodium', $food->dietary_tags ?? [])) $score += 8;
        }

        // Blood sugar adjustments
        if ($analysis->blood_sugar >= 100) {
            // High blood sugar - prefer low glycemic foods
            if ($food->fiber >= 5) $score += 10;
            if ($food->carbs < 40) $score += 8;
            if (in_array('Low glycemic', $food->health_benefits ?? [])) $score += 8;
        }

        // Cholesterol adjustments
        if ($analysis->cholesterol >= 200) {
            // High cholesterol - prefer omega-3, high fiber
            if (in_array('Omega-3', $food->health_benefits ?? [])) $score += 10;
            if (in_array('Cholesterol reduction', $food->health_benefits ?? [])) $score += 10;
            if ($food->fiber >= 8) $score += 5;
        }

        // Dietary restriction matching
        if ($analysis->dietary_restriction !== 'none') {
            $dietaryTags = $food->dietary_tags ?? [];
            
            if ($analysis->dietary_restriction === 'vegetarian') {
                if (in_array('vegetarian', $dietaryTags) || in_array('vegan', $dietaryTags)) {
                    $score += 15;
                } else {
                    $score -= 30; // Significant penalty for non-matching
                }
            } elseif ($analysis->dietary_restriction === 'vegan') {
                if (in_array('vegan', $dietaryTags)) {
                    $score += 15;
                } else {
                    $score -= 30;
                }
            } elseif ($analysis->dietary_restriction === 'gluten-free') {
                if (in_array('gluten-free', $dietaryTags)) {
                    $score += 10;
                }
            }
        }

        // Health goal matching
        switch ($analysis->health_goal) {
            case 'weight_loss':
                if ($food->calories < 300) $score += 10;
                if ($food->fiber >= 5) $score += 5;
                if ($food->protein > 15) $score += 5;
                break;
            
            case 'muscle_gain':
                if ($food->protein > 25) $score += 15;
                if ($food->calories > 350) $score += 5;
                break;
            
            case 'heart_health':
                if (in_array('Heart-healthy', $food->health_benefits ?? [])) $score += 15;
                if (in_array('Omega-3', $food->health_benefits ?? [])) $score += 10;
                break;
            
            case 'balanced':
            default:
                // Prefer balanced macros
                if ($food->protein >= 15 && $food->protein <= 30) $score += 5;
                if ($food->fiber >= 5) $score += 5;
                break;
        }

        // Activity level adjustments
        if ($analysis->activity_level === 'high' && $food->calories > 400) {
            $score += 5;
        } elseif ($analysis->activity_level === 'low' && $food->calories < 300) {
            $score += 5;
        }

        // Ensure score is within bounds
        return max(0, min(100, $score));
    }

    /**
     * Determine meal timing based on food category
     * 
     * @param string $category
     * @return string Timing (morning, afternoon, evening, snack)
     */
    private function determineMealTiming(string $category): string
    {
        return match($category) {
            'breakfast' => 'morning',
            'lunch' => 'afternoon',
            'dinner' => 'evening',
            'snack' => 'snack',
            default => 'afternoon',
        };
    }

    /**
     * Save recommendations to database
     * 
     * @param Analysis $analysis
     * @param array $recommendations
     * @return void
     */
    public function saveRecommendations(Analysis $analysis, array $recommendations): void
    {
        foreach ($recommendations as $recommendation) {
            Recommendation::create([
                'analysis_id' => $analysis->id,
                'food_id' => $recommendation['food']->id,
                'match_score' => $recommendation['score'],
                'timing' => $recommendation['timing'],
            ]);
        }
    }
}
