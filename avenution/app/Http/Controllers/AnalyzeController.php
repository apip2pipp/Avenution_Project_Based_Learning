<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnalyzeRequest;
use App\Models\Analysis;
use App\Services\BodyAnalysisService;
use App\Services\RecommendationService;
use Illuminate\Support\Str;

class AnalyzeController extends Controller
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

    public function index()
    {
        return view('analyze');
    }

    public function analyze(AnalyzeRequest $request)
    {
        // Calculate BMI
        $bmi = $this->bodyAnalysisService->calculateBMI(
            $request->weight,
            $request->height
        );

        $bmiCategory = $this->bodyAnalysisService->getBMICategory($bmi);

        // Generate unique session ID for tracking
        $sessionId = Str::uuid()->toString();

        // Create analysis record
        $analysis = Analysis::create([
            'user_id' => auth()->id(), // null for guests
            'session_id' => $sessionId,
            'age' => $request->age,
            'weight' => $request->weight,
            'height' => $request->height,
            'gender' => $request->gender,
            'blood_pressure_systolic' => $request->blood_pressure_systolic,
            'blood_pressure_diastolic' => $request->blood_pressure_diastolic,
            'blood_sugar' => $request->blood_sugar,
            'cholesterol' => $request->cholesterol,
            'activity_level' => $request->activity_level,
            'dietary_restriction' => $request->dietary_restriction,
            'health_goal' => $request->health_goal,
            'bmi' => $bmi,
            'bmi_category' => $bmiCategory,
        ]);

        // Generate food recommendations
        $recommendations = $this->recommendationService->generateRecommendations($analysis);

        // Save recommendations
        $this->recommendationService->saveRecommendations($analysis, $recommendations);

        // Redirect to results page
        return redirect()->route('result.show', ['sessionId' => $sessionId])
            ->with('success', 'Analysis completed successfully!');
    }
}
