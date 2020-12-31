<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\FoodAmount;
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
                'food_id' => Food::where('name', 'flour')
                    ->first()->id,
                'amount' => 4.25,
                'unit' => 'oz',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'food_id' => Food::where('name', 'sugar')
                    ->first()->id,
                'amount' => 2,
                'unit' => 'tbsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'food_id' => Food::where('name', 'baking powder')
                    ->first()->id,
                'amount' => 2,
                'unit' => 'tsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'food_id' => Food::where('name', 'salt')
                    ->first()->id,
                'amount' => 1,
                'unit' => 'tsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'food_id' => Food::where('name', 'egg')
                    ->first()->id,
                'amount' => 1,
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'food_id' => Food::where('name', 'milk')
                    ->first()->id,
                'amount' => 1,
                'unit' => 'cup',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'food_id' => Food::where('name', 'vegetable oil')
                    ->first()->id,
                'amount' => 2,
                'unit' => 'tbsp',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
        ];
        FoodAmount::factory()->createMany($amounts);

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
                'food_id' => Food::where('name', 'peanut butter')
                    ->first()->id,
                'amount' => 2,
                'unit' => 'cup',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
            [
                'food_id' => Food::where('name', 'canned corn')
                    ->first()->id,
                'amount' => 15.25,
                'unit' => 'oz',
                'recipe_id' => $recipe->id,
                'weight' => $weight++,
            ],
        ];
        FoodAmount::factory()->createMany($amounts);

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
