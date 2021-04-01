<?php

namespace Tests\Feature\JsonApi;

use App\Models\JournalEntry;
use Database\Factories\JournalEntryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JournalEntryApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

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

}
