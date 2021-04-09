<?php

namespace Tests\Feature\JsonApi;

use App\Models\JournalEntry;
use Database\Factories\JournalEntryFactory;
use Illuminate\Database\Eloquent\Collection;
use Tests\Feature\JsonApi\Traits\BelongsToUser;

class JournalEntryApiTest extends JsonApiTestCase
{
    use BelongsToUser;

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
    public function resourceName(): string
    {
        return 'journal-entries';
    }

    /**
     * @inheritdoc
     */
    protected function createInstances(int $count = 1): Collection {
        // Remove random entries for accurate count tests.
        $this->user->journalEntries()->delete();
        return $this->factory()->count($count)->for($this->user)->create();
    }

    public function testCanGetRelatedFoods(): void {
        $record = $this->factory()->hasFoods(2)->create();
        $this->getRelatedData($record, 'foods');
    }

    public function testCanIncludeRelatedFoods(): void {
        $record = $this->factory()->hasFoods(2)->create();
        $this->getRelatedData($record, 'foods');
    }

    public function testCanGetRelatedRecipes(): void {
        $record = $this->factory()->hasRecipes(2)->create();
        $this->getRelatedData($record, 'recipes');
    }

    public function testCanIncludeRelatedRecipes(): void {
        $record = $this->factory()->hasRecipes(2)->create();
        $this->getRelatedData($record, 'recipes');
    }

}
