<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Analysis;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $foodsCount = 0;
        if (Schema::hasTable('foods')) {
            try {
                $foodsCount = Food::count();
            } catch (\Throwable $e) {
                $foodsCount = 0;
            }
        }

        $stats = [
            'users' => '50,000+',
            'accuracy' => '98%',
            'foods' => $foodsCount . '+',
            'rating' => '4.9★',
        ];

        $title = 'Avenution — Smart Food Recommendations';
        $metaDescription = 'Avenution uses advanced AI to analyze your health metrics and deliver personalized nutrition plans tailored to your body.';
        $ogImage = asset('images/hero.png');

        return view('landing', compact('stats', 'title', 'metaDescription', 'ogImage'));
    }
}
