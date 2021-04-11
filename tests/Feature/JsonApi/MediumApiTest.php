<?php

namespace Tests\Feature\JsonApi;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediumApiTest extends JsonApiTestCase
{

    /**
     * @inheritdoc
     */
    public function factory(): Factory
    {
        // No-op for media.
        return Factory::new();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    protected function createInstances(int $count = 1): Collection {
        // No-op for media.
        return new Collection();
    }

    public function setUp(): void
    {
        parent::setUp();
        $route_prefix = config('json-api-v1.url.name');
        $this->routeBase = "{$route_prefix}media";
    }

    public function testCanGetIndex(): void {
        Recipe::factory()->createOneWithMedia();
        $index_route = route("$this->routeBase.index");
        $response = $this->get($index_route);
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

    public function testCanGetRelatedOwner(): void {
        $record = Recipe::factory()->createOneWithMedia();
        $this->getRelatedData($record->media->first(), 'owner', 'recipes');
    }

    public function testCanIncludeRelatedOwner(): void {
        $record = Recipe::factory()->createOneWithMedia();
        $this->getRelatedData($record->media->first(), 'owner', 'recipes');
    }

}
