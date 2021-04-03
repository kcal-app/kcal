<?php

namespace Tests\Feature\JsonApi;

use App\Models\Recipe;
use App\Models\RecipeStep;
use Database\Factories\RecipeStepFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\JsonApi\Traits\BelongsToRecipe;

class RecipeStepApiTest extends JsonApiTestCase
{
    use RefreshDatabase, BelongsToRecipe;

    /**
     * @inheritdoc
     */
    public function factory(): RecipeStepFactory
    {
        return RecipeStep::factory();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'recipe-steps';
    }

    /**
     * @inheritdoc
     */
    protected function createInstances(int $count = 1): Collection {
        $recipe = Recipe::factory()->create();
        return $this->factory()->count($count)->for($recipe)->create();
    }

}
