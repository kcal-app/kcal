<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Goal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $from = $this->faker->dateTimeThisMonth;
        $to = $this->faker->dateTimeBetween($from, '+1 year');
        return [
            'from' => $this->faker->randomElement([$from, null]),
            'to' => $this->faker->randomElement([$to, null]),
            'frequency' => $this->faker->randomElement(Goal::$frequencyOptions)['value'],
            'name' => $this->faker->randomElement(Goal::getNameOptions())['value'],
            'goal' => $this->faker->numberBetween(0, 2000),
            'user_id' => $user->id,
        ];
    }
}
