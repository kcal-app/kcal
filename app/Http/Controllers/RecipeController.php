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
        // Pre-populate relationships from form data or current recipe.
        $ingredients = [];
        if ($old = old('ingredients')) {
            foreach ($old['id'] as $key => $food_id) {
                if (empty($food_id)) {
                    continue;
                }
                $ingredients[] = [
                    'original_key' => $old['original_key'][$key],
                    'amount' => $old['amount'][$key],
                    'unit' => $old['unit'][$key],
                    'food_id' => $food_id,
                    'food_name' => $old['name'][$key],
                    'detail' => $old['detail'][$key],
                ];
            }
        }
        else {
            foreach ($recipe->foodAmounts as $key => $foodAmount) {
                $ingredients[] = [
                    'original_key' => $key,
                    'amount' => $foodAmount->amount_formatted,
                    'unit' => $foodAmount->unit,
                    'food_id' => $foodAmount->food->id,
                    'food_name' => $foodAmount->food->name,
                    'detail' => $foodAmount->detail,
                ];
            }
        }

        $steps = [];
        if ($old = old('steps')) {
            foreach ($old['step'] as $key => $step) {
                if (empty($step)) {
                    continue;
                }
                $steps[] = [
                    'original_key' => $old['original_key'][$key],
                    'step_default' => $step,
                ];
            }
        }
        else {
            foreach ($recipe->steps as $key => $step) {
                $steps[] = [
                    'original_key' => $key,
                    'step_default' => $step->step,
                ];
            }
        }

        return view('recipes.edit')
            ->with('recipe', $recipe)
            ->with('ingredients', $ingredients)
            ->with('steps', $steps)
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
            'ingredients.amount' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.amount.*' => ['required_with:ingredients.id.*', 'nullable', new StringIsDecimalOrFraction],
            'ingredients.unit' => ['required', 'array'],
            'ingredients.unit.*' => 'nullable|string',
            'ingredients.detail' => ['required', 'array'],
            'ingredients.detail.*' => 'nullable|string',
            'ingredients.id' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.id.*' => 'required_with:ingredients.amount.*|nullable|exists:App\Models\Food,id',
            'ingredients.original_key' => 'nullable|array',
            'steps.step' => ['required', 'array', new ArrayNotEmpty],
            'steps.step.*' => 'nullable|string',
            'steps.original_key' => 'nullable|array',
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

                // Delete any removed ingredients.
                $removed = array_diff($recipe->foodAmounts->keys()->all(), $input['ingredients']['original_key']);
                foreach ($removed as $removed_key) {
                    $recipe->foodAmounts[$removed_key]->delete();
                }

                // Add/update current ingredients.
                $food_amounts = [];
                $weight = 0;
                foreach (array_filter($input['ingredients']['id']) as $key => $food_id) {
                    if (!is_null($input['ingredients']['original_key'][$key])) {
                        $food_amounts[$key] = $recipe->foodAmounts[$input['ingredients']['original_key'][$key]];
                    }
                    else {
                        $food_amounts[$key] = new FoodAmount();
                    }
                    $food_amounts[$key]->fill([
                        'amount' => Number::floatFromString($input['ingredients']['amount'][$key]),
                        'unit' => $input['ingredients']['unit'][$key],
                        'detail' => $input['ingredients']['detail'][$key],
                        'weight' => $weight++,
                    ]);
                    $food_amounts[$key]->food()->associate($food_id);
                }
                $recipe->foodAmounts()->saveMany($food_amounts);

                $steps = [];
                $number = 1;

                // Delete any removed steps.
                $removed = array_diff($recipe->steps->keys()->all(), $input['steps']['original_key']);
                foreach ($removed as $removed_key) {
                    $recipe->steps[$removed_key]->delete();
                }

                foreach (array_filter($input['steps']['step']) as $key => $step) {
                    if (!is_null($input['steps']['original_key'][$key])) {
                        $steps[$key] = $recipe->steps[$input['steps']['original_key'][$key]];
                    }
                    else {
                        $steps[$key] = new RecipeStep();
                    }
                    $steps[$key]->fill(['number' => $number++, 'step' => $step]);
                }
                $recipe->steps()->saveMany($steps);
            });
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors($e->getMessage());
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
