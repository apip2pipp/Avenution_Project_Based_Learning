<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Analysis;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalAnalyses' => Analysis::count(),
            'totalFoods' => Food::count(),
        ];

        $recentAnalyses = Analysis::with(['user', 'recommendations'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAnalyses'));
    }
}
