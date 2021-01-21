<?php

namespace App\Http\Controllers;

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
        return view('recipes.edit')
            ->with('recipe', $recipe)
            ->with('ingredients_units', new Collection([
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
            'ingredients_amount' => ['required', 'array', new ArrayNotEmpty],
            'ingredients_amount.*' => ['required_with:ingredients.*', 'nullable', new StringIsDecimalOrFraction],
            'ingredients_unit' => ['required', 'array'],
            'ingredients_unit.*' => 'nullable|string',
            'ingredients_detail' => ['required', 'array'],
            'ingredients_detail.*' => 'nullable|string',
            'ingredients' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.*' => 'required_with:ingredients_amount.*|nullable|exists:App\Models\Food,id',
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
                foreach (array_filter($input['ingredients_amount']) as $key => $amount) {
                    $food_amounts[$key] = $recipe->foodAmounts[$key] ?? new FoodAmount();
                    $food_amounts[$key]->fill([
                        'amount' => Number::floatFromString($amount),
                        'unit' => $input['ingredients_unit'][$key],
                        'detail' => $input['ingredients_detail'][$key],
                        'weight' => $weight++,
                    ]);
                    $food_amounts[$key]->food()->associate($input['ingredients'][$key]);
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
