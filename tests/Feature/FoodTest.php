<?php

namespace Tests\Feature;

use App\Http\Controllers\FoodController;
use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LoggedInTestCase;

class FoodTest extends LoggedInTestCase
{
    use RefreshDatabase;

    public function testCanLoadFoodIndex()
    {
        $response = $this->get('/foods');
        $response->assertOk();
    }

    public function testCanAddFood()
    {
        $create_url = action([FoodController::class, 'create']);
        $response = $this->get($create_url);
        $response->assertOk();

        /** @var \App\Models\Food $food */
        $food = Food::factory()->make();
        $store_url = action([FoodController::class, 'store']);
        $response = $this->followingRedirects()->post($store_url, $food->toArray());
        $response->assertOk();
        $response->assertSee("Food {$food->name} updated!");
    }

    public function testCanViewFood()
    {
        /** @var \App\Models\Food $food */
        $food = Food::factory()->create();
        $view_url = action([FoodController::class, 'show'], ['food' => $food]);
        $response = $this->get($view_url);
        $response->assertOk();
        $response->assertSee($food->name);
    }

    public function testCanEditFood()
    {
        /** @var \App\Models\Food $food */
        $food = Food::factory()->create();
        $edit_url = action([FoodController::class, 'edit'], ['food' => $food]);
        $response = $this->get($edit_url);
        $response->assertOk();

        /** @var \App\Models\Food $new_food */
        $new_food = Food::factory()->make();
        $put_url = action([FoodController::class, 'update'], ['food' => $food]);
        $response = $this->followingRedirects()->put($put_url, $new_food->toArray());
        $response->assertOk();
        $response->assertSee("Food {$new_food->name} updated!");
    }

    public function testCanDeleteFood()
    {
        /** @var \App\Models\Food $food */
        $food = Food::factory()->create();
        $delete_url = action([FoodController::class, 'delete'], ['food' => $food]);
        $response = $this->get($delete_url);
        $response->assertOk();
        $response->assertSee("Delete {$food->name}?");

        $destroy_url = action([FoodController::class, 'destroy'], ['food' => $food]);
        $response = $this->followingRedirects()->delete($destroy_url);
        $response->assertOk();

        $view_url = action([FoodController::class, 'show'], ['food' => $food]);
        $response = $this->get($view_url);
        $response->assertNotFound();
    }
}
