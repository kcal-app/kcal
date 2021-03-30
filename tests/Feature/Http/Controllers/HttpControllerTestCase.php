<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Tests\LoggedInTestCase;

abstract class HttpControllerTestCase extends LoggedInTestCase
{

    /**
     * Get the class name of the controller to be tested.
     */
    abstract public function class(): string;

    /**
     * Get the factory of the model to be tested.
     */
    abstract public function factory(): Factory;

    /**
     * Get the route key used for the model to be tested.
     */
    abstract public function routeKey(): string;

    /**
     * Create an instance of the model being tested.
     */
    protected function createInstance(): Model {
        return $this->factory()->create();
    }

    public function testCanLoadIndex(): void
    {
        $index_url = action([$this->class(), 'index']);
        $response = $this->get($index_url);
        $response->assertOk();
    }

    public function testCanAddInstance(): void
    {
        $create_url = action([$this->class(), 'create']);
        $response = $this->get($create_url);
        $response->assertOk();
        $instance = $this->factory()->make();
        $store_url = action([$this->class(), 'store']);
        $response = $this->followingRedirects()->post($store_url, $instance->toArray());
        $response->assertOk();
        $response->assertSessionHasNoErrors();
        $response->assertViewHas($this->routeKey());
    }

    public function testCanViewInstance(): void
    {
        $instance = $this->createInstance();
        $view_url = action([$this->class(), 'show'], [$this->routeKey() => $instance]);
        $response = $this->get($view_url);
        $response->assertOk();
        $response->assertViewHas($this->routeKey());
    }

    public function testCanEditInstance(): void
    {
        $instance = $this->createInstance();
        $edit_url = action([$this->class(), 'edit'], [$this->routeKey() => $instance]);
        $response = $this->get($edit_url);
        $response->assertOk();

        $new_instance = $this->factory()->make();
        $put_url = action([$this->class(), 'update'], [$this->routeKey() => $instance]);
        $response = $this->followingRedirects()->put($put_url, $new_instance->toArray());
        $response->assertOk();
        $response->assertSessionHasNoErrors();
        $response->assertViewHas($this->routeKey());
    }

    public function testCanDeleteInstance(): void
    {
        $instance = $this->createInstance();
        $delete_url = action([$this->class(), 'delete'], [$this->routeKey() => $instance]);
        $response = $this->get($delete_url);
        $response->assertOk();
        $response->assertViewHas($this->routeKey());

        $destroy_url = action([$this->class(), 'destroy'], [$this->routeKey() => $instance]);
        $response = $this->followingRedirects()->delete($destroy_url);
        $response->assertOk();

        $view_url = action([$this->class(), 'show'], [$this->routeKey() => $instance]);
        $response = $this->get($view_url);
        $response->assertNotFound();
    }

}
