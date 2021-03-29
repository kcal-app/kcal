<?php

namespace Tests\Feature;

use App\Http\Controllers\GoalController;
use App\Models\Goal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LoggedInTestCase;

class GoalTest extends LoggedInTestCase
{
    use RefreshDatabase;

    public function testCanLoadGoalIndex(): void
    {
        $index_url = action([GoalController::class, 'index']);
        $response = $this->get($index_url);
        $response->assertOk();
    }

    public function testCanAddGoal(): void
    {
        $create_url = action([GoalController::class, 'create']);
        $response = $this->get($create_url);
        $response->assertOk();

        /** @var \App\Models\Goal $goal */
        $goal = Goal::factory()->make();
        $store_url = action([GoalController::class, 'store']);
        $response = $this->followingRedirects()->post($store_url, $goal->toArray());
        $response->assertOk();
        $response->assertSee('Goal updated!');
    }

    public function testCanViewGoal(): void
    {
        /** @var \App\Models\Goal $goal */
        $goal = Goal::factory()->create();
        $view_url = action([GoalController::class, 'show'], ['goal' => $goal]);
        $response = $this->get($view_url);
        $response->assertOk();
        $response->assertSee($goal->summary);
    }

    public function testCanEditGoal(): void
    {
        /** @var \App\Models\Goal $goal */
        $goal = Goal::factory()->create();
        $edit_url = action([GoalController::class, 'edit'], ['goal' => $goal]);
        $response = $this->get($edit_url);
        $response->assertOk();

        /** @var \App\Models\Goal $new_food */
        $new_food = Goal::factory()->make(['tags' => []]);
        $put_url = action([GoalController::class, 'update'], ['goal' => $goal]);
        $response = $this->followingRedirects()->put($put_url, $new_food->toArray());
        $response->assertOk();
        $response->assertSee('Goal updated!');
    }

    public function testCanDeleteGoal(): void
    {
        /** @var \App\Models\Goal $goal */
        $goal = Goal::factory()->create();
        $delete_url = action([GoalController::class, 'delete'], ['goal' => $goal]);
        $response = $this->get($delete_url);
        $response->assertOk();
        $response->assertSee("Delete {$goal->summary} goal?");

        $destroy_url = action([GoalController::class, 'destroy'], ['goal' => $goal]);
        $response = $this->followingRedirects()->delete($destroy_url);
        $response->assertOk();

        $view_url = action([GoalController::class, 'show'], ['goal' => $goal]);
        $response = $this->get($view_url);
        $response->assertNotFound();
    }
}
