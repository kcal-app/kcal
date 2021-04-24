<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFoodRequest;
use App\Models\Food;
use App\Support\Number;
use App\Support\Nutrients;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
    public function store(UpdateFoodRequest $request): RedirectResponse
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
                ['value' => 'oz', 'label' => 'oz'],
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food): RedirectResponse
    {
        $attributes = $request->validated();

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
