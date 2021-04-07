<?php

namespace Database\Factories;

use App\Models\Tag;
use Database\Support\Words;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = Tag::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'name' => Words::randomWords('a'),
        ];
    }
}
