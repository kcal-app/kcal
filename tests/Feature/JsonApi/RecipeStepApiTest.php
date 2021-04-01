<?php

namespace Tests\Feature\JsonApi;

use App\Models\Recipe;
use App\Models\RecipeStep;
use Database\Factories\RecipeStepFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeStepApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

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
        return Recipe::factory()->count(1)->hasSteps($count)->create();
    }

}
