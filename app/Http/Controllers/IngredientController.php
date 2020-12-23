<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('ingredients.create');
    }

    /**
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
        /** @var \App\Models\Ingredient $ingredient */
        $ingredient = tap(new Ingredient(array_filter($attributes)))->save();
        return redirect()->back()->with('message', "Ingredient {$ingredient->name} added!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingredient $ingredient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        //
    }
}
