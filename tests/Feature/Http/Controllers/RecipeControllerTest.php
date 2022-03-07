<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\RecipeController;
use App\Models\IngredientAmount;
use App\Models\Recipe;
use App\Models\RecipeSeparator;
use App\Models\RecipeStep;
use Database\Factories\RecipeFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;

class RecipeControllerTest extends HttpControllerTestCase
{
    use WithFaker;

    /**
     * @inheritdoc
     */
    public function class(): string
    {
        return RecipeController::class;
    }

    /**
     * @inheritdoc
     */
    public function factory(): RecipeFactory
    {
        return Recipe::factory();
    }

    /**
     * @inheritdoc
     */
    public function routeKey(): string
    {
        return 'recipe';
    }

    /**
     * @inheritdoc
     */
    protected function createInstance(): Recipe
    {
        return $this->factory()
            ->hasIngredientAmounts(10)
            ->hasSteps(6)
            ->hasIngredientSeparators(2)
            ->hasTags(5)
            ->createOneWithMedia();
    }

    public function testCanAddInstance(): void
    {
        $create_url = action([$this->class(), 'create']);
        $response = $this->get($create_url);
        $response->assertOk();

        $ingredient_amounts = IngredientAmount::factory()
            ->count(10)
            ->make(['parent_id' => null, 'parent_type' => null]);

        $data = $this->factory()->makeOne()->toArray() + [
            'ingredients' => $this->createFormDataFromIngredientAmounts($ingredient_amounts),
            'steps' => $this->createFormDataFromRecipeSteps(RecipeStep::factory()->count(6)->make()),
            'separators' => $this->createFormDataFromRecipeSeparators(RecipeSeparator::factory()->count(2)->make()),
            'image' => UploadedFile::fake()->image('recipe.jpg', 1600, 900),
            'tags' => implode(',', $this->faker->words),
        ];

        $store_url = action([$this->class(), 'store']);
        $response = $this->post($store_url, $data);
        $response->assertSessionHasNoErrors();
    }

    public function testCanEditInstance(): void
    {
        $instance = $this->createInstance();
        $edit_url = action([$this->class(), 'edit'], [$this->routeKey() => $instance]);
        $response = $this->get($edit_url);
        $response->assertOk();

        // Remove one of each item.
        $instance->ingredientAmounts[1]->delete();
        $instance->steps[1]->delete();
        $instance->separators[1]->delete();
        $instance->refresh();

        $data = $this->factory()->makeOne()->toArray() + [
            'ingredients' => $this->createFormDataFromIngredientAmounts($instance->ingredientAmounts),
            'steps' => $this->createFormDataFromRecipeSteps($instance->steps),
            'separators' => $this->createFormDataFromRecipeSeparators($instance->ingredientSeparators),
            'image' => UploadedFile::fake()->image('recipe.jpg', 1600, 900),
            'tags' => implode(',', $this->faker->words),
        ];

        $put_url = action([$this->class(), 'update'], [$this->routeKey() => $instance]);
        $response = $this->put($put_url, $data);
        $response->assertSessionHasNoErrors();
    }

    public function testCanDuplicateInstances(): void {
        $instance = $this->createInstance();
        $confirm_url = action([$this->class(), 'duplicateConfirm'], [$this->routeKey() => $instance]);
        $response = $this->get($confirm_url);
        $response->assertOk();
        $response->assertViewHas($this->routeKey());

        $duplicate_url = action([$this->class(), 'duplicate'], [$this->routeKey() => $instance]);
        $response = $this->followingRedirects()->post($duplicate_url, ['name' => 'Duplicated Recipe']);
        $response->assertOk();

        $recipe = Recipe::latest()->first();
        $this->assertEquals('Duplicated Recipe', $recipe->name);
        $this->assertEquals($instance->tags->toArray(), $instance->tags->toArray());
        $this->assertEquals($instance->ingredientAmounts->toArray(), $instance->ingredientAmounts->toArray());
        $this->assertEquals($instance->steps->toArray(), $instance->steps->toArray());
        $this->assertEquals($instance->separators->toArray(), $instance->separators->toArray());
    }

