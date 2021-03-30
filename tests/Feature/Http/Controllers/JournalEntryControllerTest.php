<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\GoalController;
use App\Http\Controllers\JournalEntryController;
use App\Models\Goal;
use App\Models\JournalEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JournalEntryControllerTest extends HttpControllerTestCase
{
    use RefreshDatabase;

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
    public function testCanViewInstance(): void {
        $this->setName('can *not* view instance');
        // Journal entries are not independently viewable.
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanEditInstance(): void {
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
        $response = $this->followingRedirects()->post($store_url, $instance->toArray());
        $response->assertOk();
        $response->assertSessionHasNoErrors();
    }

}
