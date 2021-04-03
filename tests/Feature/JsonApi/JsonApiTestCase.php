<?php

namespace Tests\Feature\JsonApi;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\LoggedInTestCase;

abstract class JsonApiTestCase extends LoggedInTestCase
{

    /**
     * API index route name.
     */
    protected string $indexRouteName;

    /**
     * Get the factory of the model to be tested.
     */
    abstract public function factory(): Factory;

    /**
     * Get the resource name used for API requests.
     */
    abstract public function resourceName(): string;

    public function setUp(): void
    {
        parent::setUp();
        $route_prefix = config('json-api-v1.url.name');
        $this->indexRouteName = "{$route_prefix}{$this->resourceName()}.index";
    }

    /**
     * Create instances of the model being tested.
     */
    protected function createInstances(int $count = 1): Collection {
        return $this->factory()->count($count)->create();
    }

    public function testCanGetIndex(): void
    {
        $this->createInstances(10);
        $index_url = route($this->indexRouteName);
        $response = $this->get($index_url);
        $response->assertOk();
        $response->assertJson(['data' => true]);
        $response->assertJsonCount(10, 'data');
    }

}