    public function testSessionKeepsOldInputOnAdd(): void {
        $instance = $this->createInstance();
        $data = $this->createInvalidFormData($instance);
        $create_url = action([$this->class(), 'create']);
        $store_url = action([$this->class(), 'store']);
        $response = $this->from($create_url)->post($store_url, $data);
        $response->assertRedirect($create_url);
        $response->assertSessionHasErrors();
        $response->assertSessionHasInput('ingredients', $data['ingredients']);
        $response->assertSessionHasInput('steps', $data['steps']);
        $response->assertSessionHasInput('separators', $data['separators']);
    }

    public function testSessionKeepsOldInputOnEdit(): void {
        $instance = $this->createInstance();
        $data = $this->createInvalidFormData($instance);
        $edit_url = action([$this->class(), 'edit'], [$this->routeKey() => $instance]);
        $put_url = action([$this->class(), 'update'], [$this->routeKey() => $instance]);
        $response = $this->from($edit_url)->put($put_url, $data);
        $response->assertRedirect($edit_url);
        $response->assertSessionHasErrors();
        $response->assertSessionHasInput('ingredients', $data['ingredients']);
        $response->assertSessionHasInput('steps', $data['steps']);
        $response->assertSessionHasInput('separators', $data['separators']);

        $this->followingRedirects()
            ->from($edit_url)
            ->put($put_url, $data);
        $this->assertEquals($edit_url, url()->current());
    }

    /**
     * Create invalid form data for testing rejected forms.
     */
    private function createInvalidFormData(Recipe $instance): array {
        $instance = $this->createInstance();
        $data = [
                'ingredients' => $this->createFormDataFromIngredientAmounts($instance->ingredientAmounts),
                'steps' => $this->createFormDataFromRecipeSteps($instance->steps),
                'separators' => $this->createFormDataFromRecipeSeparators($instance->ingredientSeparators),
            ] + $instance->toArray();

        // Remove the first amount value to force a form error.
        $data['ingredients']['amount'][0] = NULL;
        return $data;
    }

    /**
     * Convert ingredient amount instances in to a form data style array.
     */
    private function createFormDataFromIngredientAmounts(Collection $ingredient_amounts): array {
        $ingredients = [];
        /** @var \App\Models\IngredientAmount $ingredient_amount */
        foreach ($ingredient_amounts as $key => $ingredient_amount) {
            $ingredients['amount'][] = $ingredient_amount->amount;
            $ingredients['unit'][] = $ingredient_amount->unit;
            $ingredients['detail'][] = $this->faker->words(2, true);
            $ingredients['id'][] = $ingredient_amount->ingredient->id;
            $ingredients['type'][] = $ingredient_amount->ingredient->type;
            $ingredients['weight'][] = $this->faker->unique()->numberBetween(0, 9);
            $ingredients['key'][] = $ingredient_amount->exists ? $key : null;
        }
        return $ingredients;
    }

    /**
     * Convert recipe step instances in to a form data style array.
     */
    private function createFormDataFromRecipeSteps(Collection $recipe_steps): array {
        $steps = [];
        /** @var \App\Models\RecipeStep $recipe_step */
        foreach ($recipe_steps as $key => $recipe_step) {
            $steps['step'][] = $recipe_step->step;
            $steps['key'][] = $recipe_step->exists ? $key : null;
        }
        return $steps;
    }

    /**
     * Convert recipe separator instances in to a form data style array.
     */
    private function createFormDataFromRecipeSeparators(Collection $recipe_separators): array {
        $separators = [];
        /** @var \App\Models\RecipeSeparator $recipe_separator */
        foreach ($recipe_separators as $key => $recipe_separator) {
            $separators['text'][] = $recipe_separator->text;
            $separators['weight'][] = $recipe_separator->weight;
            $separators['key'][] = $recipe_separator->exists ? $key : null;
        }
        return $separators;
    }

}
