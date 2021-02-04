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
        return view('foods.index');
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
            ->with('nutrients', Nutrients::$all)
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
        $food->fill($attributes)->save();

        // Sync tags.
        if ($tags = $request->get('tags')) {
            $food->syncTags(explode(',', $tags));
        }

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
        if ($food->ingredientAmountChildren()->count()) {
            return back()->withErrors('Cannot delete: this food is used in recipes.');
        }
        $food->delete();
        return redirect(route('foods.index'))
            ->with('message', "Food {$food->name} deleted!");
    }
}
