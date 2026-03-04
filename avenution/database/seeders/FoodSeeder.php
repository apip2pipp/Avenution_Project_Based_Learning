<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = [
            // Breakfast
            [
                'name' => 'Oatmeal with Berries',
                'category' => 'breakfast',
                'calories' => 320,
                'protein' => 12.0,
                'carbs' => 54.0,
                'fat' => 6.0,
                'fiber' => 8.0,
                'description' => 'Steel-cut oats topped with fresh mixed berries and a drizzle of honey',
                'dietary_tags' => ['vegetarian', 'high-fiber', 'heart-healthy'],
                'health_benefits' => ['High fiber', 'Antioxidants', 'Heart-healthy', 'Blood pressure support'],
                'emoji' => '🥣',
            ],
            [
                'name' => 'Greek Yogurt Parfait',
                'category' => 'breakfast',
                'calories' => 220,
                'protein' => 18.0,
                'carbs' => 28.0,
                'fat' => 4.0,
                'fiber' => 3.0,
                'description' => 'Low-fat Greek yogurt layered with granola and fresh fruits',
                'dietary_tags' => ['vegetarian', 'probiotic', 'calcium-rich'],
                'health_benefits' => ['Probiotics', 'Bone health', 'Calcium-rich', 'High protein'],
                'emoji' => '🫙',
            ],
            [
                'name' => 'Avocado Toast with Egg',
                'category' => 'breakfast',
                'calories' => 380,
                'protein' => 16.0,
                'carbs' => 32.0,
                'fat' => 20.0,
                'fiber' => 9.0,
                'description' => 'Whole grain toast topped with mashed avocado and poached egg',
                'dietary_tags' => ['vegetarian', 'healthy-fats'],
                'health_benefits' => ['Healthy fats', 'High fiber', 'Protein-rich', 'Heart-healthy'],
                'emoji' => '🥑',
            ],
            [
                'name' => 'Banana Smoothie Bowl',
                'category' => 'breakfast',
                'calories' => 290,
                'protein' => 8.0,
                'carbs' => 52.0,
                'fat' => 7.0,
                'fiber' => 6.0,
                'description' => 'Blended banana smoothie bowl topped with nuts and seeds',
                'dietary_tags' => ['vegan', 'gluten-free'],
                'health_benefits' => ['Energy boost', 'Potassium-rich', 'Antioxidants'],
                'emoji' => '🍌',
            ],
            
            // Lunch
            [
                'name' => 'Grilled Salmon & Quinoa',
                'category' => 'lunch',
                'calories' => 480,
                'protein' => 38.0,
                'carbs' => 42.0,
                'fat' => 14.0,
                'fiber' => 5.0,
                'description' => 'Grilled Atlantic salmon fillet with quinoa and steamed vegetables',
                'dietary_tags' => ['gluten-free', 'omega-3-rich'],
                'health_benefits' => ['Omega-3', 'Complete protein', 'Low glycemic', 'Heart-healthy'],
                'emoji' => '🐟',
            ],
            [
                'name' => 'Mediterranean Chicken Bowl',
                'category' => 'lunch',
                'calories' => 420,
                'protein' => 32.0,
                'carbs' => 38.0,
                'fat' => 12.0,
                'fiber' => 7.0,
                'description' => 'Grilled chicken with chickpeas, cucumber, tomatoes, and tahini',
                'dietary_tags' => ['high-protein', 'mediterranean'],
                'health_benefits' => ['High protein', 'Heart-healthy', 'Balanced nutrition'],
                'emoji' => '🍗',
            ],
            [
                'name' => 'Brown Rice Veggie Bowl',
                'category' => 'lunch',
                'calories' => 360,
                'protein' => 14.0,
                'carbs' => 58.0,
                'fat' => 8.0,
                'fiber' => 10.0,
                'description' => 'Brown rice with roasted vegetables and tofu',
                'dietary_tags' => ['vegan', 'high-fiber'],
                'health_benefits' => ['High fiber', 'Low cholesterol', 'Plant-based protein'],
                'emoji' => '🍚',
            ],
            [
                'name' => 'Turkey Wrap with Hummus',
                'category' => 'lunch',
                'calories' => 340,
                'protein' => 26.0,
                'carbs' => 35.0,
                'fat' => 10.0,
                'fiber' => 6.0,
                'description' => 'Whole wheat wrap with lean turkey, hummus, and fresh veggies',
                'dietary_tags' => ['high-protein', 'low-fat'],
                'health_benefits' => ['Lean protein', 'High fiber', 'Low saturated fat'],
                'emoji' => '🌯',
            ],
            
            // Dinner
            [
                'name' => 'Vegetable Stir-fry with Tofu',
                'category' => 'dinner',
                'calories' => 380,
                'protein' => 24.0,
                'carbs' => 35.0,
                'fat' => 12.0,
                'fiber' => 9.0,
                'description' => 'Mixed vegetables and firm tofu stir-fried in light soy sauce',
                'dietary_tags' => ['vegan', 'low-sodium'],
                'health_benefits' => ['Plant protein', 'Low sodium', 'High vitamins', 'Cholesterol reduction'],
                'emoji' => '🥦',
            ],
            [
                'name' => 'Grilled Chicken Breast',
                'category' => 'dinner',
                'calories' => 310,
                'protein' => 42.0,
                'carbs' => 8.0,
                'fat' => 12.0,
                'fiber' => 2.0,
                'description' => 'Herb-marinated grilled chicken breast with steamed broccoli',
                'dietary_tags' => ['high-protein', 'low-carb', 'keto-friendly'],
                'health_benefits' => ['High protein', 'Low carb', 'Muscle building'],
                'emoji' => '🍗',
            ],
            [
                'name' => 'Lentil Curry',
                'category' => 'dinner',
                'calories' => 350,
                'protein' => 18.0,
                'carbs' => 48.0,
                'fat' => 8.0,
                'fiber' => 12.0,
                'description' => 'Red lentil curry with aromatic spices and coconut milk',
                'dietary_tags' => ['vegan', 'high-fiber', 'gluten-free'],
                'health_benefits' => ['High fiber', 'Plant protein', 'Iron-rich'],
                'emoji' => '🍛',
            ],
            [
                'name' => 'Baked Cod with Vegetables',
                'category' => 'dinner',
                'calories' => 290,
                'protein' => 34.0,
                'carbs' => 18.0,
                'fat' => 8.0,
                'fiber' => 5.0,
                'description' => 'Lemon-herb baked cod with roasted root vegetables',
                'dietary_tags' => ['low-calorie', 'high-protein'],
                'health_benefits' => ['Low calorie', 'High protein', 'Omega-3'],
                'emoji' => '🐟',
            ],
            
            // Snacks
            [
                'name' => 'Mixed Nuts & Seeds',
                'category' => 'snack',
                'calories' => 180,
                'protein' => 6.0,
                'carbs' => 8.0,
                'fat' => 14.0,
                'fiber' => 3.0,
                'description' => 'Raw almonds, walnuts, pumpkin seeds mix',
                'dietary_tags' => ['vegan', 'gluten-free', 'healthy-fats'],
                'health_benefits' => ['Healthy fats', 'Protein', 'Heart-healthy'],
                'emoji' => '🥜',
            ],
            [
                'name' => 'Apple Slices with Almond Butter',
                'category' => 'snack',
                'calories' => 200,
                'protein' => 5.0,
                'carbs' => 24.0,
                'fat' => 10.0,
                'fiber' => 5.0,
                'description' => 'Fresh apple slices with natural almond butter',
                'dietary_tags' => ['vegan', 'gluten-free'],
                'health_benefits' => ['Fiber', 'Healthy fats', 'Energy boost'],
                'emoji' => '🍎',
            ],
            [
                'name' => 'Carrot Sticks with Hummus',
                'category' => 'snack',
                'calories' => 120,
                'protein' => 4.0,
                'carbs' => 16.0,
                'fat' => 5.0,
                'fiber' => 4.0,
                'description' => 'Fresh carrot sticks with chickpea hummus',
                'dietary_tags' => ['vegan', 'low-calorie'],
                'health_benefits' => ['Low calorie', 'Vitamin A', 'Fiber'],
                'emoji' => '🥕',
            ],
            [
                'name' => 'Green Smoothie',
                'category' => 'snack',
                'calories' => 150,
                'protein' => 6.0,
                'carbs' => 28.0,
                'fat' => 2.0,
                'fiber' => 5.0,
                'description' => 'Spinach, banana, and almond milk smoothie',
                'dietary_tags' => ['vegan', 'low-fat'],
                'health_benefits' => ['Vitamins', 'Antioxidants', 'Energy'],
                'emoji' => '🥤',
            ],
        ];

        foreach ($foods as $food) {
            Food::firstOrCreate(
                ['name' => $food['name']],
                $food
            );
        }
    }
}
