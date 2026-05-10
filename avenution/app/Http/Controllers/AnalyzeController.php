<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnalyzeRequest;
use App\Services\AnalysisProcessingService;
use App\Services\PendingAnalysisService;

class AnalyzeController extends Controller
{
    public function __construct(
        protected AnalysisProcessingService $analysisProcessingService,
        protected PendingAnalysisService $pendingAnalysisService
    ) {
    }

    public function index()
    {
        $title = 'Analyze — Avenution';
        $metaDescription = 'Input your health data to get personalized food recommendations powered by AI.';
        $ogImage = asset('images/food.png');

        return view('analyze', compact('title', 'metaDescription', 'ogImage'));
    }

    public function analyze(AnalyzeRequest $request)
    {
        $validatedPayload = $request->validated();

        if (! auth()->check()) {
            $this->pendingAnalysisService->remember($request, $validatedPayload);

            return redirect()
                ->route('login')
                ->with('status', 'Please login or register first to see your recommendations. Your form data has been saved.');
        }

        $analysis = $this->analysisProcessingService->process($validatedPayload, $request->user());

        // Redirect to results page
        return redirect()->route('result.show', ['sessionId' => $analysis->session_id])
            ->with('success', 'Analysis completed successfully!');
    }
}
