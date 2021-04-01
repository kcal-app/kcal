<?php

namespace Tests\Feature\JsonApi;

use App\Models\Recipe;
use Database\Factories\RecipeFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

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
    public function resourceName(): string
    {
        return 'recipes';
    }

}
