<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analysis;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get user's analyses
        $analyses = $user->analyses()->latest()->take(5)->get();
        $totalAnalyses = $user->analyses()->count();
        
        // Calculate average BMI
        $avgBMI = $user->analyses()->avg('bmi');
        
        // Get latest analysis
        $latestAnalysis = $user->analyses()->latest()->first();
        
        return view('dashboard', compact(
            'user',
            'analyses',
            'totalAnalyses',
            'avgBMI',
            'latestAnalysis'
        ));
    }
}
