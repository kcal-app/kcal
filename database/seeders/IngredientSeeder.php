<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_ingredients = [
            [
                'name' => 'black beans',
                'unit' => 'cup',
                'calories' => 236,
                'protein' => 15.9,
                'fat' => 0.972,
                'carbohydrates' => 42.3
            ],
            [
                'name' => 'egg white',
                'calories' => 17.2,
                'protein' => 3.6,
                'fat' => 0.056,
                'carbohydrates' => 0.241
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
                'name' => 'rice, brown (cooked)',
                'unit' => 'cup',
                'calories' => 238,
                'protein' => 5.32,
                'fat' => 1.87,
                'carbohydrates' => 49.6
            ],
        ];
        Ingredient::factory()->createMany($default_ingredients);
    }
}
