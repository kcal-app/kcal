<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Rules\StringIsDecimalOrFraction;
use App\Support\Number;
use App\Support\Nutrients;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('foods.index')->with('tags', Food::getTagTotals());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return $this->edit(new Food());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->update($request, new Food());
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food): View
    {
        return view('foods.show')->with('food', $food);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food): View
    {
        // Convert string tags (from old form data) to a Collection.
        $food_tags = old('tags', $food->tags->pluck('name'));
        if (is_string($food_tags)) {
            $food_tags = new Collection(explode(',', $food_tags));
        }

        return view('foods.edit')
            ->with('food', $food)
            ->with('food_tags', $food_tags)
            ->with('serving_units', new Collection([
                ['value' => 'tsp', 'label' => 'tsp.'],
                ['value' => 'tbsp', 'label' => 'tbsp.'],
                ['value' => 'cup', 'label' => 'cup'],
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Food $food): RedirectResponse
    {
        $attributes = $request->validate([
            'name' => 'required|string',
            'detail' => 'nullable|string',
            'brand' => 'nullable|string',
            'source' => 'nullable|string',
            'notes' => 'nullable|string',
            'serving_size' => ['required', new StringIsDecimalOrFraction],
            'serving_unit' => 'nullable|string',
            'serving_unit_name' => 'nullable|string',
            'serving_weight' => 'required|numeric',
            'calories' => 'nullable|numeric',
            'fat' => 'nullable|numeric',
            'cholesterol' => 'nullable|numeric',
            'sodium' => 'nullable|numeric',
            'carbohydrates' => 'nullable|numeric',
            'protein' => 'nullable|numeric',
        ]);
        $attributes['serving_size'] = Number::floatFromString($attributes['serving_size']);
        $attributes['name'] = Str::lower($attributes['name']);

        // Default nutrients to zero.
        foreach (Nutrients::all()->pluck('value') as $nutrient) {
            if (is_null($attributes[$nutrient])) {
                $attributes[$nutrient] = 0;
            }
        }

        $food->fill($attributes)->save();

        $tags = $request->get('tags', []);
        if (!empty($tags)) {
            $food->syncTags(explode(',', $tags));
        }
        elseif ($food->tags->isNotEmpty()) {
            $food->detachTags($food->tags);
        }

        // Refresh and index updated tags.
        $food->fresh()->searchable();

        session()->flash('message', "Food {$food->name} updated!");
        return redirect()->route('foods.show', $food);
    }

    /**
     * Confirm removal of specified resource.
     */
    public function delete(Food $food): View
    {
        return view('foods.delete')->with('food', $food);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food): RedirectResponse
    {
        // Remove the food from any recipes.
        foreach ($food->ingredientAmountRelationships as $ia) {
            $ia->delete();
        }
        $food->delete();
        return redirect(route('foods.index'))
            ->with('message', "Food {$food->name} deleted!");
    }
}
