<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientAmount;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
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
        $ingredients = Ingredient::all(['id', 'name', 'detail'])->collect()
            ->map(function ($ingredient) {
                return [
                    'value' => $ingredient->id,
                    'label' => "{$ingredient->name}" . ($ingredient->detail ? ", {$ingredient->detail}" : ""),
                ];
            });
        return view('recipes.create')
            ->with('ingredients', $ingredients)
            ->with('ingredient_units', new Collection([
                ['value' => 'tsp', 'label' => 'tsp.'],
                ['value' => 'tbsp', 'label' => 'tbsp.'],
                ['value' => 'cup', 'label' => 'cup'],
                ['value' => 'g', 'label' => 'g'],
            ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'servings' => 'required|numeric',
            'ingredients_amount' => 'required|array',
            'ingredients_amount.*' => 'required_with:ingredients.*|nullable|numeric|min:0',
            'ingredients_unit' => 'required|array',
            'ingredients_unit.*' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required_with:ingredients_amount.*|nullable|exists:App\Models\Ingredient,id',
        ]);

        $recipe = new Recipe([
            'name' => $input['name'],
            'description' => $input['description'],
            'servings' => (int) $input['servings'],
        ]);

        try {
            DB::transaction(function () use ($recipe, $input) {
                if (!$recipe->save()) {
                    return;
                }
                $ingredient_amounts = [];
                foreach (array_filter($input['ingredients_amount']) as $key => $amount) {
                    $ingredient_amounts[$key] = new IngredientAmount([
                        'amount' => (float) $amount,
                        'unit' => $input['ingredients_unit'][$key],
                        'weight' => (int) $key,
                    ]);
                    $ingredient_amounts[$key]->recipe()->associate($recipe);
                    $ingredient_amounts[$key]->ingredient()->associate($input['ingredients'][$key]);
                }
                $recipe->ingredientAmounts()->saveMany($ingredient_amounts);
            });
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors("Failed to add recipe due to database error: {$e->getMessage()}.");
        }

        return back()->with('message', "Recipe {$recipe->name} added!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
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
