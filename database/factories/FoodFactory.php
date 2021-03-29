<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = Food::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'detail' => $this->faker->sentence(2),
            'brand' => $this->faker->word,
            'source' => $this->faker->url,
            'notes' => $this->faker->paragraph,
            'serving_size' => $this->faker->randomFloat(2, 1/2, 5),
            'serving_unit' => $this->faker->randomElement(['tsp', 'tbsp', 'cup']),
            'serving_weight' => $this->faker->numberBetween(5, 500),
            'serving_unit_name' => $this->faker->word,
            'calories' => $this->faker->randomFloat(2, 0, 100),
            'fat' => $this->faker->randomFloat(2, 0, 10),
            'cholesterol' => $this->faker->randomFloat(2, 0, 100),
            'sodium' => $this->faker->randomFloat(2, 0, 500),
            'carbohydrates' => $this->faker->randomFloat(2, 0, 20),
            'protein' => $this->faker->randomFloat(2, 0, 20),
        ];
    }

    /**
     * Make instance with "tsp" serving unit.
     */
    public function tspServingUnit()
    {
        return $this->state(function (array $attributes) {
            return [
                'serving_unit' => 'tsp',
                'serving_size' => 1,
            ];
        });
    }

    /**
     * Make instance with "tbsp" serving unit.
     */
    public function tbspServingUnit()
    {
        return $this->state(function (array $attributes) {
            return [
                'serving_unit' => 'tbsp',
                'serving_size' => 1,
            ];
        });
    }

    /**
     * Make instance with "cup" serving unit.
     */
    public function cupServingUnit()
    {
        return $this->state(function (array $attributes) {
            return [
                'serving_unit' => 'cup',
                'serving_size' => 1,
            ];
        });
    }

    /**
     * Make instance with no" serving unit.
     */
    public function noServingUnit()
    {
        return $this->state(function (array $attributes) {
            return [
                'serving_unit' => null,
                'serving_unit_name' => 'head'
            ];
        });
    }
}
