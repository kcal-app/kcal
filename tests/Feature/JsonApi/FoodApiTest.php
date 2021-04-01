<?php

namespace Tests\Feature\JsonApi;

use App\Models\Food;
use Database\Factories\FoodFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

    /**
     * @inheritdoc
     */
    public function factory(): FoodFactory
    {
        return Food::factory();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'foods';
    }

}
