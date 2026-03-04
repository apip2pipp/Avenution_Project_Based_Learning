<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analysis;

class HistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $analyses = $user->analyses()
            ->with('recommendations.food')
            ->latest()
            ->paginate(10);
        
        return view('history', compact('analyses'));
    }
}
