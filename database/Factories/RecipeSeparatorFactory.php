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
            'weight' => $this->faker->numberBetween(0, 20),
            'text' => $this->faker->optional()->words(rand(1, 3), TRUE),
        ];
    }
}
