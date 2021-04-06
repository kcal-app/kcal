<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\IngredientPickerController;
use App\Models\Food;
use App\Models\Recipe;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\LoggedInTestCase;

/**
 * @todo Improve testing of Algolia and ElasticSearch drivers.
 */
class IngredientPickerControllerTest extends LoggedInTestCase
{
    use RefreshDatabase;

    private function buildUrl(array $parameters = []): string
    {
        return action([IngredientPickerController::class, 'search'], $parameters);
    }

    public function testSearchUrlLoads(): void
    {
        $response = $this->get($this->buildUrl());
        $response->assertOk();
    }

    public function testCanSearchWithDatabase(): void
    {
        Config::set('scout.driver', 'null');
        $this->addButter();
        $response = $this->get($this->buildUrl(['term' => 'butter']));
        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['name' => 'Butter']);
        $response->assertJsonFragment(['name' => 'Buttered Toast']);
    }

    /**
     * Essentially only confirms that the Algolia search method is used.
     */
    public function testCanSearchWithAlgolia(): void
    {
        $this->expectException(ConnectException::class);
        $this->expectExceptionMessageMatches("/Could not resolve host: \-dsn\.algolia\.net/");

        Config::set('scout.driver', 'algolia');
        $response = $this->get($this->buildUrl(['term' => 'butter']));
        $response->assertStatus(500);
        if ($response->exception) {
            throw $response->exception;
        }
    }

    /**
     * Essentially only confirms that the ElasticSearch search method is used.
     */
    public function testCanSearchWithElasticSearch(): void
    {
        Config::set('scout.driver', 'elastic');
        $this->addButter();
        $response = $this->get($this->buildUrl(['term' => 'butter']));
        $response->assertOk();
        $response->assertJson([]);
    }

    private function addButter(): void
    {
        Food::factory()->createOne(['name' => 'Butter']);
        Recipe::factory()->createOne(['name' => 'Buttered Toast']);
    }

}
