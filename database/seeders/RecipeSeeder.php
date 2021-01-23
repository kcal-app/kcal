<?php

namespace Database\Seeders;

use App\Models\Food;
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
                'ingredient_id' => Food::where('name', 'flour')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 4.25,
                'unit' => 'oz',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Food::where('name', 'sugar')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 2,
                'unit' => 'tbsp',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Food::where('name', 'baking powder')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 2,
                'unit' => 'tsp',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Food::where('name', 'salt')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 1,
                'unit' => 'tsp',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Food::where('name', 'egg')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 1,
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Food::where('name', 'milk')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 1,
                'unit' => 'cup',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Food::where('name', 'vegetable oil')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 2,
                'unit' => 'tbsp',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight,
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

        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::factory()->create([
            'name' => 'peanut butter corn',
            'description' => 'Peanut butter and corn -- YUM',
            'servings' => 4,
        ]);

        $weight = 0;
        $amounts = [
            [
                'ingredient_id' => Food::where('name', 'peanut butter')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 2,
                'unit' => 'cup',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight++,
            ],
            [
                'ingredient_id' => Food::where('name', 'canned corn')
                    ->first()->id,
                'ingredient_type' => Food::class,
                'amount' => 15.25,
                'unit' => 'oz',
                'parent_id' => $recipe->id,
                'parent_type' => Recipe::class,
                'weight' => $weight,
            ],
        ];
        IngredientAmount::factory()->createMany($amounts);

        $steps = [
            [
                'recipe_id' => $recipe->id,
                'number' => 1,
                'step' => 'Mix it together.',
            ],
            [
                'recipe_id' => $recipe->id,
                'number' => 2,
                'step' => 'Eat it.',
            ]
        ];
        RecipeStep::factory()->createMany($steps);
    }
}
