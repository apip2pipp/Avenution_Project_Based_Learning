<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Analysis;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalAnalyses' => Analysis::count(),
            'totalFoods' => Food::count(),
        ];

        $analysisQuery = Analysis::with(['user', 'recommendations']);
        
        // Search by user name or email
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $analysisQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        
        $allowedSortColumns = ['created_at', 'bmi', 'bmi_category'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'created_at';
        }
        
        $analysisQuery->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->input('per_page', 10);
        $recentAnalyses = $analysisQuery->paginate($perPage)->appends($request->query());

        return view('admin.dashboard', compact('stats', 'recentAnalyses'));
    }
}
