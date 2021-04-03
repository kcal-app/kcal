<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RecipeFactory extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $model = Recipe::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        $description = htmlspecialchars($this->faker->realText(500));
        return [
            'name' => $this->faker->words($this->faker->numberBetween(1, 5), true),
            'description' => "<p>{$description}</p>",
            'description_delta' => '{"ops":[{"insert":"' . $description . '\n"}]}"',
            'time_prep' => $this->faker->numberBetween(0, 20),
            'time_cook' => $this->faker->numberBetween(0, 90),
            'source' => $this->faker->optional()->url,
            'servings' => $this->faker->numberBetween(1, 10),
            'weight' => $this->faker->randomFloat(1, 60, 2000),
            'tags' => $this->faker->words,
        ];
    }

    /**
     * Create a recipe and add fake media to it.
     */
    public function createOneWithMedia(array $attributes = []): Recipe {
        Storage::fake('tests');
        /** @var \App\Models\Recipe $recipe */
        $recipe = $this->createOne($attributes);
        $file = UploadedFile::fake()->image('recipe.jpg', 1600, 900);
        $path = $file->store('tests');
        $recipe->addMediaFromDisk($path)
            ->usingName($recipe->name)
            ->usingFileName("{$recipe->slug}.jpg")
            ->toMediaCollection();
        return $recipe;
    }
}
