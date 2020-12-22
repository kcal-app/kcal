<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientAmount;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::factory()->create(['name' => 'pancakes']);

        $weight = 0;
        $amounts = [
            [
                'ingredient_id' => Ingredient::where('name', 'flour, all-purpose')
                    ->first()->id,
                'amount' => 1,
                'unit' => 'cup',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Ingredient::where('name', 'sugar, white')
                    ->first()->id,
                'amount' => 2,
                'unit' => 'tbsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Ingredient::where('name', 'baking powder')
                    ->first()->id,
                'amount' => 2,
                'unit' => 'tsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Ingredient::where('name', 'salt')
                    ->first()->id,
                'amount' => 1,
                'unit' => 'tsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Ingredient::where('name', 'egg')
                    ->first()->id,
                'amount' => 1,
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Ingredient::where('name', 'milk, whole')
                    ->first()->id,
                'amount' => 1,
                'unit' => 'cup',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Ingredient::where('name', 'vegetable oil')
                    ->first()->id,
                'amount' => 2,
                'unit' => 'tbsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
        ];
        IngredientAmount::factory()->createMany($amounts);
    }
}
