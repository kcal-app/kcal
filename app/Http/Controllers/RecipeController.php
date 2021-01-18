<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodAmount;
use App\Models\Recipe;
use App\Models\RecipeStep;
use App\Rules\ArrayNotEmpty;
use App\Rules\StringIsDecimalOrFraction;
use App\Support\Number;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('recipes.index')
            ->with('recipes', Recipe::all()->sortBy('name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return $this->edit(new Recipe());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->update($request, new Recipe());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Recipe $recipe): View
    {
        return view('recipes.show')->with('recipe', $recipe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Recipe $recipe): View
    {
        $foods = Food::all(['id', 'name', 'detail'])->sortBy('name')->collect()
            ->map(function ($food) {
                return [
                    'value' => $food->id,
                    'label' => "{$food->name}" . ($food->detail ? ", {$food->detail}" : ""),
                ];
            });
        return view('recipes.edit')
            ->with('recipe', $recipe)
            ->with('foods', $foods)
            ->with('food_units', new Collection([
                ['value' => 'tsp', 'label' => 'tsp.'],
                ['value' => 'tbsp', 'label' => 'tbsp.'],
                ['value' => 'cup', 'label' => 'cup'],
                ['value' => 'oz', 'label' => 'oz'],
                ['value' => 'grams', 'label' => 'g'],
            ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Recipe $recipe
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable
     */
    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $input = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'source' => 'nullable|string',
            'servings' => 'required|numeric',
            'foods_amount' => ['required', 'array', new ArrayNotEmpty],
            'foods_amount.*' => ['required_with:foods.*', 'nullable', new StringIsDecimalOrFraction],
            'foods_unit' => ['required', 'array'],
            'foods_unit.*' => 'nullable|string',
            'foods_detail' => ['required', 'array'],
            'foods_detail.*' => 'nullable|string',
            'foods' => ['required', 'array', new ArrayNotEmpty],
            'foods.*' => 'required_with:foods_amount.*|nullable|exists:App\Models\Food,id',
            'steps' => ['required', 'array', new ArrayNotEmpty],
            'steps.*' => 'nullable|string',
        ]);

        $recipe->fill([
            'name' => Str::lower($input['name']),
            'description' => $input['description'],
            'source' => $input['source'],
            'servings' => (int) $input['servings'],
        ]);

        try {
            DB::transaction(function () use ($recipe, $input) {
                if (!$recipe->save()) {
                    return;
                }

                $food_amounts = [];
                $weight = 0;
                // TODO: Handle removals.
                foreach (array_filter($input['foods_amount']) as $key => $amount) {
                    $food_amounts[$key] = $recipe->foodAmounts[$key] ?? new FoodAmount();
                    $food_amounts[$key]->fill([
                        'amount' => Number::floatFromString($amount),
                        'unit' => $input['foods_unit'][$key],
                        'detail' => $input['foods_detail'][$key],
                        'weight' => $weight++,
                    ]);
                    $food_amounts[$key]->food()->associate($input['foods'][$key]);
                }
                $recipe->foodAmounts()->saveMany($food_amounts);

                $steps = [];
                $number = 1;
                // TODO: Handle removals.
                foreach (array_filter($input['steps']) as $key => $step) {
                    $steps[$key] = $recipe->steps[$key] ?? new RecipeStep();
                    $steps[$key]->fill(['number' => $number++, 'step' => $step]);
                }
                $recipe->foodAmounts()->saveMany($steps);
            });
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors("Failed to updated recipe due to database error: {$e->getMessage()}.");
        }

        session()->flash('message', "Recipe {$recipe->name} updated!");
        return redirect()->route('recipes.show', $recipe);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
