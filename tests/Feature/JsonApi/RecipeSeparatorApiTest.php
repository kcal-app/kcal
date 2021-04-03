<?php

namespace Tests\Feature\JsonApi;

use App\Models\Recipe;
use App\Models\RecipeSeparator;
use Database\Factories\RecipeSeparatorFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\JsonApi\Traits\BelongsToRecipe;

class RecipeSeparatorApiTest extends JsonApiTestCase
{
    use RefreshDatabase, BelongsToRecipe;

    /**
     * @inheritdoc
     */
    public function factory(): RecipeSeparatorFactory
    {
        return RecipeSeparator::factory();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'recipe-separators';
    }

    /**
     * @inheritdoc
     */
    protected function createInstances(int $count = 1): Collection {
        $recipe = Recipe::factory()->create();
        return $this->factory()->count($count)->for($recipe)->create();
    }

}
