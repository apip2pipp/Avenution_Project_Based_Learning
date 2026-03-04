<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::latest()->paginate(15);
        return view('admin.foods.index', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.foods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request)
    {
        Food::create($request->validated());

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        return view('admin.foods.show', compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        $food->update($request->validated());

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item deleted successfully!');
    }
}
