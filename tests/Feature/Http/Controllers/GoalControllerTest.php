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

    /**
     * @inheritdoc
     */
    public function testCanAddInstance(): void
    {
        $create_url = action([$this->class(), 'create']);
        $response = $this->get($create_url);
        $response->assertOk();

        $data = $this->factory()->makeOne()->toArray();
        $data['days'] = Goal::days()->pluck('value')->random(3)->toArray();

        $store_url = action([$this->class(), 'store']);
        $response = $this->post($store_url, $data);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @inheritdoc
     */
    public function testCanEditInstance(): void
    {
        $instance = $this->createInstance();
        $edit_url = action([$this->class(), 'edit'], [$this->routeKey() => $instance]);
        $response = $this->get($edit_url);
        $response->assertOk();

        $data = $this->factory()->makeOne()->toArray();
        $data['days'] = Goal::days()->pluck('value')->random(3)->toArray();

        $put_url = action([$this->class(), 'update'], [$this->routeKey() => $instance]);
        $response = $this->put($put_url, $data);
        $response->assertSessionHasNoErrors();
    }

}
