<?php

namespace Tests\Feature\JsonApi;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

    /**
     * @inheritdoc
     */
    public function factory(): Factory
    {
        return Tag::factory();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'tags';
    }

}
