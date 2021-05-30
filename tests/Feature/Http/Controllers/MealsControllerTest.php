<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\MealsController;
use Tests\LoggedInTestCase;

class MealsControllerTest extends LoggedInTestCase
{

    /**
     * Test editing meals.
     */
    public function testCanEditMeals(): void
    {
        $edit_url = action([MealsController::class, 'edit']);
        $response = $this->get($edit_url);
        $response->assertOk();

        $meal_data = [];
        $this->user->meals->each(function (array $meal) use (&$meal_data) {
            $meal_data['value'][] = $meal['value'];
            $meal_data['weight'][] = $meal['weight'];
            $meal_data['label'][] = "Updated {$meal['label']}";
            $meal_data['enabled'][] = $meal['enabled'] ?? false;
        });
        $put_url = action([MealsController::class, 'update']);
        $response = $this->put($put_url, ['meal' => $meal_data]);
        $response->assertSessionHasNoErrors();

        $this->user->refresh();
        $this->user->meals->each(function (array $meal) {
            $this->assertStringStartsWith('Updated', $meal['label']);
        });
    }

}
