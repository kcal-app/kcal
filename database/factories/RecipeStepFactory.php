<?php

namespace Database\Factories;

use App\Models\Recipe;
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
        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::factory()->create();
        return [
            'recipe_id' => $recipe->id,
            'number' => $this->faker->numberBetween(1, 50),
            'step' => $this->faker->realText(500),
        ];
    }

    /**
     * Define a specific recipe.
     */
    public function recipe(Recipe $recipe): static
    {
        return $this->state(function (array $attributes) use ($recipe) {
            return [
                'recipe_id' => $recipe->id,
            ];
        });
    }
}
