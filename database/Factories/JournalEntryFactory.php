<?php

namespace Database\Factories;

use App\Models\JournalEntry;
use App\Models\User;
use Database\Support\Words;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalEntryFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = JournalEntry::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeThisMonth,
            'summary' => Words::randomWords($this->faker->randomElement(['n', 'n, n', 'n, n, n'])),
            'calories' => $this->faker->randomFloat(1, 0, 500),
            'fat' => $this->faker->randomFloat(1, 0, 20),
            'cholesterol' => $this->faker->randomFloat(1, 0, 200),
            'sodium' => $this->faker->randomFloat(1, 0, 500),
            'carbohydrates' => $this->faker->randomFloat(1, 0, 40),
            'protein' => $this->faker->randomFloat(1, 0, 20),
            'meal' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snacks']),
        ];
    }

}
