<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analysis;
use App\Services\BodyAnalysisService;

class ResultController extends Controller
{
    protected $bodyAnalysisService;

    public function __construct(BodyAnalysisService $bodyAnalysisService)
    {
        $this->bodyAnalysisService = $bodyAnalysisService;
    }

    public function show($sessionId)
    {
        $analysis = Analysis::where('session_id', $sessionId)
            ->with(['recommendations.food'])
            ->firstOrFail();

        $healthSummary = $this->bodyAnalysisService->getHealthSummary($analysis);
        $warnings = $this->bodyAnalysisService->generateHealthWarnings($analysis);

        return view('result', compact('analysis', 'healthSummary', 'warnings'));
    }
}
