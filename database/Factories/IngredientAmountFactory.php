<?php

namespace Database\Factories;

use App\Models\Food;
use App\Models\IngredientAmount;
use App\Models\Recipe;
use App\Support\Nutrients;
use Database\Support\Words;
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
        if ($this->faker->boolean(90)) {
            $ingredient_factory = Food::factory();
            $ingredient_type = Food::class;
        }
        else {
            $ingredient_factory = Recipe::factory();
            $ingredient_type = Recipe::class;
        }

        $amounts = [1/8, 1/4, 1/3, 1/2, 2/3, 3/4, 1, 1 + 1/4, 1 + 1/3, 1 + 1/2, 1 + 2/3, 1 + 3/4, 2, 2 + 1/2, 3];
        return [
            'ingredient_id' => $ingredient_factory,
            'ingredient_type' => $ingredient_type,
            'amount' => $this->faker->randomElement($amounts),
            'detail' => $this->faker->boolean() ? Words::randomWords('a') : null,
            'weight' => $this->faker->numberBetween(0, 50),
            'parent_id' => Recipe::factory(),
            'parent_type' => Recipe::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configure(): static
    {
        return $this->afterMaking(function (IngredientAmount $ingredient_amount) {
            // Set the unit to a random one supported by the ingredient.
            $ingredient_amount->unit = $ingredient_amount->ingredient
                ->units_supported
                ->random(1)
                ->pluck('value')
                ->first();
        });
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
