<?php

namespace Tests\Feature\JsonApi;

use App\Models\Recipe;
use App\Models\RecipeSeparator;
use Database\Factories\RecipeSeparatorFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeSeparatorApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

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
        return Recipe::factory()->count(1)->hasSeparators($count)->create();
    }

}
