<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientAmount;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::factory()->create([
            'name' => 'pancakes',
            'description' => 'Basic pancakes in two steps.',
            'servings' => 4,
        ]);

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

        $steps = [
            [
                'recipe_id' => $recipe->id,
                'number' => 1,
                'step' => 'In a large bowl, mix flour, sugar, baking powder and salt. Make a well in the center, and pour in milk, egg and oil. Mix until smooth.',
            ],
            [
                'recipe_id' => $recipe->id,
                'number' => 2,
                'step' => 'Heat a lightly oiled griddle or frying pan over medium high heat. Pour or scoop the batter onto the griddle, using approximately 1/4 cup for each pancake. Brown on both sides and serve hot.',
            ]
        ];
        RecipeStep::factory()->createMany($steps);
    }
}
