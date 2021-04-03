<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\IngredientPickerController;
use App\Models\Food;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LoggedInTestCase;

class IngredientPickerControllerTest extends LoggedInTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Food::factory()->create(['name' => 'Good food']);
        Food::factory()->create(['name' => 'Bad food']);
        Recipe::factory()->create(['name' => 'Good recipe']);
        Recipe::factory()->create(['name' => 'Bad recipe']);
        Food::factory()->create(['name' => 'abcdefg']);
        Food::factory()->create(['name' => 'hijklmnop']);
        Recipe::factory()->create(['name' => 'qrstuv']);
        Recipe::factory()->create(['name' => 'wxyz']);

        // Try to ensure index is updated.
        // @todo Find a better way to ensure indexing.
        $this->artisan('scout:import App\\\Models\\\Food');
        $this->artisan('scout:import App\\\Models\\\Recipe');
        sleep(5);
    }

    private function buildUrl(array $parameters = []): string {
        return action([IngredientPickerController::class, 'search'], $parameters);
    }

    public function testSearchUrlLoads(): void {
        $response = $this->get($this->buildUrl());
        $response->assertOk();
    }

    public function testFindsByName(): void
    {
        $response = $this->getJson($this->buildUrl(['term' => 'good']));
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['name' => 'Good recipe']);
        $response->assertJsonFragment(['name' => 'Good food']);
        $response->assertJsonMissing(['name' => 'Bad recipe']);
        $response->assertJsonMissing(['name' => 'Bad food']);

        $response = $this->getJson($this->buildUrl(['term' => 'bad']));
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['name' => 'Bad recipe']);
        $response->assertJsonFragment(['name' => 'Bad food']);
        $response->assertJsonMissing(['name' => 'Good recipe']);
        $response->assertJsonMissing(['name' => 'Good food']);
    }

    public function testFindsByNameAsYouType(): void
    {
        $response = $this->getJson($this->buildUrl(['term' => 'abc']));
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'abcdefg']);
        $response->assertJsonMissing(['name' => 'hijklmnop']);
        $response->assertJsonMissing(['name' => 'qrstuv']);
        $response->assertJsonMissing(['name' => 'wxyz']);

        $response = $this->getJson($this->buildUrl(['term' => 'hijkl']));
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'hijklmnop']);
        $response->assertJsonMissing(['name' => 'abcdefg']);
        $response->assertJsonMissing(['name' => 'qrstuv']);
        $response->assertJsonMissing(['name' => 'wxyz']);
    }

}
