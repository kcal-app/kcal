<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\IngredientPickerController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LoggedInTestCase;

/**
 * Class IngredientPickerControllerTest
 *
 * Most of the functionality of this test is has been removed because it is too
 * unstable, particularly for parallel testing.
 *
 * @todo Find a stable way to test Elasticsearch querying.
 *
 * @package Tests\Feature\Http\Controllers
 */
class IngredientPickerControllerTest extends LoggedInTestCase
{
    use RefreshDatabase;

    private function buildUrl(array $parameters = []): string {
        return action([IngredientPickerController::class, 'search'], $parameters);
    }

    public function testSearchUrlLoads(): void {
        $response = $this->get($this->buildUrl());
        $response->assertOk();
    }

}
