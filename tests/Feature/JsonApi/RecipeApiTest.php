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

    public function testSearchFilter(): void {
        $attributes = [
            'name' => 'Chocolate Chip Cookies',
            'description' => 'Buttery, delicious cookies.',
            'source' => "America's Test Kitchen",
        ];
        $this->factory()->create($attributes);
        $this->factory()->create([
            'name' => 'Eggplant Parmesan',
            'description' => 'Veggies and cheese!',
            'source' => 'Joy of Baking',
        ]);

        foreach ($attributes as $attribute => $value) {
            $partial = substr($value, rand(0, 5), 5);
            $search_route = route($this->indexRouteName, [
                'filter' => ['search' => $partial]
            ]);
            $response = $this->get($search_route);
            $response->assertOk();
            $response->assertJsonCount(1, 'data');
            $response->assertJsonFragment([$attribute => $value]);
        }
    }

}
