<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Tests\LoggedInTestCase;

class ProfileControllerTest extends LoggedInTestCase
{

    /**
     * Test view own profile.
     */
    public function testCanViewOwnProfile(): void
    {
        $view_url = action([ProfileController::class, 'show'], ['user' => $this->user]);
        $response = $this->get($view_url);
        $response->assertOk();
        $response->assertViewHas('user', $this->user);
    }

    /**
     * Test view other user profile.
     */
    public function testCanViewOtherUserProfile(): void
    {
        $user = User::factory()->createOne();
        $view_url = action([ProfileController::class, 'show'], ['user' => $user]);
        $response = $this->get($view_url);
        $response->assertOk();
        $response->assertViewHas('user', $user);
    }

    /**
     * Test view own profile.
     */
    public function testCanEditOwnProfile(): void
    {
        $edit_url = action([ProfileController::class, 'edit'], ['user' => $this->user]);
        $response = $this->get($edit_url);
        $response->assertOk();

        $new_user = User::factory()->make();
        $put_url = action([ProfileController::class, 'update'], ['user' => $this->user]);
        $response = $this->put($put_url, $new_user->toArray());
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test view own profile.
     */
    public function testCanNotEditOtherUserProfile(): void
    {
        $user = User::factory()->createOne();
        $edit_url = action([ProfileController::class, 'edit'], ['user' => $user]);
        $response = $this->get($edit_url);
        $response->assertForbidden();
    }

}
