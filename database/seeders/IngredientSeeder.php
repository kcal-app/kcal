<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_ingredients = [
            [
                'name' => 'baking powder',
                'unit' => 'tsp',
                'calories' => 2.44,
                'protein' => 0,
                'fat' => 0,
                'carbohydrates' => 1.27
            ],
            [
                'name' => 'egg',
                'calories' => 71.5,
                'protein' => 6.28,
                'fat' => 4.76,
                'carbohydrates' => 0.36
            ],
            [
                'name' => 'flour, all-purpose',
                'unit' => 'cup',
                'calories' => 455,
                'protein' => 12.9,
                'fat' => 1.22,
                'carbohydrates' => 95.4
            ],
            [
                'name' => 'milk, whole',
                'unit' => 'cup',
                'calories' => 146,
                'protein' => 8,
                'fat' => 7.81,
                'carbohydrates' => 11.4
            ],
            [
                'name' => 'salt',
                'unit' => 'tsp',
                'calories' => 0,
                'protein' => 0,
                'fat' => 0,
                'carbohydrates' => 0
            ],
            [
                'name' => 'sugar, white',
                'unit' => 'cup',
                'calories' => 770,
                'protein' => 0,
                'fat' => 0.54,
                'carbohydrates' => 199
            ],
            [
                'name' => 'vegetable oil',
                'unit' => 'tbsp',
                'calories' => 124,
                'protein' => 0,
                'fat' => 14,
                'carbohydrates' => 199
            ],
        ];
        Ingredient::factory()->createMany($default_ingredients);
    }
}
