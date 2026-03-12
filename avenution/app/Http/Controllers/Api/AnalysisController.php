<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Analysis;
use App\Models\User;
use App\Services\BodyAnalysisService;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnalysisController extends Controller
{
    protected $bodyAnalysisService;
    protected $recommendationService;

    public function __construct(
        BodyAnalysisService $bodyAnalysisService,
        RecommendationService $recommendationService
    ) {
        $this->bodyAnalysisService = $bodyAnalysisService;
        $this->recommendationService = $recommendationService;
    }

    /**
     * Store a new body analysis and generate recommendations
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required_without:user_id|string|max:255',
            'email' => 'required_without:user_id|email|max:255',
            'age' => 'required|integer|min:10|max:120',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:20|max:300',
            'height' => 'required|numeric|min:100|max:250',
            'activity_level' => 'required|in:sedentary,light,moderate,active,very_active',
            'goal' => 'required|in:weight_loss,maintain,muscle_gain',
            'blood_pressure_systolic' => 'nullable|integer|min:70|max:250',
            'blood_pressure_diastolic' => 'nullable|integer|min:40|max:150',
            'blood_sugar' => 'nullable|numeric|min:50|max:500',
            'cholesterol' => 'nullable|numeric|min:100|max:400',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get or create user
            $userId = $request->user_id;
            if (!$userId) {
                // Create guest user or find existing by email
                $user = User::firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name' => $request->name,
                        'password' => bcrypt('guest123'), // Default password for guests
                    ]
                );
                $userId = $user->id;
            }

            // Calculate BMI
            $bmi = $this->bodyAnalysisService->calculateBMI(
                $request->weight,
                $request->height
            );

            $bmiCategory = $this->bodyAnalysisService->getBMICategory($bmi);

            // Create analysis record with basic data first
            $analysis = Analysis::create([
                'user_id' => $userId,
                'age' => $request->age,
                'gender' => $request->gender,
                'weight' => $request->weight,
                'height' => $request->height,
                'bmi' => $bmi,
                'bmi_category' => $bmiCategory,
                'activity_level' => $request->activity_level,
                'goal' => $request->goal,
                'blood_pressure_systolic' => $request->blood_pressure_systolic,
                'blood_pressure_diastolic' => $request->blood_pressure_diastolic,
                'blood_sugar' => $request->blood_sugar,
                'cholesterol' => $request->cholesterol,
            ]);

            // Now calculate everything using the Analysis model
            $dailyCalories = $this->bodyAnalysisService->calculateDailyCalories($analysis);
            $dietType = $this->bodyAnalysisService->predictDietType($analysis);
            $conditions = $this->bodyAnalysisService->detectHealthConditions($analysis);

            // Update analysis with predictions
            $analysis->update([
                'predicted_diet_type' => $dietType,
                'health_conditions' => json_encode($conditions),
                'daily_calorie_target' => $dailyCalories,
            ]);

            // Generate food recommendations
            $recommendations = $this->recommendationService->generateRecommendations($analysis);
            
            // Save recommendations to database
            $this->recommendationService->saveRecommendations($analysis, $recommendations);

            // Load recommendations with food details
            $analysis->load(['recommendations.food', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Analysis completed successfully',
                'data' => [
                    'analysis' => [
                        'id' => $analysis->id,
                        'bmi' => round($bmi, 2),
                        'bmi_category' => $bmiCategory,
                        'predicted_diet_type' => $dietType,
                        'health_conditions' => $conditions,
                        'daily_calorie_target' => $dailyCalories,
                        'created_at' => $analysis->created_at->toDateTimeString(),
                    ],
                    'recommendations' => $analysis->recommendations->map(function ($rec) {
                        return [
                            'id' => $rec->id,
                            'score' => $rec->match_score,
                            'food' => [
                                'id' => $rec->food->id,
                                'name' => $rec->food->name,
                                'emoji' => $rec->food->emoji,
                                'category' => $rec->food->category,
                                'calories' => $rec->food->calories,
                                'protein' => $rec->food->protein,
                                'carbs' => $rec->food->carbs,
                                'fat' => $rec->food->fat,
                                'fiber' => $rec->food->fiber,
                                'sodium' => $rec->food->sodium,
                                'sugars' => $rec->food->sugars,
                                'meal_type' => $rec->food->meal_type,
                                'image_url' => $rec->food->image_url,
                            ],
                        ];
                    }),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process analysis',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get analysis by ID with recommendations
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $analysis = Analysis::with(['recommendations.food', 'user'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'analysis' => [
                        'id' => $analysis->id,
                        'user' => [
                            'name' => $analysis->user->name,
                            'email' => $analysis->user->email,
                        ],
                        'age' => $analysis->age,
                        'gender' => $analysis->gender,
                        'weight' => $analysis->weight,
                        'height' => $analysis->height,
                        'bmi' => round($analysis->bmi, 2),
                        'bmi_category' => $analysis->bmi_category,
                        'activity_level' => $analysis->activity_level,
                        'goal' => $analysis->goal,
                        'blood_pressure_systolic' => $analysis->blood_pressure_systolic,
                        'blood_pressure_diastolic' => $analysis->blood_pressure_diastolic,
                        'blood_sugar' => $analysis->blood_sugar,
                        'cholesterol' => $analysis->cholesterol,
                        'predicted_diet_type' => $analysis->predicted_diet_type,
                        'health_conditions' => json_decode($analysis->health_conditions),
                        'daily_calorie_target' => $analysis->daily_calorie_target,
                        'created_at' => $analysis->created_at->toDateTimeString(),
                    ],
                    'recommendations' => $analysis->recommendations->map(function ($rec) {
                        return [
                            'id' => $rec->id,
                            'score' => $rec->match_score,
                            'food' => [
                                'id' => $rec->food->id,
                                'name' => $rec->food->name,
                                'emoji' => $rec->food->emoji,
                                'category' => $rec->food->category,
                                'calories' => $rec->food->calories,
                                'protein' => $rec->food->protein,
                                'carbs' => $rec->food->carbs,
                                'fat' => $rec->food->fat,
                                'fiber' => $rec->food->fiber,
                                'sodium' => $rec->food->sodium,
                                'sugars' => $rec->food->sugars,
                                'meal_type' => $rec->food->meal_type,
                                'image_url' => $rec->food->image_url,
                            ],
                        ];
                    }),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Analysis not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get user's analysis history
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $analyses = Analysis::where('user_id', $request->user_id)
                ->with('recommendations.food')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $analyses->map(function ($analysis) {
                    return [
                        'id' => $analysis->id,
                        'bmi' => round($analysis->bmi, 2),
                        'bmi_category' => $analysis->bmi_category,
                        'predicted_diet_type' => $analysis->predicted_diet_type,
                        'health_conditions' => json_decode($analysis->health_conditions),
                        'recommendations_count' => $analysis->recommendations->count(),
                        'created_at' => $analysis->created_at->toDateTimeString(),
                    ];
                }),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
