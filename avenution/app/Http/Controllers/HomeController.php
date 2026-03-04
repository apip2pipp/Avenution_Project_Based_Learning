<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Analysis;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => '50,000+',
            'accuracy' => '98%',
            'foods' => Food::count() . '+',
            'rating' => '4.9★',
        ];

        return view('landing', compact('stats'));
    }
}
