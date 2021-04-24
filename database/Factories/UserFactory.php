<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'admin' => $this->faker->boolean,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Create an admin user.
     */
    public function admin(): static
    {
        return $this->state(['admin' => true]);
    }

    /**
     * Create a user and add fake media to it.
     */
    public function createOneWithMedia(array $attributes = []): User {
        Storage::fake('tests');
        /** @var \App\Models\User $user */
        $user = $this->createOne($attributes);
        $file = UploadedFile::fake()->image('user.jpg', 400, 400);
        $path = $file->store('tests');
        $user->addMediaFromDisk($path)
            ->usingName($user->name)
            ->usingFileName("{$user->slug}.jpg")
            ->toMediaCollection();
        return $user;
    }
}
