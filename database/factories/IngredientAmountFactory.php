<?php

namespace Database\Factories;

use App\Models\Food;
use App\Models\IngredientAmount;
use App\Models\Recipe;
use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class IngredientAmountFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = IngredientAmount::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        // @todo Remove these hard-corded create statements.
        // See: https://laravel.com/docs/8.x/database-testing#factory-relationships

        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::factory()->create();

        if ($this->faker->boolean(90)) {
            /** @var \App\Models\Food $ingredient */
            $ingredient = Food::factory()->create();
            $unit = Nutrients::units()->pluck('value')->random(1)->first();
        }
        else {
            /** @var \App\Models\Recipe $ingredient */
            $ingredient = Recipe::factory()->create();
            $unit = 'serving';
        }

        return [
            'ingredient_id' => $ingredient->id,
            'ingredient_type' => $ingredient::class,
            'amount' => $this->faker->randomFloat(1, 1/3, 5),
            'unit' => $unit,
            'detail' => $this->faker->optional(0.8)->realText(),
            'weight' => $this->faker->optional(0.8)->numberBetween(0, 50),
            'parent_id' => $recipe->id,
            'parent_type' => $recipe::class,
        ];
    }

    /**
     * Define a specific parent.
     */
    public function parent(Model $parent): static
    {
        return $this->state(function (array $attributes) use ($parent) {
            return [
                'parent_id' => $parent->id,
                'parent_type' => $parent::class,
            ];
        });
    }

    /**
     * Define a specific ingredient.
     */
    public function ingredient(Model $ingredient): static
    {
        return $this->state(function (array $attributes) use ($ingredient) {
            return [
                'ingredient_id' => $ingredient->id,
                'ingredient_type' => $ingredient::class,
            ];
        });
    }
}
