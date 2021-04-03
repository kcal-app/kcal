<?php

namespace Tests\Feature\JsonApi;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

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
        $index_url = route($this->indexRouteName);
        $response = $this->get($index_url);
        $response->assertOk();
        $response->assertJson(['data' => true]);
        $response->assertJsonCount(10, 'data');
    }

}
