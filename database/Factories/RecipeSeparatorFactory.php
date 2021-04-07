<?php

namespace Database\Factories;

use App\Models\RecipeSeparator;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeSeparatorFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = RecipeSeparator::class;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'container' => 'ingredients',
            'weight' => $this->faker->numberBetween(0, 100),
            'text' => $this->faker->optional()->realText(20),
        ];
    }
}
