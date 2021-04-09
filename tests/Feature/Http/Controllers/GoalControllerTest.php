<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\GoalController;
use App\Models\Goal;
use Database\Factories\GoalFactory;

class GoalControllerTest extends HttpControllerTestCase
{

    /**
     * @inheritdoc
     */
    public function class(): string
    {
        return GoalController::class;
    }

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
    public function routeKey(): string
    {
        return 'goal';
    }

    /**
     * @inheritdoc
     */
    protected function createInstance(): Goal
    {
        return $this->factory()->for($this->user)->create();
    }

}
