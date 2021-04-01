<?php

namespace Tests\Feature\JsonApi;

use App\Models\IngredientAmount;
use Database\Factories\IngredientAmountFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientAmountApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

    /**
     * @inheritdoc
     */
    public function factory(): IngredientAmountFactory
    {
        return IngredientAmount::factory();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'ingredient-amounts';
    }

}
