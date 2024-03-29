<?php

namespace Tests\Feature\JsonApi;

use App\Models\Recipe;
use Database\Factories\RecipeFactory;
use Tests\Feature\JsonApi\Traits\HasTags;

class RecipeApiTest extends JsonApiTestCase
{
    use HasTags;

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

    public function testCanGetRelatedIngredientAmounts(): void {
        $record = $this->factory()->hasIngredientAmounts(2)->create();
        $this->getRelatedData($record, 'ingredient-amounts');
    }

    public function testCanIncludeRelatedIngredientAmounts(): void {
        $record = $this->factory()->hasIngredientAmounts(2)->create();
        $this->getRelatedData($record, 'ingredient-amounts');
    }

    public function testCanGetRelatedMedia(): void {
        $record = $this->factory()->createOneWithMedia();
        $this->getRelatedData($record, 'media');
    }

    public function testCanIncludeRelatedMedia(): void {
        $record = $this->factory()->createOneWithMedia();
        $this->getRelatedData($record, 'media');
    }

    public function testCanGetRelatedSeparators(): void {
        $record = $this->factory()->hasSeparators(2)->create();
        $this->getRelatedData($record, 'separators', 'recipe-separators');
    }

    public function testCanIncludeRelatedSeparators(): void {
        $record = $this->factory()->hasSeparators(2)->create();
        $this->getRelatedData($record, 'separators', 'recipe-separators');
    }

    public function testCanGetRelatedSteps(): void {
        $record = $this->factory()->hasSteps(2)->create();
        $this->getRelatedData($record, 'steps', 'recipe-steps');
    }

    public function testCanIncludeRelatedSteps(): void {
        $record = $this->factory()->hasSteps(2)->create();
        $this->getRelatedData($record, 'steps', 'recipe-steps');
    }

    public function testCanUseSearchFilter(): void {
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
