<?php

namespace App\Exports;

use App\Exports\Sheets\AnalysisRecommendationDetailSheet;
use App\Exports\Sheets\AnalysisSummarySheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnalysesExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new AnalysisSummarySheet(),
            new AnalysisRecommendationDetailSheet(),
        ];
    }
}