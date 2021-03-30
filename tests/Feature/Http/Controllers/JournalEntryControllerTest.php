<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\JournalEntryController;
use App\Models\IngredientAmount;
use App\Models\JournalEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class JournalEntryControllerTest extends HttpControllerTestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @inheritdoc
     */
    public function class(): string
    {
        return JournalEntryController::class;
    }

    /**
     * @inheritdoc
     */
    public function factory(): Factory
    {
        return JournalEntry::factory();
    }

    /**
     * @inheritdoc
     */
    public function routeKey(): string
    {
        return 'journal_entry';
    }

    /**
     * @inheritdoc
     */
    protected function createInstance(): Model
    {
        return $this->factory()->for($this->user)->create();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanViewInstance(): void
    {
        $this->setName('can *not* view instance');
        // Journal entries are not independently viewable.
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanEditInstance(): void
    {
        $this->setName('can *not* edit instance');
        // Journal entries are not editable.
    }

    public function testCanAddInstance(): void
    {
        $create_url = action([$this->class(), 'createFromNutrients']);
        $response = $this->get($create_url);
        $response->assertOk();

        $instance = $this->factory()->make();
        $store_url = action([$this->class(), 'storeFromNutrients']);
        $response = $this->post($store_url, $instance->toArray());
        $response->assertSessionHasNoErrors();
    }

    public function testCanAddInstanceFromIngredients(): void
    {
        $create_url = action([$this->class(), 'create']);
        $response = $this->get($create_url);
        $response->assertOk();

        // Create ingredients based on ingredient amounts.
        $ingredients = [
            'date' => [], 'meal' => [], 'amount' => [], 'unit' => [],
            'id' => [], 'type' => [],
        ];
        /** @var \App\Models\IngredientAmount[] $ingredient_amounts */
        $ingredient_amounts = IngredientAmount::factory()
            ->count(10)
            ->make(['parent_id' => null, 'parent_type' => null]);
        foreach ($ingredient_amounts as $ingredient_amount) {
            $ingredients['date'][] = $this->faker->dateTimeThisMonth;
            $ingredients['meal'][] = $this->faker->randomElement(JournalEntry::meals()->pluck('value')->toArray());
            $ingredients['amount'][] = $ingredient_amount->amount;
            $ingredients['unit'][] = $ingredient_amount->unit;
            $ingredients['id'][] = $ingredient_amount->ingredient->id;
            $ingredients['type'][] = $ingredient_amount->ingredient->type;
        }
        $data = ['ingredients' => $ingredients, 'group_entries' => true];
        $store_url = action([$this->class(), 'store']);
        $response = $this->post($store_url, $data);
        $response->assertSessionHasNoErrors();

        $data['group_entries'] = false;
        $store_url = action([$this->class(), 'store']);
        $response = $this->post($store_url, $data);
        $response->assertSessionHasNoErrors();
    }

}
