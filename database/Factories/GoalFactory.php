<?php

namespace Database\Factories;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = Goal::class;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        $from = $this->faker->dateTimeThisMonth;
        $to = $this->faker->dateTimeBetween($from, '+1 year');
        return [
            'from' => $this->faker->randomElement([$from, null]),
            'to' => $this->faker->randomElement([$to, null]),
            'frequency' => $this->faker->randomElement(Goal::$frequencyOptions)['value'],
            'name' => $this->faker->randomElement(Goal::getNameOptions())['value'],
            'goal' => $this->faker->numberBetween(0, 2000),
        ];
    }
}
