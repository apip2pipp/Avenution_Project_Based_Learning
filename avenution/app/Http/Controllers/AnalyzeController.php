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
        return view('analyze');
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
