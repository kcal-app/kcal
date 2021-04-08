<?php

namespace Database\Factories;

use App\Models\RecipeStep;
use Database\Support\Words;
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
        $word_combos = ['v', 'vn', 'van', 'vnpan', 'vanpn'];
        return [
            'number' => $this->faker->numberBetween(1, 50),
            'step' => Words::randomWords($this->faker->randomElement($word_combos)),
        ];
    }
}
