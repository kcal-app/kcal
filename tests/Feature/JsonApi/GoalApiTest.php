<?php

namespace Tests\Feature\JsonApi;

use App\Models\Goal;
use App\Models\User;
use Database\Factories\GoalFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoalApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

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
        return User::factory()->count(1)->hasGoals($count)->create();
    }

}
