<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (disable foreign key checks first)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Food::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("📦 Importing makanan Indonesia dari 2 dataset...");
        $this->command->newLine();

        // Import from nutrition.csv (bahan mentah)
        $this->command->info("1️⃣ Import dari nutrition.csv (bahan mentah)...");
        $count1 = $this->importNutritionCSV();
        
        // Import from nilai-gizi.csv (produk olahan + detailed nutrition)
        $this->command->info("2️⃣ Import dari nilai-gizi.csv (produk olahan + fiber + sodium)...");
        $count2 = $this->importNilaiGiziCSV();

        $this->command->newLine();
        $this->command->info("✅ Total berhasil import " . ($count1 + $count2) . " makanan!");
        $this->command->info("   📊 nutrition.csv: {$count1} items");
        $this->command->info("   📊 nilai-gizi.csv: {$count2} items");
    }

    /**
     * Import from nutrition.csv (original dataset - 1346 foods)
     */
    private function importNutritionCSV(): int
    {
        $csvPath = storage_path('app/datasets/nutrition.csv');
        
        if (!File::exists($csvPath)) {
            $this->command->error("File nutrition.csv tidak ditemukan!");
            return 0;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header
        
        $foods = [];
        $count = 0;
        $existingNames = [];

        while (($row = fgetcsv($file)) !== false) {
            // CSV: id,calories,proteins,fat,carbohydrate,name,image
            $name = $row[5] ?? 'Unknown';
            
            // Skip duplicates
            $nameLower = strtolower(trim($name));
            if (isset($existingNames[$nameLower])) {
                continue;
            }
            $existingNames[$nameLower] = true;

            $calories = (int) ($row[1] ?? 0);
            $protein = (float) ($row[2] ?? 0);
            $fat = (float) ($row[3] ?? 0);
            $carbs = (float) ($row[4] ?? 0);
            $imageUrl = $row[6] ?? null;

            $category = $this->determineCategory($name);
            $mealType = $this->determineMealType($name);
            $emoji = $this->determineEmoji($category, $name);
            
            // Estimate fiber for nutrition.csv (tidak punya data fiber)
            $fiber = $this->estimateFiber($category, $calories, $carbs);

            $foods[] = [
                'name' => $name,
                'category' => $category,
                'calories' => $calories,
                'protein' => $protein,
                'carbs' => $carbs,
                'fat' => $fat,
                'fiber' => $fiber,
                'sugars' => null,
                'sodium' => null,
                'cholesterol' => null,
                'meal_type' => $mealType,
                'image_url' => $imageUrl,
                'emoji' => $emoji,
                'dietary_tags' => json_encode([]),
                'health_benefits' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $count++;

            if (count($foods) >= 100) {
                Food::insert($foods);
                $foods = [];
                $this->command->info("   Imported {$count} foods...");
            }
        }

        if (count($foods) > 0) {
            Food::insert($foods);
        }

        fclose($file);
        return $count;
    }

    /**
     * Import from nilai-gizi.csv (detailed nutrition with fiber & sodium)
     */
    private function importNilaiGiziCSV(): int
    {
        $csvPath = storage_path('app/datasets/nilai-gizi.csv');
        
        if (!File::exists($csvPath)) {
            $this->command->warn("File nilai-gizi.csv tidak ditemukan, skip...");
            return 0;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header
        
        $foods = [];
        $count = 0;
        
        // Get existing food names to prevent duplicates
        $existingNames = Food::pluck('name')->map(fn($n) => strtolower(trim($n)))->toArray();

        while (($row = fgetcsv($file)) !== false) {
            // CSV columns: name,manufacturer,serving_size,energy_kcal,protein_g,carbohydrate_g,fat_g,sugar_g,sodium_mg,fiber_g,...
            $name = $row[0] ?? 'Unknown';
            $servingSizeStr = $row[2] ?? '100 g';
            
            // Skip duplicates
            $nameLower = strtolower(trim($name));
            if (in_array($nameLower, $existingNames)) {
                continue;
            }
            $existingNames[] = $nameLower;

            // Parse serving size (e.g., "20.30 g", "1 g", "15 g")
            $servingSize = $this->parseServingSize($servingSizeStr);
            
            // Get nutrition values (per serving)
            $calories = (float) ($row[3] ?? 0);
            $protein = (float) ($row[4] ?? 0);
            $carbs = (float) ($row[5] ?? 0);
            $fat = (float) ($row[6] ?? 0);
            $sugar = (float) ($row[7] ?? 0);
            $sodium = (float) ($row[8] ?? 0);
            $fiber = (float) ($row[9] ?? 0);

            // Normalize to per 100g with smart validation
            // Skip normalization if serving size is too small (likely already per 100g or data error)
            // or if result would be unrealistic (> 100g for macros)
            if ($servingSize > 0 && $servingSize != 100 && $servingSize >= 10) {
                $multiplier = 100 / $servingSize;
                
                // Test if normalization would create unrealistic values
                $testCarbs = $carbs * $multiplier;
                $testProtein = $protein * $multiplier;
                $testFat = $fat * $multiplier;
                
                // Only normalize if values remain realistic (max 100g per 100g is reasonable)
                if ($testCarbs <= 100 && $testProtein <= 100 && $testFat <= 100) {
                    $calories = round($calories * $multiplier, 1);
                    $protein = round($protein * $multiplier, 2);
                    $carbs = round($carbs * $multiplier, 2);
                    $fat = round($fat * $multiplier, 2);
                    $sugar = round($sugar * $multiplier, 2);
                    $sodium = round($sodium * $multiplier, 2);
                    $fiber = round($fiber * $multiplier, 2);
                }
                // If unrealistic, assume values are already per 100g, use as-is
            }

            $category = $this->determineCategory($name);
            $mealType = $this->determineMealType($name);
            $emoji = $this->determineEmoji($category, $name);

            // Additional validation: skip if macros are unrealistic (likely data error)
            if ($carbs > 100 || $protein > 100 || $fat > 100 || $calories > 1000) {
                continue; // Skip this food item
            }

            $foods[] = [
                'name' => $name,
                'category' => $category,
                'calories' => (int) $calories,
                'protein' => $protein,
                'carbs' => $carbs,
                'fat' => $fat,
                'fiber' => $fiber > 0 ? $fiber : null,
                'sugars' => $sugar > 0 ? $sugar : null,
                'sodium' => $sodium > 0 ? $sodium : null,
                'cholesterol' => null, // nilai-gizi.csv tidak punya cholesterol
                'meal_type' => $mealType,
                'image_url' => null,
                'emoji' => $emoji,
                'dietary_tags' => json_encode([]),
                'health_benefits' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $count++;

            if (count($foods) >= 100) {
                Food::insert($foods);
                $foods = [];
                $this->command->info("   Imported {$count} foods...");
            }
        }

        if (count($foods) > 0) {
            Food::insert($foods);
        }

        fclose($file);
        return $count;
    }

    /**
     * Parse serving size string to get gram value
     * Examples: "20.30 g" -> 20.30, "1 g" -> 1, "15 g" -> 15
     */
    private function parseServingSize(string $servingSizeStr): float
    {
        // Remove "g" and any spaces, convert to float
        $cleaned = trim(str_replace(['g', 'G'], '', $servingSizeStr));
        return (float) $cleaned ?: 100; // Default to 100g if parsing fails
    }

    /**
     * Determine food category based on name
     */
    private function determineCategory(string $name): string
    {
        $name = strtolower($name);

        // Sayuran (Vegetables)
        if (str_contains($name, 'sayur') || str_contains($name, 'bayam') || 
            str_contains($name, 'kangkung') || str_contains($name, 'sawi') ||
            str_contains($name, 'brokoli') || str_contains($name, 'wortel') ||
            str_contains($name, 'tomat') || str_contains($name, 'timun') ||
            str_contains($name, 'terong') || str_contains($name, 'labu') ||
            str_contains($name, 'kol') || str_contains($name, 'kubis') ||
            str_contains($name, 'selada') || str_contains($name, 'lobak')) {
            return 'Sayuran';
        }

        // Buah (Fruits)
        if (str_contains($name, 'buah') || str_contains($name, 'pisang') || 
            str_contains($name, 'apel') || str_contains($name, 'jeruk') ||
            str_contains($name, 'mangga') || str_contains($name, 'anggur') ||
            str_contains($name, 'pepaya') || str_contains($name, 'semangka') ||
            str_contains($name, 'melon') || str_contains($name, 'durian') ||
            str_contains($name, 'rambutan') || str_contains($name, 'salak') ||
            str_contains($name, 'jambu') || str_contains($name, 'nanas') ||
            str_contains($name, 'bengkuang') || str_contains($name, 'belimbing')) {
            return 'Buah';
        }

        // Protein Hewani (Animal Protein)
        if (str_contains($name, 'ayam') || str_contains($name, 'sapi') || 
            str_contains($name, 'ikan') || str_contains($name, 'daging') ||
            str_contains($name, 'kambing') || str_contains($name, 'bebek') ||
            str_contains($name, 'telur') || str_contains($name, 'udang') ||
            str_contains($name, 'cumi') || str_contains($name, 'kepiting') ||
            str_contains($name, 'salmon') || str_contains($name, 'tuna') ||
            str_contains($name, 'lele') || str_contains($name, 'gurame') ||
            str_contains($name, 'bandeng') || str_contains($name, 'tongkol')) {
            return 'Protein Hewani';
        }

        // Protein Nabati (Plant Protein)
        if (str_contains($name, 'tahu') || str_contains($name, 'tempe') || 
            str_contains($name, 'kacang') || str_contains($name, 'oncom') ||
            str_contains($name, 'kedelai') || str_contains($name, 'ampas')) {
            return 'Protein Nabati';
        }

        // Karbohidrat (Carbohydrates)
        if (str_contains($name, 'nasi') || str_contains($name, 'roti') || 
            str_contains($name, 'mie') || str_contains($name, 'bihun') ||
            str_contains($name, 'kentang') || str_contains($name, 'singkong') ||
            str_contains($name, 'ubi') || str_contains($name, 'jagung') ||
            str_contains($name, 'gandum') || str_contains($name, 'pasta') ||
            str_contains($name, 'talas') || str_contains($name, 'sagu')) {
            return 'Karbohidrat';
        }

        // Dairy
        if (str_contains($name, 'susu') || str_contains($name, 'keju') || 
            str_contains($name, 'yogurt') || str_contains($name, 'yoghurt')) {
            return 'Dairy';
        }

        return 'Lainnya';
    }

    /**
     * Determine meal type based on name and category
     */
    private function determineMealType(string $name): string
    {
        $name = strtolower($name);

        // Breakfast foods
        if (str_contains($name, 'roti') || str_contains($name, 'telur') || 
            str_contains($name, 'bubur') || str_contains($name, 'oat')) {
            return 'Sarapan';
        }

        // Snacks
        if (str_contains($name, 'kue') || str_contains($name, 'biskuit') || 
            str_contains($name, 'cemilan') || str_contains($name, 'gorengan') ||
            str_contains($name, 'keripik')) {
            return 'Camilan';
        }

        // Default to main meal
        return 'Makan Utama';
    }

    /**
     * Determine emoji based on category
     */
    private function determineEmoji(string $category, string $name): string
    {
        return match($category) {
            'Sayuran' => '🥬',
            'Buah' => '🍎',
            'Protein Hewani' => '🍗',
            'Protein Nabati' => '🥜',
            'Karbohidrat' => '🍚',
            'Dairy' => '🥛',
            default => '🍽️',
        };
    }

    /**
     * Estimate fiber content based on category and nutrition
     * Since nutrition.csv doesn't have fiber data
     */
    private function estimateFiber(string $category, int $calories, float $carbs): float
    {
        // Rough estimation based on category and carbs
        return match($category) {
            'Sayuran' => max(2.0, $carbs * 0.3), // Vegetables are high in fiber
            'Buah' => max(1.5, $carbs * 0.2), // Fruits have moderate fiber
            'Protein Nabati' => max(3.0, $carbs * 0.25), // Plant proteins high in fiber
            'Karbohidrat' => $carbs * 0.1, // Refined carbs lower fiber
            'Protein Hewani' => 0, // Animal protein has no fiber
            'Dairy' => 0, // Dairy has no fiber
            default => $carbs * 0.05, // Unknown, minimal estimation
        };
    }

    /**
     * Old dummy data for reference (commented out)
     */
    private function oldDummyData(): array
    {
        return $foods = [
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
    }
}
