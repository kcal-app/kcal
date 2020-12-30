<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('foods.index')
            ->with('foods', Food::all()->sortBy('name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('foods.create');
    }

    /**newly
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
           'name' => 'required|string',
           'detail' => 'nullable|string',
           'carbohydrates' => 'nullable|numeric',
           'calories' => 'nullable|numeric',
           'cholesterol' => 'nullable|numeric',
           'fat' => 'nullable|numeric',
           'protein' => 'nullable|numeric',
           'sodium' => 'nullable|numeric',
           'unit_weight' => 'required_without:cup_weight|nullable|numeric',
           'cup_weight' => 'required_without:unit_weight|nullable|numeric',
        ]);
        /** @var \App\Models\Food $food */
        $food = tap(new Food(array_filter($attributes)))->save();
        return back()->with('message', "Food {$food->name} added!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        //
    }
}
