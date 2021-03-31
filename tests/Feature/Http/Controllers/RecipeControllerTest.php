<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\RecipeController;
use App\Models\IngredientAmount;
use App\Models\Recipe;
use App\Models\RecipeSeparator;
use App\Models\RecipeStep;
use Database\Factories\RecipeFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class RecipeControllerTest extends HttpControllerTestCase
{
    use RefreshDatabase, WithFaker;

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
            ->create();
    }

    public function testCanAddInstance(): void
    {
        $create_url = action([$this->class(), 'create']);
        $response = $this->get($create_url);
        $response->assertOk();


        $ingredient_amounts = IngredientAmount::factory()
            ->count(10)
            ->make(['parent_id' => null, 'parent_type' => null]);

        $data = [
            'ingredients' => $this->createFormDataFromIngredientAmounts($ingredient_amounts),
            'steps' => $this->createFormDataFromRecipeSteps(RecipeStep::factory()->count(6)->make()),
            'separators' => $this->createFormDataFromRecipeSeparators(RecipeSeparator::factory()->count(2)->make()),
        ] + $this->factory()->makeOne()->toArray();

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

        $data = [
            'ingredients' => $this->createFormDataFromIngredientAmounts($instance->ingredientAmounts),
            'steps' => $this->createFormDataFromRecipeSteps($instance->steps),
            'separators' => $this->createFormDataFromRecipeSeparators($instance->ingredientSeparators),
        ] + $this->factory()->makeOne()->toArray();

        $put_url = action([$this->class(), 'update'], [$this->routeKey() => $instance]);
        $response = $this->put($put_url, $data);
        $response->assertSessionHasNoErrors();
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
