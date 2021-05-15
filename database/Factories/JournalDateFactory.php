<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\JournalDate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalDateFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = JournalDate::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeThisMonth,
            'user_id' => User::factory(),
            'goal_id' => Goal::factory(),
        ];
    }

}
