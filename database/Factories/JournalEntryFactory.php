<?php

namespace Database\Factories;

use App\Models\JournalEntry;
use App\Models\User;
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
            'summary' => $this->faker->realText(50),
            'calories' => $this->faker->randomFloat(1, 0, 500),
            'fat' => $this->faker->randomFloat(1, 0, 50),
            'cholesterol' => $this->faker->randomFloat(1, 0, 2000),
            'sodium' => $this->faker->randomFloat(1, 0, 2000),
            'carbohydrates' => $this->faker->randomFloat(1, 0, 100),
            'protein' => $this->faker->randomFloat(1, 0, 100),
            'meal' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snacks']),
        ];
    }

}
