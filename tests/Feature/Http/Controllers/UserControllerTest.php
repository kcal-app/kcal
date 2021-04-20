<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Models\User;
use Database\Factories\UserFactory;

class UserControllerTest extends HttpControllerTestCase
{

    /**
     * @inheritdoc
     */
    public function class(): string
    {
        return UserController::class;
    }

    /**
     * @inheritdoc
     */
    public function factory(): UserFactory
    {
        return User::factory();
    }

    /**
     * @inheritdoc
     */
    public function routeKey(): string
    {
        return 'user';
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanViewInstance(): void
    {
        $this->setName('can *not* view instance');
        // Users are not independently viewable.
    }

    /**
     * @inheritdoc
     */
    public function testCanAddInstance(): void
    {
        $create_url = action([$this->class(), 'create']);
        $response = $this->get($create_url);
        $response->assertOk();
        $instance = $this->factory()->make();
        $attributes = $instance->toArray();
        $attributes['password'] = 'password';
        $attributes['password_confirmation'] = $attributes['password'];
        $store_url = action([$this->class(), 'store']);
        $response = $this->post($store_url, $attributes);
        $response->assertSessionHasNoErrors();
    }

    public function testCanNotDeleteSelf(): void {
        $user = User::first();
        $edit_url = action([$this->class(), 'delete'], [$this->routeKey() => $user]);
        $response = $this->get($edit_url);
        $response->assertForbidden();
    }

}
