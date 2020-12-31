<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_foods = [
            [
                'name' => 'baking powder',
                'calories' => 53,
                'carbohydrates' => 27.7,
                'sodium' => 10.6,
                'cup_weight' => 220.8,
            ],
            [
                'name' => 'egg',
                'detail' => 'large',
                'calories' => 147,
                'carbohydrates' => 0.96,
                'cholesterol' => 0.411,
                'fat' => 9.96,
                'protein' => 12.4,
                'sodium' => 0.129,
                'unit_weight' => 50.3,
            ],
            [
                'name' => 'flour',
                'detail' => 'all-purpose',
                'calories' => 364,
                'carbohydrates' => 76.31,
                'fat' => 0.98,
                'protein' => 10.33,
                'sodium' => 0.004,
                'cup_weight' => 125,
            ],
            [
                'name' => 'milk',
                'detail' => 'whole',
                'calories' => 60,
                'carbohydrates' => 4.67,
                'cholesterol' => 0.012,
                'fat' => 3.2,
                'protein' => 3.28,
                'sodium' => 0.038,
                'cup_weight' => 244,
            ],
            [
                'name' => 'salt',
                'detail' => 'table',
                'sodium' => 38.758,
                'cup_weight' => 292,
            ],
            [
                'name' => 'sugar',
                'detail' => 'white',
                'calories' => 385,
                'carbohydrates' => 99.6,
                'fat' => 0.32,
                'protein' => 0,
                'sodium' => 0.001,
                'cup_weight' => 200,
            ],
            [
                'name' => 'vegetable oil',
                'calories' => 886,
                'fat' => 100,
                'cup_weight' => 224,
            ],
            [
                'name' => 'peanut butter',
                'detail' => 'Kirkland organic creamy',
                'calories' => 562.5,
                'fat' => 46.875,
                'sodium' => 0.203125,
                'carbohydrates' => 21.875,
                'protein' => 25,
                'cup_weight' => 256,
            ],
        ];
        Food::factory()->createMany($default_foods);
    }
}
