<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = User::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'),
            'name' => $this->faker->name,
            'remember_token' => Str::random(10),
        ];
    }
}
