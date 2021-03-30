<?php

namespace Database\Factories;

use App\Models\Recipe;
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
        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::factory()->create();
        return [
            'recipe_id' => $recipe->id,
            'container' => 'ingredients',
            'weight' => $this->faker->numberBetween(0, 100),
            'text' => $this->faker->optional()->realText(20),
        ];
    }
}
