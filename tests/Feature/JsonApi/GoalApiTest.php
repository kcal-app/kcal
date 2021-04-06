<?php

namespace Tests\Feature\JsonApi;

use App\Models\Goal;
use Database\Factories\GoalFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\JsonApi\Traits\BelongsToUser;

class GoalApiTest extends JsonApiTestCase
{
    use RefreshDatabase, BelongsToUser;

    /**
     * @inheritdoc
     */
    public function factory(): GoalFactory
    {
        return Goal::factory();
    }

    /**
     * @inheritdoc
     */
    public function resourceName(): string
    {
        return 'goals';
    }

    /**
     * @inheritdoc
     */
    protected function createInstances(int $count = 1): Collection {
        // Remove random goals for accurate count tests.
        $this->user->goals()->delete();
        return $this->factory()->count($count)->for($this->user)->create();
    }

}
