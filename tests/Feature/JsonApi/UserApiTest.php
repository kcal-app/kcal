<?php

namespace Tests\Feature\JsonApi;

use App\Models\User;
use Database\Factories\UserFactory;

class UserApiTest extends JsonApiTestCase
{

    /**
     * @inheritdoc
     */
    public function factory(): UserFactory
    {
        return User::factory();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'users';
    }

    public function testCanGetIndex(): void
    {
        // Initial user created by test so only make 9 new instances.
        $this->createInstances(9);
        $index_url = route("$this->routeBase.index");
        $response = $this->get($index_url);
        $response->assertOk();
        $response->assertJson(['data' => true]);
        $response->assertJsonCount(10, 'data');
    }

    public function testCanGetRelatedGoals(): void {
        $record = $this->factory()->hasGoals(2)->create();
        $this->getRelatedData($record, 'goals');
    }

    public function testCanIncludeRelatedGoals(): void {
        $record = $this->factory()->hasGoals(2)->create();
        $this->getRelatedData($record, 'goals');
    }

    public function testCanGetRelatedJournalEntries(): void {
        $record = $this->factory()->hasJournalEntries(2)->create();
        $this->getRelatedData($record, 'journal-entries');
    }

    public function testCanIncludeRelatedJournalEntries(): void {
        $record = $this->factory()->hasJournalEntries(2)->create();
        $this->getRelatedData($record, 'journal-entries');
    }

}
