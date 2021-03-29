<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\GoalController;
use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoalControllerTest extends HttpControllerTestCase
{
    use RefreshDatabase;

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
    public function factory(): Factory
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

}
