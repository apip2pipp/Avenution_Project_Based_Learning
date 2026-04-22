<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AnalysesExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AnalysisExportController extends Controller
{
    public function download(): BinaryFileResponse
    {
        $fileName = 'analysis-report-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(new AnalysesExport(), $fileName);
    }
}