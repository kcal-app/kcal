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
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'date' => $this->faker->dateTimeThisMonth,
            'summary' => $this->faker->realText(50),
            'calories' => $this->faker->randomFloat(2, 0, 500),
            'fat' => $this->faker->randomFloat(2, 0, 50),
            'cholesterol' => $this->faker->randomFloat(2, 0, 2000),
            'sodium' => $this->faker->randomFloat(2, 0, 2000),
            'carbohydrates' => $this->faker->randomFloat(2, 0, 100),
            'protein' => $this->faker->randomFloat(2, 0, 100),
            'meal' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snacks']),
        ];
    }

    /**
     * Define a specific user.
     */
    public function user(User $user): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
