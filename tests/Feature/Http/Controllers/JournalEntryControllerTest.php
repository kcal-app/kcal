<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\JournalEntryController;
use App\Models\IngredientAmount;
use App\Models\JournalEntry;
use Database\Factories\JournalEntryFactory;
use Illuminate\Foundation\Testing\WithFaker;

class JournalEntryControllerTest extends HttpControllerTestCase
{
    use WithFaker;

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
    public function factory(): JournalEntryFactory
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
    protected function createInstance(): JournalEntry
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

    public function testCanAddInstanceFromIngredientsGrouped(): void
    {
        $create_url = action([$this->class(), 'create']);
        $response = $this->get($create_url);
        $response->assertOk();

        $data = $this->createIngredientsDataArray();
        $store_url = action([$this->class(), 'store']);
        $response = $this->post($store_url, $data);
        $response->assertSessionHasNoErrors();
    }

    public function testCanAddInstanceFromIngredientsUnGrouped(): void
    {
        $data = $this->createIngredientsDataArray();
        $data['group_entries'] = false;
        $store_url = action([$this->class(), 'store']);
        $response = $this->post($store_url, $data);
        $response->assertSessionHasNoErrors();
    }

    public function testSessionKeepsOldInput(): void {
        $data = $this->createIngredientsDataArray();

        // Set first amount to an invalid string.
        $data['ingredients']['amount'][0] = 'abcd';

        $create_url = action([$this->class(), 'create']);
        $store_url = action([$this->class(), 'store']);
        $response = $this->from($create_url)->post($store_url, $data);
        $response->assertRedirect($create_url);
        $response->assertSessionHasErrors();
        $response->assertSessionHasInput('ingredients', $data['ingredients']);

        $this->followingRedirects()
            ->from($create_url)
            ->post($store_url, $data);
        $this->assertEquals($create_url, url()->current());
    }

    /**
     * Create a test array for creating an entry from ingredients data.
     */
    private function createIngredientsDataArray(): array {
        // Create ingredients based on ingredient amounts.
        $ingredients = [
            'date' => [], 'meal' => [], 'amount' => [], 'unit' => [],
            'id' => [], 'type' => [],
        ];

        $ingredient_amounts = IngredientAmount::factory()
            ->count(10)
            ->make(['parent_id' => null, 'parent_type' => null]);
        /** @var \App\Models\IngredientAmount $ingredient_amount */
        foreach ($ingredient_amounts as $ingredient_amount) {
            $ingredients['date'][] = $this->faker->dateTimeThisMonth->format('Y-m-d');
            $ingredients['meal'][] = $this->faker->randomElement(JournalEntry::meals()->pluck('value')->toArray());
            $ingredients['name'][] = $ingredient_amount->ingredient->name;
            $ingredients['amount'][] = $ingredient_amount->amount;
            $ingredients['unit'][] = $ingredient_amount->unit;
            $ingredients['id'][] = $ingredient_amount->ingredient->id;
            $ingredients['type'][] = $ingredient_amount->ingredient->type;
        }
        return ['ingredients' => $ingredients, 'group_entries' => true];
    }

}
