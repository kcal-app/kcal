<?php

namespace Database\Factories;

use App\Models\Food;

use Database\Support\Words;
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
            'name' => Words::randomWords($this->faker->randomElement(['n', 'an'])),
            'detail' => $this->faker->boolean() ? Words::randomWords('a') : null,
            'brand' => $this->faker->optional()->word,
            'source' => $this->faker->optional()->url,
            'notes' => $this->faker->optional(0.25)->realText(),
            'serving_size' => $this->faker->numberBetween(1, 3),
            'serving_unit' => $this->faker->randomElement(['tsp', 'tbsp', 'cup', 'oz']),
            'serving_weight' => $this->faker->numberBetween(5, 500),
            'calories' => $this->faker->randomFloat(1, 0, 100),
            'fat' => $this->faker->randomFloat(1, 0, 10),
            'cholesterol' => $this->faker->randomFloat(1, 0, 100),
            'sodium' => $this->faker->randomFloat(1, 0, 500),
            'carbohydrates' => $this->faker->randomFloat(1, 0, 20),
            'protein' => $this->faker->randomFloat(1, 0, 20),
            'tags' => Words::randomWords($this->faker->randomElement(['a', 'aa', 'aaa']), TRUE),
        ];
    }

}
