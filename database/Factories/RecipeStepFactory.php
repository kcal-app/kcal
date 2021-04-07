<?php

namespace Database\Factories;

use App\Models\RecipeStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeStepFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = RecipeStep::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->numberBetween(1, 50),
            'step' => $this->faker->realText(500),
        ];
    }
}
