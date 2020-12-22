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
                'calories' => 53,
                'protein' => 0,
                'fat' => 0,
                'carbohydrates' => 27.7,
                'cup_weight' => 220.8,
            ],
            [
                'name' => 'egg',
                'detail' => 'large',
                'calories' => 147,
                'protein' => 12.4,
                'fat' => 9.96,
                'carbohydrates' => 0.96,
                'unit_weight' => 50.3,
            ],
            [
                'name' => 'flour',
                'detail' => 'all-purpose',
                'calories' => 364,
                'protein' => 10.33,
                'fat' => 0.98,
                'carbohydrates' => 76.31,
                'cup_weight' => 125,
            ],
            [
                'name' => 'milk',
                'detail' => 'whole',
                'calories' => 60,
                'protein' => 3.28,
                'fat' => 3.2,
                'carbohydrates' => 4.67,
                'cup_weight' => 244,
            ],
            [
                'name' => 'salt',
                'detail' => 'table',
                'calories' => 0,
                'protein' => 0,
                'fat' => 0,
                'carbohydrates' => 0,
                'cup_weight' => 292,
            ],
            [
                'name' => 'sugar',
                'detail' => 'white',
                'calories' => 385,
                'protein' => 0,
                'fat' => 0.32,
                'carbohydrates' => 99.6,
                'cup_weight' => 200,
            ],
            [
                'name' => 'vegetable oil',
                'calories' => 886,
                'protein' => 0,
                'fat' => 100,
                'carbohydrates' => 0,
                'cup_weight' => 224,
            ],
        ];
        Ingredient::factory()->createMany($default_ingredients);
    }
}
