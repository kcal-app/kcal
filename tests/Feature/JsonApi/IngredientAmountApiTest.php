<?php

namespace Tests\Feature\JsonApi;

use App\Models\Food;
use App\Models\IngredientAmount;
use App\Models\JournalEntry;
use App\Models\Recipe;
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

    public function testCanGetRelatedIngredient(): void {
        $ingredient = Food::factory()->create();
        $record = $this->factory()->ingredient($ingredient)->create();
        $this->getRelatedData($record, 'ingredient', 'foods');
    }

    public function testCanIncludeRelatedIngredient(): void {
        $ingredient = Recipe::factory()->create();
        $record = $this->factory()->ingredient($ingredient)->create();
        $this->getRelatedData($record, 'ingredient', 'recipes');
    }

    public function testCanGetRelatedParent(): void {
        $parent = Recipe::factory()->create();
        $record = $this->factory()->parent($parent)->create();
        $this->getRelatedData($record, 'parent', 'recipes');
    }

    public function testCanIncludeRelatedParent(): void {
        $parent = JournalEntry::factory()->create();
        $record = $this->factory()->parent($parent)->create();
        $this->getRelatedData($record, 'parent', 'journal-entries');
    }

}
