<?php

namespace Tests\Feature\JsonApi;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Tests\LoggedInTestCase;

abstract class JsonApiTestCase extends LoggedInTestCase
{

    /**
     * API route base.
     */
    protected string $routeBase;

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
        $this->routeBase = "{$route_prefix}{$this->resourceName()}";
    }

    /**
     * Create instances of the model being tested.
     */
    protected function createInstances(int $count = 1): Collection {
        return $this->factory()->count($count)->create();
    }

    /**
     * Provide a template for getting related data.
     */
    protected function getRelatedData(Model $record, string $related, string $expectedType = NULL): void {
        $related_route = route(
            "{$this->routeBase}.relationships.{$related}",
            ['record' => $record]
        );
        $response = $this->get($related_route);
        $response->assertOk();
        $response->assertJsonFragment(['type' => $expectedType ?? $related]);
    }

    /**
     * Provide a template for included related data.
     */
    protected function includeRelatedData(Model $record, string $related, string $expectedType = NULL): void {
        $related_route = route(
            "{$this->routeBase}.read",
            ['record' => $record, 'include' => $related]
        );
        $response = $this->get($related_route);
        $response->assertOk();
        $response->assertJsonPath('included.0.type', $expectedType ?? $related);
    }

    public function testCanGetIndex(): void
    {
        $this->createInstances(10);
        $index_url = route("$this->routeBase.index");
        $response = $this->get($index_url);
        $response->assertOk();
        $response->assertJson(['data' => true]);
        $response->assertJsonCount(10, 'data');
    }

}
