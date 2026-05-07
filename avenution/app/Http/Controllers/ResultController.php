<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analysis;
use App\Models\Food;
use App\Services\BodyAnalysisService;
use App\Services\RecommendationService;

class ResultController extends Controller
{
    protected $bodyAnalysisService;
    protected $recommendationService;

    public function __construct(
        BodyAnalysisService $bodyAnalysisService,
        RecommendationService $recommendationService
    )
    {
        $this->bodyAnalysisService = $bodyAnalysisService;
        $this->recommendationService = $recommendationService;
    }

    public function show($sessionId)
    {
        $analysis = Analysis::where('session_id', $sessionId)
            ->with(['recommendations.food'])
            ->firstOrFail();

        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (! $user->hasRole('admin') && (int) $analysis->user_id !== (int) $user->id) {
            abort(403, 'You are not authorized to view this analysis result.');
        }

        // Self-heal old analyses that were created while foods data was empty.
        if ($analysis->recommendations->isEmpty() && Food::query()->exists()) {
            $recommendations = $this->recommendationService->generateRecommendations($analysis);

            if (!empty($recommendations)) {
                $this->recommendationService->saveRecommendations($analysis, $recommendations);
                $analysis->load(['recommendations.food']);
            }
        }

        $healthSummary = $this->bodyAnalysisService->getHealthSummary($analysis);
        $warnings = $this->bodyAnalysisService->generateHealthWarnings($analysis);
        $idealWeight = $this->bodyAnalysisService->calculateIdealWeight($analysis->height);

        return view('result', compact('analysis', 'healthSummary', 'warnings', 'idealWeight'));
    }
}
