<?php

namespace Tests\Feature\JsonApi;

use App\Models\Food;
use Database\Factories\FoodFactory;

use Tests\Feature\JsonApi\Traits\HasTags;

class FoodApiTest extends JsonApiTestCase
{
    use HasTags;

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

    public function testCanUseSearchFilter(): void {
        $attributes = [
            'name' => 'Popcorn',
            'detail' => 'buttered',
            'brand' => 'Orville Redenbacher',
        ];
        $this->factory()->create($attributes);
        $this->factory()->create([
            'name' => 'tomatoes',
            'detail' => 'canned',
            'brand' => 'Kroger',
        ]);

        foreach ($attributes as $attribute => $value) {
            $partial = substr($value, rand(0, 3), 3);
            $search_route = route("$this->routeBase.index", [
                'filter' => ['search' => $partial]
            ]);
            $response = $this->get($search_route);
            $response->assertOk();
            $response->assertJsonCount(1, 'data');
            $response->assertJsonFragment([$attribute => $value]);
        }
    }

}
